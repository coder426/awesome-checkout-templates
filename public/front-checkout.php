<?php


function wacout_get_post_meta_using_id(){

	//get the template id
	global $post;

	if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'wacout') ) {
		$regex_pattern = get_shortcode_regex();
		preg_match ('/'.$regex_pattern.'/s', $post->post_content, $regex_matches);
		if ($regex_matches[2] == 'wacout') :
		$attribureStr = str_replace (" ", "&", trim ($regex_matches[3]));
		$attribureStr = str_replace ('"', '', $attribureStr);
		$attributes = wp_parse_args ($attribureStr);
		if (isset ($attributes["post_id"])) :
		$post_id = intval($attributes["post_id"]);
		endif;
		endif;
	}else{

		if(isset($_POST['post_id']) && !empty($_POST['post_id']) ){
			$post_id = intval($_POST['post_id']); //get_the_ID();
		} else {
			$post_id = get_the_ID();
		}
	}

	return $post_id;

}

add_action( 'woocommerce_after_checkout_billing_form', 'display_extra_fields_after_billing_address' , 10, 1 );
function display_extra_fields_after_billing_address () {
	global $post;

	if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'wacout') ) {
		$regex_pattern = get_shortcode_regex();
		preg_match ('/'.$regex_pattern.'/s', $post->post_content, $regex_matches);
		if ($regex_matches[2] == 'wacout') :
		$attribureStr = str_replace (" ", "&", trim ($regex_matches[3]));
		$attribureStr = str_replace ('"', '', $attribureStr);
		$attributes = wp_parse_args ($attribureStr);
		if (isset ($attributes["post_id"])) :
		$postid = intval($attributes["post_id"]);
		endif;
		endif;
	}else{
		$postid = $post->ID;
	}

	?>
	<input type="hidden" name="post_id" class="post_id" placeholder="Delivery Date" value="<?php echo esc_attr($postid); ?>">
  <?php
}
/*
** Change section heading on checkout page
*/
function wacout_checkout_heading_change( $translated_text, $text, $domain ) {

	$post_id = wacout_get_post_meta_using_id();

	$template_layout = get_post_meta( $post_id,'_wacout_template_layout_settings',"true" ); // post meta
	if(isset($template_layout) && !empty($template_layout)){
	$temp_sec_lbl = $template_layout['template_layout_all_settings']['layout_sec_lbl'];
}
	if(isset($temp_sec_lbl['wacout_billing_heading']) && !empty($temp_sec_lbl['wacout_billing_heading'])){
		$billing = sanitize_text_field($temp_sec_lbl['wacout_billing_heading']);
	} else{ $billing = "Billing Details"; }

	if(isset($temp_sec_lbl['wacout_shipping_heading']) && !empty($temp_sec_lbl['wacout_shipping_heading'])){
		$shipping = sanitize_text_field($temp_sec_lbl['wacout_shipping_heading']);
	} else{ $shipping = "Ship To A different address?"; }

	if(isset($temp_sec_lbl['wacout_order_heading']) && !empty($temp_sec_lbl['wacout_order_heading'])){
		$order = sanitize_text_field($temp_sec_lbl['wacout_order_heading']);
	} else{ $order = "Order Details"; }

	if(isset($temp_sec_lbl['wacout_related_heading']) && !empty($temp_sec_lbl['wacout_related_heading'])){
		$related = sanitize_text_field($temp_sec_lbl['wacout_related_heading']);
	} else{ $related = "Related Products"; }

	if(isset($temp_sec_lbl['wacout_payment_heading']) && !empty($temp_sec_lbl['wacout_payment_heading'])){
		$payment = sanitize_text_field($temp_sec_lbl['wacout_payment_heading']);
	} else{ $payment = "Payment Information"; }

	if( $translated_text == 'Billing details' ){ $translated_text = __( esc_html($billing), 'woocommerce' ); }
	if( $translated_text == 'Ship to a different address?' ){ $translated_text = __( esc_html($shipping), 'woocommerce' ); }
	if( $translated_text == 'Order details' ){ $translated_text = __( esc_html($order), 'woocommerce' ); }
	if( $translated_text == 'Related products' ){ $translated_text = __( esc_html($related), 'woocommerce' ); }
	if( $translated_text == 'Payment information' ){ $translated_text = __( esc_html($payment), 'woocommerce' ); }

	return $translated_text;
}
if(!is_admin()){
	add_filter( 'gettext', 'wacout_checkout_heading_change', 20, 3 );
}


