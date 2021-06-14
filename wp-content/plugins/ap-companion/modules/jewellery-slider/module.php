<?php
namespace ApCompanion\Modules\JewellerySlider;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-jewellery-slider-product';
	}

	public function get_widgets() {

		$widgets = [
			'Jewellery_Slider'
		];

		return $widgets;
	}
}
