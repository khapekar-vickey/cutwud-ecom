<?php
function dms_contact_details($wp_customize){
    //  =============================
    //  = Section Header Logo     =
    //  =============================
    
    $wp_customize->add_section('header_logo', array(
        'title'      => __( 'Header Site Logo', 'twentytwenty' ),
        'description' => '',
        'priority'   => 90,
        )
    ); 

    //  =============================
    //  = Header Logo Image Upload   =
    //  =============================
    $wp_customize->add_setting('header_logo_upload', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'type'           => 'theme_mod',
 
    ));
 
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'header_logo_upload', array(
        'label'    => __('Organization logo', 'twentytwenty'),
        'section'  => 'header_logo',
    )));

    //  =============================
    //  = Section Header Mobile Logo     =
    //  =============================
    
    $wp_customize->add_section('header_mob_logo', array(
        'title'      => __( 'Header Mobile Logo', 'twentytwenty' ),
        'description' => '',
        'priority'   => 90,
        )
    ); 

    //  =============================
    //  = Header Mobile Logo Image Upload   =
    //  =============================
    $wp_customize->add_setting('header_logo_mobile', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'type'           => 'theme_mod',
 
    ));
 
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'header_logo_mobile', array(
        'label'    => __('Upload Mobile logo', 'twentytwenty'),
        'section'  => 'header_mob_logo',
    )));
    
    //  =============================
    //  = Social Channels Section   =
    //  =============================
    
    $wp_customize->add_section('social_channels', array(
        'title'      => __( 'Social Channels', 'twentytwenty' ),
        'description' => '',
        'priority'   => 220,
        )
    ); 
    
    //  ===============================
    //  =Social Channels Text Input 1 facebook =
    //  ===============================
    $wp_customize->add_setting('social_facebook', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
 
    ));
 
    $wp_customize->add_control('social_facebook', array(
        'type' => 'url',
        'priority' => 10,
        'label'      => __('Facebook', 'twentytwenty'),
        'section'    => 'social_channels',
    ));
    //  ===============================
    //  =Social Channels Text Input 2 youTube =
    //  ===============================
    $wp_customize->add_setting('social_youTube', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
 
    ));
 
    $wp_customize->add_control('social_youTube', array(
        'type' => 'url',
        'priority' => 10,
        'label'      => __('YouTube', 'twentytwenty'),
        'section'    => 'social_channels',
    ));
    //  ===============================
    //  =Social Channels Text Input 3 twitter =
    //  ===============================
    $wp_customize->add_setting('social_twitter', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
 
    ));
 
    $wp_customize->add_control('social_twitter', array(
        'type' => 'url',
        'priority' => 10,
        'label'      => __('Twitter', 'twentytwenty'),
        'section'    => 'social_channels',
    ));

    //  ===============================
    //  =Social Channels Text Input 4 linkedIn =
    //  ===============================
    $wp_customize->add_setting('social_linkedIn', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
 
    ));
 
    $wp_customize->add_control('social_linkedIn', array(
        'type' => 'url',
        'priority' => 10,
        'label'      => __('LinkedIn', 'twentytwenty'),
        'section'    => 'social_channels',
    ));
    
    
    //  ===============================
    //  =Social Channels Text Input 5 instagram =
    //  ===============================
    $wp_customize->add_setting('social_instagram', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
 
    ));
 
    $wp_customize->add_control('social_instagram', array(
        'type' => 'url',
        'priority' => 10,
        'label'      => __('Instagram', 'twentytwenty'),
        'section'    => 'social_channels',
    ));
    
	//  ===============================
    //  =Social Channels Text Input 6 Pinterest =
    //  ===============================
    $wp_customize->add_setting('social_pinterest', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
 
    ));
 
    $wp_customize->add_control('social_pinterest', array(
        'type' => 'url',
        'priority' => 10,
        'label'      => __('Pinterest', 'twentytwenty'),
        'section'    => 'social_channels',
    ));

     //  =============================
    //  = Header Phone No. Section   =
    //  =============================
    
    $wp_customize->add_section('call_number', array(
        'title'      => __( 'Header Contact', 'twentytwenty' ),
        'description' => '',
        'priority'   => 200,
        )
    ); 

    //  ===================================
    //  =Contact Information Text Input 2 =
    //  ===================================
    $wp_customize->add_setting('header_phone_number', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
 
    ));
 
    $wp_customize->add_control('header_phone_number', array(
        //'type' => 'number',
        'priority' => 10,
        'label'      => __('Phone Number', 'twentytwenty'),
        'section'    => 'call_number',
    ));
    
    
    //  =============================
    //  = Contact Information Section   =
    //  =============================
    
    $wp_customize->add_section('contact_information', array(
        'title'      => __( 'Footer Section', 'twentytwenty' ),
        'description' => '',
        'priority'   => 240,
        )
    ); 

    //  =============================
    //  = Footer Logo Image Upload   =
    //  =============================
    $wp_customize->add_setting('footer_logo_upload', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'type'           => 'theme_mod',
 
    ));
 
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'footer_logo_upload', array(
        'label'    => __('Organization logo', 'twentytwenty'),
        'section'  => 'contact_information',
    )));

    //  =============================
    //  = Footer Warranty Logo Image Upload   =
    //  =============================
    $wp_customize->add_setting('footer_warranty_logo_upload', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'type'           => 'theme_mod',
 
    ));
 
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'footer_warranty_logo_upload', array(
        'label'    => __('Warranty logo', 'twentytwenty'),
        'section'  => 'contact_information',
    )));

    //  =============================
    //  = Footer Payment Gateway Logo Image Upload   =
    //  =============================
    $wp_customize->add_setting('footer_pg_logo_upload', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'type'           => 'theme_mod',
 
    ));
 
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'footer_pg_logo_upload', array(
        'label'    => __('Payment Gateway logo', 'twentytwenty'),
        'section'  => 'contact_information',
    )));
    
    //  ===================================
    //  =Contact Information Text Input 1 =
    //  ===================================
    $wp_customize->add_setting('contact_address', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
 
    ));
 
    $wp_customize->add_control('contact_address', array(
        'type'     => 'textarea',
        'priority' => 10,
        'label'      => __('Address', 'twentytwenty'),
        'section'    => 'contact_information',
    ));

    
    //  ===================================
    //  =Contact Information Text Input 2 =
    //  ===================================
    $wp_customize->add_setting('phone_number', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
 
    ));
 
    $wp_customize->add_control('phone_number', array(
        //'type' => 'number',
        'priority' => 10,
        'label'      => __('Phone Number', 'twentytwenty'),
        'section'    => 'contact_information',
    ));
    
    //  ===================================
    //  =Contact Information Text Input 3 =
    //  ===================================
    $wp_customize->add_setting('email_address', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
 
    ));
 
    $wp_customize->add_control('email_address', array(
        'type' => 'email',
        'priority' => 10,
        'label'      => __('Email Address', 'twentytwenty'),
        'section'    => 'contact_information',
    ));

    

}

add_action('customize_register', 'dms_contact_details');



// Before VC Init