/**
** WooCommerce Checkout Fields Label change, add custom class and fields required or not
*/


add_filter( 'woocommerce_checkout_fields' , 'wacout_wc_checkout_fields', 9999 );

function wacout_wc_checkout_fields( $fields ) {

	$post_id = wacout_get_post_meta_using_id();

	$wacout_flds_lbls = get_post_meta( $post_id,'_wacout_template_layout_settings',"true" );
	if(isset($wacout_flds_lbls) && !empty($wacout_flds_lbls)){
	$wacout_front_flds_lbls = $wacout_flds_lbls['template_layout_all_settings']['layout_fields_lbl'];
		}
	// Fields Custom name
	if(isset($wacout_front_flds_lbls['billing_first_name']) && !empty($wacout_front_flds_lbls['billing_first_name'])){ $wacout_billing_first_name = sanitize_text_field($wacout_front_flds_lbls['billing_first_name']); } else{ $wacout_billing_first_name = "First name"; }

	if(isset($wacout_front_flds_lbls['billing_last_name']) && !empty($wacout_front_flds_lbls['billing_last_name'])){ $wacout_billing_last_name = sanitize_text_field($wacout_front_flds_lbls['billing_last_name']); } else{ $wacout_billing_last_name = "Last name"; }

	if(isset($wacout_front_flds_lbls['billing_company']) && !empty($wacout_front_flds_lbls['billing_company'])){ $wacout_billing_company = sanitize_text_field($wacout_front_flds_lbls['billing_company']); } else{ $wacout_billing_company = "Company name"; }

	if(isset($wacout_front_flds_lbls['billing_country']) && !empty($wacout_front_flds_lbls['billing_country'])){ $wacout_billing_country = sanitize_text_field($wacout_front_flds_lbls['billing_country']); } else{ $wacout_billing_country = "Country / Region"; }

	if(isset($wacout_front_flds_lbls['billing_phone']) && !empty($wacout_front_flds_lbls['billing_phone'])){ $wacout_billing_phone = sanitize_text_field($wacout_front_flds_lbls['billing_phone']); } else{ $wacout_billing_phone = "Phone"; }

	if(isset($wacout_front_flds_lbls['billing_email']) && !empty($wacout_front_flds_lbls['billing_email'])){ $wacout_billing_email = sanitize_text_field($wacout_front_flds_lbls['billing_email']); } else{ $wacout_billing_email = "Email address"; }

	if(isset($wacout_front_flds_lbls['shipping_first_name']) && !empty($wacout_front_flds_lbls['shipping_first_name'])){ $wacout_shipping_first_name = sanitize_text_field($wacout_front_flds_lbls['shipping_first_name']); } else{ $wacout_shipping_first_name = "First name"; }

	if(isset($wacout_front_flds_lbls['shipping_last_name']) && !empty($wacout_front_flds_lbls['shipping_last_name'])){ $wacout_shipping_last_name = sanitize_text_field($wacout_front_flds_lbls['shipping_last_name']); } else{ $wacout_shipping_last_name = "Last name"; }

	if(isset($wacout_front_flds_lbls['shipping_company']) && !empty($wacout_front_flds_lbls['shipping_company'])){ $wacout_shipping_company = sanitize_text_field($wacout_front_flds_lbls['shipping_company']); } else{ $wacout_shipping_company = "Company name"; }

	if(isset($wacout_front_flds_lbls['shipping_country']) && !empty($wacout_front_flds_lbls['shipping_country'])){ $wacout_shipping_country = sanitize_text_field($wacout_front_flds_lbls['shipping_country']); } else{ $wacout_shipping_country = "Country / Region"; }


	// Fields Custom class
	if(isset($wacout_front_flds_lbls['fields_class']['billing_first_name_class']) && !empty($wacout_front_flds_lbls['fields_class']['billing_first_name_class'])){ $wacout_billing_first_name_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['billing_first_name_class']); } else{ $wacout_billing_first_name_class = ""; }

	if(isset($wacout_front_flds_lbls['fields_class']['billing_last_name_class']) && !empty($wacout_front_flds_lbls['fields_class']['billing_last_name_class'])){ $wacout_billing_last_name_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['billing_last_name_class']); } else{ $wacout_billing_last_name_class = ""; }

	if(isset($wacout_front_flds_lbls['fields_class']['billing_company_class']) && !empty($wacout_front_flds_lbls['fields_class']['billing_company_class'])){ $wacout_billing_company_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['billing_company_class']); } else{ $wacout_billing_company_class = ""; }

	if(isset($wacout_front_flds_lbls['fields_class']['billing_country_class']) && !empty($wacout_front_flds_lbls['fields_class']['billing_country_class'])){ $wacout_billing_country_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['billing_country_class']); } else{ $wacout_billing_country_class = ""; }

	if(isset($wacout_front_flds_lbls['fields_class']['billing_phone_class']) && !empty($wacout_front_flds_lbls['fields_class']['billing_phone_class'])){ $wacout_billing_phone_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['billing_phone_class']); } else{ $wacout_billing_phone_class = ""; }

	if(isset($wacout_front_flds_lbls['fields_class']['billing_email_class']) && !empty($wacout_front_flds_lbls['fields_class']['billing_email_class'])){ $wacout_billing_email_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['billing_email_class']); } else{ $wacout_billing_email_class = ""; }

	if(isset($wacout_front_flds_lbls['fields_class']['shipping_first_name_class']) && !empty($wacout_front_flds_lbls['fields_class']['shipping_first_name_class'])){ $wacout_shipping_first_name_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['shipping_first_name_class']); } else{ $wacout_shipping_first_name_class = ""; }

	if(isset($wacout_front_flds_lbls['fields_class']['shipping_last_name_class']) && !empty($wacout_front_flds_lbls['fields_class']['shipping_last_name_class'])){ $wacout_shipping_last_name_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['shipping_last_name_class']); } else{ $wacout_shipping_last_name_class = ""; }

	if(isset($wacout_front_flds_lbls['fields_class']['shipping_company_class']) && !empty($wacout_front_flds_lbls['fields_class']['shipping_company_class'])){ $wacout_shipping_company_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['shipping_company_class']); } else{ $wacout_shipping_company_class = ""; }

	if(isset($wacout_front_flds_lbls['fields_class']['shipping_country_class']) && !empty($wacout_front_flds_lbls['fields_class']['shipping_country_class'])){ $wacout_shipping_country_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['shipping_country_class']); } else{ $wacout_shipping_country_class = ""; }


	// Billing Field
	$fields['billing']['billing_first_name']['label'] = esc_html($wacout_billing_first_name) ;
	$fields['billing']['billing_last_name']['label'] = esc_html($wacout_billing_last_name) ;
	$fields['billing']['billing_company']['label'] = esc_html($wacout_billing_company) ;
	$fields['billing']['billing_country']['label'] = esc_html($wacout_billing_country) ;
	$fields['billing']['billing_email']['label'] = esc_html($wacout_billing_email) ;
	$fields['billing']['billing_phone']['label'] = esc_html($wacout_billing_phone) ;
	// Shipping Field
	$fields['shipping']['shipping_first_name']['label'] = esc_html($wacout_shipping_first_name) ;
	$fields['shipping']['shipping_last_name']['label'] = esc_html($wacout_shipping_last_name) ;
	$fields['shipping']['shipping_company']['label'] = esc_html($wacout_shipping_company) ;
	$fields['shipping']['shipping_country']['label'] = esc_html($wacout_shipping_country) ;

	// Billing Field custom class add
	$fields['billing']['billing_first_name']['class'][0] = esc_html($wacout_billing_first_name_class) ;
	$fields['billing']['billing_last_name']['class'][0] = esc_html($wacout_billing_last_name_class) ;
	$fields['billing']['billing_company']['class'][0] = esc_html($wacout_billing_company_class) ;
	$fields['billing']['billing_country']['class'][0] = esc_html($wacout_billing_country_class) ;
	$fields['billing']['billing_email']['class'][0] = esc_html($wacout_billing_email_class) ;
	$fields['billing']['billing_phone']['class'][0] = esc_html($wacout_billing_phone_class) ;

	// Shipping Field custom class add
	$fields['shipping']['shipping_first_name']['class'][0] = esc_html($wacout_shipping_first_name_class) ;
	$fields['shipping']['shipping_last_name']['class'][0] = esc_html($wacout_shipping_last_name_class) ;
	$fields['shipping']['shipping_company']['class'][0] = esc_html($wacout_shipping_company_class) ;
	$fields['shipping']['shipping_country']['class'][0] = esc_html($wacout_shipping_country_class) ;


	//die;
	//Required fields
	$req_fields = get_post_meta( $post_id,'_wacout_fields_req',true );

	if(isset($req_fields['billing_first_name_req']) && !empty($req_fields['billing_first_name_req'])){ $billing_first_name_req =  absint($req_fields['billing_first_name_req']); }else{ $billing_first_name_req = null; }

	if(isset($req_fields['billing_last_name_req']) && !empty($req_fields['billing_last_name_req'])){ $billing_last_name_req =  absint($req_fields['billing_last_name_req']); }else{ $billing_last_name_req = null; }

	if(isset($req_fields['billing_company_req']) && !empty($req_fields['billing_company_req'])){ $billing_company_req =  absint($req_fields['billing_company_req']); }else{ $billing_company_req = null; }

	if(isset($req_fields['billing_country_req']) && !empty($req_fields['billing_country_req'])){ $billing_country_req =  absint($req_fields['billing_country_req']); }else{ $billing_country_req = null; }

	if(isset($req_fields['billing_phone_req']) && !empty($req_fields['billing_phone_req'])){ $billing_phone_req =  absint($req_fields['billing_phone_req']); }else{ $billing_phone_req = null; }

	if(isset($req_fields['billing_email_req']) && !empty($req_fields['billing_email_req'])){ $billing_email_req =  absint($req_fields['billing_email_req']); }else{ $billing_email_req = null; }

	if(isset($req_fields['shipping_first_name_req']) && !empty($req_fields['shipping_first_name_req'])){ $shipping_first_name_req =  absint($req_fields['shipping_first_name_req']); }else{ $shipping_first_name_req = null; }

	if(isset($req_fields['shipping_last_name_req']) && !empty($req_fields['shipping_last_name_req'])){ $shipping_last_name_req =  absint($req_fields['shipping_last_name_req']); }else{ $shipping_last_name_req = null; }

	if(isset($req_fields['shipping_company_req']) && !empty($req_fields['shipping_company_req'])){ $shipping_company_req =  absint($req_fields['shipping_company_req']); }else{ $shipping_company_req = null; }

	if(isset($req_fields['shipping_country_req']) && !empty($req_fields['shipping_country_req'])){ $shipping_country_req =  absint($req_fields['shipping_country_req']); }else{ $shipping_country_req = null; }

	if( $billing_first_name_req == '' ) {  unset($fields['billing']['billing_first_name']['required']); }
	if( $billing_last_name_req == '' ) {  unset($fields['billing']['billing_last_name']['required']); }
	if( $billing_company_req == '1' ) {  $fields['billing']['billing_company']['required'] = true; }
	if( $billing_country_req == '' ) {  unset($fields['billing']['billing_country']['required']); }
	if( $billing_email_req == '' ) {  unset($fields['billing']['billing_email']['required']); }
	if( $billing_phone_req == '' ) {  unset($fields['billing']['billing_phone']['required']); }
	if( $shipping_first_name_req == '' ) {  unset($fields['shipping']['shipping_first_name']['required']); }
	if( $shipping_last_name_req == '' ) {  unset($fields['shipping']['shipping_last_name']['required']); }
	if( $shipping_company_req == '1' ) {  $fields['shipping']['shipping_company']['required']  = true; }
	if( $shipping_country_req == '' ) {  unset($fields['shipping']['shipping_country']['required']); }

	return $fields;
}


