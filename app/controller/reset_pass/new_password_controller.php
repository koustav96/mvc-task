<?php

session_start();
if (isset($_SESSION["data"])) {
  header("location: /home");
  exit();
}
require_once './model/query.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_POST['password']) && isset($_GET['token'])) {
    $password = $_POST['password'];
    $token = $_GET['token'];
    $dbQueries = new Queries();

    if (!$dbQueries->validateToken($token)) {
      $message = 'Invalid token or token expired!!';
    } 
    else {
      $result = $dbQueries->changePassword($password, $token);
      if ($result) {
        $message = 'Password changed, Now you can LogIn !!';
      } 
      else {
        $message = 'Password not changed !!';
      }
    }
  }
}
