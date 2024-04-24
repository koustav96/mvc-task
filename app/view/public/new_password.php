<?php

require_once __DIR__. '/../../controller/reset_pass/new_password_controller.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Password</title>
  <link rel="stylesheet" href="/view/css/reset.css">
</head>
<body>
  <div class="container">
    <form method="post">
      <label for="password">Password</label>
      <input type="password" name="password" required>

      <input type="submit" value="Submit">
    </form>
      <div>
        <?= $message ?>
      </div>
  </div>
</body>
</html>
