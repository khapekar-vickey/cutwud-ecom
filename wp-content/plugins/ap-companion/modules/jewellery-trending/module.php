<?php
namespace ApCompanion\Modules\JewelleryTrending;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-jewellery-trending';
	}

	public function get_widgets() {

		$widgets = [
			'Jewellery_Trending'
		];

		return $widgets;
	}
}
