<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Mail;

class CalendarController extends AbstractController
{
    /**
     * @Route("/admin", name="calendar")
     */
    public function index(Mail $sendmail): Response
    {
        // $sendmail->mail('email@gmail.com','asunto','mensaje');
        
        return $this->render('calendar/index.html.twig', [
            'controller_name' => 'CalendarController',
        ]);
    }
}

