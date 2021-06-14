<?php
/*
Template Name: Full Page Template
*/

get_header();
?>

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
