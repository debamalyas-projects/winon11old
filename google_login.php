<?php
include('common/include.php');

check_logout();

//Google Login
include('thirdParty/googleLogin/config.php');

$login_button = '';

$login_button = $google_client->createAuthUrl();

if(isset($_GET["code"]))
{
	
 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

 if(!isset($token['error']))
 {

  $google_client->setAccessToken($token['access_token']);

  $_SESSION['access_token'] = $token['access_token'];

  $google_service = new Google_Service_Oauth2($google_client);

  $data = $google_service->userinfo->get();
  
  if(!empty($data->givenName))
  {
   $_SESSION['user_first_name'] = $data->givenName;
  }
  if(!empty($data->familyName))
  {
   $_SESSION['user_last_name'] = $data->familyName;
  }
  if(!empty($data->email))
  {
   $_SESSION['user_email_address'] = $data->email;
  }
 }
 header('location:dashboard.php');
}