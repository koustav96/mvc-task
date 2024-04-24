<?php
require_once './model/query.php';
session_start();
// If the session is not set then redirect to login page.
if (!isset($_SESSION["email"])) {
  header("location: /");
  exit();
}
$dbQueries = new Queries();

if (isset($_POST['submit'])) {
  // Checks if the user uploads image without caption.
  if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) && empty($_POST['caption'])) {
    $image = file_get_contents($_FILES['image']['tmp_name']);
    if ($dbQueries->createPost($_SESSION['email'], NULL, $image)) {
      header("location: /home");
    }
  } 
  // Checks if the user only provide a text without any image
  elseif (empty($_FILES['image']['tmp_name']) && isset($_POST['caption']) && !empty($_POST['caption'])) {
    $caption = $_POST['caption'];
    if ($dbQueries->createPost($_SESSION['email'], $caption, NULL)) {
      header("location: /home");
    }
  } 
  // Checks if the user the provides both image and caption.
  elseif (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) && isset($_POST['caption']) && !empty($_POST['caption'])) {
    $image = file_get_contents($_FILES['image']['tmp_name']);
    $caption = $_POST['caption'];
    if ($dbQueries->createPost($_SESSION['email'], $caption, $image)) {
      header("location: /home");
    }
  }
}
