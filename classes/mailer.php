<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as MailerException;

class mailer
{
    private ?PHPMailer $mail = null;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->initServerSettings();
    }

    protected function initServerSettings(): void {
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output OFF
        $this->mail->isSMTP();                                         //Send using SMTP
        $this->mail->Host       = 'sandbox.smtp.mailtrap.io';          //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                //Enable SMTP authentication
        $this->mail->Username   = 'your.username';                    //SMTP username
        $this->mail->Password   = 'your.password';                    //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      //Enable implicit TLS encryption
        $this->mail->Port       = 587;                                 //TCP port to connect to;
    }

    public function sendOneTimePassword(string $recipientName, string $recipientEmail, string $password): bool {
        
        try {
            //Recipients
            $this->mail->setFrom('info@mailtrap.io', 'Mailer');
            $this->mail->addAddress($recipientEmail, $recipientName);     //set recipient
            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = 'Your one time password';
            $this->mail->Body    = $this->getOneTimePasswordMessageBody($recipientName, $password, 'html');
            $this->mail->AltBody = $this->getOneTimePasswordMessageBody($recipientName, $password, 'text');
            $this->mail->send();
            return true;
        } catch (MailerException $e) {
            ; // log error?
        }
        return false;
    }

    protected function getOneTimePasswordMessageBody(string $recipientName, string $password, string $type = 'html'): string {

        if ($type == 'html') {
            return <<<HTML
        <h2>Thank you for registering {$recipientName}</h2>
        <p>This is your one time password: {$password}</p>
        <p>Please use this password on your next login!</p>
        <p>Thank you</p>
HTML;
        } elseif ($type == 'text') {
            $text =  "Thank you for registering {$recipientName}\r\n";
            $text.= "This is your one time password: {$password}\r\n";
            $text.= "Please use this password on your next login!\r\n";
            $text.= "Thank you";
            return $text;
        }
        return '';
    }
}