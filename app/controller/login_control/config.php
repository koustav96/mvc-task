<?php

$client_id = "86opaue7273v2a";
$client_secret = "wxDOl2fxZXBfjhWM";
$redirect_uri = "http://mysocial.com/auth";
$scope = rawurlencode('openid profile email');
$url = "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri&state=foobar&scope=$scope";
