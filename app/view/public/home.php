<?php

require_once __DIR__. '/../../controller/posts_control/post_controller.php';
require_once __DIR__. '/../../controller/posts_control/home_controller.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="view/css/home_style.css">
  <script src="https://kit.fontawesome.com/7566e30b80.js" crossorigin="anonymous"></script>
  <title>MySocial</title>
</head>
<body>
  <!-- Div for header elements. -->
  <div class="header">
    <div id="head">
      <a href="/home" style="font-size:x-large;">MySocial</a>
    </div>
    <div id="uname">
      <p>Hello <?= $_SESSION['name'] ?></p>
      <a href="/controller/login_control/logout.php">Log out</a>
    </div>
  </div>

  <!-- Container for the page. -->
  <div class="container">
    <form action="" method="post" enctype="multipart/form-data" class="form">
      <label for="caption"></label>
      <input type="text" id="caption" placeholder="What's on your mind..." name="caption">
      <div class="uploadPost">
        <div class="uploadPostLeft">
          <label for="uploadFile" class="fa fa-picture-o fa-2x" aria-hidden="true"></label>
          <input style="display: none;" type="file" name="image" id="uploadFile" accept="image/*">
        </div>
        <div class="uploadPostRight">
          <input type="submit" name="submit" value="Share">
        </div>
      </div>
    </form>

    <!-- Container for each post. -->
    <div id="postsContainer">
      <?php foreach ($data as $row) : ?>
        <div class="post">
          <p class="name"><?= $row['name'] ?></p>
          <?php if (!empty($row['caption'])) : ?>
            <p class="caption"><?= $row['caption'] ?></p>
          <?php endif; ?>
          <?php if (!empty($row['img'])) : ?>
            <div class="image-container">
              <?= '<img src="data:image;base64,' . base64_encode($row['img']) . '" class="post-image">'; ?>
            </div>
          <?php endif; ?>
          <div class="logos">
            <div class="like_count">
              <button class="like_button" data-post-id="<?= $row['id'] ?>"><i class="fa fa-thumbs-up" aria-hidden="true"></i></button>
              &ensp;
              <?= $row['like_count'] ?>
            </div>
            <div class="comment-section">
              <button class="comment_button" data-post-id="<?= $row['id'] ?>"><i class="fa fa-comment" aria-hidden="true"></i></button>
              &ensp;
              0
              <div class="comment-field hidden">
                <input type="text" placeholder="Write a comment..." class="comment_input">
                <button class="post_comment_button">Post</button>
              </div>

            </div>
            <div>
              <i class="fa-solid fa-share"></i>
              &ensp;
              0
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Button to load rest posts. -->
    <button id="loadMore">Load More</button>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="/view/js/script.js"></script>
</body>
</html>
