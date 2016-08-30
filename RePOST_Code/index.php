<?php
session_start ();

include_once ('connection.php');
include_once ('common_functions.php');

if (! isset ( $_SESSION ['userid'] )) {
	header ( "Location: login.php" );
	exit ();
}

if (isset ( $_POST ['delete'] )) {
	$my_name = get_username ( $_SESSION ['userid'] );
	if (strcmp ( $my_name, $_POST ['username'] ) == 0) {
		delete_review ( $_POST ['msg_id'] );
		$_SESSION ['message'] = 'Deleted post!';
	} else {
		$_SESSION ['message'] = "You can't delete this post!";
	}
}
?>

<html>
<head>

<title></title>
<meta
	content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'
	name='viewport' />
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="./css/bootstrap.css" media="screen">
<link rel="stylesheet" href="./css/custom.css">
<script src="./js/jquery-2.0.3.min.js"></script>
<script src="./js/bootstrap.js"></script>

<script>
        function charCount(v){
            var length = v.value.length;
            $('#char_count').text(length);
        }
        
    </script>

<script type="text/javascript">
        $(document).ready(function(){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getCoords);
            }
            else{
                alert("Error");
                console.log("No location services");
            }
        });

        function getCoords( position ) {
            document.getElementById('lat').value = position.coords.latitude;
            document.getElementById('lng').value = position.coords.longitude;
        }
    </script>

</head>

<body>
<?php show_navbar(); ?>
<div id="imagecover" style='overflow: auto; z-index: 1'>
<?php
if (isset ( $_SESSION ['message'] )) {
	echo "<center></br></br></br></br></br><span style='color:white;'><strong>" . $_SESSION ['message'] . "</strong></span></center>\n";
	unset ( $_SESSION ['message'] );
} else {
	
	echo "<br><br><br><br>\n";
}
?>
<div class="container" id="stuff" align="center"
			style='background-color: transparent; overflow: auto; z-index: 2'>
			<form method='post' action='add.php'>
				<br>
				<div align="right" style="color: white; font-weight: bold;">
					<span id="char_count"> 0 </span> <span> / 360 </span>
				</div>
				<textarea class="form-control has-warning" name='body' rows="5"
					maxlength='360' placeholder="Post your review.."
					style='resize: none;' onKeyUp="charCount(this)"></textarea>
				<br>

				<div align="right">
					<input type='hidden' name='lat' id='lat' value='0'> <input
						type='hidden' name='lng' id='lng' value='0'>
					<button type="submit" name="review" class="btn btn-warning btn-md">POST</button>
				</div>

			</form>
			<br>
			<br>
    <?php
				
				$users = show_users ( $_SESSION ['userid'] );
				
				if (count ( $users )) {
					$myusers = array_keys ( $users );
				} else {
					$myusers = array ();
				}
				$myusers [] = $_SESSION ['userid'];
				$review = show_posts ( $myusers, 0 );
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
			<span style='color: black;'><strong>There's nothing posted!</strong>
		
		</div>
	</div>
<?php
				}
				
				?>
</body>
<script
	src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
</html>