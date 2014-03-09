<?php
	include_once("models/db_class.php");
	
	$content = '';
	$title = 'University';
	$h1 = '';
	$mesg = '';
	$chat = '';
	$admin_menu = '';
	$user_name = '';
	
	include ('controllers/action.php');
	include 'tpl.php'; echo $main_tpl;//вивід шаблона
	
?>