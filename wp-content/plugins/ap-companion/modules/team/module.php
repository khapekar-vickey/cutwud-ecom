<?php
namespace ApCompanion\Modules\Team;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-team';
	}

	public function get_widgets() {

		$widgets = [
			'Team'
		];

		return $widgets;
	}
}
