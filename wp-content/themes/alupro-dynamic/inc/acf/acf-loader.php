<?php
/**
 * ACF Field Registration Loader.
 *
 * @package AluProDynamic
 */

if ( ! function_exists('acf_add_local_field_group') ) {
	return;
}

// List of modular ACF field configuration files
$acf_files = array(
	'about-fields.php',
	'browse-fields.php',
);


foreach ( $acf_files as $file ) {
	$filepath = locate_template( 'inc/acf/' . $file );
	if ( $filepath && file_exists( $filepath ) ) {
		require_once $filepath;
	}
}
