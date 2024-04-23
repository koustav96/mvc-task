<?php

require_once './model/query.php';
require_once './controller/login_control/email_process.php';

session_start();
if (isset($_SESSION["data"])) {
  header("location: /home");
  exit();
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['email'])) {
  $email = $_POST['email'];
  $dbQueries = new Queries();
  if ($dbQueries->checkUser($email)) {
    $token = bin2hex(random_bytes(16));
    $token_hash = password_hash($token, PASSWORD_DEFAULT);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 5);
    $dbQueries->updateResetToken($email, $token_hash, $expiry);

    $otpSender = new EmailProcess();
    $otpSender->sendEmail($email, $token_hash);
  } 
  else {
    ?>
    <script type="text/javascript"> alert ("Your email is not registered with our database !!")</script>
    <?php
  }
}
