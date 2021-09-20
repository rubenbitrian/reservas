<?php

namespace App\Controller;

use App\Repository\SignUpRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(SignUpRepository $repo): Response
    {
        
        $registro = $repo->find(1);
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'registro' => $registro
        ]);
    }
}
