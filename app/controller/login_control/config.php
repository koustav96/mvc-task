<?php

require_once __DIR__. '/../../core/Dotenv.php';

// Creating instance of Dotenv class.
new Dotenv();

// Accessing client id  and client secret of linkedin.
$client_id = $_ENV['clientId'];
$client_secret = $_ENV['clientSecret'];
// Redirected uri which same with the link provided on linkdin.
$redirect_uri = "http://mysocial.com/auth";
// Defining scope.
$scope = rawurlencode('openid profile email');
$url = "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri&state=foobar&scope=$scope";
