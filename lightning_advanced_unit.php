<?php
/**
 * Plugin Name: Lightning Advanced Unit
 * Plugin URI:
 * Version: 0.0.0
 * Author: Vektor,Inc.
 * Author URI: http://www.vektor-inc.co.jp
 * Description:
 * Text Domain: lightning-adv-unit
 * Domain Path: /languages
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

$data = get_file_data( __FILE__, array( 'version' => 'Version','textdomain' => 'Text Domain' ) );
define( 'LIGHTNING_ADVANCED_VERSION', $data['version'] );
define( 'LIGHTNING_ADVANCED_TEXTDOMAIN', $data['textdomain'] );
define( 'LIGHTNING_ADVANCED_BASENAME', plugin_basename( __FILE__ ) );
define( 'LIGHTNING_ADVANCED_URL', plugin_dir_url( __FILE__ ) );
define( 'LIGHTNING_ADVANCED_DIR', plugin_dir_path( __FILE__ ) );
define( 'LIGHTNING_ADVANCED_SHORT_NAME', 'LTG' );

// require_once( ltg_adv_DIR . 'class.lightning_adv-common.php' );

require_once( LIGHTNING_ADVANCED_DIR . 'plugins/navigation/navigation.php' );
require_once( LIGHTNING_ADVANCED_DIR . 'plugins/widgets/widget-new-posts.php' );
require_once( LIGHTNING_ADVANCED_DIR . 'plugins/menu-btn-position.php' );

/*-------------------------------------------*/
/*  translations
/*-------------------------------------------*/
function lightning_adv_unit_textdomain() {
	load_plugin_textdomain( LIGHTNING_ADVANCED_TEXTDOMAIN, false, dirname(plugin_basename(__FILE__)).'/languages/' );
}
add_action( 'plugins_loaded', 'lightning_adv_unit_textdomain' );




/*-------------------------------------------*/
/*  Load lightning_adv js
/*-------------------------------------------*/
// add_action( 'wp_head','ltg_adv_addJs' );
// function ltg_adv_addJs() {
// 	wp_register_script( 'ltg_adv_js' , LIGHTNING_ADVANCED_URL.'js/lightning_adv.min.js', array( 'jquery' ), LIGHTNING_ADVANCED_VERSION );
// 	wp_enqueue_script( 'ltg_adv_js' );
// }

/*-------------------------------------------*/
/*  Load lightning_adv admin js
/*-------------------------------------------*/
// add_action( 'admin_print_scripts-ltg_adv_****', 'ltg_adv_admin_add_js' );
// function ltg_adv_admin_add_js( $hook_suffix ) {
// 	wp_register_script( 'ltg_adv_admin_js', LIGHTNING_ADVANCED_URL.'js/ltg_adv_admin.min.js', array( 'jquery' ), LIGHTNING_ADVANCED_VERSION );
// 	wp_enqueue_script( 'ltg_adv_admin_js' );
// }

/*-------------------------------------------*/
/*  Load lightning_adv css
/*-------------------------------------------*/
// add_action( 'wp_enqueue_scripts', 'ltg_adv_style_enq' );
// function ltg_adv_style_enq() {
// 	wp_enqueue_style( 'ltg_adv_style_css', LIGHTNING_ADVANCED_URL.'css/ltg_adv_style.css', array(), LIGHTNING_ADVANCED_VERSION, 'all' );
// }

/*-------------------------------------------*/
/*  Load lightning_adv admin css
/*-------------------------------------------*/
// add_action( 'admin_print_styles-ltg_adv_****', 'ltg_adv_style_admin_enq' );
// function ltg_adv_style_admin_enq() {
// 	wp_enqueue_style( 'ltg_adv_admin_css', LIGHTNING_ADVANCED_URL.'css/ltg_adv_admin.css', array(), LIGHTNING_ADVANCED_VERSION, 'all' );
// }
