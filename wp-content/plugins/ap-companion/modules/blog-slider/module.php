<?php
namespace ApCompanion\Modules\BlogSlider;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-blog-slider';
	}

	public function get_widgets() {

		$widgets = [
			'Blog_Slider'
		];

		return $widgets;
	}
}
