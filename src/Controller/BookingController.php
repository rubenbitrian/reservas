<?php

namespace App\Controller;

use App\Entity\Boking;
use App\Entity\State;
use App\Entity\User;
use App\Form\BokingType;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Repository\SignUpRepository;
use App\Services\Mail;
use DateInterval;
use DatePeriod;
use DateTime;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * FOSJsRouting doc: https://github.com/FriendsOfSymfony/FOSJsRoutingBundle/tree/master/Resources/doc
 */
class BookingController extends AbstractController {

    /**
     * @var Security
     */
    private $security;

    private $mailer;

    private $emailAdmin;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    /**
     * @Route("/admin/reservas", name="admon_reservas")
     */
    public function index():Response {
        $repository = $this->getDoctrine()->getRepository(Boking::class);

        $bokings = $repository->findBy([], ['id' => 'DESC']);

        $stateRepo = $this->getDoctrine()->getRepository(State::class);

        $states = $stateRepo->findAll('list');

        return $this->render('booking/index.html.twig', ['bokings' => $bokings, 'states' => $states]);
    }

    /**
     * @Route("/admin/reservas/add", name="booking_add")
     */
    public function add(Request $request) {
        $boking = new Boking();

        $form = $this->createForm(BokingType::class, $boking);
        if ($request->request->get('boking')) {
            $postData = $request->request->get('boking');
            $postData['startDate'] = $this->formatDate($postData['startDate']);
            $postData['endDate'] = $this->formatDate($postData['endDate']);
            $request->request->set('boking', $postData);
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($postData['startDate'] >= $postData['endDate']) {
                $this->addFlash('error', 'No puedes poner la fecha de inicio inferior a la de fecha final.');
                return;
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($boking);
            $em->flush();
            $this->addFlash('success', 'Tus cambios se han guardado!');
            return $this->redirectToRoute('admon_reservas');
        }

        $fechasPilladas = $this->getDatesFromRangeToDatepicker('d/m/Y');

        return $this->render('booking/add.html.twig', ['form' => $form->createView(), 'fechasPilladas' => $fechasPilladas]);
    }

    /**
     * @Route("/reservar", name="reservar",  options={"expose"=true})
     */
    public function reservar(Request $request, Mail $mailer, SignUpRepository $repo) {
        $registro = $repo->find(1);
        $boking = new Boking();

        $form = $this->createForm(BokingType::class, $boking);
        // Creamos bien la reserva
        if ($request->request->get('boking')) {
            $postData = $request->request->get('boking');
            $postData['startDate'] = $this->formatDate($postData['startDate']);
            $postData['endDate'] = $this->formatDate($postData['endDate']);
            $userId = $this->security->getUser()->getId();
            if (!empty($userId)) {
                $postData['user'] = $userId;
            }
            $postData['state'] = 1;
            $postData['mobileHome'] = 1;
            $request->request->set('boking', $postData);
        }
        $form->handleRequest($request);
        // Comprobamos y guardamos la reserva
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepo = $this->getDoctrine()->getRepository(User::class);
            $adminUsers = $userRepo->findByRole('ADMIN');
            $userBooking = $this->security->getUser();

            if ($postData['startDate'] >= $postData['endDate']) {
                $this->addFlash('error', 'No puedes poner la fecha de inicio inferior a la de fecha final.');
                return;
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($boking);
            $data = $em->flush();
            foreach ($adminUsers as $adminUser) {
                $mail = $adminUser->getEmail();
                $asunto = "Reserva del mobilhome";
                $templHTML = "solicitado";
                $templTXT = "solicitado";
                $nombre = $adminUser->getName();
                $apellidos = $adminUser->getSurnames();
                $nombreReserva = $userBooking->getName();
                $apellidosReserva =  $userBooking->getSurnames();
                $familia = $userBooking->getUserGroup()->getName();

/*
                $email = (new TemplatedEmail())->from(new Address('noresponder@bitrian.com', 'Sistema de Reservas'))
                                               ->to(new Address($mail, $nombre . ' ' . $apellidos))
                                               ->subject($asunto)
                                               ->embedFromPath('D:\webs\bitrian-com\reservas\public\images\logo_mail.png', 'logo_mail')
                                               ->html('<img src="cid:logo_mail">')
                    // path of the Twig template to render
                                               ->htmlTemplate('emails/' . $templHTML . '.html.twig')
                                               ->textTemplate('emails/' . $templTXT . '.txt.twig')
                    // pass variables (name => value) to the template
                                               ->context([
                                                   'nombre' => $nombre,
                                                   'apellidos' => $apellidos,
                                                   'nombreReserva' => $nombreReserva,
                                                   'apellidosReserva' => $apellidosReserva,
                                                   'familia' => $familia,
                                                             ]);
                $mailer->send($email);
                */

                $mailer->enviar($mail, $asunto, $templHTML, $templTXT, $nombre, $apellidos, $nombreReserva, $apellidosReserva, $familia);
            }

            $this->addFlash('success', 'Tus cambios se han guardado!');
            return $this->render('booking/finreservar.html.twig', ['data' => $data]);
        }

        $fechasPilladas = $this->getDatesFromRangeToDatepicker('d/m/Y');

        return $this->render('booking/reservar.html.twig', ['form' => $form->createView(), 'fechasPilladas' => $fechasPilladas, 'registro' => $registro,]);
    }

    /**
     * @Route("/admin/reservas/edit/{id}", name="booking_edit")
     */
    public function edit(Boking $boking, Request $request) {
        $form = $this->createForm(BokingType::class, $boking);
        if ($request->request->get('boking')) {
            $postData = $request->request->get('boking');
            $postData['startDate'] = $this->formatDate($postData['startDate']);
            $postData['endDate'] = $this->formatDate($postData['endDate']);
            $request->request->set('boking', $postData);
        }
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($boking);
            $em->flush();
            $this->addFlash('success', 'Tus cambios se han guardado!');
            return $this->redirectToRoute('admon_reservas');
        }

        $fechasPilladas = $this->getDatesFromRangeToDatepicker('d/m/Y');

        return $this->render('booking/add.html.twig', ['form' => $form->createView(), 'fechasPilladas' => $fechasPilladas]);
    }

