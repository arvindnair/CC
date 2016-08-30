
<link rel="stylesheet" href="./css/vote4.css">
<link rel="stylesheet" href="./css/bootstrap.css" media="screen">
<?php
include_once ('connection.php');
include_once ('common_functions.php');
$spam = $_GET ['value'];
$query = "SELECT count(vote_id) from spam where vote_id = ";
$query .= $spam;
$result = mysqli_query ( $connection, $query );
$result = mysql_query ( $query ) or die ( mysql_error () );
$row = mysql_fetch_array ( $result );
echo "<center>";
echo "Number of users who have reported this as spam: " . $row [0];
echo "</center>";
?>
</br>
</br>
<center>
	<button class="btn btn-warning btn-md"
		onclick="window.close('vote4.php')">Close Window</button>

</center>