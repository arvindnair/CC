<?php
session_start ();
include_once ("connection.php");
include_once ("common_functions.php");

if (! $_SESSION ['userid']) {
	header ( "Location: login.php" );
	exit ();
}
?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Users</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="./css/bootstrap.css" media="screen">
<link rel="stylesheet" href="./css/custom.css">
<script src="./js/jquery-2.0.3.min.js"></script>
<script src="./js/bootstrap.js"></script>
</head>
<body>
<?php show_navbar()?>

<div id="imagecover" style='overflow: auto; z-index: 1'>
		<div class="container" id="stuff"
			style='background-color: transparent; overflow: auto; z-index: 2'>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
<?php
$users = show_users ();
$follower = following ( $_SESSION ['userid'] );
$uname = $_SESSION ['username'];
if (count ( $users )) {
	?>
    <?php
	foreach ( $users as $key => $value ) {
		if ($value == $uname) {
		} else {
			echo "<div class='panel panel-default'>";
			echo "<div class='panel-body'>";
			echo "$value";
			if (in_array ( $key, $follower )) {
				echo "<button type='button' onclick='window.location.href=\"tofollow.php?id=$key&do=unfollow\"' class='btn btn-danger pull-right'>Unfollow</button>";
			} else {
				echo "<button type='button' onclick='window.location.href=\"tofollow.php?id=$key&do=follow\"' class='btn btn-warning pull-right'>&nbsp;Follow&nbsp;&nbsp;</button>";
			}
			echo "</div>";
			echo "</div>";
		}
	}
	?>
<?php
} else {
	?>
<div align="center">
				<span style="color: white;"><strong>There are no users in the
						system!</strong></span>
			</div>
<?php
}
?>
        </div>
	</div>
</body>
</html>