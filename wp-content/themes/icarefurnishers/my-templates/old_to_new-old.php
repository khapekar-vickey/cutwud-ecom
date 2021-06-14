<?php
/**
 * Template Name: Old to New
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
$porudctId=  isset($_GET['pid']) ? $_GET['pid'] : 918;

if($porudctId)
{
 $post_thumbnail_id = get_post_thumbnail_id($porudctId);
    if ($post_thumbnail_id) 
    {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'thumbnail');
        $thumbimg= $post_thumbnail_img[0];
    }else{
      $thumbimg= 'https://mdbootstrap.com/img/Photos/Others/Carousel-thumbs/img%20(121).jpg';
    }

  $image_gallery = get_post_meta($porudctId,'_product_image_gallery',true);
  $product_image_gallery = explode(",",$image_gallery);
  //print_r($product_image_gallery);

}else{
  $thumbimg= 'https://mdbootstrap.com/img/Photos/Others/Carousel-thumbs/img%20(121).jpg';
}

?>
<div class="container">
<div class="row">
<div class="col-sm-12">
    
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<h2><?=get_the_title($porudctId);?></h2>
  
      <!--Carousel Wrapper-->
      <div class="slider-container">
          <div id="slider" class="slider owl-carousel">
          <div class="item">
          <div class="content">
          <img id="slidermain_img" src="<?=$thumbimg?>" class="img-responsive">
          </div>
          </div>
          </div>
      </div>
    
      <!--/.Carousel Wrapper-->
      <div class="thumbnail-slider-container" >
        <div id="thumbnailSlider" class="thumbnail-slider owl-carousel">
        <?php
          if($image_gallery)
          {
          foreach ($product_image_gallery as $key => $galvalue) 
          {
            # code...
            $thumbimg="";
            $post_thumbnail_img = wp_get_attachment_image_src($galvalue, 'thumbnail');
            $thumbimg= $post_thumbnail_img[0];
          
          ?>
        <div class="item">
            <div class="content">
                  <img src="<?=$thumbimg?>" class="img-responsive">
            </div>
        </div>
        <?php }
          } ?>
        </div>
      </div>

      <!--/.Carousel Wrapper end-->
			<?php
    
			while ( have_posts() ) : the_post();

           ?>
            
            <div class="col-md-8 offset-md-2 old-newForm">
            	<?php
            	the_content();
            	?>
            </div>
			
           <?php
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div>
</div>
</div>
<!-- </div> -->

<?php
get_footer();
?>

<!--Latest jQuery-->
<script type="text/javascript" src="http://demo.nstechframe.com/assets/js/jquery-2.2.0.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function () 
{
    jQuery.noConflict();
    // reference for main items
    var slider = $('#slider');
    // reference for thumbnail items
    var thumbnailSlider = $('#thumbnailSlider');
    //transition time in ms
    var duration = 550;
    // carousel function for main slider
slider.owlCarousel({
            loop:true,
            nav:false,
            items:1
            });

// carousel function for thumbnail slider
thumbnailSlider.owlCarousel({
      loop:true,
      center:true, //to display the thumbnail item in center
      nav:true,
      responsive:{
                0:{
                items:3
                },
                600:{
                items:4
                },
                1000:{
                items:5
                }
          }
}).on('click', '.owl-item img', function () 
{
// On click of thumbnail items to trigger same main item
//slider.trigger('to.owl.carousel', [$(this).index(), duration, true]);
var src = jQuery(this).attr('src');
//alert(src);
jQuery("#slider img").attr('src',src);

});

    
      //jQuery( "#date_and_time_1929" ).datepicker( "option", "dateFormat", 'mm/dd/yy' );
      jQuery( "#date_and_time_1929" ).datepicker("setDate", "10/12/2012" ,"option", { disabled: true });


});
</script>