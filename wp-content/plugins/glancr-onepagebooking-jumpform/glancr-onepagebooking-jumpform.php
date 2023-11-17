<?php
/*
* Plugin Name: Jump Form
*/

add_shortcode( 'opb_jumpform', 'opb_jumpform_shortcode' );

wp_register_script( 'VanillaCalendar', 'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.js' );

wp_register_style('VanillaCalendar', 'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.css');
wp_register_style('VanillaCalendarLightTheme', 'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/themes/light.min.css');
wp_register_style('GlancrOnepagebookingJumpform', plugin_dir_url( __FILE__ ) . '/style.css');

function opb_jumpform_shortcode( $attributes = [], $content = null ): string {
	wp_enqueue_style( 'VanillaCalendar' );
	wp_enqueue_style( 'VanillaCalendarLightTheme' );
	wp_enqueue_style( 'GlancrOnepagebookingJumpform', deps: ['skin-material-css'] );

	wp_enqueue_script( 'VanillaCalendar', args: ['strategy' => 'defer'] );
	wp_enqueue_script(
		'glancr-onepagebooking-jumpform-script',
		plugin_dir_url( __FILE__ ) . 'js/plugin.js',
		['VanillaCalendar'],
		time(), // Change this to null for production
		true
	);

	$svg_path = plugin_dir_path( __FILE__) . 'svg/';

	ob_start();
	require_once('templates/booking-form.php');
	$form = ob_get_contents();
	ob_get_clean();
	return $form;
}
