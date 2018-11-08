<?php

namespace awsmug\TorroFormsProtectorsPlus\Tests;

use awsmug\Torro_Forms\Tests\Unit_Test_Case;
use awsmug\TorroFormsProtectorsPlus\Extension;

class Tests_Load extends Unit_Test_Case {

	public function test_extension_loaded() {
		$instance = torro()->extensions()->get( 'torro_forms_protectors_plus' );

		$this->assertInstanceOf( Extension::class, $instance );
	}

	/**
	 * @expectedIncorrectUsage awsmug\Torro_Forms\Components\Extensions::register()
	 */
	public function test_torro_forms_protectors_plus_load() {
		// This must error because the extension will already be registered.
		$result = torro_forms_protectors_plus_load( torro() );

		$this->assertWPError( $result );
	}
}
