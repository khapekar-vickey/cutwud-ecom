<?php
//--------------------------------Term Metabox-------------------------------------------
//https://www.smashingmagazine.com/2015/12/how-to-use-term-meta-data-in-wordpress/

function fscf_display_userTermbox($termid)
{
  $fscfauthor = get_term_meta( $termid, 'fscf_author', true );
  $ucargs = array(
	'show_option_all'         => false,
	'show_option_none'        => 'Select Partner',
	//'hide_if_only_one_author' => '',
	'orderby'                 => 'display_name',
    'order'                   => 'ASC',
    'multi'                   => false,
    'show'                    => 'display_name',
    'echo'                    => true,
    'selected'                => $fscfauthor,
    'include_selected'        => false,
    'option_none_value'       => -1,
    'name'                    => 'fscf_author', // string
    'id'                      => null, // integer
    'class'                   => null, // string 
    'blog_id'                 => $GLOBALS['blog_id'],
    'who'                     => null, // string,
    'role'                    => 'ourpartner', // string|array,
);
   echo '<p><lable>Select Partner</lable></p>';
 wp_dropdown_users( $ucargs );
}


//ADDING META DATA WITH A NEW TERM
add_action( 'product_cat_add_form_fields', 'add_fscf_author_field', 10, 2 );
function add_fscf_author_field($taxonomy) {
    global $fscf_authors;
    $termid="";
    ?><div class="form-field term-group">
        <?php
       fscf_display_userTermbox($termid);
        ?>
    </div><?php
}

add_action( 'created_product_cat', 'save_feature_meta', 10, 2 );

function save_feature_meta( $term_id, $tt_id ){
    if( isset( $_POST['fscf_author'] ) && ’ !== $_POST['fscf_author'] ){
        $group = sanitize_title( $_POST['fscf_author'] );
        add_term_meta( $term_id, 'fscf_author', $group, true );
    }
}

//Updating A Term With Meta Data

add_action( 'product_cat_edit_form_fields', 'edit_fscf_author_field', 10, 2 );

function edit_fscf_author_field( $term, $taxonomy ){
    // get current group
    //$fscf_author = get_term_meta( $term->term_id, 'fscf_author', true );
    
    ?><tr class="form-field term-group-wrap">
        <th scope="row"><label for="feature-group"><?php _e( 'Partner Group', 'my_plugin' ); ?></label></th>
        <td><?php fscf_display_userTermbox($term->term_id);?></td>
    </tr><?php
}

add_action( 'edited_product_cat', 'update_feature_meta', 10, 2 );

function update_feature_meta( $term_id, $tt_id ){

    if( isset( $_POST['fscf_author'] ) && ’ !== $_POST['fscf_author'] ){
        $group = sanitize_title( $_POST['fscf_author'] );
        update_term_meta( $term_id, 'fscf_author', $group );
    }
}

//Displaying The Term Meta Data In The Term List
add_filter('manage_edit-product_cat_columns', 'add_fscf_author_column' );

function add_fscf_author_column( $columns ){
    $columns['fscf_author'] = __( 'Partner', 'my_plugin' );
    return $columns;
}

add_filter('manage_product_cat_custom_column', 'add_fscf_author_column_content', 10, 3 );

function add_fscf_author_column_content( $content, $column_name, $term_id ){
    global $fscf_authors;

    if( $column_name !== 'fscf_author' ){
        return $content;
    }

    $term_id = absint( $term_id );
    $fscf_author = get_term_meta( $term_id, 'fscf_author', true );
    $user = get_user_by( 'id', $fscf_author );
    $userId = $user->ID;
    $name  = $user->first_name . ' ' . $user->last_name;

    if( !empty( $fscf_author ) ){
        $content .= esc_attr( $name );
    }

    return $content;
}

add_filter( 'manage_edit-product_cat_sortable_columns', 'add_fscf_author_column_sortable' );

function add_fscf_author_column_sortable( $sortable ){
    $sortable[ 'fscf_author' ] = 'fscf_author';
    return $sortable;
}
//--------------------------------Term Metabox end-------------------------------------------