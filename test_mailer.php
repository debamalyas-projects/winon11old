<?php
include('common/include.php');

$recipient_arr = array();
$recipient_arr[]=array('address'=>'debamalyas.projects@gmail.com','name'=>'Debamalya Sarker');
$recipient_arr[]=array('address'=>'debamalyas.software.tutorials@gmail.com','name'=>'Debamalya Sarker');

$replyto_arr = array();
$replyto_arr[]=array('address'=>'bhattacharjeesubhajit92@gmail.com','name'=>'Subhajit Bhattacharjee');
$replyto_arr[]=array('address'=>'debamalyas.software.tutorials@gmail.com','name'=>'Debamalya Sarker');

$cc_arr = array();
$cc_arr[]=array('address'=>'pamirghosh1998@gmail.com','name'=>'Pamir Ghosh');
$cc_arr[]=array('address'=>'debamalyas.software.tutorials@gmail.com','name'=>'Debamalya Sarker');

$bcc_arr = array();
$bcc_arr[]=array('address'=>'pamirghosh1998@gmail.com','name'=>'Pamir Ghosh');
$bcc_arr[]=array('address'=>'suman.official2019@gmail.com','name'=>'Suman Maji');

$attachment_arr = array();
$attachment_arr[]=array('path'=>'uploads/file.txt','name'=>'test.txt');

$mailParams = array(
					'mailSystemArr_json'=>mailSystemArr_json,
					'recipient_arr'=>$recipient_arr,
					'replyto_arr'=>$replyto_arr,
					'cc_arr'=>$cc_arr,
					'bcc_arr'=>$bcc_arr,
					'attachment_arr'=>$attachment_arr,
					'SetFromAddress'=>'service.syncxini@gmail.com',
					'SetFromName'=>'Syncxini Infosystem',
					'subject'=>'Test Email',
					'content'=>'<b>This is a test email.</b>'
					);

$mailObj = new mailer($mailParams);

$return=$mailObj->sendMailer();

echo $return;