<?php
session_start();

define('API_URL','https://winon11.com/syncxini/admin/api/');

define('ASSET_LINK','https://winon11.com/assets/');

define('CLIENT_EMAIL','debamalyas.projects@gmail.com');

define('CLIENT_NAME','WinON11');

define('BASE_URL','https://winon11.com/');

//PHP Mailer Constants
$mailSystemArr = array(
						'Mailer'=>'smtp',
						'SMTPDebug'=>0,
						'SMTPAuth'=>TRUE,
						'SMTPSecure'=>'tls',
						'Port'=>587,
						'Host'=>'smtp.gmail.com',
						'Username'=>'service.syncxini@gmail.com',
						'Password'=>'123#@developer',
						'IsHTML'=>true
						);
$mailSystemArr_json = json_encode($mailSystemArr);
define('mailSystemArr_json',$mailSystemArr_json);

//SMS Gateway constants
define('SMS_API_KEY','sD7FZL7UHro-iVQpGSo7VAw5P4bxxyjkCvy02j85Rg');
define('SMS_API_URL','http://api.textlocal.in/send/?');

//FB Constants
define('FB_APP_ID','784856505385652');
define('FB_APP_SECRET','73d5b97fd3167a282f0a554fe40744d0');
define('FB_DEFAULT_GRAPH_VERSION','v2.10');
define('FB_REDIRECT_URI','https://winon11.com/facebook_login.php');

//Google Constants
define('GOOGLE_CLIENT_ID','320138859813-uhld3pb6ljkctbj8ajp3nvleqgv5ouir.apps.googleusercontent.com');
define('GOOGLE_SCRET_KEY','iJgANr4UTnQmDKtfTMsKhzmM');
define('GOOGLE_REDIRECT_URI','https://winon11.com/google_login.php');

//PayuMoney Constants
define('MERCHANT_KEY','MBBifamP');
define('SALT','jtsGlQDXBy');
// End point - change to https://test.payu.in for TEST mode
define('PAYU_BASE_URL','https://secure.payu.in');
//AADHAR Card Validation Constants
define('AADHAR_NUMBER_LINK','https://aadhaarnumber-verify.p.rapidapi.com/Uidverify?');
define('CLIENTID','111');
define('METHOD','uidverify');
define('TXN_ID','123456');
define('CURLOPT_MAXREDIRS_NO','10');
define('CURLOPT_TIMEOUT_NO','30');
define('content-type','application/x-www-form-urlencoded');
define('x-rapidapi-host','aadhaarnumber-verify.p.rapidapi.com');
define('x-rapidapi-key','43763226fbmsh713fd22fd0520f5p19e977jsn720f6f3f2906');