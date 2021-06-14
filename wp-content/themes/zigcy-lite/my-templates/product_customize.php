<?php
/**
 * Template Name: Product Customizeeeee
 *
 *
 */
get_header();
/*if (!is_user_logged_in() ){
        //wp_redirect("/login/");
        echo '<script>window.location.href="'.home_url('/login/').'"</script>';
    exit;
        } */
		
		

		
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

$sku =  $product->get_sku($porudctId);
/*
echo "<pre>";
print_r($sku);

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
    <div class="row">
      <div class="col-md-8">
        		<!-- <h2><?=get_the_title($porudctId);?></h2> -->
          
                <!--Carousel Wrapper-->
                <div class="custom-slide-img slider-container">
                    <div id="custom_prd_slider" class="slider">
						<div class="item">
							<div class="content">
								<img id="slidermain_img" src="<?=$main_img?>" class="img-responsive">
							</div>
						</div>
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
			?>          </div>
              </div>
            </div>
			<div class="customize-add-to-cart-btn mt-4 mb-4">
				<button name="cst_addtocart_data" id="cst_addtocart_data" class="btn btn-primary">Add To Cart</button>
				<span id="Viewaddtocart_data"></span>
			</div>
          </div><!-- col-md-4 -->
        </div>
       
       <!-- Description -->
            <div class="row">
              <div class="col-md-12">
				<div class="customize-content-section">
                <?php
                $post   = get_post( $porudctId );
                $output =  apply_filters( 'the_content', $post->post_content );
                echo $output;
                ?>
				</div>
              </div>
            </div>
        <!-- Description end -->
      </div>
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
</style>
<?php
get_footer();
?>

<!--Latest jQuery-->
<!-- <script type="text/javascript" src="http://demo.nstechframe.com/assets/js/jquery-2.2.0.min.js"></script> -->