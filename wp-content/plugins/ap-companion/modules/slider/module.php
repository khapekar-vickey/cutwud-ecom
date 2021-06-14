<?php
namespace ApCompanion\Modules\Slider;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-slider';
	}

	public function get_widgets() {

		$widgets = [
			'Slider'
		];

		return $widgets;
	}
}
