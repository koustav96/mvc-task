<?php
require_once './model/query.php';
session_start();
if (!isset($_SESSION["email"])) {
  header("location: /");
  exit();
}
$dbQueries = new Queries();

if (isset($_POST['submit'])) {
  if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) && empty($_POST['caption'])) {
    $image = file_get_contents($_FILES['image']['tmp_name']);
    if ($dbQueries->createPost($_SESSION['email'], NULL, $image)) {
      header("location: /home");
    }
  } elseif (empty($_FILES['image']['tmp_name']) && isset($_POST['caption']) && !empty($_POST['caption'])) {
    $caption = $_POST['caption'];
    if ($dbQueries->createPost($_SESSION['email'], $caption, NULL)) {
      header("location: /home");
    }
  } elseif (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name']) && isset($_POST['caption']) && !empty($_POST['caption'])) {
    $image = file_get_contents($_FILES['image']['tmp_name']);
    $caption = $_POST['caption'];
    if ($dbQueries->createPost($_SESSION['email'], $caption, $image)) {
      header("location: /home");
    }
  }
}
