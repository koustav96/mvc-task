<?php

session_start();
if (isset($_SESSION["data"])) {
  header("location: /home");
  exit();
}
require_once './model/query.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_POST['password']) && isset($_GET['token'])) {
    $password = $_POST['password'];
    $token = $_GET['token'];
    $dbQueries = new Queries();

    if (!$dbQueries->validateToken($token)) {
      ?>
      <script type="text/javascript">alert("Invalid token or token expired!!");</script>
      <?php
    } 
    else {
      $result = $dbQueries->changePassword($password, $token);
      if ($result) {
        ?>
        <script type="text/javascript">alert("Password changed, Now you can LogIn !!");</script>
        <?php
      } 
      else {
        ?>
        <script type="text/javascript">alert("Password not changed !!");</script>
        <?php
      }
    }
  }
}
