<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package icarefurnishers
 */

?>

	</div><!-- #content -->

	<footer class="footer">
        <div class="footer-section">
            <div class="container">
            	<div class="footer-top">
	                <div class="row">
	                    <div class="col-md-4">
	                        <div class="icare-contact mb-2">
	                            <?php if(get_theme_mod('footer_logo_upload')):?>
	                            <a href="<?php echo get_home_url(); ?>" target="_blank"><img src="<?php echo get_theme_mod('footer_logo_upload'); ?>" class="footer-logo" /></a>
	                            <?php endif; ?>
	                            <div class="f-contact mb-3 d-flex">
	                            	<i class="fa fa-home"></i> 
					                <?php
					                $content_mod = get_theme_mod('contact_address');
					                echo $content_mod; ?>
					            </div>
	                            <div class="f-phone mb-3 d-flex">
	                                <i class="fa fa-phone"></i> 
	                                <a href="tel:<?php $content_mod = get_theme_mod('phone_number'); echo $content_mod;?>">
	                                <?php
	                                $content_mod = get_theme_mod('phone_number');
	                                echo $content_mod;?>
	                                </a>
	                            </div>
	                            <div class="f-email d-flex">
	                                <i class="fa fa-envelope"></i> 
	                                <a href="mailto:<?php $content_mod = get_theme_mod('email_address'); echo $content_mod; ?>">
	                                    <?php
	                                        $content_mod = get_theme_mod('email_address');
	                                        echo $content_mod;
	                                    ?>
	                                </a>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-md-4">
	                        <div class="info-links mb-2">
	                            <h3>Useful Links</h4>
	                            <?php wp_nav_menu(array('menu' => 'footer_menu', 'menu_class' => 'footer-nav')); ?>
	                        </div>
	                    </div>
	                    <div class="col-md-4">
	                        <div class="footer-social-link">
	                            <h3>Connect with us</h4>
	                            <!-- <a href="#"><i class="fa fa-facebook"></i></a>
	                            <a href="#"><i class="fa fa-instagram"></i></a>
	                            <a href="#"><i class="fa fa-linkedin"></i></a>
	                            <a href="#"><i class="fa fa-twitter"></i></a> -->
	                            <div class="social-icons ">
		                            <?php if($content_mod = get_theme_mod('social_facebook')):?>
		                            <a href="<?php $content_mod = get_theme_mod('social_facebook'); echo $content_mod; ?>" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a>
		                            <?php endif; ?>

		                            <?php if($content_mod = get_theme_mod('social_instagram')):?>
		                            <a href="<?php $content_mod = get_theme_mod('social_instagram'); echo $content_mod; ?>" target="_blank" class="instagram"><i class="fa fa-instagram"></i></a>
		                            <?php endif; ?>
									
									<?php if($content_mod = get_theme_mod('social_youTube')):?>
		                            <a href="<?php $content_mod = get_theme_mod('social_youTube'); echo $content_mod; ?>" target="_blank" class="youtube"><i class="fa fa-youtube"></i></a>
		                            <?php endif; ?>
		                            
		                            <?php if($content_mod = get_theme_mod('social_linkedIn')):?>
		                            <a href="<?php $content_mod = get_theme_mod('social_linkedIn'); echo $content_mod; ?>" target="_blank" class="linkedin"><i class="fa fa-linkedin"></i></a>
		                            <?php endif; ?>
									
									<?php if($content_mod = get_theme_mod('social_pinterest')):?>
		                            <a href="<?php $content_mod = get_theme_mod('social_pinterest'); echo $content_mod; ?>" target="_blank" class="pinterest"><i class="fa fa-pinterest"></i></a>
		                            <?php endif; ?>

		                            <?php if($content_mod = get_theme_mod('social_twitter')):?>
		                            <a href="<?php $content_mod = get_theme_mod('social_twitter'); echo $content_mod; ?>" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a>
		                            <?php endif; ?>

		                            
	                        	</div>
	                            <div class="warranty-logo">
	                            	<img src="<?php echo get_theme_mod('footer_warranty_logo_upload'); ?>" alt="Warranty Logo">
	                            </div>
	                        </div>
	                    </div>
	                </div>
                </div>
                <div class="footer-copyright">
	                <div class="row">
	                    <div class="col-sm-6">
	                        <div class="copyright">
	                            <p>All rights reserved @<?php echo date("Y"); ?> icarefurnishers</p>
	                        </div>
	                    </div>
	                    <div class="col-sm-6">
	                        <div class="payment-gateway text-right">
	                            <img src="<?php echo get_theme_mod('footer_pg_logo_upload'); ?>" alt="">
	                        </div>
	                    </div>
	                </div>
                </div>
            </div>
        </div>
    </footer>
    <script type="text/javascript">

        /*-- Chat Box --*/
        
        /*-- Chat Box --*/

        /*-- Search box --*/
        jQuery(document).ready(function ($) {
	    	//$('.search-inline').hide();
		    jQuery(".search-open").click(function() {
		        jQuery('.search-inline').toggle();
		    });
		    
		    jQuery(".search-close").click(function() {
		        jQuery('.search-inline').hide();
		    });

		    // End here
		});
        
    </script>

    
</div><!-- #page -->
<script src="<?php echo get_template_directory_uri();?>/textlocal_sms/verification.js"></script>

<?php wp_footer(); ?>
<!-- ==== ===========Login Popup=========================-->
<!-- The Modal Login Popup -->
<div class="modal" id="loginForm">
	<div class="modal-dialog">
	  <div class="modal-content">
		<!-- Modal Header -->
		<div class="modal-header">
		  <h4 class="modal-title">Login</h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		
		<!-- Modal body -->
		<div class="modal-body">
			<div class="loginFields">
	<?php 
	echo do_shortcode('[WPUM_LOGIN title="Login"]');
	?>
			  	
			</div>
		</div>
		
		<!-- Modal footer -->
		<!--div class="modal-footer">
		  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
		</div-->
		
	  </div>
	</div>
</div>
<!-- End Login Popup -->
<!-- The Modal Registration Popup -->
<div class="modal" id="registrationForm">
	<div class="modal-dialog">
	  <div class="modal-content">
		<!-- Modal Header -->
		<div class="modal-header">
		  <h4 class="modal-title">Registration</h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		
		<!-- Modal body -->
		<div class="modal-body">
			<div class="registrationFields">
			  	<?php 
			echo do_shortcode('[WPUM_NEWUSER_REGISTRATION uid="" userrole="customer" title="Registration" redirect_slug="login"]');

			?>
			</div>
		</div>
		
		<!-- Modal footer -->
		<!--div class="modal-footer">
		  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
		</div-->
		
	  </div>
	</div>
</div>
<!-- End The Modal Registration Popup -->	
<!-- ==== ===========Login Popup=========================-->
</body>
</html>