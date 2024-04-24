<?php

require_once './model/query.php';
session_start();
$dbQueries = new Queries();
if (isset($_POST['post_id'])) {
  $post_id = $_POST['post_id'];
  // Update the like or dislike of specific post.
  $dbQueries->likePost($post_id, $_SESSION['email']);
}
