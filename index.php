<?php
/**
 * Plugin Name:		  Awesome Checkout Templates
 * Plugin URI:		  https://woo.hirewebxperts.com
 * Description:		  Awesome checkout templates is an add on for woocommerce based websites where you can control your checkout pages by changing their layout, color, fields, labels etc. You can also make standalone checkout pages by using different shortcodes and can create unique landing pages with checkout option in ecommerce website.
 * Version: 		  1.0.2
 * Author: 			  Coder426
 * Author URI:		  https://www.hirewebxperts.com
 * Donate link: 	  https://hirewebxperts.com/donate/
 * Text Domain:       wacout
 * Domain Path:		  /languages
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * License: GPL2
 * WC tested up to: 4.4.1
*/

/**
 * Define plugin url path
 */
define('WACOUT_PLUGIN_URL',plugin_dir_url( __FILE__ ));
define('WACOUT_PLUGIN_DIR',dirname( __FILE__ ));
define('WACOUT_JS',WACOUT_PLUGIN_URL. 'admin/js/');
define('WACOUT_CSS',WACOUT_PLUGIN_URL. 'admin/css/');
define('WACOUT_IMG',WACOUT_PLUGIN_URL. 'admin/images/');
define('WACOUT_TEMP',WACOUT_PLUGIN_DIR. '/templates/');
define('WACOUT_INC',WACOUT_PLUGIN_DIR. '/includes/');
define('WACOUT_PUB',WACOUT_PLUGIN_DIR. '/public/');

if ( ! defined( 'ABSPATH' ) ) {
	exit; // exit if accessed directly
}

/*
* Add languages files
*/
add_action('init','wacout_language_translate');
function wacout_language_translate(){
	load_plugin_textdomain( 'wacout', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}


/**
 * Setting link to pluign
 */
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'wacout_add_plugin_page_settings_link');

function wacout_add_plugin_page_settings_link( $links ) {
    $links[] = '<a href="' .admin_url( 'edit.php?post_type=awesome_checkout&page=awesome-checkout-settings' ) .'">' . __('Settings') . '</a>';
    return $links;
}

include(WACOUT_INC.'include-script.php');

include(WACOUT_INC.'custom-column.php');

include(WACOUT_INC.'general-function.php');

include(WACOUT_INC.'meta-box.php');

include(WACOUT_PUB.'front-checkout.php');

include(WACOUT_INC.'wacout-shortcode.php');


?>