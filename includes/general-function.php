<?php

/*
** Create custom post type
** @since  1.1.1.1
** Awesome checkout template
*/
add_action( 'init','wacout_post_type');
function wacout_post_type() {

	// Set UI labels for Custom Post Type
	$supports   = array( 'title' );
	$slug = 'awesome-checkout' ;
	$rewrite = array( 'slug' => $slug, 'with_front' => false, 'pages' => false, ) ;
	$labels = array(
		'name'                => __( 'Awesome Checkout Templates','wacout'),
		'singular_name'       => __( 'Awesome Checkout Template','wacout' ),
		'menu_name'           => __( 'Awesome Checkout Templates','wacout' ),
		'parent_item_colon'   => __( 'Parent Awesome Checkout Templates','wacout'),
		'all_items'           => __( 'All Templates','wacout'),
		'view_item'           => __( 'View  Template','wacout'),
		'add_new_item'        => __( 'Create Checkout Template','wacout'),
		'add_new'             => __( 'Create New Template','wacout'),
		'edit_item'           => __( 'Edit Template','wacout'),
		'update_item'         => __( 'Update Template','wacout'),
		'search_items'        => __( 'Search Template','wacout'),
		'not_found'           => __( 'Not Found','wacout'),
		'not_found_in_trash'  => __( 'Not found in Trash','wacout'),
		'parent_item_colon'   => '',
	);
	// Set other options for Custom Post Type
	$args = array(
		'labels'              => $labels,
		'description'         => __( 'Awesome checkout template for WooCommerce' , 'wacout' ),
		'public'              => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 50,
		'menu_icon'           => 'dashicons-cart',
		'hierarchical'        => false,
		'supports'            => $supports,
		'rewrite'	          => $rewrite,
		'show_in_rest' 		  => true
	);
	register_post_type( 'awesome_checkout', $args );
	flush_rewrite_rules();

}
add_action('admin_menu','wacout_add_menu_page');

/**
* Add settings menu pge
*
* @since    1.0.0
*/
function wacout_add_menu_page(){
	add_submenu_page( 'edit.php?post_type=awesome_checkout',  __( 'Awesome Checkout Settings', 'wacout' ) , __( 'Settings', 'wacout' ), 'manage_options', 'awesome-checkout-settings', 'wacout_settings_menu');
}

/**
* call the admin settings display
*
* @since    1.0.0
*/
function wacout_settings_menu(){
	$page = esc_html($_GET['page']);
	$tab = (isset($_GET['tab'])) ? esc_html($_GET['tab']) : '';
	if (empty($tab)) {
		$tab = 'wacout_general';
	}
	$menus = array();
	$menus['wacout_general'] = __('General', 'wacout');
	$menus['wacout_support'] = __('Support', 'wacout');
	$menus = apply_filters('wacout_extand_menus', $menus);

?>

<div class="container-fluid pt-3" id="wacout_stng">
	<div class="row">
		<div class="col-md-12">
			<div class='wrap'>
				<div id="wacout_stng_wrap">
					<div id="wacout_stng_body">
						<div class="wacout_stng_sidebar">
							<ul class="nav wacout_stng_nav">
								<?php
								foreach ($menus as $key => $menu) {
									$tab_url = add_query_arg(array(
										'page' => $page,
										'tab' => $key,
									), admin_url('admin.php'));
								?>
								<li>
									<a class="<?php if ($tab == $key) echo 'active'; ?>" href="<?php echo esc_url($tab_url); ?>"><?php echo esc_html($menu); ?></a>
								</li>
								<?php
								}
								?>
							</ul>
						</div><!-- close sidemenu-->
						<?php
						if($tab == 'wacout_support'){
							include(WACOUT_INC.'wacout_setting_support.php');
						}elseif($tab == 'wacout_general'){?>
						<div class="wacout_stng_cntnt"><!-- start general setting-->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="wacout_general_tab">
									<div class="tabpane_inner">
										<h1 class="qck_lnk wacout_stng_hd"><?php echo esc_html__(__('Woocommerce checkout template Settings', 'wacout')) ?><span class="tgl-indctr" aria-hidden="true"></span></h1>
										<form method="post" action="options.php">
											<?php
											  settings_fields( 'wacout_setting' );
											  do_settings_sections( 'wacout_setting' );
											  submit_button(__('Save Changes', 'wacout'));
											?>
										</form>
									</div>
								</div>
							</div>
						</div><!-- close general setting-->
						<?php }else{
							do_action('wacout_extand_menus_side_settings');
						}?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}


