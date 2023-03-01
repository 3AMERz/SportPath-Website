<?php

require_once('../../../../../vendor/autoload.php');

use League\OAuth2\Client\Provider\Github;

$provider = new Github([
    'clientId'          => '50459096f293e5250b25',
    'clientSecret'      => '12f2fae0cbf415c42a4ce8d3dcd5cd5507cbd17b',
    'redirectUri'       => 'https://sportpath.org/includes/functions/github-callback.php',
]);

$options = [
    'state' => 'OPTIONAL_CUSTOM_CONFIGURED_STATE',
    'scope' => ['user','user:email','repo'] // array or string; at least 'user:email' is required
];

$authorizationUrl = $provider->getAuthorizationUrl($options);

// echo '<pre>';print_r($authUrl);echo '</pre>';exit;

header('Location: '.$authorizationUrl);
exit;