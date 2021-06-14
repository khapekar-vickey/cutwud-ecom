<?php
// ---------------------------------------------------------
// Add Plugin Settings Fields Form
// ---------------------------------------------------------
function wpss_render_social_sharing(){

	$icon = "url( " . plugins_url( "assets/icon/icon.png", WPSS_PLUGIN_URL ) . " )"; ?>

	<div class="wrap wpss_social_share_buttons_settings wpss_social_share_buttons">
	    <h2 style="background-image: <?php echo $icon; ?>;background-repeat:  no-repeat;background-position: left 12px;background-size: 25px;padding-left: 30px;">
	    	Woocommerce Product Social Sharing
		</h2>

	    <form action="options.php" method="post"><?php

			settings_fields( 'wpss_settings_group' );

			do_settings_sections( 'wpss_settings_section' );

			submit_button('Save Changes'); ?>

	    </form>
	</div>

<?php }

?>