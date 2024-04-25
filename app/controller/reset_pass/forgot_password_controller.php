<?php

require_once './model/Queries.php';
require_once './controller/login_control/EmailProcess.php';

// If the session is set then redirect to homepage.
session_start();
if (isset($_SESSION["data"])) {
  header("location: /home");
  exit();
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['email'])) {
  $email = $_POST['email'];
  $dbQueries = new Queries();
  // Checks if the mailID is present in the database.
  if ($dbQueries->checkUser($email)) {

    // Generates random token.
    $token = bin2hex(random_bytes(16));
    $tokenHash = password_hash($token, PASSWORD_DEFAULT);
    // Set the token expiry time.
    $expiry = date("Y-m-d H:i:s", time() + 60 * 5);
    // Update the database with the token_hash and expiry.
    $dbQueries->updateResetToken($email, $tokenHash, $expiry);

    // Send mail to the user with the reset link.
    $otpSender = new EmailProcess();
    $otpSender->sendEmail($email, $tokenHash);
    $message = "Reset link is sent on your mail !!";
  }
  else {
    $message = "Your email is not registered with our database !!";
  }
}
