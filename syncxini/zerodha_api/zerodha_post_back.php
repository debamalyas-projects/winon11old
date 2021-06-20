<?php
$post_data = $_REQUEST;
echo "<pre>"; print_r($post_data); echo "</pre>";
$file = fopen(dirname(__FILE__)."/zerodha_post_back.txt");
fwrite($file,serialize($post_data));
fclose($file);
?>