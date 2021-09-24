<?php

namespace App\Controller;

use App\Entity\Boking;
use App\Entity\State;
use App\Form\Type\StateType;
use App\Services\Mail;
use App\Repository\StateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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
    public function edit($id = 0, StateRepository $repo, Request $req): Response
    {

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
    public function delete($id, StateRepository $estRepo): Response
    {
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

    /**
     * @Route("/switchState", name="_switchState",  options={"expose"=true})
     */
    public function switchState(Request $request, Mail $mailer, SerializerInterface $serializer, StateRepository $repo)
    {
        $est = $repo->find($request->request->get('stateId'));

        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Boking::class)->find($request->request->get('bookingId'));

        if (!$product) {
            return new Response(
                $serializer->serialize(false, 'json'),
                Response::HTTP_OK
            );
        }

        $product->setState($est);
        $entityManager->flush();

        // Envío de email a todos los usuarios, el estado ($est) 2 es confirmado
        // Revisar lo que trae $product para obtener el usuario que reserva y usarlo en el email

        /*
                $userBooking = $product;

                $userRepo = $this->getDoctrine()->getRepository(User::class);
                $users = $userRepo->findAll();
                if ($est == 2) {
                    foreach ($users as $user) {
                        $mailer->mail(
                            $user->getName() . " " . $user->getSurnames() <$user->getEmail()>,
                            'Reserva solicitada',
                            'Mensaje to wapo pa to kiski'
                        );
                    }
        */


    }
return new Response(
$serializer->serialize(true, 'json'),
Response::HTTP_OK
);
}

}