add_filter( 'woocommerce_default_address_fields' , 'wacout_rename_state_province', 9999 );
function wacout_rename_state_province( $fields ) {

	$post_id = wacout_get_post_meta_using_id();

	$wacout_flds_lbls = get_post_meta( $post_id,'_wacout_template_layout_settings',"true" );
	if(isset($wacout_flds_lbls) && !empty($wacout_flds_lbls)){
	$wacout_front_flds_lbls = $wacout_flds_lbls['template_layout_all_settings']['layout_fields_lbl'];
}
	if(isset($wacout_front_flds_lbls['address_1']) && !empty($wacout_front_flds_lbls['address_1'])){ $wacout_address_1 = sanitize_text_field($wacout_front_flds_lbls['address_1']); } else{ $wacout_address_1 = "Street address"; }

	if(isset($wacout_front_flds_lbls['city']) && !empty($wacout_front_flds_lbls['city'])){ $wacout_city = sanitize_text_field($wacout_front_flds_lbls['city']); } else{ $wacout_city = "Town / City"; }

	if(isset($wacout_front_flds_lbls['fields_class']['address_1_class']) && !empty($wacout_front_flds_lbls['fields_class']['address_1_class'])){ $wacout_address_1_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['address_1_class']); } else{ $wacout_address_1_class = ""; }

	if(isset($wacout_front_flds_lbls['fields_class']['city_class']) && !empty($wacout_front_flds_lbls['fields_class']['city_class'])){ $wacout_city_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['city_class']); } else{ $wacout_city_class = ""; }


	$fields['address_1']['label'] = esc_html($wacout_address_1) ;
	$fields['city']['label'] = esc_html($wacout_city) ;

	$fields['address_1']['class'][0] = esc_html($wacout_address_1_class) ;
	$fields['city']['class'][0] = esc_html($wacout_city_class) ;


	//Required fields
	$req_fields = get_post_meta( $post_id,'_wacout_fields_req',true );

	if(isset($req_fields['address_1_req']) && !empty($req_fields['address_1_req'])){ $address_1_req =  absint($req_fields['address_1_req']); }else{ $address_1_req = null; }

	if(isset($req_fields['city_req']) && !empty($req_fields['city_req'])){ $city_req =  absint($req_fields['city_req']); }else{ $city_req = null; }

	if( $address_1_req == '' ) {  unset($fields['address_1']['required']); }
	if( $city_req == '' ) {  unset($fields['city']['required']); }


	return $fields;
}

