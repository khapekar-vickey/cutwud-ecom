<?php
namespace ApCompanion\Modules\WooCategories;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-woo-categories';
	}

	public function get_widgets() {

		$widgets = [
			'Woo_Categories'
		];

		return $widgets;
	}
}
