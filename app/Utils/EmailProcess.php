<?php

namespace App\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailProcess
{
    private $mail;

    public function __construct($host, $username, $password, $secure, $port)
    {
        // Initialize PHPMailer
        $this->mail = new PHPMailer(true);

        // SMTP Configuration
        $this->mail->isSMTP();
        $this->mail->Host       = $host;
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $username;
        $this->mail->Password   = $password;
        $this->mail->SMTPSecure = $secure;
        $this->mail->Port       = $port;

        $this->mail->setFrom($username, "Teatops");
    }

    public function sendEmail($recipient, $subject, $message, $attachmentPath = null)
    {
        try {
            $this->mail->isHTML(true); 
            $this->mail->addAddress($recipient);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $message;

            if ($attachmentPath !== null) {
                if (file_exists($attachmentPath)) {
                    $this->mail->addAttachment($attachmentPath);
                }
            }

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
