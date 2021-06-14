<?php
namespace ApCompanion\Modules\SiteLogo;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-site-logo';
	}

	public function get_widgets() {

		$widgets = [
			'Site_Logo'
		];

		return $widgets;
	}
}
