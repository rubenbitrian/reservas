<?php

namespace App\Controller;

use App\Entity\SingUp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\SignUpRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{

    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }
    /**
     * @Route("/admin/usuarios", name="admon_usuarios")
     */
    public function index(UserRepository $repo, SignUpRepository $repo2): Response
    {
        $lst = $repo->findAll();
        $registro = $repo2->find(1);

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'lst' => $lst,
            'registro' => $registro,
        ]);
    }

    /**
     * @Route("/admin/usuarios/delete/{id}", name="admon_usuarios_del")
     */
    public function eliminar($id, UserRepository $repo)
    {
        $user = $repo->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute("admon_usuarios");
    }
     /**
     * @Route("/admin/usuarios/add", name="admon_usuarios_add")
     * @Route("/usuario/perfil/edit/{id}", name="user_profile")
     * @Route("/admin/usuarios/edit/{id}", name="admon_usuarios_edit")
     */
    public function edit($id = 0, UserRepository $repo, Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        $userId = $this->security->getUser()->getId();
        $userRoles = $this->security->getUser()->getRoles();
        if (!in_array("ROLE_ADMIN", $userRoles)) {
            $id = $userId;
        }
        // if ($id !== $userId) {
        //     return $this->redirectToRoute('user_profile');
        // }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        if ($id != 0) {
            $user = $repo->find($id);
            $form = $this->createForm(UserType::class, $user, ['required' => false]);

            if ($user == null) {
                $this->addFlash('danger', 'Es necesario un usuario para poder editarlo.');
                return $this->redirectToRoute("admon_usuarios");
            }
        }
        //handle y procesado submit
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('plainPassword')->getData()) {
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Tus cambios se han guardado!');
            if (!in_array("ROLE_ADMIN", $userRoles)) {
                return $this->redirectToRoute("user_profile");
            } else {
                return $this->redirectToRoute("admon_usuarios");
            }


        }

        return $this->render('user/perfil.html.twig', [
            'frmUser' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
    * @Route("/admin/usuarios/habilitar", name="admon_usuarios_habilitar")
    */
    public function habilitar(SignUpRepository $repo){

        $registro = $repo->find(1);//0 es el id
        if($registro->getEnable() == false){
            $registro->setEnable(true);
        }else{
            $registro->setEnable(false);
        }
        $this->getDoctrine()->getManager()->persist($registro);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('success', 'Tus cambios se han guardado!');
        return $this->redirectToRoute("admon_usuarios");
    }
}