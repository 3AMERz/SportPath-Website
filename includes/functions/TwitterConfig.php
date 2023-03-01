<?php
require_once '../../../vendor/autoload.php';
  
$config = [
    'callback' => 'sportpath.org/index.php',
    'keys'     => ['key' => 'TWITTER_CONSUMER_API_KEY', 'secret' => 'TWITTER_CONSUMER_API_SECRET_KEY'],
    'authorize' => true
];
  
$adapter = new Hybridauth\Provider\Twitter( $config );