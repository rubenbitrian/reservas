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

    public function __construct(MailerInterface $mailer, String $emailAdmin)
    {
        $this->mailer = $mailer;
        $this->emailAdmin = $emailAdmin;
    }

    public function mail($mail, $asunto, $templHTML, $templTXT, $nombre, $apellidos)
    {
        if ($mail != '') {
            $email = (new TemplatedEmail())
                ->from(new Address($this->emailAdmin, 'Sistema de Reservas'))
                ->to(new Address($mail, $nombre . ' ' . $apellidos))
                ->subject($asunto)

                // path of the Twig template to render
                ->htmlTemplate('emails/' . $templHTML . '.html.twig')
                ->textTemplate('emails/' . $templTXT . '.txt.twig')

                // pass variables (name => value) to the template
                ->context([
                              'nombre' => $nombre,
                              'apellidos' => $apellidos,
                          ]);
            $this->mailer->send($email);
        }
    }
}

