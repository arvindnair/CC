
<link rel="stylesheet" href="./css/spam.css">
<link rel="stylesheet" href="./css/bootstrap.css" media="screen">
<?php
require_once ("connection.php");
include_once ('common_functions.php');
$spam = $_GET ['value'];
$names = $_SESSION ['userid'];
$names = mysql_real_escape_string ( $names );
$spam = mysql_real_escape_string ( $spam );
$ps = $_GET ['value'];
$names = $_SESSION ['userid'];

$query = "SELECT users_id,id from review where users_id = ";
$query = $query . $names;
$query = $query . " and id = ";
$query = $query . $ps;
$result = mysql_query ( $query );
if (mysql_fetch_row ( $result )) {
	echo " You can not report your own review as Spam!";
	echo "<center>";
	echo "<button class=\"btn btn-warning btn-md\"
 			onclick=\"window.close('addvote.php')\">Close Window</button>";
	echo "</center>";
	return;
}

$query = "SELECT vote_id , user_id from spam where vote_id = ";
$query = $query . $spam;
$query = $query . " and user_id = ";
$query = $query . $names;
$result = mysql_query ( $query );
if (mysql_fetch_row ( $result ) > 0) {
	echo " You have already reported this as spam!";
} 

else {
	$query = "INSERT INTO spam (vote_id , user_id) VALUES ('{$spam}','{$names}')";
	$result = mysqli_query ( $connection, $query );
	if ($result) {
		echo "<center>";
		echo "Spam Reported";
		echo "</center>";
		?>
</br>
</br>
<?php
	} else {
		die ( "Database query failed." . mysqli_error ( $connection ) );
	}
}
?>

<center>
	<button class="btn btn-warning btn-md"
		onclick="window.close('vote3.php')">Close Window</button>

</center>