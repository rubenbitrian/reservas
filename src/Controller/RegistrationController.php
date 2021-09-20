<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\SignUpRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/registro", name="registro")
     */
    public function index(Request $request, SignUpRepository $repo)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));

            // Set their role
            $user->setRoles(['ROLE_USER']);

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            /*
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
            */

            return $this->redirectToRoute('app_login');
        }

        $registro = $repo->find(1);

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
            'registro' => $registro,
        ]);
    }
}