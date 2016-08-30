<?php
session_start ();
include_once ("connection.php");
include_once ("common_functions.php");

if (user_exist ( $_SESSION ['username'] )) {
	$userid = $_SESSION ['userid'];
	$body = substr ( $_POST ['body'], 0, 360 );
	$body = htmlspecialchars ( $body );
	$lat = $_POST ['lat'];
	$lng = $_POST ['lng'];
	
	add_post ( $userid, $body, $lat, $lng );
	
	header ( "Location:index.php" );
} else {
	header ( "Location:login.php" );
}
?>