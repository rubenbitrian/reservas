<?php

namespace App\Controller;

use App\Entity\UserGroup;
use App\Form\Type\UserGroupType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserGroupRepository;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin/grupos", name="admon_grupos")
 */
class UserGroupController extends AbstractController
{
    /**
     * @Route("/", name="")
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
     * @Route("/delete/{id}", name="_del")
     */
    public function eliminar($id, UserGroupRepository $userGroupRepositorio)
    {
        $userGroup = $userGroupRepositorio->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($userGroup);
        $entityManager->flush();
        return $this->redirectToRoute("admon_grupos");
    }
     /**
     * @Route("/add", name="_add")
     * @Route("/edit/{id}", name="_edit")
     */
    public function edit($id = 0, UserGroupRepository $userGroupRepositorio, Request $request)
    {

        $usergroup = new UserGroup();
        if ($id != 0) {
            $usergroup = $userGroupRepositorio->find($id);
            if ($usergroup == null) {
                //flash error
                return $this->redirectToRoute("admon_grupos");
            }
        }
        $form = $this->createForm(UserGroupType::class, $usergroup);
        //handle y procesado submit
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usergroup = $form->getData(); //para mostrar los datos enviados

            $this->getDoctrine()->getManager()->persist($usergroup);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("admon_grupos");
        }

        return $this->render('user_group/edit.html.twig', [
            'frmUserGroup' => $form->createView(),
            'usergroup' => $usergroup,
        ]);
    }
}
