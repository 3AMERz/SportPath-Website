<?php
session_start();

require_once('../../../../../vendor/autoload.php');
// require dirname(__FILE__).'/src/user.php';

$provider = new League\OAuth2\Client\Provider\Facebook([
    'clientId'          => '731594688539578',
    'clientSecret'      => '0e53c9cc75a124904a54673548fddf31',
    'redirectUri'       => 'https://sportpath.org/includes/functions/github-callback.php',
    'graphApiVersion'   => 'v2.10'
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $user = $provider->getResourceOwner($token);
        $userArr = $user->toArray();

        print_r($userArr);
        
        // $_POST['action'] = 'loginWithGithub';
        // include 'loginWithApps.php';

        
        // Use these details to create a new profile
        // printf('Hello %s!', $user->getNickname());

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    // echo $token->getToken();
}