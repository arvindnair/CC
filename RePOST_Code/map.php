<?php
session_start ();
include_once ("connection.php");
include_once ("common_functions.php");

if (! $_SESSION ['userid']) {
	header ( "Location: login.php" );
	exit ();
}

$lat = $_GET ['lat'];
$lng = $_GET ['lng'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Repost!</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
			<link rel="stylesheet" href="./css/bootstrap.css" media="screen">
				<link rel="stylesheet" href="./css/custom.css">
					<script src="./js/jquery-2.0.3.min.js"></script>
					<script src="./js/bootstrap.js"></script>
					<style>
#map-canvas {
	height: 100%;
	margin: 0px;
	padding: 0px
}
</style>
					<script
						src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>

					<script>
        var map;

        function initialize() {
            var mapOptions = {
                <?php
																
																if ($lat != 0 or $lng != 0) {
																	echo "zoom: 15\n";
																} else {
																	echo "zoom: 18,\n";
																	echo "mapTypeId: google.maps.MapTypeId.SATELLITE\n";
																}
																?>
            };
            map = new google.maps.Map(document.getElementById('map-canvas'),
                mapOptions);

      <?php
						
						if ($lat != 0 or $lng != 0) {
							echo "
           var pos = new google.maps.LatLng($lat, $lng);\n


           var infowindow = new google.maps.InfoWindow({\n
                        map: map,\n
                        position: pos,\n
                        content: 'Location of post!'\n
           });\n

                    map.setCenter(pos);\n

            ";
						} else {
							echo "


           var content = 'Location unavailable';\n
           var options = {\n
                map: map,\n
                position: new google.maps.LatLng(0,0),\n
                content: content\n
            };\n

            var infowindow = new google.maps.InfoWindow(options);\n
            map.setCenter(options.position);\n
        ";
						}
						?>
        }
        google.maps.event.addDomListener(window, 'load', initialize);


    </script>

</head>


<body>
<?php show_navbar()?>
<div id="imagecover" style='overflow: auto; z-index: 1'>
		<div class="container" id="stuff" align="center"
			style='background-color: transparent; overflow: auto; z-index: 2;'>
			<br><br><br><br><br>
								<div id="map-canvas" style="height: 600px;"></div>
		
		</div>
	</div>
</body>

</html>