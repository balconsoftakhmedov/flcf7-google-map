<?php
/**
 * Settings page.
 *
 * @author  Balcomsoft
 * @package Bsgmapspro
 * @version 1.0.0
 * @since   1.0.0
 */


add_action('admin_menu', 'flcf7gmap_address_autocomplete_menu_item');

function flcf7gmap_address_autocomplete_menu_item()
	{
		add_submenu_page(
											'wpcf7',
											esc_html__('Flance Google Map API','flcf7gmap'),
											esc_html__('Google Map API','flcf7gmap'),
											'manage_options',
											'flcf7gmap-map-api',
											'flcf7gmap_google_place_admin'
										);
	}

	function flcf7gmap_google_place_admin()
	{
?>
		<div class="wrap">
			<h1>Google Map API Info.</h1>
			<form method="post" action="options.php">
				<?php settings_fields( 'flcf7gmap_section' ); ?>
				<table class="form-table" role="presentation">
				   <tbody>
				      <tr>
				         <th scope="row">Google Map API Key</th>
				         <td>
				            <input type="text" class="regular-text" required="" name="flcf7gmap_map_api_key"  value="<?php echo get_option('flcf7gmap_map_api_key');?>">
				            <p class="description">Google requires an API key to retrieve Auto Complete Address for job listings. Acquire an API key from the <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/places-autocomplete">Google Maps API developer site</a>.</p>
				         </td>
				      </tr>

				   </tbody>
				</table>
				<?php

					submit_button();
				?>

			</form>
		</div>
<?php
	}

	add_action('admin_init', 'flcf7gmap_autocomplete_fields');
	function flcf7gmap_autocomplete_fields()
	{
			register_setting('flcf7gmap_section', 'flcf7gmap_map_api_key');
	}
