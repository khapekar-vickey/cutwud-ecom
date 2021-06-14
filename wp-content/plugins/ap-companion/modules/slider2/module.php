<?php
namespace ApCompanion\Modules\Slider2;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-slider2';
	}

	public function get_widgets() {

		$widgets = [
			'Slider2'
		];

		return $widgets;
	}
}
