<?php

namespace App\Controller;

use App\Entity\SignUp;
use App\Entity\SingUp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
<<<<<<< HEAD
=======
use App\Repository\SignUpRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
>>>>>>> 64d84cac4b8204fc9c2d37c563fa96f1d72ad824

/**
 * @Route("/admin/usuarios", name="admon_usuarios")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="")
     */
    public function index(UserRepository $repo): Response
    {
        $lst = $repo->findAll();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'lst' => $lst
        ]);
    }

    /**
     * @Route("/delete/{id}", name="_del")
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
     * @Route("/add", name="_add")
     * @Route("/edit/{id}", name="_edit")
     */
    public function edit($id = 0, UserRepository $repo, Request $request)
    {

        $user = new User();
        if ($id != 0) {
            $user = $repo->find($id);
            if ($user == null) {
                //flash error
                return $this->redirectToRoute("admon_usuarios");
            }
        }
        $form = $this->createForm(UserType::class, $user);
        //handle y procesado submit
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData(); //para mostrar los datos enviados

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("admon_usuarios");
        }

        return $this->render('user/edit.html.twig', [
            'frmUser' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
    * @Route("/habilitar", name="_habilitar")
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
        return $this->redirectToRoute("admon_usuarios");
    }
}