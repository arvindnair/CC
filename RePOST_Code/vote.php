
<?php

include_once('connection.php');
include_once('common_functions.php');

if(isset($_POST['vote']))
{
	$votes_id=$_POST["msg_id"];
	
echo "<form action=\"addvote.php\" method=\"post\">Select vote value";
echo "</br>";
echo"<input type=\"hidden\" name=\"msg_id\" value='".$votes_id."'>";
echo "<input type=\"radio\" name=\"vot\" value=\"1\" /> One";
echo "<input type=\"radio\" name=\"vot\" value=\"2\" /> Two";
echo "<input type=\"radio\" name=\"vot\" value=\"3\" /> Three";
echo "<input type=\"radio\" name=\"vot\" value=\"4\" /> Four";
echo "<input type=\"radio\" name=\"vot\" value=\"5\" /> Five";
echo "<input type=\"submit\" name=\"vote\" value=\"Record Vote!\" >";
echo "</form>";
}

else if (isset($_POST['vote_stats']))
{
$votes_id=$_POST["msg_id"];
$query = "SELECT AVG (vote_count) from vote where vote_id = " ;
$query .=$votes_id;
$result = mysqli_query($connection, $query);
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($result);
echo "The average vote is ". $row[0] . " / 5";
$query = "SELECT count(vote_id) from vote where vote_id = ";
$query .=$votes_id;
$result = mysqli_query($connection, $query);
$result = mysql_query($query) or die(mysql_error());
$row = mysql_fetch_array($result);
echo "\br";
echo "Number of users who have voted: ". $row[0] ;
}

else if (isset($_POST['spam_report']))
{
	$spam = $_POST["msg_id"];
	 
	$query = "INSERT INTO spam (vote_id) VALUES ('{$spam}')";
	$result = mysqli_query($connection, $query);
	if($result)
	{
		echo "Record Created";
		?>
	<br/>
	
	<?php  
	}
	else
	{
	die("Database query failed." . mysqli_error($connection));
	}
}

else if (isset($_POST['spam_stats']))
{
	$spam = $_POST["msg_id"];
	$query = "SELECT count(vote_id) from spam where vote_id = ";
	$query .=$spam;
	$result = mysqli_query($connection, $query);
	$result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($result);
	echo "/br";
	echo "Number of users who have reported this as spam: ". $row[0] ;
}
?>