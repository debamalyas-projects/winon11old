<?php
include('common/include.php');

check_login();

$id=$_GET['id'];

$EmailVerificationStatus=1;

$request = array();
$request['tableName'] = 'customers';
$request['fields_to_be_updated'] = array('EmailVerificationStatus'=>$EmailVerificationStatus,'EmailVerificationCode'=>'');
$request['fields'] = array('EmailVerificationCode'=>$id);
$request_json = json_encode($request);

$api = API_URL.'update_entity_fields_by_fields_from_table';

$curl_obj = new curl($request_json,$api);

$result = $curl_obj->exec_curl();
$result_array_customer = json_decode($result,true);

$_SESSION['message']=$result_array_customer['message'];
header('location:myAccount.php');

?>