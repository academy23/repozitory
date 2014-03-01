<?php
	$host = 'localhost';
	$user = 'root';
	$pwd  = '';
	$dbname = 'univer';
	$db = mysql_connect($host, $user, $pwd);
	mysql_select_db($dbname, $db);
	mysql_set_charset( 'utf8' );
?>