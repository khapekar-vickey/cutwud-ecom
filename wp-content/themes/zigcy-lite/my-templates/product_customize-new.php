<?php
/**
 * Template Name: Product Customize template
 *
 *
 */
get_header();
/*if (!is_user_logged_in() ){
        //wp_redirect("/login/");
        echo '<script>window.location.href="'.home_url('/login/').'"</script>';
    exit;
        } */
?>
<!-- Customizer sticky navigation -->
<div class="sticky-nav">
    <div class="container">
        <div class="st-navblock clearfl">
            <div class="float-l leftblock">
                <ul class="clearfl">
                    <li class="active"> <a href="#">Gallery</a> </li>
                    <li class=""><a href="#details-block" >Item Details</a></li>
                    <li class=""><a href="#">Often Bought With</a></li>
                     <li class=""><a href="#">Explore Collection</a></li>
                </ul>
            </div>
            <div class="float-r rghtblock-btn" style="display:block">
                <a href="/cart" class="st-buybtn">VIEW CART</a>
            </div>
        </div>
    </div>
</div>
<!-- Customizer section navigation -->
<?php
global $post;

$porudctId=  isset($_GET['pid']) ? $_GET['pid'] : '';
if($porudctId)
{
    $post_thumbnail_id = get_post_thumbnail_id($porudctId);
    if ($post_thumbnail_id) 
    {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'full');
        $thumbimg= $post_thumbnail_img[0];

    }

  $image_gallery = get_post_meta($porudctId,'_product_image_gallery',true);
  $product_image_gallery = explode(",",$image_gallery);
  //print_r($product_image_gallery);

}


 $attr_for_gall = get_post_meta($porudctId,'_product_attributes',true);
 //print_r($attr_for_gall);

 // Get $product object from product ID
 $product = wc_get_product( $porudctId );
 //print_r($product);
 $imageAPiURl= "https://image.icarefurnishers.com/api/Image/Getimage?sku=".$product->get_sku().'&attributeJson=';
$array=array();
$attr = get_post_meta($porudctId,'_product_attributes',true);
$mainImag = toplevel_mainImage($attr,$porudctId);
$main_img = str_replace('"', "'", $imageAPiURl.'['.$mainImag.']&width=1000&height=1000');

$companyCode = 'ICF';
$storeCode = 'NGP';

//$pricedata ='{"companyCode":"'.$companyCode.'","storeCode":"'.$storeCode.'","SKU":"'.$product->get_sku().'"}';
$pricedata = array(
  "companyCode" => $companyCode,
  "storeCode" => $storeCode,
  "SKU" => $product->get_sku()
);

$dataPrice = getProductPrice($pricedata);
*/
/* ************* Date :- 08-06-2020 *************** */
/* ******************* Vickey ********************* */
// For Customize Product images url

$sku =  $product->get_sku();
$attributes = $product->get_attributes();
// echo "<pre>";
// print_r($attributes);
// echo "</pre>";

foreach ( $attributes as $attribute ):
    
	$attribute_data = $attribute->get_data(); // Get the data in an array
  // echo "<pre>";
// print_r($attribute_data);
// echo "</pre>";
    $attribute_name = $attribute_data['name']; // The taxonomy slug name
    $attribute_terms_option = $attribute_data['options']; // The terms Ids
	$attribute_terms = $attribute->get_terms(); // The terms
	foreach( $attribute_terms as $term ){

		$terms =  $term->name;
    }

