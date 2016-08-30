<?php
session_start ();
include_once ("connection.php");
include_once ("common_functions.php");

if (isset ( $_POST ['Register'] )) {
	
	if (! $_POST ['username'] | ! $_POST ['email'] | ! $_POST ['password'] | ! $_POST ['password2']) {
		$_SESSION ['message'] = 'You did not fill in all the fields';
		header ( "Location: " . $_SERVER ['PHP_SELF'] . "" );
		exit ();
	}
	$_POST ['username'] = mysql_real_escape_string ( $_POST ['username'] );
	$user_exist = user_exist ( $_POST ['username'] );
	if ($user_exist != 0) {
		$_SESSION ['message'] = 'Sorry, the username ' . $_POST ['username'] . ' is already in use.';
		header ( "Location: " . $_SERVER ['PHP_SELF'] . "" );
		exit ();
	}
	if ($_POST ['password'] != $_POST ['password2']) {
		$_SESSION ['message'] = 'Your passwords did not match. ';
		header ( "Location: " . $_SERVER ['PHP_SELF'] . "" );
		exit ();
	}
	if (strlen ( $_POST ['password'] ) < 8) {
		$_SESSION ['message'] = 'Your password is too short.';
		header ( "Location: " . $_SERVER ['PHP_SELF'] . "" );
		exit ();
	}
	$_POST ['password'] = mysql_real_escape_string ( $_POST ['password'] );
	$_POST ['username'] = mysql_real_escape_string ( $_POST ['username'] );
	$_POST ['password'] = md5 ( $_POST ['password'] );
	$insert = "insert into users (username, email, password) values ('" . $_POST ['username'] . "','" . $_POST ['email'] . "', '" . $_POST ['password'] . "')";
	$add_member = mysql_query ( $insert );
	$username = $_POST ['username'];
	session_unset ();
	$_SESSION ['username'] = $username;
	$_SESSION ['userid'] = get_userid ( $username );
	$_SESSION ['password'] = $_POST ['password'];
	header ( "Location: index.php" );
	exit ();
} else {
	show_reg_form ();
}
function show_reg_form() {
	?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Register!</title>
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
					<button type="button" class="close"
						onclick="location.href='login.php';" data-dismiss="modal"
						aria-hidden="true">&times;</button>
					<h4 class="modal-title">New User Registration</h4>
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
							<label for="email" class="sr-only">Email</label> <input
								type="email" class="form-control" name="email" id="email"
								placeholder="Email" maxlength="60">
						</div>
						<div class="form-group">
							<label for="password" class="sr-only">Password</label> <input
								type="password" class="form-control" name="password"
								id="password" placeholder="Password (Min: 8 characters)">
						</div>
						<div class="form-group">
							<label for="password2" class="sr-only">Password</label> <input
								type="password" class="form-control" name="password2"
								id="password2" placeholder="Confirm Password">
						</div>
                        <?php
	
	if (isset ( $_SESSION ['message'] )) {
		echo "<br><center><span style='color:black;'><strong>" . $_SESSION ['message'] . "</strong></span></center>";
		unset ( $_SESSION ['message'] );
	}
	?>

                </div>
					<div class="modal-footer" style="border-style: none;">
						<button type="submit" name="Register"
							class="btn btn-warning btn-lg">Register!</button>
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