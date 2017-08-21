<?php
/**
 * Plugin Name: Lightning Advanced Unit
 * Plugin URI: http://lightning.vektor-inc.co.jp/
 * Version: 2.2.0
 * Author: Vektor,Inc.
 * Author URI: http://www.vektor-inc.co.jp
 * Description: This is a plug-ins that extend the functionality of the theme "Lightning".
 * Text Domain: lightning-adv-unit
 * Domain Path: /languages
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

$template = get_option('template');

if ( $template == 'lightning' ){

$data = get_file_data( __FILE__, array( 'version' => 'Version','textdomain' => 'Text Domain' ) );
define( 'LIGHTNING_ADVANCED_VERSION', $data['version'] );
define( 'LIGHTNING_ADVANCED_TEXTDOMAIN', $data['textdomain'] );
define( 'LIGHTNING_ADVANCED_BASENAME', plugin_basename( __FILE__ ) );
define( 'LIGHTNING_ADVANCED_URL', plugin_dir_url( __FILE__ ) );
define( 'LIGHTNING_ADVANCED_DIR', plugin_dir_path( __FILE__ ) );
define( 'LIGHTNING_ADVANCED_SHORT_NAME', 'LTG' );

require_once( LIGHTNING_ADVANCED_DIR . 'inc/navigation/navigation.php' );
require_once( LIGHTNING_ADVANCED_DIR . 'inc/widgets/widget-new-posts.php' );
require_once( LIGHTNING_ADVANCED_DIR . 'inc/menu-btn-position.php' );
require_once( LIGHTNING_ADVANCED_DIR . 'inc/sidebar-position.php' );
require_once( LIGHTNING_ADVANCED_DIR . 'inc/sidebar-child-list-hidden.php' );

/*-------------------------------------------*/
/*  translations
/*-------------------------------------------*/
function lightning_adv_unit_textdomain() {
	load_plugin_textdomain( LIGHTNING_ADVANCED_TEXTDOMAIN, false, dirname(plugin_basename(__FILE__)).'/languages/' );
}
add_action( 'plugins_loaded', 'lightning_adv_unit_textdomain' );

} // if ( $template == 'lightning' ){
