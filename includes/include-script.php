<?php

/******
** Include file in admin panel
** @since  1.1.1.1
*/
if (is_admin()) {

	/******
	** Include styling in admin panel
	** @since  1.1.1.1
	*/
	if( !function_exists( 'wacout_add_admin_style' )){
		function wacout_add_admin_style() {
			global $typenow,$pagenow;

			// include js for post-new.php page
			if( $typenow == 'awesome_checkout' && $pagenow == 'post-new.php' ){
				wp_enqueue_script( 'wacout_admin', WACOUT_JS . 'checkbox.js', array( 'jquery' ), 1.0,false);
			}

			if($typenow == 'awesome_checkout' || isset($_GET['page']) && esc_html($_GET['page']) == 'awesome-checkout-settings'){
				wp_enqueue_style( 'wacout_bootstrap_min_css', WACOUT_CSS . 'bootstrap.min.css');
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_style( 'wacout_jqry_min_css', WACOUT_CSS . 'jquery-ui.css');
				wp_register_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
				wp_enqueue_style( 'fontawesome');
				wp_enqueue_style( 'wacout_admin_panel', WACOUT_CSS . 'admin.css');
			}
		}
		add_action( 'admin_enqueue_scripts', 'wacout_add_admin_style',99 );
	}

	/******
	** Include script in admin panel
	** @since  1.1.1.1
	*/
	if( !function_exists( 'wacout_add_admin_scripts' )){
		function wacout_add_admin_scripts() {
			global $typenow;
			if(($typenow == 'awesome_checkout') || (isset($_GET['page']) && esc_html($_GET['page']) == 'awesome-checkout-settings')){
				wp_enqueue_script( 'wacout_admin_panel', WACOUT_JS . 'admin.js', array( 'jquery' ), 1.1,true);
				wp_enqueue_script( 'wacout_bootstrap_min_js',WACOUT_JS.'bootstrap.min.js', array( 'jquery' ), 1.0,true);
				wp_enqueue_script('wp-color-picker');
				wp_enqueue_script('jquery');
				wp_enqueue_script('jquery-ui');
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script( 'select2' );
				$admin_url = strtok( admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ), '?' );
				wp_localize_script( 'wacout_admin_panel', 'wacout_vars', array(
					'ajaxurl' => $admin_url,
					'ajax_public_nonce' => wp_create_nonce( 'ajax_public_nonce' ),
				));
			}
		}
		add_action( 'admin_enqueue_scripts', 'wacout_add_admin_scripts',99 );
	}
} else{
	/**
	 * Optimize WooCommerce Scripts
	 * add WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
	 */
	add_action( 'wp_enqueue_scripts', 'wacout_woocommerce_files_add', 99 );

	function wacout_woocommerce_files_add() {

		global $post;
		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'wacout') ) {

			//remove generator meta tag
			remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );

			//first check that woo exists to prevent fatal errors
			if ( function_exists( 'is_woocommerce' ) ) {
				//enqueue scripts and styles
				if (  ! is_checkout() ) {
					# Styles
					wp_enqueue_style( 'woocommerce-general' );
					wp_enqueue_style( 'woocommerce-layout' );
					wp_enqueue_style( 'woocommerce-smallscreen' );
					wp_enqueue_style( 'woocommerce_frontend_styles' );
					wp_enqueue_style( 'woocommerce_fancybox_styles' );
					wp_enqueue_style( 'woocommerce_chosen_styles' );
					wp_enqueue_style( 'woocommerce_prettyPhoto_css' );
					# Scripts
					wp_enqueue_script( 'wc_price_slider' );
					wp_enqueue_script( 'wc-single-product' );
					wp_enqueue_script( 'wc-add-to-cart' );
					wp_enqueue_script( 'wc-cart-fragments' );
					wp_enqueue_script( 'wc-checkout' );
					wp_enqueue_script( 'wc-add-to-cart-variation' );
					wp_enqueue_script( 'wc-single-product' );
					wp_enqueue_script( 'wc-cart' );
					wp_enqueue_script( 'wc-chosen' );
					wp_enqueue_script( 'woocommerce' );
					wp_enqueue_script( 'prettyPhoto' );
					wp_enqueue_script( 'prettyPhoto-init' );
					wp_enqueue_script( 'jquery-blockui' );
					wp_enqueue_script( 'jquery-placeholder' );
					wp_enqueue_script( 'fancybox' );
					wp_enqueue_script( 'jqueryui' );
				}
			}
		}
	}


	// for frontend
	function wacout_add_front_scripts() {

		$post_id = wacout_get_post_meta_using_id();
		wp_enqueue_script('jquery');
		wp_enqueue_style( 'wacout_owl-carousel-css', WACOUT_CSS . 'owl.carousel.min.css');
		wp_enqueue_style( 'wacout_owl.theme.default.min-css', WACOUT_CSS . 'owl.theme.default.min.css');
		wp_enqueue_script( 'wacout_owl_js', WACOUT_JS . 'owl.carousel.min.js', array( 'jquery' ), 1.0,true);
		wp_enqueue_script( 'wacout_front_js', WACOUT_JS . 'front.js', array( 'jquery' ), 1.0,true);

		$admin_url = strtok( admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) ), '?' );
		wp_localize_script( 'wacout_front_js', 'wacout_front_vars', array(
			'ajaxurl' => $admin_url,
			'postID' => $post_id,
			'ajax_public_nonce' => wp_create_nonce( 'ajax_public_nonce' ),
		));
	}
	add_action( 'wp_enqueue_scripts', 'wacout_add_front_scripts' );
}

?>
