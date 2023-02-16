<?php
/*
Plugin Name: Flance CF7 Google Map
Description: Adds a Google Map form field to Contact Form 7
Author: flance.info
Version: 1.0
*/

function flcf7gmap_enqueue_scripts() {
	wp_enqueue_script( 'cf7-google-map', plugins_url( 'assets/js/flcf7gmap.js', __FILE__ ), array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDXHhQB2qRhJ1HfYfJPKwMESW3q2F4-6Zg&libraries=places&callback=flcf7gmap_initMap', array( 'cf7-google-map' ), '', true );

}

add_action( 'wp_enqueue_scripts', 'flcf7gmap_enqueue_scripts' );

include_once 'includes/flcf7gmap-functions.php';