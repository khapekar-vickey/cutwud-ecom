<?php
function our_partnerlisting($atts=null, $content = null) 
{
  global $wpdb, $post;
  require_once('BFI_Thumb.php');
      if($atts)
      {
        $role = sanitize_text_field($atts->role);
        $number = sanitize_text_field($atts->number);
      }else{
         $role = 'ourpartner';
        $number = 10;
      }
  // We're outputting a lot of HTML, and the easiest way 
  // to do it is with output buffering from PHP.
 // ob_start();

  // Get the Search Term
  $search = ( isset($_GET["as"]) ) ? sanitize_text_field($_GET["as"]) : false ;

  // Get Query Var for pagination. This already exists in WordPress
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

  // Calculate the offset (i.e. how many users we should skip)
      if($paged==1){

            $offset=0;  

      }else {

            $offset= ($paged-1)*$number;

      }

  if($search)
  {
    // Generate the query based on search field
    $my_users = new WP_User_Query( 
      array( 
        'role' => $role, 
        'search' => '*' . $search . '*' 
      ));
  } else {
    // Generate the query 
    $my_users = new WP_User_Query( 
      array( 
      'role' => 'ourpartner',
      'orderby'      => 'ID',
      'order'        => 'DESC',
      'fields'       => 'all',
      'offset' => $offset ,
      'number' => $number
      ));
  }

  // Get the total number of partners. Based on this, offset and number 
  // per page, we'll generate our pagination.

  $total_partners = $my_users->total_users;

  // Calculate the total number of pages for the pagination
  $total_pages = ceil($total_partners/$number);

  // The partners object.

  $partner = $my_users->get_results();
  //print_r($partner);
  $total_query = count($partner);
  $srn=1;
?>

  <div class="partner-search">
        <h2>Search partners by name</h2>
          <form method="get" id="sul-searchform" action="<?php the_permalink() ?>">
            <label for="as" class="assistive-text">Search</label>
            <input type="text" class="field" name="as" id="sul-s" placeholder="Search Partners" />
            <input type="submit" class="submit" name="submit" id="sul-searchsubmit" value="Search" />
          </form>
        <?php 
        if($search)
          { ?>
          <h2 >Search Results for: <em><?php echo $search; ?></em></h2>
          <a href="<?php the_permalink(); ?>">Back To Partner Listing</a>
        <?php
         } 
        ?>

  </div><!-- .partner-search -->
<?php
if($total_query >0)
{

  foreach ($partner as $uservalue) 
  {
    //provider_id customer_id services cust_email provider_email
   
      $reqid = $uservalue->ID;
      $fname   = get_user_meta($reqid,'first_name',true);
      $lname   = get_user_meta($reqid,'last_name',true);

      $user_phone   = get_user_meta($reqid,'user_phone',true);
      $user_address   = get_user_meta($reqid,'user_address',true);
      $user_city   = get_user_meta($reqid,'user_city',true);
      $user_country   = get_user_meta($reqid,'user_country',true);
      $user_state   = get_user_meta($reqid,'user_state',true);
      $user_postcode   = get_user_meta($reqid,'user_postcode',true);

      $user_login = $uservalue->user_login;

      $user_nicename = $uservalue->user_nicename;

 
       $profile_pic = get_user_meta( $reqid, 'wpum_user_avatar', true );

      //$user_avatar_big = get_user_meta($reqid,'user_avatar_big',true);

      $gwpm_gender = get_user_meta( $reqid, 'gender', true ); 

      $user_avatar = wp_get_attachment_image_src( $profile_pic, 'thumbnail' );

        ?>
        <div class="camplistbox">

                    <div class="row">

                        <div class="col-sm-12">

                                <div class="col-sm-4 camp-img">                               

                                <?php 
                                echo "<p>".$fname." ".$lname."</p>";
                                if(!empty($user_avatar[0])){ ?>

                                    <a href="#">

                                    <img src="<?php echo bfi_thumb($user_avatar[0]); ?>" style=" width:90px " >

                                    </a>

                                <?php }else{ 
                                  ?>

                                    <a href="#">

                                    <img src="<?php echo get_bloginfo('template_url') ?>/images/profile-image-men.jpg" alt="Softwarehawk" class="default-img" style=" width:90px ">

                                    </a>

                                <?php } 
                                echo "<p>Contact No: ".$user_phone."<br>";
                                echo "Address  :".$user_address."<br>";
                                echo $user_city.", ". get_wpum_state($user_state).", ".get_wpum_country($user_country)."- ".$user_postcode."</p>";
                                ?>

                                </div>
                               

                        </div>
                      

                    </div>
                       

                </div><!-- camplistbox -->

            <?php }

            }else{

              echo '<h3>Result not found,try again...</h3>';

            }

/*--------------------------------------------------
// Members Pagination Function  
--------------------------------------------------------*/
    if ($total_pages) 
          {

          echo '<div id="pagination" class="clearfix">';

          //echo '<span class="pages">Pages:</span>';

          $big = 999999999; // need an unlikely integer

            $current_page = max(1, get_query_var('paged'));

            echo paginate_links(array(

             'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),

              'format' => 'paged/%#%/',

              'current' => $paged,

              'total' => $total_pages,

              'prev_next'    => true,

              'type'         => 'list',//list plain

              'end_size'           => 1,

            'mid_size'           => 2,

            'prev_text'          => __('« Previous'),

            'next_text'          => __('Next »')

              ));

          echo '</div>';

    }
    ?>
    <style>

#pagination {display: inline-block; padding: 6px 5px 6px 0px; text-align: center;

margin: 2px; background-color: #999; width: 100%;

}

#pagination ul li{float: left; list-style: none;}

#pagination ul li a {

    border: 1px solid #ccc;

    color: black;

    float: left;

    margin-left: 2px;

    margin-right: 2px;

    margin-top: -8px;

    padding: 8px 16px;

    text-decoration: none;

}

.page-numbers .current {

    background-color: #4CAF50;

    color: white;

    padding: 8px 16px;

}
.page-numbers a:hover:not(.current) {background-color: #ddd;}

</style>
    <?php
}
// Add the shortcode to WordPress. 
add_shortcode('UserListinG', 'our_partnerlisting');