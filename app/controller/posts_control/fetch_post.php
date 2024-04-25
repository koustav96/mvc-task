<?php

require_once 'model/Queries.php';
$dbQueries = new Queries();
// Fetch specific number of posts from database.
$data = $dbQueries->loadPost($_POST['offset'], $_POST['limit']);

// Split the post data and show in the feed.
foreach ($data as $row) {
  $output = '';
  $output .= '<div class="post">
          <p class="name">' . $row['name'] . '</p>';

  if (!empty($row['caption'])) {
    $output .= '<p class="caption">' . $row['caption'] . ' </p>';
  }
  if (!empty($row['img'])) {
    $output .= '<div class="image-container">
              <img src="data:image;base64,' . base64_encode($row['img']) . '" class="post-image">
            </div>';
  }
  $output .= '<div class="logos">
            <div>
              <button class="like_button" data-post-id="' . $row['id'] . '"><i class="fa fa-thumbs-up"></i></button>' . $row['like_count'] .
          '</div>
            <div>
              <i class="fa fa-comment" aria-hidden="true"></i>
              0
            </div>
            <div>
              <i class="fa-solid fa-share"></i>
              0
            </div>
          </div>
        </div>';
  echo $output;
}
