var maps = [];
var markers = [];
var infoWindows = [];
var geocoders = [];

function initMap() {
	jQuery('.google-map').each(function (index, element) {
		var map = new google.maps.Map(element, {
			center: {lat: -34.397, lng: 150.644},
			zoom: 8
		});

		maps.push(map);
		markers.push(null);


		var index = maps.indexOf(map);
		if (markers[index]) {
			markers[index].setMap(null);
		}

		markers[index] = new google.maps.Marker({
			map: map,
			position: {lat: -34.397, lng: 150.644}
		});

		infoWindows.push(new google.maps.InfoWindow({
			content: "Marker Location"
		}));
		geocoders.push(new google.maps.Geocoder());

		var autocomplete = new google.maps.places.Autocomplete(jQuery(element).siblings('.google-map-autocomplete')[0]);
		autocomplete.bindTo('bounds', map);

		autocomplete.addListener('place_changed', function () {
			var place = autocomplete.getPlace();
			if (!place.geometry) {
				return;
			}

			var index = maps.indexOf(map);
			if (markers[index]) {
				markers[index].setMap(null);
			}

			markers[index] = new google.maps.Marker({
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

		google.maps.event.addListener(map, 'click', function (event) {
			var index = maps.indexOf(map);
			markers[index].setPosition(event.latLng);
			geocoders[index].geocode({'latLng': event.latLng}, function (results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						infoWindows[index].setContent(results[0].formatted_address);
						infoWindows[index].open(map, markers[index]);
					}
					jQuery(element).siblings('.google-map-autocomplete').val(results[0].formatted_address);
				}
			});
		});
	});
}
