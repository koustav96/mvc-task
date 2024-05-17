<?php

require_once __DIR__. '/EmailProcess.php';

session_start();
$mail = new EmailProcess();
// Generate a random string with the numbers.
$otp_str = str_shuffle("123456789");
// Create a substring of 4 digit.
$sentOtp = substr($otp_str, 0, 4);
$email = $_POST['email'];
$_SESSION['otp'] = $sentOtp;
$_SESSION['sentMail'] = $email;
$mail->sendOTP($email, $sentOtp);
