<?php
/**
 * Template Name: Partners Details
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
$page_layout = get_post_meta( $post->ID, 'wp_store_sidebar_layout', true );

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
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_the_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php wp_store_posted_on(); ?>
					</div><!-- .entry-meta -->
					<?php
					endif; ?>
				</header><!-- .entry-header -->	
			<?php
			while ( have_posts() ) : the_post();

			 		$partnerID = ( isset($_GET["id"]) ) ? sanitize_text_field($_GET["id"]) : false ;
			 		$permalink=get_permalink($partnerID);
                    $postDate= date('m-d-Y', strtotime($partnerPost->post->post_date));
                    $address = get_post_meta($partnerID,'address',true);
                    $partner_zipcode = get_post_meta($partnerID,'partner_zipcode',true);
                    $partner_city = get_post_meta($partnerID,'partner_city',true);
                    $partner_state = get_post_meta($partnerID,'partner_state',true);
                    $postcontent = get_post($partnerID);
                    $fscf_author = get_post_meta($partnerID,'fscf_author',true); //user id
                    $dkgallery_data = get_post_meta( $partnerID, 'dkgallery_data', true );
			?>
			

			<div class="partner_image">
                          <?php echo get_partner_preview_thumb($partnerID,'full');?>
           	</div>

			<div class="content-thumbnail <?php if(!has_post_thumbnail()){ echo 'full-width';} ?>">
					<?php if(has_post_thumbnail($partnerID)): ?>
						<div class="post-thumbnail">
							<?php
								$image_resize = 'wp-store-large-image';
		                       	$image = wp_get_attachment_image_src(get_post_thumbnail_id($partnerID), $image_resize);
		                       	//print_r($image);
		                        echo '<img src="' . esc_url($image[0]) . '" alt="'.esc_attr( get_the_title($partnerID) ).'"  />'; ?>
						</div>		
					<?php endif; ?>

			</div>
		<div>
			<?php
              if ( isset( $dkgallery_data['image_url'] ) ) 
              {
              $i = 0;

                    foreach ($dkgallery_data['image_url'] as $key => $value) 
                    {
              ?>
                  <div class="col-sm-2">
                    <a href="#"><img class="partner-thm-img" src="<?=$value?>" alt="Partner Thumbnail"></a>
                  </div>

                  <?php 
                }
              }
                ?>
            </div>
			<div class="wrap-content">
						<?php
						echo $postcontent->post_content;

						endwhile; // End of the loop.
 						?>

					</div>
			</article>

		</main><!-- #main -->
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