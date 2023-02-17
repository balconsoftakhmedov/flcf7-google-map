<?php
/**
 *
 * @author    balconet.co
 * @package   Tigon
 * @version   1.0.0
 * @since     1.0.0
 */


add_action( 'wpcf7_init', 'flcf7gmap_add_form_tag_map' );
function flcf7gmap_add_form_tag_map() {
	wpcf7_add_form_tag( array( 'cf7_gmap', 'cf7_gmap*' ), 'flcf7gmap_map_form_tag_handler', array( 'name-attr' => true ) );
}

function flcf7gmap_map_form_tag_handler( $tag ) {
	$tag = new WPCF7_FormTag( $tag );
	if ( empty( $tag->name ) ) {
		return '';
	}
	$validation_error = wpcf7_get_validation_error( $tag->name );
	$class            = 'flcf7gmap-google-map-autocomplete';
	if ( $validation_error ) {
		$class .= ' wpcf7-not-valid';
	}
	$atts          = array();
	$atts_complete = array();
	$atts['class'] = $tag->get_class_option( 'flcf7gmap-google-map' );
	$atts['id']    = $tag->get_option( 'id', 'id', true );
	$atts['style'] = 'width: 100%; height: 300px;';
	if ( $tag->is_required() ) {
		$atts_complete['aria-required'] = 'true';
	}
	if ( $validation_error ) {
		$atts_complete['aria-invalid']     = 'true';
		$atts_complete['aria-describedby'] = wpcf7_get_validation_error_reference(
			$tag->name
		);
	} else {
		$atts_complete['aria-invalid'] = 'false';
	}
	$atts_complete['name']  = $tag->name;
	$atts_complete['class'] = $tag->get_class_option( $class );
	$html                   = sprintf(
		'<div %s></div>
		
		<input type="text" class="flcf7gmap-google-map-autocomplete" %3$s autocomplete="on" />
		<span class="wpcf7-form-control-wrap" data-name="%2$s">%4$s</span>',
		wpcf7_format_atts( $atts ),
		esc_attr( $tag->name ),
		wpcf7_format_atts( $atts_complete ),
		$validation_error
	);

	return $html;
}

add_filter( 'wpcf7_validate_cf7_gmap', 'wpcf7_myCustomField_validation_filter', 10, 2 );
add_filter( 'wpcf7_validate_cf7_gmap*', 'wpcf7_myCustomField_validation_filter', 10, 2 );
function wpcf7_myCustomField_validation_filter( $result, $tag ) {
	$tag = new WPCF7_FormTag( $tag );
	$name = $tag->name;
	if ( isset( $_POST[ $name ] ) && is_array( $_POST[ $name ] ) ) {
		foreach ( $_POST[ $name ] as $key => $value ) {
			if ( '' === $value ) {
				unset( $_POST[ $name ][ $key ] );
			}
		}
	}
	$empty = ! isset( $_POST[ $name ] ) || empty( $_POST[ $name ] ) && '0' !== $_POST[ $name ];
	if ( $tag->is_required() && $empty ) {
		$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
	}

	return $result;
}

