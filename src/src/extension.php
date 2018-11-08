<?php
/**
 * Extension main class
 *
 * @package TorroFormsProtectorsPlus
 * @since 1.0.0
 */

namespace awsmug\TorroFormsProtectorsPlus;

use awsmug\Torro_Forms\Components\Extension as Extension_Base;
use awsmug\TorroFormsProtectorsPlus\Protectors\Mathematics;
use Leaves_And_Love\Plugin_Lib\Assets;
use WP_Error;

/**
 * Extension main class.
 *
 * @since 1.0.0
 */
class Extension extends Extension_Base {

	/**
	 * The assets manager instance.
	 *
	 * @since 1.0.0
	 * @var Assets
	 */
	protected $assets;

	/**
	 * Checks whether the extension can run on this setup.
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Error|null Error object if the extension cannot run on this setup, null otherwise.
	 */
	public function check() {
		return null;
	}

	/**
	 * Loads the base properties of the class.
	 *
	 * @since 1.0.0
	 */
	protected function load_base_properties() {
		$this->version      = '1.0.0';
		$this->vendor_name  = 'awsmug';
		$this->project_name = 'TorroFormsProtectorsPlus';
	}

	/**
	 * Loads the extension's textdomain.
	 *
	 * @since 1.0.0
	 */
	protected function load_textdomain() {
		$this->load_plugin_textdomain( 'torro-forms-protectors-plus', '/languages' );
	}

	/**
	 * Instantiating services.
	 *
	 * @since 1.0.0
	 */
	public function instantiate_services() {
		// TODO: Implement instantiate_services() method.
	}

	/**
	 * Registering protectors
	 *
	 * @param awsmug\Torro_Forms\Modules\Protectors\Module $module Action manager instance.
	 *
	 * @since 1.0.0
	 */
	public function register_protectors( $module ) {
		$module->register( 'mathematic', Mathematics::class );
	}

	/**
	 * Sets up all action and filter hooks for the service.
	 *
	 * This method must be implemented and then be called from the constructor.
	 *
	 * @since 1.0.0
	 */
	protected function setup_hooks() {
		// The following hooks are sample code and can be removed.
		$this->actions[] = array(
			'name'     => 'torro_register_protectors',
			'callback' => array( $this, 'register_protectors' ),
			'priority' => 10,
			'num_args' => 1,
		);
	}

	/**
	 * Checks whether the dependencies have been loaded.
	 *
	 * If this method returns false, the extension will attempt to require the composer-generated
	 * autoloader script. If your extension uses additional dependencies, override this method with
	 * a check whether these dependencies already exist.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if the dependencies are loaded, false otherwise.
	 */
	protected function dependencies_loaded() {
		return class_exists( 'APIAPI\Structure_WordPress\Structure_WordPress' );
	}
}
