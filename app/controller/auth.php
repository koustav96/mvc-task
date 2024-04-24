<?php

require_once __DIR__. '/../vendor/autoload.php';
require_once __DIR__. '/login_control/config.php';
require_once __DIR__.'/../model/query.php';

use GuzzleHttp\Client;

$client = new Client();

$param_arr = explode('&', $query);
$code_arr = explode('=', $param_arr[0]);
$code = $code_arr[1];

if (isset($code)) {
  $acc_url = "https://www.linkedin.com/oauth/v2/accessToken";
  try {
    $response = $client->request('POST', $acc_url, [
      'form_params' => [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri
      ]
    ]);
    $arr = json_decode($response->getBody(), true);
    $id_token = $arr['id_token'];
    try {
      $ex_arr = explode('.', $id_token);
      $payload_encrypted = $ex_arr[1];
      $payload = json_decode(base64_decode($payload_encrypted), true);
      $email = $payload['email'];
      $name = $payload['name'];

      session_start();
      $dbQueries = new Queries();
      $dbQueries->checkUser($email);
      if ($dbQueries->checkUser($email)) {
        $_SESSION['data'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        header('location: /home');
      } 
      else {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['data'] = true;
        $dbQueries->insertUser($name, $email, NULL);
        header('location:/home');
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}
