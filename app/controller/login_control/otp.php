<?php

require_once __DIR__. '/email_process.php';

session_start();
$mail = new EmailProcess();

$otp_str = str_shuffle("123456789");
$sentOtp = substr($otp_str, 0, 4);
$email = $_POST['email'];
$_SESSION['otp'] = $sentOtp;
$_SESSION['sentMail'] = $email;
$mail->sendOTP($email, $sentOtp);