endforeach;
$cust_pro_normal_img_url = "https://image.icarefurnishers.com/images/".$sku."/".$attribute_name."/".$terms."/Normal/sofa01.jpg";
$cust_pro_data_img_url = "https://image.icarefurnishers.com/images/".$sku."/".$attribute_name."/".$terms."/Normal/sofa##.jpg|01..24";
/*
echo "<pre>";
print_r("SKU = ".$sku);
echo"\n";
print_r("Attribute = ".$attribute_name);
echo"\n";
print_r("Term name = ".$terms);
echo"\n";
print_r("Pro url = ".$cust_pro_img_url);
echo "</pre>";

*/


  /*$SalesPrice =  $dataPrice->SalesPrice;
  $RetailPrice =  $jsonArrayResponse->Data[0]->RetailPrice;
  $Quantity   =  $jsonArrayResponse->Data[0]->Quantity;
  $Sku    =  $jsonArrayResponse->Data[0]->Sku;*/
?>
<div id="customize-preloader"></div>
<div class="customize-page-wrapper">
    <div class="container">
        <div class="row customizer-top">
            <div class="col-md-8">
        		<!-- <h2><?=get_the_title($porudctId);?></h2> -->
                <!--Carousel Wrapper-->
                <div class="custom-slide-img slider-container">
    				<a data-toggle="modal" data-target="#ImgzoomModal" class="fullscreen-button action-button-icon icon-fullscreen-off"></a>
                    <div id="custom_prd_slider" class="slider">
    					<div class="item">
    						<div class="content" >
    						<!-- <div id="slidermain_img-reel" class="reel reel-overlay frame-1"> -->
    							<img id="slidermain_img" width="1024" height="800" src="<?=$cust_pro_normal_img_url?>" class="reel" data-images="<?=$cust_pro_data_img_url?>" >
    						
    						<!-- </div> -->
    						<div class="rotate-360-degree" style="display: block; opacity: 1.08347;">Drag to Rotate. Click to Zoom</div>
    						</div>
    					</div>
                    </div>
                </div>
    			
    			<!-- The Modal -->
    			<div id="ImgzoomModal" class="modal">
    				<button type="button" class="close" data-dismiss="modal">&times;</button>
					  <div>  				
					<img id="zoom_slidermain_img" width="1024" height="800" src="<?=$cust_pro_normal_img_url?>" class="reel" data-images="<?=$cust_pro_data_img_url?>" >
					 </div> 
			
    			</div>
            <!--/.Carousel Wrapper-->
            <!--/.Carousel Wrapper end-->
            </div>
            <div class="col-md-4">
                <div class="color-options">
                    <h2><?=get_the_title($porudctId);?></h2>
                    <div id="accordion" class="accordion">
                        <div class="card mb-0">
                			<?php
                			while ( have_posts() ) : the_post();
                          $frm=0;
                          //$attr = get_post_meta($porudctId,'_product_attributes',true);
                          if(count( $attr)>0 && $porudctId!="")
                            {
                            //print_r($attr);
                            ?>     
                            <form name="cst_getproduct" id="cst_getproduct" action="" method="post">
                              <input type="hidden" name="product_id" value="<?=$porudctId?>">
                              <input type="hidden" name="product_price" value="<?=$dataPrice->SalesPrice?>">
                              <?php
                              $termlist ='';
                                  $srnNo=1;
                                  foreach ($attr as $key => $value)
                                    {
                                        $title = str_replace("pa_"," ",$key);
                                        $title = str_replace("-"," ",$title);
                                        # code...
                                        //$termlist .='<a name="'.$key.'">&nbsp;</a><h3 class="title-color">'.ucwords($title).'</h3><br>';
                                        $termlist .='<div class="card-header collapsed" data-toggle="collapse" href="#collapseOne'.$srnNo.'">
                                        <a class="card-title"><span class="sr-no">'.$srnNo.'</span> '.ucwords($title).'</a>
                                        </div>';
                                        $termlist .='<div id="collapseOne'.$srnNo.'" class="card-body collapse" data-parent="#accordion">
                                        <ul>';
                                        // Query arguments.
                                        //$result = wc_get_product_terms($product_id, $taxonomy, $args); 
                                        $pterms = wc_get_product_terms($porudctId, $key, $args=array());
                                     
                                            foreach ($pterms as $key1 => $term)
                                            {                  

                                               // Get term by name ''news'' in Tags taxonomy.
                                                $tag = get_term_by('slug', $term->slug, $key);
                                                // print_r($tag);
                                                $term_id = $tag->term_id;
                                                $allTermImg="";
                                                $term_image = get_term_meta( $term_id, 'color_image', true);
                                                $term_image_src = wp_get_attachment_image_src($term_image, 'thumbnail' );

                                                 $default = get_term_meta( $term_id, 'set_default_attribute', true);
                                                if($default==1)
                                                  {
                                                    $check="checked='checked'";
                                                    $active="active";

                                                  }else{$check="";$active="";}
                                                $termlist .='<li id="term_id'.$term->term_id.'"><div class="mediumbox '.trim($key).' term_list'.$term_id.' '.$active.'"><div class="medium-img">';

                                                $termlist .="<img id='frameimage".$term_id."' src='".$term_image_src[0]."' alt='".$term->slug."' /></div><div class='medium-name'>";

                                                $termlist .='<input '.$check.' data-pid="'.$porudctId.'" data-termkey="'.trim($key).'" data-sku="'.$sku.'" type="radio" name="product_attr['.trim($key).'][]" class="term_list_all" id="term_list'.$term->term_id.'"  value="'.$term->slug.'" /></div></div></li>';
                                            }
                                              $termlist .='</ul> </div>';
                                           $srnNo++;
                                       }//foreach
                                    echo $termlist;
                                      ?>
                                     <!--  <button name="cst_getproduct_data" id="cst_getproduct_data" class="btn btn-primary">Get Data</button> -->
                                      <!-- <input type="submit" name="submit" value="Get"> -->
                            </form>
                            <?php }//end if
                            else{
                              echo '<h3>Please select <a style="color:blue" href="shop">Product</a>..</h3>';
                              
                            }
                			endwhile; // End of the loop.
                			?>          
                        </div>
                  </div>
                </div>
    			<div class="customize-add-to-cart-btn mt-4 mb-4">
    				<button name="cst_addtocart_data" id="cst_addtocart_data" class="btn btn-primary">Add To Cart</button>
    				<span id="Viewaddtocart_data"></span>
    			</div>
            </div><!-- col-md-4 -->
        </div>
       
        <!-- Description -->
        <div id="details-block" class="product-info">
           <div class="row">
              <div class="col-sm-6">
                    <div class="customize-content-section" >
                        <?php
                        $post   = get_post( $porudctId );
                        $output =  apply_filters( 'the_content', $post->post_content );
                        echo $output;
                        ?>
                    </div>
              </div>
              <div class="col-sm-6">
                    <div class="short-descr">
                        <?php
                        $posts   = get_post( $porudctId );
                        $outputs = apply_filters( 'woocommerce_short_description', $posts->post_excerpt );
                        echo $outputs;
                        ?>
                    </div>  
                
              </div>
            </div>
        </div>
        <!-- Description end -->

        <!-- Upsell/linked product -->
        <div class="linked-product">
            <?php
                $product = new WC_Product($porudctId);
                $upsells = $product->get_upsells();
                if (!$upsells)
                    return;
                $meta_query = WC()->query->get_meta_query();
                $args = array(
                    'post_type' => 'product',
                    'ignore_sticky_posts' => 1,
                    'no_found_rows' => 1,
                    'posts_per_page' => $posts_per_page,
                    'orderby' => $orderby,
                    'post__in' => $upsells,
                    'post__not_in' => array($product->id),
                    'meta_query' => $meta_query
                );

                $products = new WP_Query($args);
                if( $products->have_posts() ) : ?>
                    <h2><?php esc_html_e( 'You may also like&hellip;', 'woocommerce' ); ?></h2>
                    <?php
                        echo '<div class="cross-sells">';
                        woocommerce_product_loop_start();
                        while ( $products->have_posts() ) : $products->the_post();
                            wc_get_template_part( 'content', 'product' );
                        endwhile; // end of the loop.
                        woocommerce_product_loop_end();
                        echo '</div>';
                     ?>
                <?php
                endif;
                wp_reset_postdata(); ?>
        </div>
        <!-- Upsell/linked product -->
    </div>
