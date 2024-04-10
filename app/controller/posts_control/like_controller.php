<?php
require_once './model/query.php';

$dbQueries = new Queries();
if (isset($_POST['post_id'])) {
  $post_id = $_POST['post_id'];
  $dbQueries->likePost($post_id, $_SESSION['email']);
}
