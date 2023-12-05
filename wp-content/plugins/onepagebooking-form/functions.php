<?php

namespace Glancr\OnepagebookingForm;

use function register_post_type;
use function get_post_meta;
use function add_meta_box;
use function wp_nonce_field;
use function wp_verify_nonce;
use function wp_register_style;
use function plugin_dir_url;

// Function to display help text
function display_custom_post_type_help_text(): void {
	global $pagenow;

	// Check if we are on the edit.php page for your custom post type
	if ($pagenow === 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'opbf_form') {
		?>
        <div class="notice notice-info">
            <p><? _e('Create a booking form, then use it anywhere on a page/post with its shortcode as listed below.', 'opbf_form') ?></p>
        </div>
		<?php
	}
}

function register_assets(): void {
	wp_register_script( 'VanillaCalendar',
	                    'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.js' );
	wp_register_script( 'glancr-onepagebooking-jumpform-script', src: plugin_dir_url( __FILE__ ) . 'js/plugin.js',
		deps:           [ 'VanillaCalendar' ] );
	wp_register_script( 'VanillaCalendarInit', src: plugin_dir_url( __FILE__ ) . 'js/vanilla-calendar.js',
		deps:           [ 'VanillaCalendar' ] );

	wp_register_style( 'VanillaCalendar',
	                   'https://cdn.jsdelivr.net/npm/@uvarov.frontend/vanilla-calendar/build/vanilla-calendar.min.css' );
	wp_register_style( 'GlancrOnepagebookingJumpform', plugin_dir_url( __FILE__ ) . 'style.css' );
}

/**
 * Filter multiple scripts to add type=“module”.
 */
function set_module_type_for_scripts( $tag, $handle, $source ) {
	// Add main js file and all modules to the array.
	$theme_handles = [
		'glancr-onepagebooking-jumpform-script',
		'VanillaCalendarInit',
	];
	// Loop through the array and filter the tag.
	if ( in_array( $handle, $theme_handles, true ) ) {
		return '<script src="' . esc_url( $source ) . '" type="module" id="' . $handle . '"></script>';
	} else {
		return $tag;
	}
}


function register_custom_post_type(): void {
	register_post_type( 'opbf_form', [
		'labels'              => [
			'name'               => 'Buchungsformulare',
			'menu_name'          => 'Buchungsformulare',
			'singular_name'      => 'Buchungsformular',
			'add_new'            => 'Neues Formular erstellen',
			'add_new_item'       => 'Neues Formular erstellen',
			'edit'               => 'Bearbeiten',
			'edit_item'          => 'Formular bearbeiten',
			'new_item'           => 'Neues Formular',
			'view'               => 'Ansehen',
			'view_item'          => 'Formular ansehen',
			'search_items'       => 'Formulare suchen',
			'not_found'          => 'Kein Formular gefunden',
			'not_found_in_trash' => 'Kein Formular im Papierkorb gefunden',
			'parent'             => 'Übergeordnetes Formular',
		],
		'menu_icon'           => "dashicons-forms",
		'public'              => false,
		"publicly_queryable"  => false,
		'exclude_from_search' => true,
		'show_in_rest'        => true,
		'show_ui'             => true,
		'menu_position'       => 15,
		'rewrite'             => [],
		'supports'            => [
			'title',
			'custom-fields',
		],
		'taxonomies'          => [],
		'has_archive'         => false,
	] );
}

// register meta box
function add_form_settings_meta_box(): void {
	add_meta_box(
		id:       'opbf_meta_box',
		title:    __( 'Formular-Einstellungen' ),
		callback: __NAMESPACE__ . '\build_meta_box_callback',
		screen:   'opbf_form'
	);
}

/**
 * Registers meta field columns on the booking form index view.
 *
 * @param  array<string, string>  $columns  Existing columns of this table view.
 */
function add_settings_columns( array $columns ): array {
	return array_merge(
		$columns,
		[
			'url'         => __( 'URL' ),
			'button_text' => __( 'Button text' ),
			'usage'       => __( 'Usage' ),
		]
	);
}

/**
 * Fill custom registered columns on the booking form index view.
 *
 * @see \Glancr\OnepagebookingForm\add_settings_columns()
 */
