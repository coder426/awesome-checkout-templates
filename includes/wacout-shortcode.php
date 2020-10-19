<?php

// create shortcode
function wacout_shortcode( $attr = array() ) {
	global $post,$checkout ;
	$cart =   WC()->cart->get_cart() ;
	$checkout = WC()->checkout;

	//get selected template post meta
	$template_layout = get_post_meta( $attr['post_id'],'_wacout_template_layout_settings',true );

	// display templale
	if( isset($template_layout) && !empty($template_layout) ){ $select_lay = absint($template_layout['template_layout_all_settings']['layout_select']); }else{ $select_lay = ''; }
	if(absint($select_lay) == 1){
		include(WACOUT_TEMP.'template-1.php');
	}elseif(absint($select_lay) == 2){
		include(WACOUT_TEMP.'template-2.php');
	}else{
		echo 'Please select the layout';
	}
}
add_shortcode( 'wacout', 'wacout_shortcode' );

?>
