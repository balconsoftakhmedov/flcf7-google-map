'use strict';

let flcf7gmap_maps = [];
let flcf7gmap_markers = [];
let flcf7gmap_infoWindows = [];
let flcf7gmap_geocoders = [];

function flcf7gmap_initMaps() {
	jQuery('.flcf7gmap-google-map').each(function (index, element) {
		let map = new google.maps.Map(element, {
			center: {lat: -34.397, lng: 150.644},
			zoom: 8
		});

		flcf7gmap_maps.push(map);
		flcf7gmap_markers.push(null);

		let index = flcf7gmap_maps.indexOf(map);
		if (flcf7gmap_markers[index]) {
			flcf7gmap_markers[index].setMap(null);
		}

		flcf7gmap_markers[index] = new google.maps.Marker({
			map: map,
			position: {lat: -34.397, lng: 150.644}
		});

		flcf7gmap_infoWindows.push(new google.maps.InfoWindow({
			content: "Marker Location"
		}));
		flcf7gmap_geocoders.push(new google.maps.Geocoder());

		let autocomplete = new google.maps.places.Autocomplete(jQuery(element).siblings('.flcf7gmap-google-map-autocomplete')[0]);
		autocomplete.bindTo('bounds', map);

		autocomplete.addListener('place_changed', function () {
			let place = autocomplete.getPlace();
			if (!place.geometry) {
				return;
			}

			let index = flcf7gmap_maps.indexOf(map);
			if (flcf7gmap_markers[index]) {
				flcf7gmap_markers[index].setMap(null);
			}

			flcf7gmap_markers[index] = new google.maps.Marker({
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
			let index = flcf7gmap_maps.indexOf(map);
			flcf7gmap_markers[index].setPosition(event.latLng);
			flcf7gmap_geocoders[index].geocode({'latLng': event.latLng}, function (results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						flcf7gmap_infoWindows[index].setContent(results[0].formatted_address);
						flcf7gmap_infoWindows[index].open(map, flcf7gmap_markers[index]);
					}
					jQuery(element).siblings('.flcf7gmap-google-map-autocomplete').val(results[0].formatted_address);
				}
			});
		});
	});
}
