<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package icarefurnishers
 */

get_header();
?>
<div class="banner-section" style="background-image: url('<?php echo wpcustom_featured_image(); ?>');">
    <div class="container">
        <!-- <?php //the_breadcrumb(); ?> -->
        <h1 class="banner-title"><?php the_title(); ?></h1>
    </div>
</div>
	<div id="primary" class="content-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="content-wrapper">
                        <?php while (have_posts()) : the_post() ?>
                            <?php the_content(); ?>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
