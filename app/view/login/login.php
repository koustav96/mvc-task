<?php
require_once __DIR__. '/../../controller/login_control/login_controller.php';
require_once __DIR__. '/../../controller/login_control/config.php';
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="view/css/login_style.css">
</head>

<body>
  <section>
    <div class="signin">
      <div class="content">
        <h2>Log In</h2>
        <div class="form">
          <div class="inputBox">
            <form method="post" action="">
              <!-- Input field for email. -->
              <input type="text" name="mailId" required> <i>Mail ID</i>
          </div>

          <div class="inputBox">
            <!-- Input field for password. -->
            <input type="password" name="password" required> <i>Password</i>
          </div>

          <!-- Forgot password and signup links. -->
          <div class="links"> <a href="/forgot">Forgot Password</a> <a href="/">Signup</a>
          </div>

          <!-- LinkedIn login option. -->
          <div class="link">
            <div class="linkedin">
              <!-- LinkedIn image link. -->
              <a href="<?= $url; ?>"><img width="200px" src="./view/assets/linkedin.png" alt=""></a>
            </div>
          </div>

          <div class="inputBox">
            <!-- Submit button. -->
            <input type="submit" name="submit" value="Login">
          </div>
          </form>
          <!-- Display login error message if any. -->
          <div id="warning">
            <?= $message ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