add_filter('woocommerce_get_country_locale', 'wacout_wc_change_state_label_locale',10,1);
function wacout_wc_change_state_label_locale($locale){

	$post_id = wacout_get_post_meta_using_id();

	$wacout_flds_lbls = get_post_meta( $post_id,'_wacout_template_layout_settings',"true" );
	if(isset($wacout_flds_lbls) && !empty($wacout_flds_lbls)){
	$wacout_front_flds_lbls = $wacout_flds_lbls['template_layout_all_settings']['layout_fields_lbl'];
}
	if(isset($wacout_front_flds_lbls['state']) && !empty($wacout_front_flds_lbls['state'])){ $wacout_state = sanitize_text_field($wacout_front_flds_lbls['state']); } else{ $wacout_state = "State"; }

	if(isset($wacout_front_flds_lbls['postcode']) && !empty($wacout_front_flds_lbls['postcode'])){ $wacout_postcode = sanitize_text_field($wacout_front_flds_lbls['postcode']); } else{ $wacout_postcode = "ZIP"; }

	if(isset($wacout_front_flds_lbls['fields_class']['state_class']) && !empty($wacout_front_flds_lbls['fields_class']['state_class'])){ $wacout_state_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['state_class']); } else{ $wacout_state_class = ""; }

	if(isset($wacout_front_flds_lbls['fields_class']['postcode_class']) && !empty($wacout_front_flds_lbls['fields_class']['postcode_class'])){ $wacout_postcode_class = sanitize_html_class($wacout_front_flds_lbls['fields_class']['postcode_class']); } else{ $wacout_postcode_class = ""; }


	// Required Fields
	$req_fields = get_post_meta( $post_id,'_wacout_fields_req',true );

	if(isset($req_fields['state_req']) && !empty($req_fields['state_req'])){ $state_req =  absint($req_fields['state_req']); }else{ $state_req = null; }

	if(isset($req_fields['postcode_req']) && !empty($req_fields['postcode_req'])){ $postcode_req =  absint($req_fields['postcode_req']); }else{ $postcode_req = null; }


	global $woocommerce;
	$cntrys = $woocommerce->countries->countries;

	foreach($cntrys as $key => $value){
		$locale[$key]['state']['label'] = esc_html($wacout_state) ;
		$locale[$key]['postcode']['label'] = esc_html($wacout_postcode) ;

		$locale[$key]['state']['class'][0] = esc_html($wacout_state_class) ;
		$locale[$key]['postcode']['class'][0] = esc_html($wacout_postcode_class) ;

		$locale[$key]['state']['required'] = esc_html($state_req);
		$locale[$key]['postcode']['required'] = esc_html($postcode_req);
	}

	return $locale;
}


