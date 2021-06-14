<?php
namespace ApCompanion\Modules\BlogPost;

use ApCompanion\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'ap-blog-post';
	}

	public function get_widgets() {

		$widgets = [
			'Blog_Post'
		];

		return $widgets;
	}
}
