<?php
namespace ApCompanion\Modules\BlogGrid;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-blog-grid';
	}

	public function get_widgets() {

		$widgets = [
			'Blog_Grid'
		];

		return $widgets;
	}
}
