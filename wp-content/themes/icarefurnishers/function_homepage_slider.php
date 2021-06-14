<?php
//https://jasonskinner.me/2013/03/creating-a-wordpress-photo-gallery-using-custom-post-types/
add_action( 'init', 'add_gallery_post_type' );
function add_gallery_post_type() {
    register_post_type( 'homepage_slider',
            array(
                'labels' => array(
                                'name' => __( 'HomePage Slider' ),
                                'singular_name' => __( 'HomePage Slider' ),
                                'all_items' => __( 'All Images')
                            ),
                'public' => true,
                'has_archive' => false,
                'exclude_from_search' => true,
                //'rewrite' => array('slug' => 'home-slider'),
                'supports' => array( 'title', 'thumbnail' ),
                'menu_position' => 4,
                'show_in_admin_bar'   => false,
                'show_in_nav_menus'   => false,
                'publicly_queryable'  => true,
                'query_var'           => false,
                'capability_type'     => 'post'
            )
    );
}

function dk_get_backend_preview_thumb($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'thumbnail');
        return $post_thumbnail_img[0];
    }
}

function dk_preview_thumb_column_head($defaults) {
    $defaults['featured_image'] = 'Image';
    return $defaults;
}
//add_filter('manage_posts_columns', 'dk_preview_thumb_column_head');

function dk_preview_thumb_column($column_name, $post_ID) {
    if ($column_name == 'featured_image') {
        $post_featured_image = dk_get_backend_preview_thumb($post_ID);
            if ($post_featured_image) {
                echo '<img src="' . $post_featured_image . '" />';
            }
    }
}
//add_action('manage_posts_custom_column', 'dk_preview_thumb_column', 10, 2);

function dk_homepageSlider($atts=null) 
{
  global $wpdb, $post;
  if($atts)
      {
        $posttype = sanitize_text_field($atts['posttype']);
        $number = sanitize_text_field($atts['number']);
      }else{
            $posttype = 'homepage_slider';
            $number = 10;
      }

$current_user_id = get_current_user_id();


          $queryPartners = array(
              'post_type' => $posttype,
              //'author' => $current_user_id ,
              'posts_per_page' => $number,
              'post_status'=>'publish',
              'orderby'     => 'ID', 
              'order'       => 'ASC'
            );

//print_r($queryPartners);
if ( is_home() || is_front_page() ) { ?>
    <div class="home-slider-container">
	<div class="container">
      <div id="home-page-slider" class="home-page-slider owl-carousel owl-theme">
<?php
                    $sliderPost = new WP_Query($queryPartners);
                    //print_r($sliderPost);
                    if($sliderPost->have_posts())
                    {
                        while ($sliderPost->have_posts())
                        {
                          $sliderPost->the_post();

                          $post_ID = $sliderPost->post->ID;   
                          $permalink=get_permalink($post_ID);
                          $postDate= date('m-d-Y', strtotime($sliderPost->post->post_date));
                          $post_content = substr($sliderPost->post->post_content,0,150).'...';
                          $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) 
    {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'full');
       // print_r($post_thumbnail_img);
        $thumbimg= "<img src='".$post_thumbnail_img[0]."' />";
    }

                    ?>
          <div class="item">
            <!-- <img src="http://icarefurnishers.com.cp-20.bigrockservers.com/wp-content/uploads/2019/12/banner-01.jpg" alt=""> -->
            <?php 
            echo $thumbimg;
            ?>
          </div>

          <?php } //end while
                    wp_reset_postdata();
                     } else { ?>
                    <div><h3>No records found</h3></div>
                    <?php 
                  } ?>
          <!-- <div class="item">
            <img src="http://icarefurnishers.com.cp-20.bigrockservers.com/wp-content/uploads/2019/12/banner-02.jpg" alt="">
          </div> -->

      </div> <!-- slider end -->
      <div class="banner-search-section">
        <div class="search-mid-sec">
<!-- <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' );?>" >
<div class="input-group mb-5">

<input type="text" value="<?php echo get_search_query();?>" name="s" id="s" class="form-control" placeholder="Type Keyword..." aria-label="Recipient's username" aria-describedby="basic-addon2">
<div class="input-group-append">
<button class="btn btn-outline-secondary" type="submit">Search</button>
</div>
</div>
</form> -->
         <!--  <div class="banner-btn-section">
            <?php //echo do_shortcode('[OldnewButton]'); ?>
          </div> <!-- button end -->
        <!-- </div> --> <!-- search end -->
        
      </div>
    </div>
	</div>
	</div>
    <?php }
}
// Add the shortcode to WordPress. 
add_shortcode('DkHomepageSlider', 'dk_homepageSlider');

/*=================Gallery start ======================*/

add_action( 'admin_init', 'add_post_gallery_so_dkgallery' );
add_action( 'admin_head-post.php', 'print_scripts_so_dkgallery' );
add_action( 'admin_head-post-new.php', 'print_scripts_so_dkgallery' );
add_action( 'save_post', 'update_post_gallery_so_dkgallery');
 
