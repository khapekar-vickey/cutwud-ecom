<?php
namespace ApCompanion\Modules\HeaderIcons;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-header-icons';
	}

	public function get_widgets() {

		$widgets = [
			'Header_Icons',
		];

		return $widgets;
	}
}