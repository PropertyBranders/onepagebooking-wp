<?php
/*
 * Plugin Name: OnePageBooking WP
 * Description: OnePageBooking WP ist ein WordPress-Plugin zur Anbindung der OnePageBooking Engine von HNS. Bieten Sie Ihren Kunden ein neues Erlebnis mit einer nahtlosen Buchungsstrecke.
 * Text Domain: onepagebooking-wp
 * Domain Path: /languages
 * Author: Property Branders GmbH
 * Author URI: https://property-branders.de/
 * Version: 1.0.0
 */

namespace Glancr\OnepagebookingForm;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once 'functions.php';

// Register a custom post type and meta fields for its settings.
add_action( 'init', __NAMESPACE__ . '\register_custom_post_type' );
add_action( 'add_meta_boxes', __NAMESPACE__ . '\add_form_settings_meta_box' );
add_action( 'save_post_opbf_form', __NAMESPACE__ . '\save_meta_box_data' );
add_filter( 'manage_opbf_form_posts_columns', __NAMESPACE__ . '\add_settings_columns' );
add_action( 'manage_opbf_form_posts_custom_column', __NAMESPACE__ . '\settings_column_content', 10, 2 );

// Show an admin notice explaining how to use the shortcode.
add_action( 'admin_notices', __NAMESPACE__ . '\display_custom_post_type_help_text' );

// Shortcode assets and registration.
register_assets();
add_filter( 'script_loader_tag', __NAMESPACE__ . '\set_module_type_for_scripts', 10, 3 );
add_shortcode( 'opb_jumpform', __NAMESPACE__ . '\render_shortcode' );

// Translations.
add_action( 'init', __NAMESPACE__. '\load_textdomain' );

add_filter( 'pll_get_post_types', __NAMESPACE__ . '\make_custom_post_type_translatable', 10, 2 );
