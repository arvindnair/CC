<?php
session_start ();
include_once ("connection.php");
include_once ("common_functions.php");

$id = $_GET ['id'];
$do = $_GET ['do'];

switch ($do) {
	case "follow" :
		become_follower ( $_SESSION ['userid'], $id );
		$msg = "You have become a follower!";
		break;
	
	case "unfollow" :
		im_not_a_follower ( $_SESSION ['userid'], $id );
		$msg = "Unfollowed!";
		break;
}
$_SESSION ['message'] = $msg;
header ( "Location:index.php" );
?>