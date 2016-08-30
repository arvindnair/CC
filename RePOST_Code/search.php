<?php
session_start ();
include_once ('connection.php');
include_once ('common_functions.php');

if (! isset ( $_SESSION ['userid'] )) {
	header ( "Location: login.php" );
	exit ();
}

if (isset ( $_POST ['q'] )) {
	if (strcmp ( $_POST ['q'], '' ) == 0) {
		header ( "Location: index.php" );
		exit ();
	}
	$_SESSION ['q'] = $_POST ['q'];
} else if (isset ( $_SESSION ['q'] )) {
	$_POST ['q'] = $_SESSION ['q'];
} else {
	header ( "Location: index.php" );
	exit ();
}

if (isset ( $_POST ['delete'] )) {
	$my_name = get_username ( $_SESSION ['userid'] );
	if (strcmp ( $my_name, $_POST ['username'] ) == 0) {
		delete_roar ( $_POST ['msg_id'] );
		$_SESSION ['message'] = 'Deleted post!';
	} else {
		$_SESSION ['message'] = "You can't delete this post!";
	}
}
?>


<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Search Hashtags</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.css" media="screen">
<link rel="stylesheet" href="css/custom.css">
<script src="js/jquery-2.0.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</head>

<body>
<?php show_navbar(); ?>
<div id="imagecover" style='overflow: auto; z-index: 1'>
    <?php
				if (isset ( $_SESSION ['message'] )) {
					echo "<center><br><br><br><span style='color:white;'><strong>" . $_SESSION ['message'] . "</strong></span></center>\n";
					unset ( $_SESSION ['message'] );
				} else {
					
					echo "<br><br><br><br>\n";
				}
				?>
    <div class="container" id="stuff" align="center"
			style='background-color: transparent; overflow: auto; z-index: 2'>
			<br>
			<br>
        <?php
								$tag_string = mysql_real_escape_string ( $_POST ['q'] );
								$tag_string = strtolower ( $tag_string );
								$tag_string = str_replace ( '#', '', $tag_string );
								$tags = explode ( " ", $tag_string );
								$review = array ();
								$review = search_posts ( $tags, 0 );
								
								if (count ( $review )) {
									display_review ( $review );
									?>

        <br>
			<br>
			<br>
		</div>
	</div>
<?php
								} else {
									?>
    <div class="panel panel-default">
		<div class="panel-body">
			<span style='color: black;'><strong>Hashtag not found!</strong>
		
		</div>
	</div>
<?php
								}
								
								?>
</body>
</html>