/**
** WooCommerce Checkout Place order Button text change
*/
add_action('wp_ajax_wacout_button_style','wacout_button_style');
add_action('wp_ajax_nopriv_wacout_button_style','wacout_button_style');
function wacout_button_style(){


	if( isset($_POST['post_id']) && !empty($_POST['post_id']) ){ $post_id = absint($_POST['post_id']); }
	if( isset($_POST['btn_txt']) && !empty($_POST['btn_txt']) ){ $btntxt = sanitize_text_field($_POST['btn_txt']); }

	$wacout_btn_txt = get_post_meta( $post_id,'_wacout_template_layout_settings',"true" );
	$wacout_front_btn_txt = $wacout_btn_txt['template_layout_all_settings']['layout_Button_text'];
	if(isset($_POST['security_nonce']) && wp_verify_nonce( $_POST['security_nonce'], 'ajax_public_nonce' )){
		if(isset($wacout_front_btn_txt['place_order_button']) && !empty($wacout_front_btn_txt['place_order_button'])){
			$response['wacout_place_order_button'] = esc_html($wacout_front_btn_txt['place_order_button']);
			$response['data_resp'] = "success";
		} else{
			$response['wacout_place_order_button'] = esc_html($btntxt);
			$response['data_resp'] = "failed";
		}
	}
	echo json_encode($response);
	wp_reset_postdata();
	clearstatcache();
	die;
}