function settings_column_content( string $column_name, int $post_id ): void {
	if ( $column_name === 'usage' ) {
		echo "<code>[opb_jumpform id=\"$post_id\"]</code>";
	} else {
		echo get_post_meta( $post_id, '_opbf_' . $column_name, true );
	}
}

// build meta box
function build_meta_box_callback( $post ): void {
	wp_nonce_field( __NAMESPACE__ . '\save_meta_box_data', 'opbf_meta_box_nonce' );
	$url         = get_post_meta( $post->ID, '_opbf_url', true );
	$button_text = get_post_meta( $post->ID, '_opbf_button_text', true );
	?>
    <p><label for="opbf_url">URL</label></p>
    <p>
        <input
                type="url"
                id="opbf_url"
                name="opbf_url"
                required
                placeholder="https://onepagebooking.com/mein-hotel"
                pattern="https://onepagebooking.com/.*"
                title="Bitte fügen Sie die vollständige URL ein, zB. https://onepagebooking.com/deine-url"
                style="width: 100%"
                value="<?php echo esc_url( $url ); ?>"
        />
        <span style="color: grey; font-size: smaller; display: block; margin-top: 0.5rem">Bitte fügen Sie die vollständige URL ein, zB. <code>https://onepagebooking.com/deine-url</code></span>
    </p>
    <p><label for="opbf_button_text">Button-Text</label></p>
    <p>
        <input type="text" id="opbf_button_text" name="opbf_button_text"
               value="<?php echo esc_attr( $button_text ); ?>"/>
    </p>
	<?php
}

// save metadata
function save_meta_box_data( $post_id ): void {
	if ( ! isset( $_POST['opbf_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['opbf_meta_box_nonce'], __NAMESPACE__ . '\save_meta_box_data' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( ! isset( $_POST['opbf_url'] ) ) {
		return;
	}
	if ( ! isset( $_POST['opbf_button_text'] ) ) {
		return;
	}


	$url         = sanitize_text_field( $_POST['opbf_url'] );
	$button_text = sanitize_text_field( $_POST['opbf_button_text'] );

	update_post_meta( $post_id, '_opbf_url', $url );
	update_post_meta( $post_id, '_opbf_button_text', $button_text );
}

/**
 * Renders the shortcode contents.
 *
 * @param  array  $attributes
 * @param  mixed  $content
 * @param  string  $tag
 *
 * @return string
 */
function render_shortcode( array $attributes = [], mixed $content = "", string $tag = '' ): string {
	$attributes = array_change_key_case( $attributes );

	// override default attributes with user attributes
	$opbf_attributes = shortcode_atts(
		[
			'url'         => '',
			'button_text' => 'Suchen',
			'id'          => null,
		],
		$attributes,
		$tag
	);

	// If user has passed a form ID, attempt to load its metadata.
	if ( ! is_null( $post_id = $opbf_attributes['id'] ) ) {
		$opbf_attributes['url']         = get_post_meta( $post_id, '_opbf_url', single: true );
		$opbf_attributes['button_text'] = get_post_meta( $post_id, '_opbf_button_text', single: true );
	}

	if ( empty( $opbf_attributes['url'] ) ) {
		return 'Bitte url-Parameter im Shortcode eingeben: <code>[opbf-form url="mein-hotel-url"]</code>';
	}

	$opbf_attributes['url'] = sanitize_url( $opbf_attributes['url'] );

	wp_enqueue_style( 'VanillaCalendar' );
	wp_enqueue_style( 'GlancrOnepagebookingJumpform' );

	wp_enqueue_script( 'VanillaCalendar' );
	wp_enqueue_script(
		      'glancr-onepagebooking-jumpform-script',
		deps: [ 'VanillaCalendar' ],
		//ver: time(), // Change this to null for production
		args: [ 'strategy' => 'defer' ]
	);
	wp_enqueue_script(
		      'VanillaCalendarInit',
		deps: [ 'VanillaCalendar' ],
		//ver: time(), // Change this to null for production
		args: [ 'strategy' => 'defer' ]
	);

	$svg_path = plugin_dir_path( __FILE__ ) . 'svg/';

	[ 'url' => $url, 'button_text' => $button_text ] = $opbf_attributes;

	ob_start();
	require( 'templates/booking-form.php' );
	$form = ob_get_contents();
	ob_get_clean();

	return $form;
}
