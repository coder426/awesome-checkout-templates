<?php

//add new custom column in custom post type
if(!function_exists('wacout_add_new_columns')){
function wacout_add_new_columns() {
  $wacout_new_column= array(
    'cb' => '<input type="checkbox" />',
    'title' => __( 'Title' ),
    'shortcode' => __( 'Shortcode' ),
    'author' => __( 'Author' ),
    'date' => __( 'Date' )
  );
    return $wacout_new_column;
}
add_filter('manage_awesome_checkout_posts_columns', 'wacout_add_new_columns');
}


//create each custom Checkout page shortcode
if(!function_exists('wacout_add_new_shortcode_columns')){
function wacout_add_new_shortcode_columns( $column,$post_ID) {
    switch ( $column ) {
		case 'shortcode' :
			global $post;
			$slug = '' ;
			$slug = $post->ID;
	    $shortcode = '<input type="text" value="[wacout post_id='.$slug.']"';
	    echo $shortcode;
	    break;
    }
}
add_action('manage_awesome_checkout_posts_custom_column', 'wacout_add_new_shortcode_columns', 10, 2);
}

?>