// rename the coupon field on the Checkout page
function wacout_rename_coupon_field_on_checkout( $translated_text, $text, $text_domain ) {

	$post_id = wacout_get_post_meta_using_id();
	$wacout_btn_txt = get_post_meta( $post_id,'_wacout_template_layout_settings',"true" );
	if(isset($wacout_btn_txt) && !empty($wacout_btn_txt)){
		$wacout_front_btn_txt = $wacout_btn_txt['template_layout_all_settings']['layout_Button_text'];
	}


	if(isset($wacout_front_btn_txt['apply_coupan_button']) && !empty($wacout_front_btn_txt['apply_coupan_button'])){ $wacout_apply_coupon_button = sanitize_text_field($wacout_front_btn_txt['apply_coupan_button']); } else{ $wacout_apply_coupon_button = "Apply coupon"; }

	if ( 'Apply coupon' === $text ) {
		$translated_text = esc_html($wacout_apply_coupon_button);
	}

	return $translated_text;
}
if(!is_admin()){
	add_filter( 'gettext', 'wacout_rename_coupon_field_on_checkout', 10, 3 );
}

// Custom sections on checkout page

function wacout_custom_section1(){

	$post_id = wacout_get_post_meta_using_id();

	$wacout_custom_sections = get_post_meta( $post_id,'_wacout_template_layout_settings',"true" ); // post meta
	$wacout_custom_sec = $wacout_custom_sections['template_layout_all_settings']['layout_custom_sections'];

	if(isset($wacout_custom_sec['wacout_cstm_sec1']) && !empty($wacout_custom_sec['wacout_cstm_sec1'])){
		$wacout_cstm_sec1_ttl = sanitize_text_field($wacout_custom_sec['wacout_cstm_sec1']);
	} else{ $wacout_cstm_sec1_ttl = ""; }

	if(isset($wacout_custom_sec['wacout_csec_wp_editor1']) && !empty($wacout_custom_sec['wacout_csec_wp_editor1'])){
		$wacout_cstm_sec1_edtr = wp_kses_post($wacout_custom_sec['wacout_csec_wp_editor1']);
	} else{ $wacout_cstm_sec1_edtr = ""; }

	if( !empty($wacout_cstm_sec1_ttl) && !empty($wacout_cstm_sec1_edtr) ){
		$html = '';
		$html .= '<div class="wacout_cs1">';
		$html .= '<h3>'.esc_html($wacout_cstm_sec1_ttl).'</h3>';
		$html .= '<div class="wacout_cs1_body p_30">'.wp_kses_post($wacout_cstm_sec1_edtr).'</div>';
		$html .= '</div>';
		echo $html;
	}


}

