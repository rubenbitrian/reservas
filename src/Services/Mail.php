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
                ->from($this->emailAdmin)
                ->to(new Address($mail))
                ->subject($asunto)

                // path of the Twig template to render
                ->htmlTemplate('emails/' . $templHTML . '.html.twig')
                ->textTemplate('emails/' . $templTXT . '.txt.twig')

                // pass variables (name => value) to the template
                ->context([
                              'name' => $nombre,
                              'apellidos' => $apellidos,
                          ]);
            $this->mailer->send($email);
        }
    }
}