/**
 * Register Setting and Create field and section in cart setting page
 */
function wacout_admin_plugin_settings() {

	register_setting( 'wacout_setting', 'wacout_template_enable');
	register_setting( 'wacout_setting', 'wacout_select_template');
	add_settings_section( 'wacout_label_settings', '', 'wacout_setting_labal_sec', 'wacout_setting' );
	add_settings_field( 'wacout_enable_fld', __('Enable checkout templates', 'wacout'), 'wacout_enable_setting', 'wacout_setting', 'wacout_label_settings' );
	add_settings_field( 'wacout_template', __('Select default checkout template', 'wacout'), 'wacout_template_selection', 'wacout_setting', 'wacout_label_settings' );


}
add_action( 'admin_init', 'wacout_admin_plugin_settings' );

/**
*Create callback function to section and field html
*/
function wacout_setting_labal_sec(){
	echo '<h2 class="wacout_hdng_stng">'. __('Checkout page template setup', 'wacout') .'</h2>';
}

/**
*enable settings field
*/
function wacout_enable_setting(){
	$enable = get_option('wacout_template_enable');?>
<label class="switch">
	<input type="checkbox" class="class1" name="wacout_template_enable" <?php if(esc_html($enable) == 'enable') echo "checked";  ?> value="enable"/>
	<span class="slider round"></span>
</label>
<?php }

/**
* Template selection
*/
function wacout_template_selection(){

	$settings = get_option( 'wacout_select_template');

	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'awesome_checkout',
		'post_status' => 'publish',
		'orderby' => 'ID',
		'order' => 'ASC',
	);

	$available_pages = get_posts($args);

	$html = '<option value = "-1">'.__( '--Select Page--' , 'wacout' ).'</option>' ;
	foreach ($available_pages as $page ) {
		if($page->ID == $settings){
			$selected_page = 'selected';
		}else{
			$selected_page = '';
		}
		$html .= '<option value = "'.absint($page->ID).'" '.esc_attr($selected_page).'>'.esc_html($page->post_title).'</option>' ;
	} ?>
<select name="wacout_select_template" class="wacout_settings_all_checkout">
	<?php echo $html ; ?>
</select><?php
}

/**
* add settings link to plugin action links
*/
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'wacout_plugin_settings_link');
function wacout_plugin_settings_link( $links ) {

	$plugin_links= array('<a href="' . admin_url( 'edit.php?post_type=awesome_checkout&page=awesome-checkout-settings' ) .'">' . __("Settings","wacout") .'</a>');
	return array_merge($plugin_links,$links);
}


/*function wacout_so_screen_layout_awesome_checkout() {
	return 1;
}
add_filter( 'get_user_option_screen_layout_awesome_checkout', 'wacout_so_screen_layout_awesome_checkout' );*/


