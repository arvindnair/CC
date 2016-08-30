<?php
session_start ();
include_once ("connection.php");
include_once ("common_functions.php");
$page = $_SERVER ['PHP_SELF'];

if (isset ( $_SESSION ['userid'] )) {
	unset ( $_SESSION ['userid'] );
}
if (isset ( $_SESSION ['username'] )) {
	unset ( $_SESSION ['username'] );
}
if (isset ( $_SESSION ['password'] )) {
	unset ( $_SESSION ['password'] );
}

show_login ();

if (isset ( $_POST ['login'] )) {
	
	if (! $_POST ['username'] or ! $_POST ['password']) {
		$_SESSION ['message'] = "Fill in the Fields...";
		header ( "Location: " . $_SERVER ['PHP_SELF'] . "" );
		exit ();
	}
	$user_exist = user_exist ( $_POST ['username'] );
	
	if ($user_exist == 0) {
		$_SESSION ['message'] = "That user does not exist in our database. <a href=registration.php>Click Here to Register</a>";
		header ( "Location: " . $_SERVER ['PHP_SELF'] . "" );
		exit ();
	}
	
	if (check_password ( $_POST ['username'], $_POST ['password'] ) == 0) {
		$_SESSION ['message'] = "Bad Password";
		header ( "Location: " . $_SERVER ['PHP_SELF'] . "" );
		exit ();
	} else {
		
		$_SESSION ['username'] = mysql_real_escape_string ( $_POST ['username'] );
		$_SESSION ['userid'] = get_userid ( $_SESSION ['username'] );
		$_SESSION ['password'] = md5 ( mysql_real_escape_string ( $_POST ['password'] ) );
		
		header ( "Location: index.php" );
		exit ();
	}
}
function show_login() {
	?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Post!</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.css" media="screen">
<link rel="stylesheet" href="css/custom.css">
<script src="js/jquery-2.0.3.min.js"></script>
<script src="js/bootstrap.js"></script>

</head>

<body>
	<script type="text/javascript">
        $(document).ready(function(){
            $('#myModal').modal('show');
        });
    </script>


	<a href="#myModal" data-toggle="modal">
		<div id="imagecover" style="z-index: 1;"></div>
	</a>

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
		data-backdrop="static" data-keyboard="false"
		aria-labelledby="myModalLabel" aria-hidden="true"
		style="overflow: hidden;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">

					<h4 class="modal-title">Login</h4>
				</div>
				<form class="form-horizontal" role="form"
					action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<div class="modal-body">
						<div class="form-group">
							<label for="username" class="sr-only">Username</label> <input
								type="text" class="form-control" name="username" id="username"
								placeholder="Username">
						</div>
						<div class="form-group">
							<label for="password" class="sr-only">Password</label> <input
								type="password" class="form-control" name="password"
								id="password" placeholder="Password">
						</div>
                        <?php
	
	if (isset ( $_SESSION ['message'] )) {
		echo "<br><center><b>" . $_SESSION ['message'] . "</b></center>";
		unset ( $_SESSION ['message'] );
	}
	?>
                </div>
					<div class="modal-footer" style="border-style: none;">
						<button type="button" name="new" class="btn btn-default btn-xs"
							onclick="location.href='registration.php';">Sign In</button>
						<button type="submit" name="login" class="btn btn-warning btn-lg">Log
							In</button>


					</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->


</body>
</html>

<?php
}
?>