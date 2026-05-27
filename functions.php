<?php

define( 'NT_ASTRA_THEME_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'NT_ASTRA_THEME_PATH', get_template_directory() . '/' );
define( 'NT_ASTRA_THEME_URL', get_template_directory_uri() . '/' );
define( 'NT_ASTRA_CHILD_THEME_PATH', get_stylesheet_directory() . '/' );
define( 'NT_ASTRA_CHILD_THEME_URL', get_stylesheet_directory_uri() . '/' );

require_once NT_ASTRA_CHILD_THEME_PATH . 'includes/requirements.php';

use NagaTheme\Astra_Child\Includes\Requirements;

if ( Requirements::run_compatibility_check() ) {
	require_once NT_ASTRA_CHILD_THEME_PATH . 'functions-ic.php';
} else {
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

function allow_font_uploads( $mimes ) {
	$mimes['woff']  = 'font/woff';
	$mimes['woff2'] = 'font/woff2';
	$mimes['ttf']   = 'font/ttf';
	$mimes['otf']   = 'font/otf';
	$mimes['eot']   = 'application/vnd.ms-fontobject';
	$mimes['svg']   = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'allow_font_uploads' );

add_action(
	'wp_enqueue_scripts',
	function () {
		$theme_dir = get_stylesheet_directory();
		$theme_uri = get_stylesheet_directory_uri();

		wp_enqueue_style(
			'astra-child-style',
			get_stylesheet_uri(),
			[],
			wp_get_theme()->get( 'Version' )
		);

		$manifest_path = $theme_dir . '/assets/manifest.php';

		if ( ! file_exists( $manifest_path ) ) {
			return;
		}

		$manifest = require $manifest_path;

		if ( ! empty( $manifest['styles'] ) && is_array( $manifest['styles'] ) ) {
			$style_dependency = [ 'astra-child-style' ];

			foreach ( $manifest['styles'] as $handle => $relative_path ) {
				$file_path = $theme_dir . '/assets/' . $relative_path;
				$file_uri  = $theme_uri . '/assets/' . $relative_path;

				if ( ! file_exists( $file_path ) ) {
					continue;
				}

				wp_enqueue_style(
					$handle,
					$file_uri,
					$style_dependency,
					filemtime( $file_path )
				);

				$style_dependency = [ $handle ];
			}
		}

		if ( ! empty( $manifest['scripts'] ) && is_array( $manifest['scripts'] ) ) {
			foreach ( $manifest['scripts'] as $handle => $relative_path ) {
				$file_path = $theme_dir . '/assets/' . $relative_path;
				$file_uri  = $theme_uri . '/assets/' . $relative_path;

				if ( ! file_exists( $file_path ) ) {
					continue;
				}

				wp_enqueue_script(
					$handle,
					$file_uri,
					[],
					filemtime( $file_path ),
					true
				);
			}
		}
	},
	99
);