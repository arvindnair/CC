<?php
$function = $_POST ['function'];
$info = array ();
switch ($function) {
	
	case ('getState') :
		if (file_exists ( 'chat.txt' )) {
			$horizontal = file ( 'chat.txt' );
		}
		$info ['state'] = count ( $horizontal );
		break;
	case ('update') :
		$state = $_POST ['state'];
		if (file_exists ( 'chat.txt' )) {
			$horizontal = file ( 'chat.txt' );
		}
		$count = count ( $horizontal );
		if ($state == $count) {
			$info ['state'] = $state;
			$info ['text'] = false;
		} else {
			$text = array ();
			$info ['state'] = $state + count ( $horizontal ) - $state;
			foreach ( $horizontal as $count => $line ) {
				if ($count >= $state) {
					$text [] = $line = str_replace ( "\n", "", $line );
				}
			}
			$info ['text'] = $text;
		}
		break;
	case ('send') :
		$nickname = htmlentities ( strip_tags ( $_POST ['nickname'] ) );
		$message = htmlentities ( strip_tags ( $_POST ['message'] ) );
		if (($message) != "\n") {
			if (preg_match ( $reg_exUrl, $message, $url )) {
				$message = preg_replace ( $reg_exUrl, '<a href="' . $url [0] . '" target="_blank">' . $url [0] . '</a>', $message );
			}
			fwrite ( fopen ( 'chat.txt', 'a' ), "<span>" . $nickname . " " . date ( "h:i:s a" ) . "</span>" . $message = str_replace ( "\n", " ", $message ) . "\n" );
		}
		break;
}
echo json_encode ( $info );
?>