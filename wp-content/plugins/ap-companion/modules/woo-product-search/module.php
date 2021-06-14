<?php
namespace ApCompanion\Modules\WooProductSearch;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-woo-product-search';
	}

	public function get_widgets() {

		$widgets = [
			'Woo_Product_Search'
		];

		return $widgets;
	}
}
