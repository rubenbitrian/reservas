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


class pruebareservarController extends AbstractController
{
    /**
     * @Route("/reserv", name="res")
     */
    public function index(): Response
    {
        return $this->render('reservar/reservar.html.twig', [
            'controller_name' => 'UserGroupgfController',
        ]);
    }
    /**
     * @Route("/fin_res", name="fin_res")
     */
    public function fin(): Response
    {
        return $this->render('reservar/finreservar.html.twig', [
            'controller_name' => 'UserGroupgfController',
        ]);
    }
}
