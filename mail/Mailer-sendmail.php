<?php
namespace PicoAuth\Mail;

/**
Sendmail example using PHPMailer
*/

class Mailer implements \PicoAuth\Mail\MailerInterface {

    protected $mail;

    public function setup() {
        $this->mail = new \PHPMailer\PHPMailer\PHPMailer;
        $this->mail->isSendmail();
        $this->mail->setFrom('noreply@example.com', 'PicoAuth');
    }

    public function setTo($mail) {
        $this->mail->addAddress($mail);
    }

    public function setSubject($subject) {
        $this->mail->Subject = $subject;
    }

    public function setBody($body) {
        $this->mail->Body = $body;
    }

    public function send() {
        return $this->mail->send();
    }

    public function getError() {
        return $this->mail->ErrorInfo;
    }
}
