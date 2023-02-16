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
add_action( 'wpcf7_init', 'flcf7gmap_add_form_tag_map' );
function flcf7gmap_add_form_tag_map() {
	wpcf7_add_form_tag( 'cf7_gmap', 'flcf7gmap_map_form_tag_handler', array( 'name-attr' => true ) );
}

function flcf7gmap_map_form_tag_handler( $tag ) {
	$tag                   = new WPCF7_FormTag( $tag );
	$atts                  = array();
	$atts['class']         = $tag->get_class_option( 'flcf7gmap-google-map' );
	$atts['id']            = $tag->get_option( 'id', 'id', true );
	$atts['style']         = 'width: 100%; height: 300px;';
	$atts_complete['name'] = $tag->name;
	$html                  = sprintf(
		'<div %s></div>
        <input type="text" class="flcf7gmap-google-map-autocomplete" %s />',
		wpcf7_format_atts( $atts ),
		wpcf7_format_atts( $atts_complete )
	);

	return $html;
}



