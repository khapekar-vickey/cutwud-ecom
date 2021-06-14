<?php
namespace ApCompanion\Modules\Testimonials;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-testimonials';
	}

	public function get_widgets() {

		$widgets = [
			'Testimonials'
		];

		return $widgets;
	}
}
