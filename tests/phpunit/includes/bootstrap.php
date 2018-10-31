<?php
/**
 * @package TorroFormsProtectionsPlus
 * @subpackage Tests
 */

$GLOBALS['wp_tests_options'] = array(
	'active_plugins' => array(
		'torro-forms/torro-forms.php',
		'torro-forms-protections-plus/torro-forms-protections-plus.php',
	),
);

require dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) . '/torro-forms/tests/phpunit/includes/bootstrap.php';

function _manually_load_extension() {
	require dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/torro-forms-protections-plus.php';
}

if ( defined( 'TORRO_MANUAL_LOAD' ) && TORRO_MANUAL_LOAD ) {
	tests_add_filter( 'muplugins_loaded', '_manually_load_extension' );
}

echo "Installing Torro Forms Protections Plus...\n";

activate_plugin( 'torro-forms-protections-plus/torro-forms-protections-plus.php' );
