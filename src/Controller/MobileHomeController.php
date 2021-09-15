<?php

namespace App\Controller;

use App\Entity\MobilHome;
use App\Form\Type\MobilHomeType;
use App\Repository\MobilHomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/mobilhome", name="admon_mobilhome")
 */
class MobilHomeController extends AbstractController
{
    /**
     * @Route("/", name="")
     */
    public function index(MobilHomeRepository $repo): Response
    {
        $arr = $repo->findAll();
        return $this->render('mobil_home/index.html.twig', [
            'arr' => $arr,
        ]);
    }

    /**
     * @Route("/add", name="_add")
     * @Route("/edit/{id}", name="_edit")
     */
    public function edit($id = 0, MobilHomeRepository $repo, Request $req): Response {

        $est = new MobilHome();
        if ($id != 0) {
            $est = $repo->find($id);
            if ($est == null) {
                $this->addFlash("danger", "El mobilhome no existe.");
                return $this->redirectToRoute("admon_mobilhome");
            }
        }

        $form = $this->createForm(MobilHomeType::class, $est);

        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $est = $form->getData();

            $this->getDoctrine()->getManager()->persist($est);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "Estado guardado correctamente.");

            return $this->redirectToRoute("admon_mobilhome");
        }

        return $this->render('mobil_home/edit.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="_del")
     */
    public function delete($id, MobilHomeRepository $estRepo): Response {
        $est = $estRepo->find($id);
        if ($est == null) {
            $this->addFlash("danger", "El mobilhome no existe.");
        } else {
            $this->getDoctrine()->getManager()->remove($est);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success", "Mobilhome eliminado correctamente.");
        }

        return $this->redirectToRoute("admon_mobilhome");
    }

}
