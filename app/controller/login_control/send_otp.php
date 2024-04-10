<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'core/cred.php';

class SendOtp
{
  private $mail;
  public function __construct()
  {
    $this->mail = new PHPMailer(true);
  }
  public function configureMail($email)
  {
    global $senderEmail, $senderPassword;
    $this->mail->isSMTP();
    $this->mail->SMTPAuth = true;
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->Username = $senderEmail;
    $this->mail->Password = $senderPassword;
    $this->mail->SMTPSecure = 'tls';
    $this->mail->Port = 587;
    $this->mail->setFrom($senderEmail);
    $this->mail->addAddress($email);
    $this->mail->isHTML(true);
  }
  public function sendEmail(string $recipientEmail, string $token_hash): void
  {
    $this->configureMail($recipientEmail);
    $this->mail->Subject = 'Reset Password';
    $this->mail->Body =  "Click <a href='http://mysocial.com/new_password?token=$token_hash'>here</a> to reset your password.";
    try {
      $this->mail->send();
    } 
    catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
    }
  }
}