/*
** redirect user checkout page
** @since  1.1.1.1
*/
add_action( 'template_redirect', 'wacout_template_redirect') ;
function wacout_template_redirect(){
	global $woocommerce;
	//get selected template post meta
	$post_id = wacout_get_post_meta_using_id();
	$template_layout = get_post_meta( $post_id,'_wacout_template_layout_settings',true ); // post meta
	if(isset($template_layout) && !empty($template_layout)){
	$temp_layout_bdpc = $template_layout['template_layout_all_settings']['layout_more_prd'];
		}
	$enable = get_option('wacout_template_enable');
	if( is_checkout() && !is_wc_endpoint_url( 'order-received' ) && $enable == 'enable'){
		if(!wacout_is_template_page()){
			$settings = get_option( 'wacout_select_template');
			if(isset($settings) && !empty($settings) && $settings != -1){
				$redirect_checkout = get_permalink( $settings );
				wp_redirect( $redirect_checkout );
				die();
			}
		}else{

			if(isset($temp_layout_bdpc['wacout_bdpc_id']) && !empty( $temp_layout_bdpc['wacout_bdpc_id'] )){
				$wacout_bdpc_id = absint($temp_layout_bdpc['wacout_bdpc_id']);
			} else{ $wacout_bdpc_id = ""; }


			// if cart empty, add it to cart
			if ( WC()->cart->get_cart_contents_count() == 0) {
				WC()->cart->add_to_cart( absint($wacout_bdpc_id) );

			}
		}
	}
	elseif( !is_checkout() && !is_wc_endpoint_url( 'order-received' ) && $enable == 'enable'){

			if(isset($temp_layout_bdpc['wacout_bdpc_id']) && !empty($temp_layout_bdpc['wacout_bdpc_id'])){
				$wacout_bdpc_id = absint($temp_layout_bdpc['wacout_bdpc_id']);
			} else{ $wacout_bdpc_id = ""; }

			// if cart empty, add it to cart
			if ( WC()->cart->get_cart_contents_count() == 0) {
				WC()->cart->add_to_cart( absint($wacout_bdpc_id) );

			}
	}
	else{
		if(isset(get_post()->post_type) && get_post()->post_type == 'awesome_checkout' && $enable != 'enable'){
			$checkout_page_url = function_exists( 'wc_get_cart_url' ) ? wc_get_checkout_url() : $woocommerce->cart->get_checkout_url();
			wp_redirect( $checkout_page_url );
			die();
		}
	}
}

