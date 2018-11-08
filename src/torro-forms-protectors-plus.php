<?php
/**
 * Plugin initialization file
 *
 * @package TorroFormsProtectorsPlus
 * @since 1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Torro Forms Protectors Plus
 * Plugin URI:  https://torro-forms.com
 * Description: Additional Torro Forms protectors.
 * Version:     0.1.0
 * Author:      Awesome UG
 * Author URI:  https://awesome.ug
 * License:     GNU General Public License v2 (or later)
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: torro-forms-protectors-plus
 * Domain Path: /languages/
 * Tags:        extension, torro forms, forms, form builder, protectors, anti-spam
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the extension.
 *
 * To retrieve the extension instance from the outside, third-party developers
 * have to call `torro()->extensions()->get( 'torro_forms_protectors_plus' )`.
 *
 * @since 1.0.0
 *
 * @param Torro_Forms $torro Main plugin instance.
 * @return bool|WP_Error True on success, error object on failure.
 */
function torro_forms_protectors_plus_load( $torro ) {
	// Require main extension class file. All other classes will be autoloaded.
	require_once dirname( __FILE__ ) . '/src/extension.php';

	// Use a string here for the extension class name so that this file can be parsed by PHP 5.2.
	$class_name = 'awsmug\TorroFormsProtectorsPlus\Extension';

	// Store the main extension file.
	$main_file = __FILE__;

	// Determine the relative basedir (will be empty unless a must-use plugin).
	$basedir_relative = '';
	$file             = wp_normalize_path( $main_file );
	$mu_plugin_dir    = wp_normalize_path( WPMU_PLUGIN_DIR );
	if ( preg_match( '#^' . preg_quote( $mu_plugin_dir, '#' ) . '/#', $file ) && file_exists( $mu_plugin_dir . '/torro-forms-protectors-plus.php' ) ) {
		$basedir_relative = 'torro-forms-protectors-plus/';
	}

	$result = $torro->extensions()->register( 'torro_forms_protectors_plus', $class_name, $main_file, $basedir_relative );

	if ( is_wp_error( $result ) ) {
		$method = get_class( $torro->extensions() ) . '::register()';
		$torro->error_handler()->doing_it_wrong( $method, $result->get_error_message(), null );
	}

	return $result;
}

if ( function_exists( 'torro_load' ) ) {
	torro_load( 'torro_forms_protectors_plus_load' );
} else {
	add_action( 'torro_loaded', 'torro_forms_protectors_plus_load', 10, 1 );
}
