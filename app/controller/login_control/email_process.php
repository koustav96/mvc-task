<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../core/cred.php');

/**
 * A class to send mail for different purpose.
 */
class EmailProcess {
  /**
   * Variable to act as a object of PHPMailer
   *
   * @var object
   */
  private $mail;
   /**
   * Constructor to initialize PHPMailer.
   */
  public function __construct() {
    $this->mail = new PHPMailer(true);
  }
  /**
   * Function to configure PHPMailer.
   * 
   * @return void
   */
  public function configureMail($email) {
    global $senderEmail, $senderPassword;
    // Server settings.
    $this->mail->isSMTP();
    $this->mail->SMTPAuth = true;
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->Username = $senderEmail;
    $this->mail->Password = $senderPassword;
    $this->mail->SMTPSecure = 'tls';
    $this->mail->Port = 587;
    // Adding sender's email address.
    $this->mail->setFrom($senderEmail);
    $this->mail->addAddress($email);
    $this->mail->isHTML(true);
  }
  /**
   * Function to send otp to user's mailID.
   *
   * @param string $recipientEmail
   *  User's mailID.
   * @param integer $otp
   *  Generated OTP.
   * 
   * @return void
   */
  public function sendOTP(string $recipientEmail, string $otp) {
    $this->configureMail($recipientEmail);
    $this->mail->Subject = 'Validate OTP';
    $this->mail->Body =  "Your OTP is $otp.";
    try {
      $this->mail->send();
    } 
    catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
    }
  }
  /**
   * Function to send password reset link to user's mailID.
   *
   * @param string $recipientEmail
   *  User's mailID.
   * @param integer $token_hash
   *  Unique token hash.
   * 
   * @return void
   */
  public function sendEmail(string $recipientEmail, string $token_hash) {
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