</div>

         
<style type="text/css">
.pr-customize-page{position: relative;}
.pr-customize-page .slider-container{position: relative;display: block;width: 100%;margin: 0 auto;}
.pr-customize-page .slider .content{width: 100%;height: auto;margin: 0 auto;}
#slidermain_img {width: 100%;height: auto;}
.pr-customize-page .thumbnail-slider-container{margin-top: 5px;width: 700px;margin: 0 auto;}
.pr-customize-page .thumbnail-slider .content{padding:5px;}
.pr-customize-page .thumbnail-slider .owl-item.active.center{border: 3px solid #333333;}
.pr-customize-page .owl-nav {font-size: 55px;}
.pr-customize-page .owl-nav .owl-prev {position: absolute; top: 7px; left: -25px;}
.pr-customize-page .owl-nav .owl-next {position: absolute; top: 7px; right: -25px;}
.pr-customize-page .owl-nav button:focus {outline: 0px;}
.pr-customize-page .lt-option ul{margin-top: 0px; padding: 0px; list-style: none; min-height: 410px; background: #b3a59a;}
/*.pr-customize-page .lt-option ul li:last-child a {border-bottom: 0px;}*/
.pr-customize-page .lt-option ul li a{background: #b3a59a; color: #fff; width: 100%; display: inline-block; padding: 7px 15px 5px; transition: 0.4s ease all;border-bottom: #9a8b7f 1px dashed;}
.pr-customize-page .lt-option ul li a:hover {background: #8c7c70; color: #fff;}
.pr-customize-page .option-size-clr ul {list-style: none;}
.pr-customize-page .title-color {float: left; width: 100%;}
.pr-customize-page .btn-primary {background: #80756e; color: #ffffff; margin: 0px 5px; border: 2px solid #80756e; padding: 5px 20px; border-radius: 4px; font-size: 14px;}
.pr-customize-page .btn-primary:hover {background: #6b615a;}
/*Fabric accordion*/
.accordion>.card:first-child .card-body {
    display: block;
}
/*sticky nav*/
.sticky-nav {
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    box-shadow: 0 2px 4px 0 rgba(0,0,0,.06);
    z-index: 499;
    background-color: #fff;
    display: none;
}
.pf-hover-white:hover, .pf-white {
    color: #000;
    background-color: #fff;
}
.float-l {
    float: left;
}
.clearfl:after{
    content: "";
    display: table;
    clear: both;
}
.leftblock ul{
    margin: 0;
    padding: 0;
}
.leftblock li {
    margin-right: 50px;
    float: left;
}
.leftblock li a {
    font-size: 13px;
    text-align: center;
    color: #353535;
    padding: 20px 10px;
    display: inline-block;
    box-sizing: border-box;
    border-bottom: 3px solid transparent;
    text-transform: uppercase;
    text-decoration: none;
}
.float-r {
    float: right;
}
.rghtblock-btn .st-buybtn {
    background-color: #8c7c70;
    color: #fff;
    text-transform: uppercase;
    font-weight: 700;
    font-size: 14px;
    padding: 10px 35px;
    display: inline-block;
    margin-top: 10px;
}
.sticky-nav.sticky {
    display: block;
}
</style>
<script>
// //Sticky nav
$(window).scroll(function(){
    if ($(window).scrollTop() >= 300) {
       $('.sticky-nav').addClass('sticky');
    }
    else {
       $('.sticky-nav').removeClass('sticky');
    }
});

</script>
<?php
get_footer();
?>

<!--Latest jQuery-->
<!-- <script type="text/javascript" src="http://demo.nstechframe.com/assets/js/jquery-2.2.0.min.js"></script> -->