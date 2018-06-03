<?php
namespace PicoAuth\Mail;

/**
SMTP example using PHPMailer
*/

class Mailer3 implements \PicoAuth\Mail\MailerInterface {

    protected $mail;

    public function setup() {
        $this->mail = new \PHPMailer\PHPMailer\PHPMailer;

        $this->mail->isSMTP();				// SMTP
        $this->mail->Host = 'smtp.example.com';		// SMTP server
        $this->mail->SMTPAuth = true;			// Authentication
        $this->mail->Username = '...'; 			// Username
        $this->mail->Password = '...';			// SMTP password
        $this->mail->SMTPSecure = 'ssl';		// Enable encryption, 'ssl'
        $this->mail->Port = 465;			// Port
        $this->mail->From = '...';			// The FROM field
        $this->mail->FromName = '...';			// The from NAME
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
