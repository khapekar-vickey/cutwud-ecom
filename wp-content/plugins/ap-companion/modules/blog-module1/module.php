<?php
namespace ApCompanion\Modules\BlogModule1;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-blog-module1';
	}

	public function get_widgets() {

		$widgets = [
			'Blog_Module1'
		];

		return $widgets;
	}
}
