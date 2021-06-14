<?php
namespace ApCompanion\Modules\BlogModule3;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-blog-module3';
	}

	public function get_widgets() {

		$widgets = [
			'Blog_Module3'
		];

		return $widgets;
	}
}
