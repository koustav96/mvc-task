<?php

require_once __DIR__. '/../vendor/autoload.php';
require_once __DIR__. '/login_control/config.php';
require_once __DIR__.'/../model/query.php';

use GuzzleHttp\Client;
// Create a new Guzzle HTTP client.
$client = new Client();
// Split query string parameters and extract authorization code.
$param_arr = explode('&', $query);
$code_arr = explode('=', $param_arr[0]);
$code = $code_arr[1];

// Check if authorization code is set.
if (isset($code)) {
  $acc_url = "https://www.linkedin.com/oauth/v2/accessToken";
  try {
    // Request access token using authorization code.
    $response = $client->request('POST', $acc_url, [
      'form_params' => [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri
      ]
    ]);
    // Decode the response and extract ID token.
    $arr = json_decode($response->getBody(), true);
    $id_token = $arr['id_token'];
    // Extract payload from ID token.
    try {
      $ex_arr = explode('.', $id_token);
      $payload_encrypted = $ex_arr[1];
      $payload = json_decode(base64_decode($payload_encrypted), true);
      $email = $payload['email'];
      $name = $payload['name'];

      // Start session and perform user check.
      session_start();
      $dbQueries = new Queries();
      $dbQueries->checkUser($email);
      // If user exists, set session variables and redirect to homepage.
      if ($dbQueries->checkUser($email)) {
        $_SESSION['data'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        header('location: /home');
      } 
      // If user does not exist, insert user into database and redirect to homepage.
      else {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['data'] = true;
        $dbQueries->insertUser($name, $email, NULL);
        header('location:/home');
      }
      // Catch any exceptions during payload extraction.
    } catch (Exception $e) {
      echo $e->getMessage();
    }
    // Catch any exceptions during access token request.
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}
