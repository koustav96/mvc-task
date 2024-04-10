<?php
require_once 'controller/login_control/login_controller.php';
require_once 'controller/login_control/config.php';
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
              <input type="text" name="mailId" required> <i>Mail ID</i>
          </div>

          <div class="inputBox">
            <input type="password" name="password" required> <i>Password</i>
          </div>

          <div class="links"> <a href="/forgot">Forgot Password</a> <a href="/">Signup</a>
          </div>

          <div class="link">
            <div class="linkedin">
              <a href="<?= $url; ?>"><img width="200px" src="./view/assets/linkedin.png" alt=""></a>
            </div>
          </div>

          <div class="inputBox">
            <input type="submit" name="submit" value="Login">
          </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
