<?php
include('common/include.php');

check_login();

$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];

$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$salt="yIEkykqEH3";

  
$_SESSION['payu_message'] = "<span style='color: red;'>Your order status is '". $status ."'.<br>"."Your transaction id for this transaction is '".$txnid."'. Your Payment failed.</span>";
  header('location:myAccount.php');