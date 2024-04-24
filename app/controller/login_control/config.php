<?php

require_once __DIR__. '/../../core/cred.php';

// Accessing client id  and client secret of linkedin.
global $client_id;
global $client_secret;
$c_id = $client_id;
$c_secret = $client_secret;
// Redirected uri which same with the link provided on linkdin.
$redirect_uri = "http://mysocial.com/auth";
// Defining scope.
$scope = rawurlencode('openid profile email');
$url = "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=$c_id&redirect_uri=$redirect_uri&state=foobar&scope=$scope";