function wacout_custom_section2(){

	$post_id = wacout_get_post_meta_using_id();

	$wacout_custom_sections = get_post_meta( $post_id,'_wacout_template_layout_settings',"true" ); // post meta
	$wacout_custom_sec = $wacout_custom_sections['template_layout_all_settings']['layout_custom_sections'];

	if(isset($wacout_custom_sec['wacout_cstm_sec2']) && !empty($wacout_custom_sec['wacout_cstm_sec2'])){
		$wacout_cstm_sec2_ttl = sanitize_text_field($wacout_custom_sec['wacout_cstm_sec2']);
	} else{ $wacout_cstm_sec2_ttl = ""; }

	if(isset($wacout_custom_sec['wacout_csec_wp_editor2']) && !empty($wacout_custom_sec['wacout_csec_wp_editor2'])){
		$wacout_cstm_sec2_edtr = wp_kses_post($wacout_custom_sec['wacout_csec_wp_editor2']);
	} else{ $wacout_cstm_sec2_edtr = ""; }

	if( !empty($wacout_cstm_sec2_ttl) && !empty($wacout_cstm_sec2_edtr) ){
		$html = '';
		$html .= '<div class="wacout_cs2">';
		$html .= '<h3>'.esc_html($wacout_cstm_sec2_ttl).'</h3>';
		$html .= '<div class="wacout_cs2_body p_30">'.wp_kses_post($wacout_cstm_sec2_edtr).'</div>';
		$html .= '</div>';
		echo $html;
	}

}

function wacout_custom_section3(){

	$post_id = wacout_get_post_meta_using_id();

	$wacout_custom_sections = get_post_meta( $post_id,'_wacout_template_layout_settings',"true" ); // post meta
	$wacout_custom_sec = $wacout_custom_sections['template_layout_all_settings']['layout_custom_sections'];

	if(isset($wacout_custom_sec['wacout_cstm_sec3']) && !empty($wacout_custom_sec['wacout_cstm_sec3'])){
		$wacout_cstm_sec3_ttl = sanitize_text_field($wacout_custom_sec['wacout_cstm_sec3']);
	} else{ $wacout_cstm_sec3_ttl = ""; }

	if(isset($wacout_custom_sec['wacout_csec_wp_editor3']) && !empty($wacout_custom_sec['wacout_csec_wp_editor3'])){
		$wacout_cstm_sec3_edtr = wp_kses_post($wacout_custom_sec['wacout_csec_wp_editor3']);
	} else{ $wacout_cstm_sec3_edtr = ""; }

	if( !empty($wacout_cstm_sec3_ttl) && !empty($wacout_cstm_sec3_edtr) ){
		$html = '';
		$html .= '<div class="wacout_cs3">';
		$html .= '<h3>'.esc_html($wacout_cstm_sec3_ttl).'</h3>';
		$html .= '<div class="wacout_cs3_body p_30">'.wp_kses_post($wacout_cstm_sec3_edtr).'</div>';
		$html .= '</div>';
		echo $html;
	}

}

/**
* Remove optional text checkout for
*/
add_filter( 'woocommerce_form_field' , 'wacout_remove_checkout_optional_text', 10, 4 );
function wacout_remove_checkout_optional_text( $field, $key, $args, $value ) {
	if( is_checkout() && ! is_wc_endpoint_url() ) {
		$optional = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
		$field = str_replace( $optional, '', $field );
	}
	return $field;
}



// Change Woo Commerce New Order Email for Admin to Display Customer Name
add_filter('woocommerce_email_subject_new_order', 'wacout_change_admin_email_subject', 1, 2);

function wacout_change_admin_email_subject( $subject, $order ) {
	global $woocommerce;

	$subject = sprintf( 'New Order (#%s) from %s %s', $order->id, $order->billing_first_name, $order->billing_last_name );

	return $subject;
}

?>
