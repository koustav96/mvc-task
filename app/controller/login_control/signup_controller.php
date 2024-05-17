<?php

require_once __DIR__. '/../../model/Queries.php';
session_start();
// If the session is set then redirect to homepage.
if (isset($_SESSION["data"])) {
  header("location: /home");
  exit();
}
$message = '';
// If submit button is clicked.
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $mailId = $_POST['mailId'];
  // Hash the password.
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $dbQueries = new Queries();

  // Checks if the mailId and password is present in the database.
  if (!$dbQueries->checkUser($mailId)) {

    // Checks if the mailId is changed after generating otp.
    if ($_SESSION['sentMail'] == $_POST['mailId']) {

      // Matches the session otp with user submitted otp.
      if ($_SESSION['otp'] == $_POST['otp']) {
        
        // Store userdata into database.
        if ($dbQueries->insertUser($name, $mailId, $password)) {
          $message = 'Data submitted successfully !! Now you can Login !!';
        }
      }
      else {
        $message = 'OTP is not matched !!';
      }
    }
    else {
      $message = 'MailId altered !!';
    }
  }
  else {
    $message = 'Mail ID is already exist !!';
  }
}

