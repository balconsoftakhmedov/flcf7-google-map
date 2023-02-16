var map;
var autocomplete;
var marker;
var infoWindow;
var geocoder;

function initMap() {
	var mapDiv = jQuery('.google-map')[0];

	map = new google.maps.Map(mapDiv, {
		center: {lat: -34.397, lng: 150.644},
		zoom: 8
	});
	if (marker) {
			marker.setMap(null);
		}

		marker = new google.maps.Marker({
			map: map,
			position: {lat: -34.397, lng: 150.644}
		});
	autocomplete = new google.maps.places.Autocomplete(jQuery('.google-map-autocomplete')[0]);
	autocomplete.bindTo('bounds', map);

	autocomplete.addListener('place_changed', function () {
		var place = autocomplete.getPlace();
		if (!place.geometry) {
			return;
		}

		if (marker) {
			marker.setMap(null);
		}

		marker = new google.maps.Marker({
			map: map,
			position: place.geometry.location
		});

		if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		} else {
			map.setCenter(place.geometry.location);
			map.setZoom(17);
		}
	});

	infoWindow = new google.maps.InfoWindow({
		content: "Marker Location"
	});
	geocoder = new google.maps.Geocoder();
	google.maps.event.addListener(map, 'click', function (event) {
		marker.setPosition(event.latLng);
		geocoder.geocode({'latLng': event.latLng}, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					infoWindow.setContent(results[0].formatted_address);
					infoWindow.open(map, marker);
				}
				jQuery('.google-map-autocomplete').val(results[0].formatted_address);
			}
		});
	});
}





