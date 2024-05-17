<?php

require_once './model/Queries.php';
session_start();
$dbQueries = new Queries();
if (isset($_POST['post_id'])) {
  $postId = $_POST['post_id'];
  // Update the like or dislike of specific post.
  $dbQueries->likePost($postId, $_SESSION['email']);
}
