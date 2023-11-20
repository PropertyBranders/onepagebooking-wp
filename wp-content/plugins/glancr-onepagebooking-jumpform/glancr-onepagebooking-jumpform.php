<?php
/*
* Plugin Name: Jump Form
*/

add_shortcode( 'opb_jumpform', 'opb_jumpform_shortcode' );

wp_register_script( 'VanillaCalendar', 'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.js' );
wp_register_script( 'glancr-onepagebooking-jumpform-script', src: plugin_dir_url( __FILE__ ) . 'js/plugin.js', deps: ['VanillaCalendar'] );
wp_register_script( 'VanillaCalendarInit', src: plugin_dir_url( __FILE__ ) . 'js/vanilla-calendar.js', deps: ['VanillaCalendar'] );

wp_register_style('VanillaCalendar', 'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.css');
wp_register_style('VanillaCalendarLightTheme', 'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/themes/light.min.css');
wp_register_style('GlancrOnepagebookingJumpform', plugin_dir_url( __FILE__ ) . '/style.css');

/**
 * Filter multiple scripts to add type=“module”.
 */
add_filter('script_loader_tag', __NAMESPACE__ . '\add_type_to_js_scripts', 10, 3);
function add_type_to_js_scripts($tag, $handle, $source){
	// Add main js file and all modules to the array.
	$theme_handles = array(
		'glancr-onepagebooking-jumpform-script',
		'VanillaCalendarInit',
	);
	// Loop through the array and filter the tag.
	if ( in_array( $handle, $theme_handles, true ) ) {
		return '<script src="' . esc_url( $source ) . '" type="module" id="'. $handle .'"></script>';
	}
	else {
		return $tag;
	}
}

function opb_jumpform_shortcode( $attributes = [], $content = null ): string {
	wp_enqueue_style( 'VanillaCalendar' );
	wp_enqueue_style( 'VanillaCalendarLightTheme' );
	wp_enqueue_style( 'GlancrOnepagebookingJumpform', ver: time(), deps: true );

	wp_enqueue_script( 'VanillaCalendar' );
	wp_enqueue_script(
		'glancr-onepagebooking-jumpform-script',
		deps: ['VanillaCalendar'],
		//ver: time(), // Change this to null for production
		args: ['strategy'=> 'defer']
	);
	wp_enqueue_script(
		      'VanillaCalendarInit',
		deps: ['VanillaCalendar'],
		//ver: time(), // Change this to null for production
		args: ['strategy' => 'defer']
	);

	$svg_path = plugin_dir_path( __FILE__) . 'svg/';

	ob_start();
	require_once('templates/booking-form.php');
	$form = ob_get_contents();
	ob_get_clean();
	return $form;
}
