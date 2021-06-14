<?php
namespace ApCompanion\Modules\Ytvideosl;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-ytvideosl';
	}

	public function get_widgets() {

		$widgets = [
			'Ytvideosl'
		];

		return $widgets;
	}
}
