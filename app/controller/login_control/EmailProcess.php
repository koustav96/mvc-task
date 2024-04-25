<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../core/Dotenv.php');

/**
 * A class to send mail for various purpose.
 */
class EmailProcess {
  /**
   * Variable to act as a object of PHPMailer.
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
   * @param string $email
   * User's email id.
   * 
   * @return void
   */
  public function configureMail($email) {
    // Creating instance of Dotenv class.
    new Dotenv();
    // Server settings.
    $this->mail->isSMTP();
    $this->mail->SMTPAuth = true;
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->Username = $_ENV['senderEmail'];
    $this->mail->Password = $_ENV['senderPassword'];
    $this->mail->SMTPSecure = 'tls';
    $this->mail->Port = 587;
    // Adding sender's email address.
    $this->mail->setFrom($_ENV['senderEmail']);
    $this->mail->addAddress($email);
    $this->mail->isHTML(true);
  }  
  /**
   * Function to set mail subject and body.
   *
   * @param  string $subject
   * Set email subject.
   * @param  string $body
   * Set email body.
   * 
   * @return void
   */
  public function setContents(string $subject, string $body) {
    $this->mail->Subject = $subject;
    $this->mail->Body =  $body;
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
    $sub = 'Validate OTP';
    $body = "Your OTP is $otp.";
    $this->configureMail($recipientEmail);
    $this->setContents($sub, $body);
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
    $sub = 'Reset Password';
    $body = "Click <a href='http://mysocial.com/new_password?token=$token_hash'>here</a> to reset your password.";
    $this->configureMail($recipientEmail);
    $this->setContents($sub, $body);
    try {
      $this->mail->send();
    } 
    catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
    }
  }
}
