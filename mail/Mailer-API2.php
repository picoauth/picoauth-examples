<?php
namespace PicoAuth\Mail;

/**
SendGrid is a 3rd party service allowing to send mail via calls to their protected API.
(external mail server interface)

In this example, a vendor-specific package (sendgrid/sendgrid) is used to make the appropriate call in order to send mail.
**/

class Mailer implements \PicoAuth\Mail\MailerInterface {

    private $from;
    private $subject;
    private $to;
    private $body;
    private $response;

    public function setup() {
	$this->from = new \SendGrid\Email("PicoAuth", "password-reset@example.com");
    }

    public function setTo($mail, $name="") {
        $this->to = new \SendGrid\Email($name, $mail);
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function setBody($body) {
        $this->body = new \SendGrid\Content("text/plain", $body);
    }

    public function send() {
        $mail = new \SendGrid\Mail($this->from, $this->subject, $this->to, $this->body);
        $sg = new \SendGrid("---"); // or getenv() to get the key from an environment variable
        $this->response = $sg->client->mail()->send()->post($mail);
        return $this->response->statusCode() == 202;
    }

    public function getError() {
        return $this->response->statusCode() . " - " . $this->response->body();
    }
}
