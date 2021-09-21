<?php

namespace App\Services;

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

    public function mail($mail = '', $asunto = "Asunto vacio", $mensaje = "mensaje vacio")
    {
        if ($mail != '') {
            $email = (new Email())
                ->from($this->emailAdmin)
                ->to($mail)
                ->subject($asunto)
                ->text($mensaje);
            $this->mailer->send($email);
        }
    }
}
