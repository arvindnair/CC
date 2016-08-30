<?php
$SERVER = 'localhost';
$USER = 'root';
$PASS = 'password';
$DB_NAME = 'cloud';

$connection = mysqli_connect ( $SERVER, $USER, $PASS, $DB_NAME );
if (! ($connect = mysql_connect ( $SERVER, $USER, $PASS ))) {
	echo "<h2>Error connecting to database.</h2><br/>";
	exit ();
}

mysql_select_db ( $DB_NAME );

?>