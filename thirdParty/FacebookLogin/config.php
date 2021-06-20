<?php
require_once 'vendor/autoload.php';

// Call Facebook API

$facebook = new \Facebook\Facebook([
  'app_id'      => FB_APP_ID,
  'app_secret'     => FB_APP_SECRET,
  'default_graph_version'  => FB_DEFAULT_GRAPH_VERSION
]);
?>