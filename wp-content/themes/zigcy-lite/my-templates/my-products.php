<?php
/**
 * Template Name: My Products
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
$porudctId=  isset($_GET['pid']) ? $_GET['pid'] : '';

  if(is_user_logged_in())
  {
      global $current_user;
      wp_get_current_user();
      //print_r($current_user);
      $userID = $current_user->ID;
      $display_name = $current_user->display_name;
  }

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<h2><?=get_the_title($porudctId);?></h2>
			
<div class="col-sm-12">
    <div class="row">
      <div class="col-sm-4">
<?php
$catargs = array(
        'taxonomy'   => 'product_cat',
        //'number'     => $number,
        'orderby'    => 'title',
        'order'      => 'ASC',
        'hide_empty' => false
        );
 $catargs['meta_query'] = array(
         array(
            'key'       => 'fscf_author',
            'value'     => $userID,
            'compare'   => '='
         )
    );

$product_categories = get_terms($catargs );
$count = count($product_categories);
if ( $count > 0 ){
   $fisrtCat = $product_categories[0]->slug;
   echo "<ul class='product-cats'>";

    foreach ( $product_categories as $product_category ) {

      
        //echo '<h4><a href="' . get_term_link( $product_category ) . '">' . $product_category->name . '</a></h4>';
       echo '<li><a href="' . home_url('/my-products/?slug='.$product_category->slug) . '">' . $product_category->name . '</a></li>';
  
        
        }
         echo "</ul>";
         ?>
       </div>
       <div class="col-sm-8">
         <?php
$category_slug = isset($_GET['slug']) ? $_GET['slug'] : $fisrtCat;
        $args = array(
            'posts_per_page' => -1,            
            'post_type' => 'product',
            'orderby' => 'title,'
        );

        if($category_slug)
        {
            $args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        // 'terms' => 'white-wines'
                        'terms' => $category_slug
                    )
                );
      }

        $products = new WP_Query( $args );
        echo "<div class='col-sm-4'>";
        while ( $products->have_posts() ) 
        {
            $products->the_post();
            $post_id      = $products->post->ID;
            $prod_img     = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'single-post-thumbnail' );
            $content_post = get_post($post_id);
            $description  = substr($content_post->post_content,0,50); 
            ?>
                        <div class="col-sm-4">
                            <div class="machine-box">
                            <div class="machine-box-img">
                            <a href="<?php echo get_the_permalink($post_id); ?>">
                              <img src="<?php echo $prod_img[0]; ?>" ></a>
                            </div>
                            <h3><a href="<?php echo get_the_permalink($post_id); ?>"><?php echo the_title(); ?></a></h3>
                            <?php //echo substr($description,0,85);
                            echo $description; ?>
                            </div>
                        </div>
                      <?php 
        }
        echo "</div>";
    
} // $count end
?>
</div>
    </div>
</div>
             
               
		

		</main><!-- #main -->
	</div><!-- #primary -->
	
</div>
<style type="text/css">
  ul.product-cats li {
    list-style: none;
    margin-left: 0;
    margin-bottom: 2px;
    text-align: left;
    /*position: relative;*/
}
ul.product-cats li img {
    margin: 0 auto; 
}
 
</style>
<?php
get_footer();
?>