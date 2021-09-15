<?php

namespace App\Controller;

use App\Entity\State;
use App\Form\Type\StateType;
use App\Repository\StateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/estado", name="admon_estado")
 */
class StateController extends AbstractController
{
    /**
     * @Route("/", name="")
     */
    public function index(StateRepository $repo): Response
    {
        $arr = $repo->findAll();
        return $this->render('state/index.html.twig', [
            'arr' => $arr,
        ]);
    }

    /**
     * @Route("/add", name="_add")
     * @Route("/edit/{id}", name="_edit")
     */
    public function edit($id = 0, StateRepository $repo, Request $req): Response {

        $est = new State();
        if ($id != 0) {
            $est = $repo->find($id);
            if ($est == null) {
                $this->addFlash("danger", "El estado no existe.");
                return $this->redirectToRoute("admon_estado");
            }
        }

        $form = $this->createForm(StateType::class, $est);

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $est = $form->getData();

            $this->getDoctrine()->getManager()->persist($est);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "Estado guardado correctamente.");

            return $this->redirectToRoute("admon_estado");
        }

        return $this->render('state/edit.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="_del")
     */
    public function delete($id, StateRepository $estRepo): Response {
        $est = $estRepo->find($id);
        if ($est == null) {
            $this->addFlash("danger", "El estado no existe.");
        } else {
            $this->getDoctrine()->getManager()->remove($est);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "Estado eliminado correctamente.");
        }

        return $this->redirectToRoute("admon_estado");
    }

}
