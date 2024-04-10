<?php

require './model/query.php';

session_start();
if (isset($_SESSION["data"])) {
  header("location: /home");
  exit();
}

if (isset($_POST['submit'])) {
  $mailId = $_POST['mailId'];
  $password = $_POST['password'];

  $dbQueries = new Queries();
  if (!$dbQueries->authenticateUser($mailId, $password)) {
    ?>
    <script type="text/javascript">alert("Invalid Credentials !!");</script>
    <?php
  } 
  else {
    $_SESSION["data"] = true;
    $_SESSION['email'] = $mailId;
    $_SESSION['name'] = $dbQueries->authenticateUser($mailId, $password);
    header('location: /home');
    exit;
  }
}