    /**
     * @Route("/admin/reservas/view/{id}", name="booking_view")
     */
    public function view(Boking $boking):Response {
        return $this->render('booking/view.html.twig', ['boking' => $boking]);
    }

    /**
     * @Route("/admin/reservas/delete/{id}", name="booking_delete")
     */
    public function delete(Boking $boking):Response {
        if (!$boking) {
            throw $this->createNotFoundException('No guest found');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($boking);
        $em->flush();

        $this->addFlash('success', 'Tus cambios se han guardado!');
        return $this->redirectToRoute('admon_reservas');
    }

    /**
     * @Route("/testDate", name="testDate",  options={"expose"=true})
     */

    public function testDate(Request $request, SerializerInterface $serializer) {
        $startDate = $this->formatDate($request->request->get('startDate'));
        $endDate = $this->formatDate($request->request->get('endDate'));
        // Hacemos una llamada para recibir todas las reservas que sean futuras
        $em = $this->getDoctrine()->getManager();
        $RAW_QUERY = 'SELECT b.* 
        FROM boking b 
        JOIN state s ON b.state_id = s.id
        WHERE ((b.start_date BETWEEN "' . $startDate . '" AND "' . $endDate . '") OR (b.end_date BETWEEN "' . $startDate . '" AND "' . $endDate . '"))
        AND s.name = "reservado"';
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
        $reservas = $statement->fetchAll();
        if (count($reservas) > 0) {
            return new Response($serializer->serialize(false, 'json'), Response::HTTP_OK);
        }
        return new Response($serializer->serialize(true, 'json'), Response::HTTP_OK);
    }

    private function getDatesFromRangeToDatepicker($format = 'Y-m-d') {
        // Declare an empty array
        $array = array ();

        // Hacemos una llamada para recibir todas las reservas que sean futuras
        $em = $this->getDoctrine()->getManager();
        $RAW_QUERY = 'SELECT b.* 
        FROM boking b 
        JOIN state s ON s.id = b.state_id
        WHERE b.end_date > "' . date('Y-m-d') . '" 
        AND s.name = "reservado"
        ORDER BY b.start_date ASC';
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
        $reservas = $statement->fetchAll();
        foreach ($reservas as $reserva) {
            $start = $reserva['start_date'];
            $end = $reserva['end_date'];
            // Variable that store the date interval
            // of period 1 day
            $interval = new DateInterval('P1D');

            $realEnd = new DateTime($end);
            $realEnd->add($interval);

            $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

            // Use loop to store date into array
            foreach ($period as $date) {
                $array[] = $date->format($format);
            }
        }
        // Return the array elements
        return $array;
    }

    private function formatDate($date) {
        $pos = strpos($date, '-');
        if ($pos === false) {
            $porciones = explode("/", $date);
            return $porciones[2] . '-' . $porciones[1] . '-' . $porciones[0];
        }
        return $date;
    }
}
