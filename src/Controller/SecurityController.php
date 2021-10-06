<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\SignUpRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $repo, SignUpRepository $repo2): Response
    {
        $registro = $repo2->find(1);
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if($lastUsername != null){

            $currentUser = new User();

            $lst = $repo->findAll();

            foreach($lst as $user){
                

                if($user->getUserIdentifier() == $user ){//Si está como registro en la base de datos
                    if ($user->getUserIdentifier() == $lastUsername){
                        $currentUser = $user;
                    }
                }
            }
            //En la entidad User el método getRoles() no debe meter al array el rol de usuario
            if($currentUser->getRoles() == array('ROLE_ADMIN')){
                return $this->redirectToRoute('admon_reservas');
            }else{//Si tiene rol usuario va a la principal
                if($currentUser->getRoles() == array('ROLE_USER')){
                    return $this->redirectToRoute('reservar');
                }else{//Si no entra porque no existe el usuario o no tiene rol
                    //return $this->redirectToRoute('app_login');
                    return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'registro' => $registro]);
                }
            }
        }

        

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'registro' => $registro]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
