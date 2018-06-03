<?php
namespace PicoAuth\Mail;

/**
MailGun is a 3rd party service allowing to send mail via calls to their protected API.
(external mail server interface)

In this example, CURL is used to make the appropriate call in order to send mail.
**/

class Mailer2 implements \PicoAuth\Mail\MailerInterface {

    protected $fields;
    protected $errorMsg;

    const MAILGUN_URL = 'https://api.mailgun.net/v3/...';
    const MAILGUN_KEY = 'key-...';

    public function setup() {
        $this->fields = array(
            'from' => 'PicoAuth <no-reply@picoauth.example>',
        );
    }

    public function setTo($mail) {
        $this->fields['to'] = $mail;
    }

    public function setSubject($subject) {
        $this->fields['subject'] = $subject;
    }

    public function setBody($body) {
        $this->fields['text'] = $body;
    }

    public function send() {
        $curl = curl_init(self::MAILGUN_URL . '/messages');
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, 'api:' . self::MAILGUN_KEY);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->fields);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($httpcode === 200) {
            return true;
        } else {
            $result = json_decode($response, true);
            if (($result === null && json_last_error() !== JSON_ERROR_NONE) || !isset($result->msg)) {
                $this->errorMsg = "Unspecified error, HTTP " . $httpcode;
            } else {
                $this->errorMsg = $result->msg . " HTTP " . $httpcode;
            }
            return false;
        }
    }

    public function getError() {
        return $this->errorMsg;
    }
}
