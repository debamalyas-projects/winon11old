<?php
include('common/include.php');

$smsParams = array();
$smsParams['sender'] = 'TXTLCL';
$smsParams['numbers'] = array('8910607157','9748803292');
$smsParams['message'] = 'Your OTP for account verification : 123456 . OTP is valid for 180 seconds. Thanks - Zero2Crore .';

$smsObj = new sms($smsParams);

$return=$smsObj->sendSMS();

print_r($return);