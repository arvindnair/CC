<?php
session_start ();
function add_post($userid, $body, $lat, $lng) {
	if (! $userid | ! $body) {
		$_SESSION ['message'] = "Empty Message";
		return;
	}
	$body = mysql_real_escape_string ( $body );
	$sqlquery = "insert into review (users_id, body, timestamp, lat, lng) values ($userid, '$body' ,now(), $lat, $lng)";
	$result = mysql_query ( $sqlquery );
	if (! $result) {
		die ( mysql_error () );
	}
	$_SESSION ['message'] = "Your post has been added!";
	$msg_id = mysql_insert_id ();
	$hashes = array ();
	$body = strtolower ( $body );
	$words = explode ( " ", $body );
	foreach ( $words as $word ) {
		if (ord ( $word ) == ord ( "#" ) and strlen ( $word ) > 1) {
			array_push ( $hashes, substr ( $word, 1 ) );
		}
	}
	foreach ( $hashes as $hash ) {
		$sqlquery = "insert into hashtags (hashtag, review_id) values ('$hash', $msg_id)";
		$result = mysql_query ( $sqlquery );
		if (! $result) {
			die ( mysql_error () );
		}
	}
}
function show_posts($userid, $limit = 0) {
	$review = array ();
	
	$user_string = implode ( ',', $userid );
	
	if ($limit > 0) {
		$added = "limit $limit";
	} else {
		$added = '';
	}
	
	$sqlquery = "select review.users_id, review.body, review.timestamp, review.id, review.lat, review.lng, users.username from review, users
		where review.users_id in ($user_string) and review.users_id = users.id
		order by review.timestamp desc $added ";
	
	$result = mysql_query ( $sqlquery );
	
	while ( $data = mysql_fetch_object ( $result ) ) {
		$review [] = array (
				'timestamp' => $data->timestamp,
				'username' => $data->username,
				'body' => substr ( stripslashes ( nl2br ( $data->body ) ), 0, 360 ),
				'msg_id' => $data->id,
				'lat' => $data->lat,
				'lng' => $data->lng 
		);
	}
	return $review;
}
function search_posts($tags, $limit = 0) {
	$review = array ();
	
	$tag_string = implode ( "','", $tags );
	
	if ($limit > 0) {
		$added = "limit $limit";
	} else {
		$added = '';
	}
	
	$sqlquery = "select review.users_id, review.body, review.timestamp, review.lat, review.lng, review.id, users.username, hashtags.hashtag, hashtags.review_id from review, users, hashtags
		where hashtags.hashtag in ('$tag_string') and hashtags.review_id = review.id and review.users_id = users.id
		order by review.timestamp desc $added ";
	$result = mysql_query ( $sqlquery );
	
	while ( $data = mysql_fetch_object ( $result ) ) {
		$review [] = array (
				'timestamp' => $data->timestamp,
				'username' => $data->username,
				'body' => substr ( stripslashes ( nl2br ( $data->body ) ), 0, 360 ),
				'msg_id' => $data->id,
				'lat' => $data->lat,
				'lng' => $data->lng 
		);
	}
	return $review;
}
function delete_review($msg_id) {
	$sqlquery = "delete from review where review.id = '$msg_id'";
	$test = mysql_query ( $sqlquery );
	if (! $test) {
		die ( mysql_error () );
	}
	$sqlquery = "delete from hashtags where hashtags.review_id = '$msg_id'";
	$test = mysql_query ( $sqlquery );
	if (! $test) {
		die ( mysql_error () );
	}
}
function following($userid) {
	$follower = array ();
	$sqlquery = "select distinct users_id from follower
			where follower_id = '$userid'";
	$result = mysql_query ( $sqlquery );
	while ( $data = mysql_fetch_object ( $result ) ) {
		array_push ( $follower, $data->users_id );
	}
	return $follower;
}
function check_follower_count($follower, $herder) {
	$sqlquery = "select count(*) from follower
			where users_id='$herder' and follower_id='$follower'";
	$result = mysql_query ( $sqlquery );
	$row = mysql_fetch_row ( $result );
	return $row [0];
}

function become_follower($my_userID, $their_userID) {
	$count = check_follower_count ( $my_userID, $their_userID );
	
	if ($count == 0) {
		$sqlquery = "insert into follower (users_id, follower_id)
				values ($their_userID,$my_userID)";
		mysql_query ( $sqlquery );
	}
}


