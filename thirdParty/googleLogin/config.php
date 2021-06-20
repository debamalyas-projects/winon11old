<?php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Client ID
$google_client->setClientId(GOOGLE_CLIENT_ID);

//Client Secret key
$google_client->setClientSecret(GOOGLE_SCRET_KEY);

//Redirect URI
$google_client->setRedirectUri(GOOGLE_REDIRECT_URI);

//Scope
$google_client->addScope('email');

$google_client->addScope('profile');

?>