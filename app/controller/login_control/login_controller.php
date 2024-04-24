<?php

require_once __DIR__. '/../../model/query.php';

session_start();
if (isset($_SESSION["data"])) {
  header("location: /home");
  exit();
}

$message = '';
if (isset($_POST['submit'])) {
  $mailId = $_POST['mailId'];
  $password = $_POST['password'];

  $dbQueries = new Queries();
  if (!$dbQueries->authenticateUser($mailId, $password)) {
    $message = 'Invalid Credentials !!';
  }
  else {
    $_SESSION["data"] = true;
    $_SESSION['email'] = $mailId;
    $_SESSION['name'] = $dbQueries->authenticateUser($mailId, $password);
    header('location: /home');
    exit;
  }
}