function im_not_a_follower($my_userID, $their_userID) {
	$count = check_follower_count ( $my_userID, $their_userID );
	
	if ($count != 0) {
		$sqlquery = "delete from follower
				where users_id='$their_userID' and follower_id='$my_userID'
				limit 1";
		
		mysql_query ( $sqlquery );
	}
}
function get_username($userid) {
	$sql = "select username from users where id = '$userid'";
	$result = mysql_query ( $sql );
	$username = mysql_fetch_object ( $result );
	return $username->username;
}
function get_userid($username) {
	$sql = "select id from users where username = '$username'";
	$result = mysql_query ( $sql );
	$id = mysql_fetch_object ( $result );
	return $id->id;
}
function show_users($user_id = 0) {
	$added = "";
	if ($user_id > 0) {
		$follow = array ();
		$follow_sqlquery = "select follower.users_id from follower
				where follower_id = $user_id";
		$follow_result = mysql_query ( $follow_sqlquery );
		
		while ( $f = mysql_fetch_object ( $follow_result ) ) {
			array_push ( $follow, $f->users_id );
		}
		if (count ( $follow )) {
			$id_string = implode ( ',', $follow );
			$added = " and id in ($id_string)";
		} else {
			return array ();
		}
	}
	$users = array ();
	$sqlquery = "select id, username from users
		where status='active'
		$added order by username";
	
	$result = mysql_query ( $sqlquery );
	
	while ( $data = mysql_fetch_object ( $result ) ) {
		$users [$data->id] = $data->username;
	}
	return $users;
}
function user_exist($username) {
	$username = mysql_real_escape_string ( $username );
	$query = mysql_query ( "SELECT username FROM users WHERE username = '$username'" ) or die ( mysql_error () );
	$result = mysql_num_rows ( $query );
	return $result;
}
function check_password($username, $password) {
	if (! $username | ! $password)
		die ( "Empty username or password" );
	$username = mysql_real_escape_string ( $username );
	$password = mysql_real_escape_string ( $password );
	$password = md5 ( $password );
	$query = mysql_query ( "SELECT * FROM users WHERE username = '$username'" ) or die ( mysql_error () );
	$result = mysql_fetch_array ( $query ) or die ( mysql_error () );
	
	if ($password != $result ['password']) {
		// passwords do not match
		return 0;
	} else {
		// passwords must match
		return 1;
	}
}
function show_navbar() {
	echo "<!--navbar begin-->\n";
	echo "<nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>\n";
	echo "   <a href='index.php' class='navbar-brand'>" . $_SESSION ['username'] . " </a>\n";
	echo "  <button class='navbar-toggle' data-toggle='collapse' data-target='.navHeaderCollapse' >\n";
	echo "    <span class='sr-only'>Toggle navigation</span>\n";
	echo "    <span class='icon-bar'></span>\n";
	echo "    <span class='icon-bar'></span>\n";
	echo "    <span class='icon-bar'></span>\n";
	echo "  </button>\n";
	echo "  <div class='collapse navbar-collapse navHeaderCollapse' style='overflow:hidden;'>\n";
	echo "    <ul class='nav navbar-nav'>\n";
	echo "      <li><a href='index.php'>Home</a></li>\n";
	echo "      <li><a href='userlist.php'>Follow</a></li>\n";
	echo "      <li><a href='chat.php'>Chat</a></li>\n";
	echo "      <li><a href='gmap.html'>GMap</a></li>\n";
	echo "     </ul>\n";
	echo "    <ul class='nav navbar-nav navbar-right'>\n";
	echo "<li style='padding-top: 5px'><form class='navbar-form' method='post' action='search.php' id='search' name='search'>\n";
	echo "<input name='q' type='text' style='font-size:16px;' size='40' placeholder='Search' />\n";
	echo "</form></li>\n";
	echo "      <li><a href='#'></a></li>\n";
	echo "      <li><a href='#'></a></li>\n";
	echo "      <li style='padding-top: 3px'><button type='button' class='btn btn-danger navbar-btn btn-sm' onclick='location.href=\"login.php\"'>Logout</button></li>\n";
	echo "      <li><a href='#'></a></li>\n";
	echo "    </ul>\n";
	echo "  </div>\n";
	echo "</nav>\n";
	echo "<!--navbar end-->\n";
}
function display_review($review) {
	foreach ( $review as $list ) {
		echo "<div class='panel panel-warning'>\n";
		echo "<div class='panel-heading' style='padding-bottom: 0; padding-top:0;'>\n";
		echo "<table class='table table-condensed panel-title' style='text-align: center;border-collapse: collapse;'>\n";
		echo "<tr class='warning' style='border:none'>\n";
		echo "<td style='text-align: left;  border:none;'>\n";
		echo "<strong>" . $list ['username'] . "</strong>\n";
		echo "</td>\n";
		echo "<td style='text-align: left; border:none'>\n";
		echo "</td>\n";
		echo "<td style='text-align: right; border:none;'>\n";
		echo "" . $list ['timestamp'] . "\n";
		echo "</td>\n";
		echo "<td style='text-align: right; width:10%; border:none;'>\n";
		echo "<form class='form-horizontal' role='form' action='" . $_SERVER ['PHP_SELF'] . "' method='post'>\n";
		echo "<input type='hidden' name='msg_id' value='" . $list ['msg_id'] . "'>\n";
		echo "<input type='hidden' name='username' value='" . $list ['username'] . "'>\n";
		echo "<button type='submit' name='delete' class='close'>&times;</button>\n";
		echo "</form>";
		echo "</td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "</div>\n";
		echo "<div class='panel-body' style='text-align: left'>\n";
		echo "" . $list ['body'] . "<br/>\n";
		echo "</div>\n";
		echo "<div class='panel-footer' align='right' style='background-color: #fcf8e3;'><a href='map.php?lat=" . $list ['lat'] . "&lng=" . $list ['lng'] . "'><span style='color: #c09853;'>Map&nbsp;
             </span></span><span class='glyphicon glyphicon-screenshot pull-right' style='color: #c09853;'></span></a></div>";
		
		$new = $list ['msg_id'];
		?>

<input type="button" class="btn btn-warning btn-md" value="Vote"
	onclick="window.open('vote1.php?value=<?php echo $new;?>','_blank','menubar=1,resizable=1,width=448,height=625')">

<input type="button" class="btn btn-warning btn-md" value="Vote Stats"
	onclick="window.open('vote2.php?value=<?php echo $new;?>','_blank','menubar=1,resizable=1,width=477,height=504')">

<input type="button" class="btn btn-warning btn-md" value="Report Spam"
	onclick="window.open('vote3.php?value=<?php echo $new;?>','_blank','menubar=1,resizable=1,width=625,height=610')">

<input type="button" class="btn btn-warning btn-md" value="Spam Count"
	onclick="window.open('vote4.php?value=<?php echo $new;?>','_blank','menubar=1,resizable=1,width=621,height=304')">


<?php
		echo "</div>\n";
	}
}

?>



