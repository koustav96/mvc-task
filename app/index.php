<?php
ini_set('display_errors', '1');
$request = $_SERVER['REQUEST_URI'];
$params = parse_url($request);
$query = '';
if (isset($params['query'])) {
  $query = $params['query'];
}
switch ($request) {
  case '':
  case '/':
    require __DIR__ . '/view/login/signup.php';
    break;
  case '/login':
    require __DIR__ . '/view/login/login.php';
    break;
  case '/home':
    require __DIR__ . '/view/public/home.php';
    break;
  case '/createpost':
    require __DIR__ . '/view/public/create_post.php';
    break;
  case '/forgot':
    require __DIR__ . '/view/public/forgot_password.php';
    break;
  case str_starts_with($request,'/new_password'):
    require __DIR__ . '/view/public/new_password.php';
    break;
  case '/fetch':
    require __DIR__ . '/controller/posts_control/fetch_post.php';
    break;
  case '/like':
    require __DIR__ . '/controller/posts_control/like_controller.php';
    break;
  case str_starts_with($request,'/auth'):
    require __DIR__ . '/auth.php';
    break;
  default:
    echo"<h1>404 Not Found</h1>";
  }
