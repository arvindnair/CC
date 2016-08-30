
<link rel="stylesheet" href="./css/vote1.css">
<link rel="stylesheet" href="./css/bootstrap.css" media="screen">

<?php
include_once ('connection.php');
include_once ('common_functions.php');
$ps = $_GET ['value'];
$names = $_SESSION ['userid'];

$query = "SELECT users_id,id from review where users_id = ";
$query = $query . $names;
$query = $query . " and id = ";
$query = $query . $ps;
$result = mysql_query ( $query );
if (mysql_fetch_row ( $result )) {
	echo " You can not vote on your own review";
	echo "<center>";
	echo "<button class=\"btn btn-warning btn-md\"
 			onclick=\"window.close('addvote.php')\">Close Window</button>";
	echo "</center>";
	return;
}
?>

<?php
echo "<ul style=\"list-style-type:none\">";
echo "<form action=\"addvote.php\" name=\"abc\" method=\"post\">Select vote value";
echo "</br>";

echo "<input type=\"hidden\" name=\"msg_id\" value='" . $ps . "'>";
echo "<li>";
echo "<input type=\"radio\" name=\"vot\" value=\"1\" />";
?>
<img src=img/1star.png alt=1star style="width: 75px; height: 20px">
</li>
<li><input type=radio name=vot value=2> <img src=img/2star.png alt=2star
	style="width: 75px; height: 20px"></li>
<li><input type=radio name=vot value=3> <img src=img/3star.png alt=3star
	style="width: 75px; height: 20px"></li>
<li><input type=radio name=vot value=4> <img src=img/4star.png alt=4star
	style="width: 75px; height: 20px"></li>
<li><input type=radio name=vot value=5> <img src=img/5star.png alt=5star
	style="width: 75px; height: 20px"></li>
</br>
</br>
<input type=submit class="btn btn-warning btn-md" name=vote value=RecordVote! >
</form>
</ul>


