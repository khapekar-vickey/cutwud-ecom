<?php
/*
Template Name: icare Home Page
*/

get_header();
?>

<div id="primary" class="content-area">
    <div class="container">
        <main id="main" class="site-main">

        <?php while (have_posts()) : the_post() ?>
            <?php the_content(); ?>
        <?php endwhile; ?>

        </main><!-- #main -->
    </div>
</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
