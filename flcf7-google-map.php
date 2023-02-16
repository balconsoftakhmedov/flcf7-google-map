<?php
/*
Plugin Name: Flance CF7 Google Map
Description: Adds a Google Map form field to Contact Form 7
Author: flance.info
Version: 1.0
*/


function cf7_google_map_enqueue_scripts() {
	wp_enqueue_script( 'cf7-google-map', plugins_url( 'assets/js/cf7-google-map.js', __FILE__ ), array(  'jquery' ), '1.0', true);
    wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDXHhQB2qRhJ1HfYfJPKwMESW3q2F4-6Zg&libraries=places&callback=initMap', array('cf7-google-map'), '', true );

}
add_action( 'wp_enqueue_scripts', 'cf7_google_map_enqueue_scripts' );


function cf7_google_map_form_tag() {
    wpcf7_add_form_tag( 'stmgooglemap', 'cf7_google_map_form_tag_handler', array( 'name-attr' => true ) );
}
//add_action( 'wpcf7_init', 'cf7_google_map_form_tag' );

function cf7_google_map_form_tag_handler( $tag ) {
    $tag = new WPCF7_FormTag( $tag );

    $atts = array();
    $atts['class'] = $tag->get_class_option( 'google-map' );
    $atts['id'] = $tag->get_option( 'id', 'id', true );
    $atts['style'] = 'width: 100%; height: 300px;';

    $html = sprintf(
        '<div %s></div>',
        wpcf7_format_atts( $atts )
    );

    return $html;
}


add_action( 'wpcf7_init', 'custom_add_form_tag_clock' );

function custom_add_form_tag_clock() {
  wpcf7_add_form_tag( 'clock', 'custom_clock_form_tag_handler' ); // "clock" is the type of the form-tag
}

function custom_clock_form_tag_handler( $tag ) {
 	  $tag = new WPCF7_FormTag( $tag );

    $atts = array();
    $atts['class'] = $tag->get_class_option( 'google-map' );
    $atts['id'] = $tag->get_option( 'id', 'id', true );
    $atts['style'] = 'width: 100%; height: 300px;';

    $html = sprintf(
        '<div %s id="google-map"></div>
        <input type="text" class="google-map-autocomplete" id="google-map-autocomplete" />',
        wpcf7_format_atts( $atts ),
        $atts['id']
    );
 $html .= sprintf(
        '<div %s id="google-map"></div>
        <input type="text" class="google-map-autocomplete" id="google-map-autocomplete" />',
        wpcf7_format_atts( $atts ),
        $atts['id']
    );
 $html .= sprintf(
        '<div %s id="google-map"></div>
        <input type="text" class="google-map-autocomplete" id="google-map-autocomplete" />',
        wpcf7_format_atts( $atts ),
        $atts['id']
    );

    return $html;
}



