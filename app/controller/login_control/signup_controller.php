<?php

require_once __DIR__. '/../../model/query.php';

session_start();
if (isset($_SESSION["data"])) {
  header("location: /home");
  exit();
}

$message = '';
if(isset($_POST['submit'])) {
  $name = $_POST['name'];
  $mailId = $_POST['mailId'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $dbQueries = new Queries();

  if(!$dbQueries->checkUser($mailId)) {
    if ($_SESSION['otp'] == $_POST['otp']) {
      if($_SESSION['sentMail'] == $_POST['mailId']) {
        if($dbQueries->insertUser($name, $mailId, $password)) {
          $message = 'Data submitted successfully !! Now you can Login !!';
        }
      }
      else {
        $message = 'MailId altered !!';
      }
    }
    else {
      $message = 'OTP not matched !!';
    }
  }
  else {
    $message = 'Mail ID is already exist !!';
  }
}

