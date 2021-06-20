<?php
include('common/include.php');
check_login();
unset($_SESSION['customer']['id']);
header("location:index.php");
?>