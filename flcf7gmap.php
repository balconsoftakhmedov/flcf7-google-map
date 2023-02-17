<?php
/*
Plugin Name: Flance CF7 Google Map
Description: Adds a Google Map form field to Contact Form 7
Author: flance.info
Version: 1.0
*/
include_once 'includes/settings.php';
include_once 'includes/flcf7gmap-functions.php';


function flcf7gmap_enqueue_scripts() {

	$flcf7gmap_map_api_key = get_option('flcf7gmap_map_api_key');
	wp_enqueue_script( 'flcf7gmap-google-map', plugins_url( 'assets/js/flcf7gmap.js', __FILE__ ), array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'flcf7gmap-google-maps-api', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key='.$flcf7gmap_map_api_key.'&libraries=places&callback=flcf7gmap_initMap', array( 'flcf7gmap-google-map' ), '', true );

}

add_action( 'wp_enqueue_scripts', 'flcf7gmap_enqueue_scripts' );