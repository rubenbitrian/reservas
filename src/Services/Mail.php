<?php

namespace App\Services;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Message;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mail
{
    private $mailer;
    private $emailAdmin;

    public function __construct(MailerInterface $mailer, string $emailAdmin)
    {
        $this->mailer = $mailer;
        $this->emailAdmin = $emailAdmin;
    }

    public function enviar(
        $mail,
        $asunto,
        $templHTML,
        $templTXT,
        $nombre,
        $apellidos,
        $nombreReserva,
        $apellidosReserva,
        $familia,
        $fechaIni = "",
        $fechaFin = ""
    ) {
        if ($mail != '') {
            $email = (new TemplatedEmail())->from(new Address('noresponder@bitrian.com', 'Sistema de Reservas'))
                                           ->to(new Address($mail, $nombre . ' ' . $apellidos))
                                           ->subject($asunto)
                //->embedFromPath('D:\webs\bitrian-com\reservas\public\images\logo_mail.png', 'logo_mail')
                                           ->embedFromPath('/home/bitrian/public_html/images/logo_mail.png','logo_mail')
                                           ->html('<img src="cid:logo_mail">')
                // path of the Twig template to render
                                           ->htmlTemplate('emails/' . $templHTML . '.html.twig')
                                           ->textTemplate('emails/' . $templTXT . '.txt.twig')
                // pass variables (name => value) to the template
                                           ->context([
                    'nombre'           => $nombre,
                    'apellidos'        => $apellidos,
                    'nombreReserva'    => $nombreReserva,
                    'apellidosReserva' => $apellidosReserva,
                    'familia'          => $familia,
                    'fechaIni'         => $fechaIni,
                    'fechaFin'         => $fechaFin,
                ]);
            $this->mailer->send($email);
        }
    }
}