/*
** include template for checkout page
** @since  1.1.1.1
*/
add_filter( 'template_include', 'wacout_template_include' , 10 , 1) ;
function wacout_template_include($template){
	global $post,$checkout ;

	if(isset($post) && $post->post_type == 'awesome_checkout'){
		$cart =   WC()->cart->get_cart() ;
		$checkout = WC()->checkout;

		$post_id = wacout_get_post_meta_using_id();

		//get selected template post meta
		$template_layout = get_post_meta( $post_id,'_wacout_template_layout_settings',true ); // post meta
		if(isset($template_layout) && !empty($template_layout)){
		$temp_selection = $template_layout['template_layout_all_settings'];
		}

		// display templale
		if( isset($temp_selection) && !empty($temp_selection) ){ $select_lay = absint($temp_selection['layout_select']); }else{ $select_lay = ''; }
		if(absint($select_lay) == 1){
			include(WACOUT_TEMP.'template-1.php');
		}elseif(absint($select_lay) == 2){
			include(WACOUT_TEMP.'template-2.php');
		}else{
			?>
			<style>
				body{background-image: url('<?php echo WACOUT_IMG."technical.jpg"?>');background-size: cover; background-position: center center;background-repeat: no-repeat;margin: 0;
				}
				.no_layout{width: 100%;height: 100%;background: #00000099; display: flex;align-items: center;}
				.layout_alert{ color: #fff;font-size: 20px;margin: 0 auto; }
			</style>
			<div class="no_layout">
				<div class="layout_alert">
					The site is experiencing technical difficulties. Please contact to site admin to select template layout.
				</div>
			</div>
			<?php
		}
		return false;
	}
	return $template ;
}


/*
** Added template checkout page
** @since  1.1.1.1
*/
add_filter( 'woocommerce_is_checkout', 'wacout_add_template_as_checkout_page');
function wacout_add_template_as_checkout_page( $is_checkout ){
	if(wacout_is_template_page()){
		$is_checkout = true ;
	}
	return $is_checkout ;
}

/*
** Check browser show checkout page
** @since  1.1.1.1
*/
function wacout_is_template_page(){
	$return = false ;
	global $wp;
	$request_url = home_url( $wp->request ) ;
	if(!empty($request_url) && mb_strpos($request_url, 'awesome-checkout')){
		$return = true ;
	}
	return $return ;
}


/*product Search filter*/
add_action( 'wp_ajax_wacout_product_search', 'wacout_product_search' ) ;
function wacout_product_search(){
	$return = array();
	$search_results = new WP_Query( array(
		's'						=> sanitize_text_field($_GET['q']),
		'post_type' 			=> array( 'product' ),
		'posts_per_page' 		=> 50
	) );

	if( $search_results->have_posts() ) :
		while( $search_results->have_posts()):
			$search_results->the_post();
			$title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;
			$product = wc_get_product( $search_results->post->ID );
			$downloadable = $product->is_downloadable();
			$stock = $product->get_stock_status();
			if( !$product->is_purchasable() || $stock === "outofstock" )
			{
				continue;
			}
			$return[] = array( $search_results->post->ID, $title );
		endwhile;
	endif;
	echo json_encode( $return );
	wp_die();
}


/*
** Check browser show checkout page
*/
function wacout_checkout_render_offer_html(){
	$html = "" ;
	$html =wacout_order_offer_html() ;
	echo $html ;
}

function wacout_order_offer_html(){
	$html = "" ;
	global $post ;
	if(!empty($post) && $post->post_type = "awesome_checkout"){

		$page_id = $post->ID ;
		$cart =   WC()->cart->get_cart() ;
		$cart_prod_ids = array();
		if(!empty($cart)){
			foreach ($cart as $item) {
				$product = $item['data'];
				if(!empty($product))
					$cart_prod_ids[] = $product->get_id();
			}
		}

		/*Product id*/
		$post_id = wacout_get_post_meta_using_id();

		$template_settings = get_post_meta($post_id,'_wacout_template_layout_settings',true ); // post meta
		$unsl_template_settings = $template_settings;

		/*Template all settings*/
		$template_all_settings = $unsl_template_settings['template_layout_all_settings'];

		/*Template related product*/
		$temp_ralated_product = $template_all_settings['layout_more_prd'];



		if(isset($temp_ralated_product['wacout_more_prd_add_count']) && !empty($temp_ralated_product['wacout_more_prd_add_count'])){
			$wacout_more_prd_add_count = $temp_ralated_product['wacout_more_prd_add_count'];
		} else{ $wacout_more_prd_add_count = "0"; }

		if(isset($temp_ralated_product['wacout_more_prd_id']) && !empty($temp_ralated_product['wacout_more_prd_id'])){
			$wacout_more_prd = $temp_ralated_product['wacout_more_prd_id'];
		} else{ $wacout_more_prd[] = ""; }


		if(array_filter($wacout_more_prd)){
			$html = '<div class="wacout_clear"></div>' ;
			$html .= '<h3>'.__( "Related products", "woocommerce" ).'</h3>' ;
			$html .= '<div class="wacout_rlt_prd wacout_tmp_owl-carousel-slider owl-carousel owl-theme">' ;
			for ($i=0; $i <= $wacout_more_prd_add_count; $i++) {

				if(isset($temp_ralated_product['wacout_more_prd_des'][$i]) && !empty($temp_ralated_product['wacout_more_prd_des'][$i])){
					$wacout_more_prd_des = wp_kses_post($temp_ralated_product['wacout_more_prd_des'][$i]);
				} else{ $wacout_more_prd_des = ""; }

				if(isset($temp_ralated_product['wacout_more_prd_btn'][$i]) && !empty($temp_ralated_product['wacout_more_prd_btn'][$i])){
					$wacout_more_prd_btn = sanitize_text_field($temp_ralated_product['wacout_more_prd_btn'][$i]);
				} else{ $wacout_more_prd_btn = "Add to Cart"; }

				if(isset($temp_ralated_product['wacout_more_prd_id'][$i]) && !empty($temp_ralated_product['wacout_more_prd_id'][$i])){
					$wacout_more_prd_id = sanitize_text_field($temp_ralated_product['wacout_more_prd_id'][$i]);
					$product = wc_get_product($wacout_more_prd_id);
					$html .= '<div>';
					$html .= '<div class="wacout_rlt_prd_body">' ;
					$html .= '<img src="'.wp_get_attachment_image_src($product->get_image_id(), 'full')[0].'" alt="" width="100px">' ;
					$html .= '<div class="wacout_rlt_prd_title">'.esc_html($product->get_title()).'</div>';
					$html .= '<div class="wacout_rlt_prd_descr">'.wp_kses_post($wacout_more_prd_des).'</div>';
					$html .= '<div class="wacout_rlt_prd_price">'.$product->get_price_html().'</div>';
					$html .= '<div class="wacout_rlt_prd_button"><a href="javascript:void(0)" id="'.$product->get_id().'" class="button alt wacout_add_cart">'.esc_html($wacout_more_prd_btn).'</a><a href="javascript:void(0)" id="'.$product->get_id().'" class="button wacout_remove wacout_add_hide alt">Remove</a></div>';
					$html .= '<div class="wacout_clear"></div>' ;
					$html .= '</div>';
					$html .= '</div>';
				}
			}
			$html .= '</div>';
		}

	}
	return $html ;
}

/**
 * Added product cart
 *
 */
add_action('wp_ajax_wacout_add_to_cart','wacout_add_to_cart');
add_action('wp_ajax_nopriv_wacout_add_to_cart','wacout_add_to_cart');
function wacout_add_to_cart(){
	$data = array( 'success' => 'false' );

	if(isset($_POST['product_id']) && $_POST['product_id'] != "" ){
		if(isset($_POST['security_nonce']) && wp_verify_nonce( $_POST['security_nonce'], 'ajax_public_nonce' )){

			$id = absint($_POST['product_id']) ;
			WC()->cart->add_to_cart( $id, $quantity = 1 );
			$data = array( 'success' => 'true' );

		}
	}

	echo json_encode($data);
	wp_die();
}

/**
 * Removes product cart
 *
 */
add_action('wp_ajax_wacout_remove_prd','wacout_remove_prd');
add_action('wp_ajax_nopriv_wacout_remove_prd','wacout_remove_prd');
function wacout_remove_prd(){

	$data = array( 'success' => 'false' );

	if(isset($_POST['product_id']) && $_POST['product_id'] != "" ){

		if(isset($_POST['security_nonce']) && wp_verify_nonce( $_POST['security_nonce'], 'ajax_public_nonce' )){

			$id = absint($_POST['product_id']) ;

			$cart_items = WC()->cart->get_cart() ;

			foreach( $cart_items as $key => $item ){

				if( $item['product_id'] == $id ){

					WC()->cart->remove_cart_item( $key );
				}
			}

			$data = array( 'success' => 'true' );

		}
	}

	echo json_encode($data);
	wp_die();
}

/*
**Send support email
*/
add_action('wp_ajax_wacout_send_email_help','wacout_send_email_help');
function wacout_send_email_help(){
	$fdbk_trm 		= sanitize_text_field($_POST['fdbk_trm']);
	$btn_action		=	sanitize_text_field($_POST['btn_action']);
	if(isset($btn_action) && $btn_action == 'wacout_send_email' && isset($fdbk_trm) && $fdbk_trm == 'on' && isset($_POST['security_nonce']) && wp_verify_nonce( $_POST['security_nonce'], 'ajax_public_nonce' )){
			$subject = sanitize_text_field(str_replace('-',' ',$_POST['form_type']));
			$subject = ucfirst($subject);
			date_default_timezone_set('Asia/Kolkata');
			$date = date('d-M-Y H:i');
			$subjects = 'Awesome Checkout Templates -'.$subject.' - '.$date;
			$email_from = sanitize_email($_POST['fdbk_email']);
			$headers[] = 'Content-type: text/html; charset=utf-8';
			$headers[] = 'From:' . $email_from;
			$body = nl2br(wp_kses_post($_POST['fdbk_msg']));
			$sent = wp_mail( "coder426@gmail.com", $subjects, $body, $headers );
			if($sent)
			{
				echo json_encode("Success");

			}
	}
	die;
}

?>
