<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserGroupRepository;

class UserGroupController extends AbstractController
{
    /**
     * @Route("/user/group", name="user_group")
     */
    public function index(UserGroupRepository $userGroupRepositorio): Response
    {
        $lst = $userGroupRepositorio->findAll();

        return $this->render('user_group/index.html.twig', [
            'controller_name' => 'UserGroupController',
            'lst' => $lst
        ]);
    }

    /**
     * @Route("/admin/user/group/delete/{id}", name="categoria_delete")
     */
    public function eliminar($id, UserGroupRepository $userGroupRepositorio)
    {
        $userGroup = $userGroupRepositorio->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($userGroup);
        $entityManager->flush();
        return $this->redirectToRoute("user");
    }
}
