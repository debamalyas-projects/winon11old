<?php
include(dirname(__FILE__).'/config.php');
$from_date_time = new DateTime('2019-07-12 9:30:00');
$to_date_time = new DateTime('2019-07-12 15:30:00');
$data = zerodha_get_historical_data('minute', $from_date_time, $to_date_time, false);
pr($data);
?>