<?php
/**
 * @package TorroFormsProtectorsPlus
 * @subpackage Tests
 */

$GLOBALS['wp_tests_options'] = array(
	'active_plugins' => array(
		'torro-forms/torro-forms.php',
		'torro-forms-protectors-plus/torro-forms-protectors-plus.php',
	),
);

require dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) . '/torro-forms/tests/phpunit/includes/bootstrap.php';

function _manually_load_extension() {
	require dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/torro-forms-protectors-plus.php';
}

if ( defined( 'TORRO_MANUAL_LOAD' ) && TORRO_MANUAL_LOAD ) {
	tests_add_filter( 'muplugins_loaded', '_manually_load_extension' );
}

echo "Installing Torro Forms Protectors Plus...\n";

activate_plugin( 'torro-forms-protectors-plus/torro-forms-protectors-plus.php' );
