<?php
function interiordesignerlisting_fun($atts=null, $content = null) 
{
  global $wpdb, $post;

require_once('BFI_Thumb.php');
$current_user_id = get_current_user_id();

// Get the Search Term
  $search = ( isset($_GET["as"]) ) ? sanitize_text_field($_GET["as"]) : false ;
  $userCity = get_user_meta($current_user_id,'user_city',true);

      if($atts)
      {
        $posttype = sanitize_text_field($atts->posttype);
        $number = sanitize_text_field($atts->number);
      }else{
            $posttype = 'interiordesigners';
            $number = 10;
      }

$paged = (get_query_var('paged') ) ? get_query_var('paged') : 1;
if($search)
  {
    // Generate the query based on search field
     $queryPartners = array(
              'post_type' => $posttype,
              //'author' => $current_user_id ,
              'posts_per_page' => $number,
              'post_status'=>'publish',
              'paged' => $paged,
               'orderby'     => 'title', 
              'order'       => 'ASC',
              's' => $search,
             /*'meta_query' => array(
              'relation'=>'AND',
                      array(
                          'key'       => 'address',
                          'value'     => $userCity,
                          'compare'   => 'LIKE'
                        )
                )*/
            );

  }else{
          $queryPartners = array(
              'post_type' => $posttype,
              //'author' => $current_user_id ,
              'posts_per_page' => $number,
              'post_status'=>'publish',
              'orderby'     => 'ID', 
              'order'       => 'ASC',
              'paged' => $paged,
             /*'meta_query' => array(
              'relation'=>'AND',
                      array(
                          'key'       => 'address',
                          'value'     => $userCity,
                          'compare'   => 'LIKE'
                        )
                )*/
            );
}
//print_r($queryPartners);
?>
  <div class="custom-partner-layout">
      <div class="partner-row">
        <div class="row">
            <!-- .partner-search -->
          <div class="col-sm-12">
            <div class="custom-search-in">
              <form method="get" id="sul-searchform" action="<?php the_permalink() ?>">
              <div class="input-group">
                <input type="text" name="as" id="sul-s" value="<?=$search?>" class="form-control" placeholder="Search Partners">
                <div class="input-group-append">
                  <!-- <button class="btn btn-success" type="submit">Search</button> -->
                  <input type="submit" class="btn btn-success" name="submit" id="sul-searchsubmit" value="Search" />
                </div>
              </div>
           </form>

        <?php 
        if($search)
          { ?>
          <h2 >Search Results for: <em><?php echo $search; ?></em></h2>
          <a href="<?php the_permalink(); ?>">Back To interiordesigner Listing</a>
        <?php
         } 
        ?>
            </div>
          </div>
        </div>
      </div>
  <!-- .partner-search -->

           
                
                    <?php
                    $partnerPost = new WP_Query($queryPartners);
                    if($partnerPost->have_posts())
                    {
                    while ($partnerPost->have_posts())
                    {
                    $partnerPost->the_post();
                    $partnerID = $partnerPost->post->ID;   
                    $permalink=get_permalink($partnerID);
                    $postDate= date('m-d-Y', strtotime($partnerPost->post->post_date));
                    $address = get_post_meta($partnerID,'address',true);
                    $partner_zipcode = get_post_meta($partnerID,'partner_zipcode',true);
                    $partner_city = get_post_meta($partnerID,'partner_city',true);
                    $partner_state = get_post_meta($partnerID,'partner_state',true);

                    $fscf_author = get_post_meta($partnerID,'fscf_author',true); //user id
                    $post_content = substr($partnerPost->post->post_content,0,150).'...';
                    $dkgallery_data = get_post_meta( $partnerID, 'dkgallery_data', true );

                    ?>
            <div class="partner-row">
        <div class="row">
          <div class="col-sm-4">
            <div class="partner-obj-img">
              <?php echo get_partner_preview_thumb($partnerID,'full');?>
              <a href="<?php echo home_url("/partners-details/?view=yes&id=".$partnerID);?>"><i class="fa fa-eye"></i><span>View</span></a>
              <!-- <img src="http://icarefurnishers.com.cp-20.bigrockservers.com/wp-content/uploads/2019/11/ecf7229f-furniture-wooden-img.jpg" alt="Partner Image"> -->
            </div>
          </div>
          <div class="col-sm-8">
            <div class="right-partner-content">
              <h3><a href="<?php echo home_url("/partners-details/?view=yes&id=".$partnerID);?>">
                <?php echo $partnerPost->post->post_title; ?></h3></a>
              <p><?=$post_content?></p>
              <div class="partner-thumbnail-row">
                <div class="row">
                  <?php //echo get_backend_preview_thumb($partnerID);?>
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
              </div>
            </div>
          </div>
        </div>
      </div>
                    <?php } //end while
                    ?>
                    <?php wp_reset_postdata();?> 
                    <?php } else { ?>
                    <div><h3>No records found</h3></div>
                    <?php } ?>
                
         
            <?php    
              if (function_exists(custom_pagination)) {
              custom_pagination($partnerPost->max_num_pages,"",$paged);
              } 
            ?>
        </div> <!-- custom-partner-layout end -->
<?php
}
// Add the shortcode to WordPress. 
add_shortcode('InteriorListinG', 'interiordesignerlisting_fun');

function interiordesigner_custom_post_type() 
{
  $labels = array(
    'name'                => __( 'Interior Designers' ),
    'singular_name'       => __( 'Interior Designer'),
    'menu_name'           => __( 'Interior Designers'),
    'parent_item_colon'   => __( 'Parent Interior Designer'),
    'all_items'           => __( 'All Interior Designers'),
    'view_item'           => __( 'View Interior Designer'),
    'add_new_item'        => __( 'Add New Interior Designer'),
    'add_new'             => __( 'Add Interior Designer'),
    'edit_item'           => __( 'Edit Interior Designer'),
    'update_item'         => __( 'Update Interior Designer'),
    'search_items'        => __( 'Search Interior Designer'),
    'not_found'           => __( 'Not Found'),
    'not_found_in_trash'  => __( 'Not found in Trash')
  );
  $args = array(
    'label'               => __( 'Interior Designers'),
    'description'         => __( 'Interior Designers'),
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'author', 'thumbnail' ),
    'public'              => true,
    'hierarchical'        => false,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'has_archive'         => true,
    'can_export'          => true,
    'exclude_from_search' => false,
    'yarpp_support'       => true,
    //'taxonomies'        => array('post_tag'),
    'publicly_queryable'  => true,
    'capability_type'     => 'post'
);
  register_post_type( 'interiordesigners', $args );
}
add_action( 'init', 'interiordesigner_custom_post_type', 0 );