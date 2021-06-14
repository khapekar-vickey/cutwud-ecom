<?php
namespace ApCompanion\Modules\PriceList;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-price-list';
	}

	public function get_widgets() {

		$widgets = [
			'Price_List'
		];

		return $widgets;
	}
}
