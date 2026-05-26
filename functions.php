<?php

/**
 * Theme version.
 *
 * @since 4.9.1
 */
define( 'NT_ASTRA_THEME_VERSION', wp_get_theme()->get( 'Version' ) );

/**
 * Theme directory path.
 *
 * @since 4.9.1
 */
define( 'NT_ASTRA_THEME_PATH', get_template_directory() . '/' );

/**
 * Theme directory URL.
 *
 * @since 4.9.1
 */
define( 'NT_ASTRA_THEME_URL', get_template_directory_uri() . '/' );

/**
 * Child theme directory path.
 *
 * @since 4.9.1
 */
define( 'NT_ASTRA_CHILD_THEME_PATH', get_stylesheet_directory() . '/' );

/**
 * Child theme directory URL.
 *
 * @since 4.9.1
 */
define( 'NT_ASTRA_CHILD_THEME_URL', get_stylesheet_directory_uri() . '/' );

require_once NT_ASTRA_CHILD_THEME_PATH . 'includes/requirements.php';

use NagaTheme\Astra_Child\Includes\Requirements;

// Perform requirements check.
if ( Requirements::run_compatibility_check() ) {

	// Load the encoded functionalities.
	require_once( NT_ASTRA_CHILD_THEME_PATH . 'functions-ic.php' );
} else {

	// Requirements are not met.
	// NagaTheme functionalities are required in case for Astra Pro to work properly.
	add_action(
		'admin_menu',
		function () {
			global $submenu;
			$slug = 'astra';
			remove_menu_page( $slug );
			if ( isset( $submenu[ $slug ] ) ) {
				unset( $submenu[ $slug ] );
			}
		},
		999999
	);
}
function allow_font_uploads($mimes) {
    $mimes['woff']  = 'font/woff';
    $mimes['woff2'] = 'font/woff2';
    $mimes['ttf']   = 'font/ttf';
    $mimes['otf']   = 'font/otf';
    $mimes['eot']   = 'application/vnd.ms-fontobject';
    $mimes['svg']   = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_font_uploads');
add_action('wp_enqueue_scripts', function () {

    $theme_dir = get_stylesheet_directory();
    $theme_uri = get_stylesheet_directory_uri();

    wp_enqueue_style(
        'astra-child-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style(
        'seamerco-fonts',
        $theme_uri . '/assets/css/fonts.css',
        ['astra-child-style'],
        filemtime($theme_dir . '/assets/css/fonts.css')
    );

    wp_enqueue_style(
        'seamerco-global',
        $theme_uri . '/assets/css/global.css',
        ['seamerco-fonts'],
        filemtime($theme_dir . '/assets/css/global.css')
    );

    wp_enqueue_style(
        'seamerco-process-section',
        $theme_uri . '/assets/css/seamerco-process-section.css',
        ['seamerco-global'],
        filemtime($theme_dir . '/assets/css/seamerco-process-section.css')
    );

    wp_enqueue_script(
        'seamerco-process-section',
        $theme_uri . '/assets/js/seamerco-process-section.js',
        [],
        filemtime($theme_dir . '/assets/js/seamerco-process-section.js'),
        true
    );

});

