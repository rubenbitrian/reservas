<?php

namespace App\Controller;

use App\Entity\UserGroup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserGroupRepository;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserGroupController extends AbstractController
{
    /**
     * @Route("/admin/user/group", name="user_group")
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
     * @Route("/admin/user/group/delete/{id}", name="user_group_delete")
     */
    public function eliminar($id, UserGroupRepository $userGroupRepositorio)
    {
        $userGroup = $userGroupRepositorio->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($userGroup);
        $entityManager->flush();
        return $this->redirectToRoute("user");
    }
     /**
     * @Route("/admin/user/group/add", name="usergroup_add")
     * @Route("/admin/user/group/edit/{id}", name="usergroup_edit")
     */
    public function edit($id = 0, UserGroupRepository $userGroupRepositorio, Request $request, SluggerInterface $slugger)
    {

        $usergroup = new UserGroup();
        if ($id != 0) {
            $usergroup = $userGroupRepositorio->find($id);
            if ($usergroup == null) {
                //flash error
                return $this->redirectToRoute("user");
            }
        }
        $form = $this->createForm(UserGroupType::class, $usergroup);
        //handle y procesado submit
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usergroup = $form->getData(); //para mostrar los datos enviados

            if ($usergroup->getSlug() == null || $usergroup->getSlug() == "") {
                $usergroup->setSlug(\strtolower($usergroup->slug($usergroup->getName())));
            }

            $this->getDoctrine()->getManager()->persist($usergroup);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("user");
        }

        return $this->render('user_group/edit.html.twig', [
            'frmCategoria' => $form->createView(),
            'usergroup' => $usergroup,
        ]);
    }
}
