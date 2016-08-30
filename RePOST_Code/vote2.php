
<link rel="stylesheet" href="./css/vote2.css">
<link rel="stylesheet" href="./css/bootstrap.css" media="screen">
<?php
include_once ('connection.php');
include_once ('common_functions.php');
$votes_id = $_GET ['value'];
$query = "SELECT AVG (vote_count) from vote where vote_id = ";
$query .= $votes_id;
$result = mysqli_query ( $connection, $query );
$result = mysql_query ( $query ) or die ( mysql_error () );
$row = mysql_fetch_array ( $result );
echo "<center>";
echo "The average vote is " . $row [0] . " / 5";
echo "</center>";
$query = "SELECT count(vote_id) from vote where vote_id = ";
$query .= $votes_id;
$result = mysqli_query ( $connection, $query );
$result = mysql_query ( $query ) or die ( mysql_error () );
$row = mysql_fetch_array ( $result );
echo "</br>";
echo "<center>";
echo "Number of users who have voted: " . $row [0];
echo "</center>";
echo "</br>";
?>
<center>
	<button class="btn btn-warning btn-md"
		onclick="window.close('vote2.php')">Close Window</button>

</center>