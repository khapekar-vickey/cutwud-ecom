<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package icarefurnishers
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
	<!-- font-family: 'Open Sans', sans-serif; --> 
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap" rel="stylesheet">
	<!-- font-family: 'Roboto', sans-serif; --> 
<?php wp_head(); ?>
	<!-- Bootstrap -->   
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.png" rel="shortcut icon" type="image/x-icon" /> 
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/owl.theme.default.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/custom.css" rel="stylesheet">

<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/custom.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.reel-min.js"></script>
<script type="text/javascript">jQuery.noConflict(true);</script>
	
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<header class="header">
		<div class="header-top">
			<div class="container">
                <div class="row">
                    <div class="col-sm-6">
                    	<span class="offer-lbl">Latest Offers</span>
                    	<ul class="ticker">
                    		<li><a href="#">20% Flat Discount</a></li>
                    	</ul>
                    </div>
                    <div class="col-sm-6">
                    	<div class="account-wrap">
							<div class="top-mob">
								<a href="tel:<?php $content_mod = get_theme_mod('header_phone_number'); echo $content_mod;?>"><i class="fa fa-phone"></i>
								<?php
	                                $content_mod = get_theme_mod('header_phone_number');
	                                echo $content_mod;?>
								</a>
							</div>
							<div class="header-cart">
								<!-- <a class="cart-content" href="https://icarefurnishers.com/cart/" title="View your shopping cart"> -->
								<!--a class="cart-content" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'icarefurnishers' ); ?>">
									<div class="count">
										<i class="fa fa-shopping-bag"></i>
										<span class="cart-count"><?php echo wp_kses_data(/* translators: Cart Item */ sprintf( _n( '%s Item', '%s Items', WC()->cart->get_cart_contents_count(), 'icarefurnishers' ), WC()->cart->get_cart_contents_count() ) ); ?></span>
										<span class="cart-total"><?php echo wp_kses_data( WC()->cart->get_cart_total() ) ; ?></span>
									</div>	               	
								</a-->
							</div>
							<div class="my-account">
								<!-- <a href="https://icarefurnishers.com/my-account/">
									<i class="fa fa-user"></i>
									<span>My Account</span>
								</a> -->
								<a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>">
										<i class="fa fa-user"></i>
										<span><?php esc_html_e('My Account','icarefurnishers');?></span>
									</a>
							</div>
							<div class="user-login">
									<?php
									//if user is logged in
									if(is_user_logged_in()){
										global $current_user;
										wp_get_current_user();
										?>						
										<a href="<?php echo esc_url(wp_logout_url( get_permalink( wc_get_page_id( 'my-account' ) ) ) ); ?>" class="logout">
											<i class="fa fa-sign-out "></i>
											<?php esc_html_e('Logout','icarefurnishers'); ?>
										</a>
										<?php
									} else{
										?>

									<!-- <a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" class="login"> -->

										<!-- <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Login</a> -->
										<a href="javascript:void(0)" class="" data-toggle="modal" data-target="#loginForm">
											<i class="fa fa-sign-in"></i>
											<?php esc_html_e('Login','icarefurnishers'); ?>
										</a>

										<a href="javascript:void(0)" class="" data-toggle="modal" data-target="#registrationForm">
											<i class="fa fa-sign-in"></i>
											<?php esc_html_e('Signup','icarefurnishers'); ?>
										</a>
										<?php 
									}
									?>
								</div>
								
								<!-- <a class="btn-sm text-white btn-primary mr-1" style="font-size: 11px; cursor: pointer;" data-toggle="modal" data-target="#loginForm"> Test Login</a>
								<a class="btn-sm text-white btn-info" style="font-size: 11px; cursor: pointer;" data-toggle="modal" data-target="#registrationForm"> Test Signup</a> -->
						</div>
                    </div>
				</div>
			</div>
		</div>

		<div class="buttom-header">
			<div class="container">
				<div class="header-logo-warapper">
					<div class="site-logo">
			            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_theme_mod('header_logo_upload'); ?>"></a>
			        </div>
			        <div class="wrap-right">
						<!--div class="header-call-to">
							<p>Call US Now</p>
							
							<a href="tel:<?php $content_mod = get_theme_mod('header_phone_number'); echo $content_mod;?>"><i class="fa fa-mobile"></i>
								<?php
	                                $content_mod = get_theme_mod('header_phone_number');
	                                echo $content_mod;?></a>
						</div-->	
						<div class="header-cart">
							<a class="cart-content" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'icarefurnishers' ); ?>">
								<div class="count">
									<i class="fa fa-shopping-cart"></i>
									<span class="cart-count"><?php echo wp_kses_data(/* translators: Cart Item */ sprintf( _n( '%s', '%s', WC()->cart->get_cart_contents_count(), 'icarefurnishers' ), WC()->cart->get_cart_contents_count() ) ); ?></span><br />
									<span class="cart-total"><?php echo wp_kses_data( WC()->cart->get_cart_total() ) ; ?></span>
								</div>	               	
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

        <div class="wrap-header-nav">
        	<div class="container">
        		<div class="row">
        			<div class="col-md-11">
        				<div class="header-menu">
                            <?php quadmenu(array("theme_location" => "menu-1", "theme" => "default_theme")); ?>
                        </div>
        			</div>
        			<div class="">
        				<div class="header-search">
	                        <div class="searching">
	                           <center>
	                                <a href="javascript:void(0)" class="search-open">
	                                <i class="fa fa-search"></i>
	                            </a>
	                           </center>
	                            <div class="search-inline" style="display: none;">

									<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' );?>" >

											<input type="text" value="<?php echo get_search_query();?>" name="s" id="s" class="form-control search-in" placeholder="Type Keyword..." aria-label="Recipient's username" aria-describedby="basic-addon2">
											<div class="input-group-append">
											<button class="btn btn-outline-secondary" type="submit">Search</button>
											</div>
											<a href="javascript:void(0)" class="search-close">
											<i class="fa fa-times"></i>
											</a>
									</form>
	                               
	                            </div>
	                        </div>
	                    </div>
        			</div>
        		</div>
        	</div>
        </div>

    </header>
	
<?php echo do_shortcode("[DkHomepageSlider number='10' posttype='homepage_slider']"); ?>
	<div id="content" class="site-content">
