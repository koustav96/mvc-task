<?php

require_once __DIR__. '/../../controller/reset_pass/forgot_password_controller.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="/view/css/reset.css">
</head>

<body>
  <div class="container">
    <form action="" method="post">

      <label for="email">Enter your email:</label>
      <input type="email" name="email" required>

      <input type="submit" value="Submit">
    </form>
    <div>
      <?= $message ?>
    </div>
  </div>
</body>
</html>
