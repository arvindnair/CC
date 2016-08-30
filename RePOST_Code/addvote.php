
<link rel="stylesheet" href="./css/vote1.css">
<link rel="stylesheet" href="./css/bootstrap.css" media="screen">

<?php

require_once ("connection.php");
include_once ('common_functions.php');
?>
<?php

if (isset ( $_POST ["vote"] )) {
	
	$vote_id = $_POST ["msg_id"];
	$vote = ( int ) $_POST ["vot"];
	$names = $_SESSION ['userid'];
}
$query = "SELECT user_id,vote_id from vote where user_id = ";
$query = $query . $names;
$query = $query . " and vote_id = ";
$query = $query . $vote_id;
$result = mysql_query ( $query );
if (mysql_fetch_row ( $result )) {
	echo " You have already voted";
} else {
	$query = "INSERT INTO vote (vote_id,vote_count,user_id)
VALUES ('{$vote_id}','{$vote}','{$names}')";
	$result = mysqli_query ( $connection, $query );
	if ($result) {
		?>
<center>
	<p>Your vote has been recorded!!</p>
	<p>Thanks for your vote!</p>
	</br>
</center>
<?php
	} else {
		die ( "Database query failed." . mysqli_error ( $connection ) );
	}
	
	mysqli_close ( $connection );
}
?>
<center>
	<button class="btn btn-warning btn-md"
		onclick="window.close('addvote.php')">Close Window</button>

</center>