/**
 * Add custom Meta Box to Posts post type
*/
function add_post_gallery_so_dkgallery()
{
  add_meta_box(
  'post_gallery',
  'Uploade Gallery Images',
  'post_gallery_options_so_dkgallery',
  'partners',// here you can set post type name
  'normal',
  'core'
      );
  add_meta_box(
  'post_gallery2',
  'Uploade Gallery Images',
  'post_gallery_options_so_dkgallery',
  'interiordesigners',// here you can set post type name
  'normal',
  'core'
      );
}
 
/**
 * Print the Meta Box content
 */
function post_gallery_options_so_dkgallery()
{
  global $post;
  $dkgallery_data = get_post_meta( $post->ID, 'dkgallery_data', true );
  //print_r($dkgallery_data);
 
  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'noncename_so_dkgallery' );
  ?>
 
<div id="dynamic_form">
 
    <div id="field_wrap">
      <div class="field_left image_wrap" id="loadImages">
    <?php
    $rowid= rand(111,999);
    if ( isset( $dkgallery_data['image_url'] ) ) 
    {
      $i = 0;
       
          foreach ($dkgallery_data['image_url'] as $key => $value) 
          {
            # code...
      
        ?>
        <div class="imgbox row" id="master-row<?=$i?>">
          <div class="field_left">
            <label>Image URL</label><input id="meta_image_url<?=$i?>" value="<?php esc_html_e( $value ); ?>" type="text" name="gallery[image_url][]" />
          </div>
          <div class="field_left">
            <img src="<?php esc_html_e( $value); ?>" height="48" width="48" />
          </div>
            <div class="field_left"><input class="button" type="button" value="Remove" onclick="remove_field(<?=$i?>)" />
          </div>
         <div class="clear"></div>
        </div>
         
        <?php
        $i++;
        } // endif
    } // endforeach

    
    ?>
  

<div class="clear"></div>
<div> 
<input type="button" id="<?=$rowid?>" class="button image-upload" value="Upload Image" />
</div>
<div class="clear"></div>

    </div> 
</div>
</div>
 
  <?php
}
 
/**
 * Print styles and scripts
 */
function print_scripts_so_dkgallery()
{
    // Check for correct post_type
    global $post;
   
    ?>
    <style type="text/css">
      .field_left {display: block; padding: 10px;}
    </style>
     <script type="text/javascript">
         function remove_field(obj) {
            //var parent=jQuery(obj).parent().parent();
            //console.log(parent)
            jQuery("#master-row"+obj).remove();
        }

  jQuery(document).ready(function($) {

    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;
    // Runs when the image button is clicked.
    //$('.image-upload').click(function(e) {
    var indexval =10;
     $('.image-upload').live('click', function(e){
      
      var index = indexval;
      // Prevents the default action from occuring.
      e.preventDefault();
      var meta_image = $('#meta_image_url'+index);
      // If the frame already exists, re-open it.
      if (meta_image_frame) {
        meta_image_frame.open()
        return
      }
      // Sets up the media library frame
      meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
        title: meta_image.title,
        button: {
          text: meta_image.button,
        },
        /*library: { type: 'image'},
                  multiple: true*/
      })
      // Runs when an image is selected.
      meta_image_frame.on('select', function() {
        // Grabs the attachment selection and creates a JSON representation of the model.
        var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
        // Sends the attachment URL to our custom image input field.
var row = '<div class="imgbox" id="master-row'+index+'"><div class="field_left"><label>Image URL</label><input id="meta_image_url'+index+'" value="'+media_attachment.url+'" type="text" name="gallery[image_url][]" /></div><div class="field_right"><img src="'+media_attachment.url+'" height="48" width="48" /></div><div class="field_right"><input class="button" type="button" value="Remove" onclick="remove_field('+index+')" /></div><div class="clear"></div>';

        $("#loadImages").append(row);
        //$("#meta_image_url"+index).after('<img src="'+media_attachment.url+'" height="48" width="48" />');
       
           indexval + 1;
      })
      // Opens the media library frame.
      meta_image_frame.open();
    })
  })
</script>
    <?php
  
}
 
/**
 * Save post action, process fields
 */
function update_post_gallery_so_dkgallery( $post_id) 
{
    // Doing revision, exit earlier **can be removed**
   if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
 
    // Doing revision, exit earlier
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
 
    if ( $_POST['gallery'] ) 
    {
        // Build array for saving post meta
        $dkgallery_data = array();
        for ($i = 0; $i < count( $_POST['gallery']['image_url'] ); $i++ ) 
        {
            if ( '' != $_POST['gallery']['image_url'][ $i ] ) 
            {
                $dkgallery_data['image_url'][]  = $_POST['gallery']['image_url'][ $i ];
            }
        }

        if ( $dkgallery_data ) 
            update_post_meta( $post_id, 'dkgallery_data', $dkgallery_data );
        else 
            delete_post_meta( $post_id, 'dkgallery_data' );
    } 
    // Nothing received, all fields are empty, delete option
    else 
    {
        delete_post_meta( $post_id, 'dkgallery_data' );
    }
}
/*=================Gallery end ======================*/