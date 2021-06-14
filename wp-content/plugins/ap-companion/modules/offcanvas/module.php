<?php
namespace ApCompanion\Modules\Offcanvas;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'offcanvas';
	}

	public function get_widgets() {

		$widgets = [
			'Offcanvas',
		];

		return $widgets;
	}
}
