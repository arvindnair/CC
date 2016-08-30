var geo_tag;
var map;
var markers = Array();
var map_data = Array();
function start() {
	geo_tag = new google.maps.Geocoder();
	var myLatlng = new google.maps.LatLng(0, 0);
	var my_choice = {
		zoom : 12,
		center : myLatlng,
		mapTypeId : google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById('gmap_canvas'), my_choice);
}
function clearFunction() {
	if (markers) {
		for (i in markers) {
			markers[i].setMap(null);
		}
		markers = [];
		map_data = [];
	}
}
function clearInfos() {
	if (map_data) {
		for (i in map_data) {
			if (map_data[i].getMap()) {
				map_data[i].close();
			}
		}
	}
}
function find_location() {
	var address = document.getElementById("gmap_where").value;
	geo_tag.geocode({
		'address' : address
	}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			var addrLocation = results[0].geometry.location;
			map.setCenter(addrLocation);
			document.getElementById('lat').value = results[0].geometry.location
					.lat();
			document.getElementById('lng').value = results[0].geometry.location
					.lng();
			var addrMarker = new google.maps.Marker({
				position : addrLocation,
				map : map,
				title : results[0].formatted_address,
				icon : 'marker.png'
			});
		} else {
			alert('Geocode was not successful for the following reason: '
					+ status);
		}
	});
}
function find_places() {
	var type = document.getElementById('gmap_type').value;
	var radius = document.getElementById('gmap_radius').value;
	var keyword = document.getElementById('gmap_keyword').value;
	var lat = document.getElementById('lat').value;
	var lng = document.getElementById('lng').value;
	var cur_location = new google.maps.LatLng(lat, lng);
	var request = {
		location : cur_location,
		radius : radius,
		types : [ type ]
	};
	if (keyword) {
		request.keyword = [ keyword ];
	}
	service = new google.maps.places.PlacesService(map);
	service.search(request, create_markers);
}
function create_markers(results, status) {
	if (status == google.maps.places.PlacesServiceStatus.OK) {
		clearFunction();
		for (var i = 0; i < results.length; i++) {
			createMarker(results[i]);
		}
	} else if (status == google.maps.places.PlacesServiceStatus.ZERO_RESULTS) {
		alert('No matching data found');
	}
}
function createMarker(obj) {
	var mark = new google.maps.Marker({
		position : obj.geometry.location,
		map : map,
		title : obj.name
	});
	markers.push(mark);
	var infowindow = new google.maps.InfoWindow({
		content : '<img src="' + obj.icon + '" /><font style="color:#000;">'
				+ obj.name + '<br />Rating: ' + obj.rating + '<br />Vicinity: '
				+ obj.vicinity + '</font>'
	});
	google.maps.event.addListener(mark, 'click', function() {
		clearInfos();
		infowindow.open(map, mark);
	});
	map_data.push(infowindow);
}
google.maps.event.addDomListener(window, 'load', start);