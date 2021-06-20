<?php

function replace_tags_html($tags_arr,$content){
	
	foreach($tags_arr AS $key=>$val){
		$content = str_replace($key,$val,$content);
	}
	
	return $content;
}

function check_login(){
	if(!isset($_SESSION['customer']['id'])){
		header('location:login.php');
	}
}

function check_logout(){
	if(isset($_SESSION['customer']['id'])){
		header('location:dashboard.php');
	}
}