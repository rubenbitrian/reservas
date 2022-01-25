<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Repository\SignUpRepository;
use App\Form\ResetPasswordRequestFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/**
 * @Route("/reset-password")
 */
class ResetPasswordController extends AbstractController {

  use ResetPasswordControllerTrait;

  private $resetPasswordHelper;

  public function __construct(ResetPasswordHelperInterface $resetPasswordHelper) {
    $this->resetPasswordHelper = $resetPasswordHelper;
  }

  /**
   * Display & process form to request a password reset.
   *
   * @Route("", name="app_forgot_password_request")
   */
  public function request(Request $request, MailerInterface $mailer, SignUpRepository $repo2):Response {
    $registro = $repo2->find(1);
    $form     = $this->createForm(ResetPasswordRequestFormType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      return $this->processSendingPasswordResetEmail(
        $form->get('email')->getData(), $mailer
      );
    }

    return $this->render('reset_password/request.html.twig', ['requestForm' => $form->createView(), 'registro' => $registro,]);
  }

  /**
   * Confirmation page after a user has requested a password reset.
   *
   * @Route("/check-email", name="app_check_email")
   */
  public function checkEmail():Response {
    // Generate a fake token if the user does not exist or someone hit this page directly.
    // This prevents exposing whether or not a user was found with the given email address or not
    if (NULL === ($resetToken = $this->getTokenObjectFromSession())) {
      $resetToken = $this->resetPasswordHelper->generateFakeResetToken();
    }

    return $this->render('reset_password/check_email.html.twig', ['resetToken' => $resetToken,]);
  }

  /**
   * Validates and process the reset URL that the user clicked in their email.
   *
   * @Route("/reset/{token}", name="app_reset_password")
   */
  public function reset(Request $request, UserPasswordEncoderInterface $passwordEncoder, string $token = NULL):Response {
    if ($token) {
      // We store the token in session and remove it from the URL, to avoid the URL being
      // loaded in a browser and potentially leaking the token to 3rd party JavaScript.
      $this->storeTokenInSession($token);

      return $this->redirectToRoute('app_reset_password');
    }

    $token = $this->getTokenFromSession();
    if (NULL === $token) {
      throw $this->createNotFoundException('No se encontró ningún token de restablecimiento de contraseña en la URL o en la sesión.');
    }

    try {
      $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
    } catch (ResetPasswordExceptionInterface $e) {
      $this->addFlash(
        'reset_password_error', sprintf(
        'Ha habido un problema al validar tu solicitud de reinicio - %s', $e->getReason()
      )
      );

      return $this->redirectToRoute('app_forgot_password_request');
    }

    // The token is valid; allow the user to change their password.
    $form = $this->createForm(ChangePasswordFormType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // A password reset token should be used only once, remove it.
      $this->resetPasswordHelper->removeResetRequest($token);

      // Encode the plain password, and set it.
      $encodedPassword = $passwordEncoder->encodePassword(
        $user, $form->get('plainPassword')->getData()
      );

      $user->setPassword($encodedPassword);
      $this->getDoctrine()->getManager()->flush();

      // The session is cleaned up after the password has been changed.
      $this->cleanSessionAfterReset();

      return $this->redirectToRoute('app_login');
    }

    return $this->render('reset_password/reset.html.twig', ['resetForm' => $form->createView(),]);
  }

  private function processSendingPasswordResetEmail(string $emailFormData, MailerInterface $mailer):RedirectResponse {
    $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $emailFormData,]);

    // Do not reveal whether a user account was found or not.
    if (!$user) {
      return $this->redirectToRoute('app_check_email');
    }

    try {
      $resetToken = $this->resetPasswordHelper->generateResetToken($user);
    } catch (ResetPasswordExceptionInterface $e) {
      // If you want to tell the user why a reset email was not sent, uncomment
      // the lines below and change the redirect to 'app_forgot_password_request'.
      // Caution: This may reveal if a user is registered or not.
      //
      // $this->addFlash('reset_password_error', sprintf(
      //     'There was a problem handling your password reset request - %s',
      //     $e->getReason()
      // ));

      return $this->redirectToRoute('app_check_email');
    }

    $mail      = $user->getEmail();
    $asunto    = "Tu solicitud de restablecimiento de contraseña";
    $templHTML = "reset_password/email.html.twig";
    $templTXT  = "reset_password/email.txt.twig";
    $nombre    = $user->getName();
    $apellidos = $user->getSurnames();

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
              'resetToken' => $resetToken,
                                                       'nombre' => $nombre,
                                                       'apellidos' => $apellidos,
                                                                 ]);
                    $mailer->send($email);
                    */

    $email = (new TemplatedEmail())->from(new Address('noresponder@bitrian.com', 'Sistema de Reservas'))->to($user->getEmail())->subject('Tu solicitud de restablecimiento de contraseña')->htmlTemplate('reset_password/email.html.twig')->context(['resetToken' => $resetToken,]);

    $mailer->send($email);

    // Store the token object in session for retrieval in check-email route.
    $this->setTokenObjectInSession($resetToken);

    return $this->redirectToRoute('app_check_email');
  }

}
