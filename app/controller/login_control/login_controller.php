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
  $mailId = $_POST['mailId'];
  $password = $_POST['password'];

  $dbQueries = new Queries();
  // Checks if the mailId and password is present in the database.
  if (!$dbQueries->authenticateUser($mailId, $password)) {
    $message = 'Invalid Credentials !!';
  }
  // Sets the mailId and name in the session and redirect to homepage.
  else {
    $_SESSION["data"] = true;
    $_SESSION['email'] = $mailId;
    $_SESSION['name'] = $dbQueries->authenticateUser($mailId, $password);
    header('location: /home');
    exit;
  }
}
