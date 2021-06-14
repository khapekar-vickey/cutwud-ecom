<?php
/**
 * Template Name: Book Appointment
 *
 *
 */
get_header();
if (!is_user_logged_in() ){
        //wp_redirect("/login/");
        echo '<script>window.location.href="'.home_url('/login/').'"</script>';
    exit;
        } 
?>
<div class="container">
<div class="row">
<div class="col-sm-12">
    
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">  
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

<?php
get_footer();
?>

<!--Latest jQuery-->
<script type="text/javascript" src="http://demo.nstechframe.com/assets/js/jquery-2.2.0.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function () 
{
      //jQuery( "#date_and_time_1929" ).datepicker( "option", "dateFormat", 'mm/dd/yy' );
      jQuery( "#date_and_time_1929" ).datepicker("setDate", "10/12/2012" ,"option", { disabled: true });
});
</script>