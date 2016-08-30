<?php
session_start ();
include_once ('connection.php');
include_once ('common_functions.php');
$sqlquery = "select review.body,review.id from review, users
where review.users_id = users.id";
$result = mysql_query ( $sqlquery );
while ( $data = mysql_fetch_object ( $result ) ) {
	echo $result;
}

?>