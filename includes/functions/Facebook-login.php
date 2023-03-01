<?php

require_once('../../../../../vendor/autoload.php');

use League\OAuth2\Client\Provider\Facebook;

$provider = new Facebook([
    'clientId'          => '731594688539578',
    'clientSecret'      => '0e53c9cc75a124904a54673548fddf31',
    'redirectUri'       => 'https://sportpath.org/includes/functions/facebook-callback.php',
    'graphApiVersion'   => 'v2.10'
]);

$authorizationUrl = $provider->getAuthorizationUrl();

// echo '<pre>';print_r($authUrl);echo '</pre>';exit;

header('Location: '.$authorizationUrl);
exit;