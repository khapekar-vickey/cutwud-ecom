<?php
/**
 * Template Name: Our Partners
 *
 *
 */
get_header(); 

if (!is_user_logged_in() ){
        //wp_redirect("/login/");
        echo '<script>window.location.href="'.home_url('/login/').'"</script>';
    exit;
        }

global $post;
$page_layout = get_post_meta( $post -> ID, 'wp_store_sidebar_layout', true );

if(empty($page_layout)):
	$page_layout = get_theme_mod('wp_store_innerpage_setting_single_page_layout','right-sidebar');
endif;	
$slider_page = get_theme_mod('wp_store_innerpage_setting_single_page_slider',0);
if($slider_page == '1'):
	do_action('wp_store_slider_section'); 
endif;
?>
<div class="ed-container">
	<?php
	if($page_layout=='both-sidebar'){
		?>
		<div class="left-sidebar-right">
		<?php
	}
	?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );
				

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->

		<!-- custom html -->
		<div class="custom-partner-layout" style="display: none">
			<div class="partner-row">
				<div class="row">
					<div class="col-sm-12">
						<div class="custom-search-in">
							<div class="input-group">
							  <input type="text" class="form-control" placeholder="Search Partners">
							  <div class="input-group-append">
							    <button class="btn btn-success" type="submit">Search</button>
							  </div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="partner-obj-img">
							<img src="http://icarefurnishers.com.cp-20.bigrockservers.com/wp-content/uploads/2019/11/ecf7229f-furniture-wooden-img.jpg" alt="Partner Image">
						</div>
					</div>
					<div class="col-sm-8">
						<div class="right-partner-content">
							<h3><a href="#">Bharat Furniture Udyog</h3></a>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							<div class="partner-thumbnail-row">
								<div class="row">
									<div class="col-sm-2">
										<a href="#"><img class="partner-thm-img" src="http://icarefurnishers.com.cp-20.bigrockservers.com/wp-content/uploads/2019/11/33207ca5-fabric-images-150x150.jpg" alt="Partner Thumbnail"></a>
									</div>
									<div class="col-sm-2">
										<a href="#"><img class="partner-thm-img" src="http://icarefurnishers.com.cp-20.bigrockservers.com/wp-content/uploads/2019/11/ecf7229f-furniture-wooden-img-150x150.jpg" alt="Partner Thumbnail"></a>
									</div>
									<div class="col-sm-2">
										<a href="#"><img class="partner-thm-img" src="http://icarefurnishers.com.cp-20.bigrockservers.com/wp-content/uploads/2019/11/33207ca5-fabric-images-150x150.jpg" alt="Partner Thumbnail"></a>
									</div>
									<div class="col-sm-2">
										<a href="#"><img class="partner-thm-img" src="http://icarefurnishers.com.cp-20.bigrockservers.com/wp-content/uploads/2019/11/ecf7229f-furniture-wooden-img-150x150.jpg" alt="Partner Thumbnail"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="partner-row">
				<div class="row">
					<div class="col-sm-4">
						<div class="partner-obj-img">
							<img src="http://icarefurnishers.com.cp-20.bigrockservers.com/wp-content/uploads/2019/11/ecf7229f-furniture-wooden-img.jpg" alt="Partner Image">
						</div>
					</div>
					<div class="col-sm-8">
						<div class="right-partner-content">
							<h3><a href="#">Bharat Furniture Udyog</h3></a>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							<div class="partner-thumbnail-row">
								<div class="row">
									<div class="col-sm-2">
										<a href="#"><img class="partner-thm-img" src="http://icarefurnishers.com.cp-20.bigrockservers.com/wp-content/uploads/2019/11/33207ca5-fabric-images-150x150.jpg" alt="Partner Thumbnail"></a>
									</div>
									<div class="col-sm-2">
										<a href="#"><img class="partner-thm-img" src="http://icarefurnishers.com.cp-20.bigrockservers.com/wp-content/uploads/2019/11/ecf7229f-furniture-wooden-img-150x150.jpg" alt="Partner Thumbnail"></a>
									</div>
									<div class="col-sm-2">
										<a href="#"><img class="partner-thm-img" src="http://icarefurnishers.com.cp-20.bigrockservers.com/wp-content/uploads/2019/11/33207ca5-fabric-images-150x150.jpg" alt="Partner Thumbnail"></a>
									</div>
									<div class="col-sm-2">
										<a href="#"><img class="partner-thm-img" src="http://icarefurnishers.com.cp-20.bigrockservers.com/wp-content/uploads/2019/11/ecf7229f-furniture-wooden-img-150x150.jpg" alt="Partner Thumbnail"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- custom html -->

	</div><!-- #primary -->
	<?php 
	if($page_layout=='left-sidebar' || $page_layout=='both-sidebar'){
	    get_sidebar('left');
	}
	if($page_layout=='both-sidebar'){
	    ?>
	    </div>
	    <?php
	}
	if($page_layout=='right-sidebar' || $page_layout=='both-sidebar'){
	 get_sidebar('right');
	}
?>
</div>
<?php
		
	if(get_theme_mod('wp_store_innerpage_setting_single_page_cta')=="1"){
		if(is_active_sidebar('widget-area-two')){
			?>
			<div class='widget-area'>
				<div class='ed-container'>
					<?php
					dynamic_sidebar('widget-area-two');
					?>
				</div>
			</div>			
			<?php
		}
	}


get_footer();