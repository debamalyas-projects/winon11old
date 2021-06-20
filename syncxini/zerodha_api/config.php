<?php
session_start();
define('WWW_ROOT_DIR', dirname(__FILE__));
define('ZERODHA_API_URL','https://api.kite.trade/');
define('ZERODHA_API_KEY','ctjs4phukxk3ierz');
define('ZERODHA_API_SECRET','lfwfroxu2gocav23tvwijg9d2edzfose');
require(WWW_ROOT_DIR."/library/kiteconnect.php");
require(WWW_ROOT_DIR.'/functions.php');

 ?>