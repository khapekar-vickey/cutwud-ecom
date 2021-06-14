<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Zigcy Lite
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		
		<div id = "store-mart-lite-section-footer-wrap" class="store-mart-lite-section-footer-wrap-main clearfix">
		<?php
		// $footer_layout = get_theme_mod('zigcy_lite_footer_width_type','layout1');
		// if($footer_layout == 'layout1'){
		// 	$class = 'footer-one';
		// }else{
		// 	$class = 'footer-two';
		// } 
		?>
			<div class="container">
				<div class="row">
					<div class="col-3">
						<?php echo dynamic_sidebar('footer-1');?>
					</div>
					<div class="col-3">
						<?php echo dynamic_sidebar('footer-2');?>
					</div>
					<div class="col-3">
						<?php echo dynamic_sidebar('footer-3');?>
					</div>
					<div class="col-3">
						<?php echo dynamic_sidebar('footer-4');?>
					</div>
				</div>
				<div class="container <?php echo $class; ?>" >
					<?php //do_action( 'zigcy_lite_footer' );  ?>
					<?php do_action( 'zigcy_lite_footer_copyright_fn' ); ?>
				</div>
			</div>
			
		</div>
		


	<!-- Advertisement Pop - up modal -->

	<div id="advertiseModal" class="modal" tabindex="-1" role="dialog">
	    <div class="modal-dialog">
	      	<!-- Modal content-->
	      	<div class="modal-content">
	        	<div class="modal-header">
	          		<button type="button" class="close" data-dismiss="modal">&times;</button>
	          		
	        	</div>
	        	<div class="modal-body">
	          		<!-- Your modal Content -->
	          		<?php

					$args = array(
					        // 'posts_per_page' =>1,
					        'post_type' => 'advertisements',
					    );
					/*    if ( $advertisement_id )
					        $args['post__in'] = array( $advertisement_id );
					 */
					    $query = new WP_Query( $args  );

					        while ( $query->have_posts() ) : $query->the_post();
					        	$post_id = get_the_ID();
					            $advertisement_data = get_post_meta( $post_id, '_advertisement', true );
						        $show_hide = get_field( 'show_hide', $post_id );
								
								if( $show_hide == 'Show' ): 						        	
						        	$advertise_image = get_field('advertisement_images', $post_id);
									$advertise_url = get_field('advertisement_url', $post_id);
									// echo "<pre>";
									// print_r($post_id);
								?>
									<a href="<?php echo $advertise_url ?>"><img src="<?php echo $advertise_image; ?>" alt="<?php echo $advertise_image; ?>" /></a>
								<?php		
								endif;			            
					        endwhile;
							
					        wp_reset_postdata();
	          		?>
	        	</div>
	      	</div>
	    </div>
	</div>		
	</footer><!-- #colophon -->



	<div class="sml-scrollup">
		<a href="#" class="back-to-top" >
            <span>
            	<i class="lnr lnr-chevron-up" aria-hidden="true"></i>
            </span>
        </a>
	</div>
</div>

<!-- <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
	// jQuery('document').ready(function(){
		// jQuery(window).on('load',function(){
		//     setTimeout(function(){
		// 		jQuery('#advertiseModal').modal('show');
		// 	}, 3000);
		// });
	// })	
	
</script>
<?php wp_footer(); ?>

</body>
</html>


