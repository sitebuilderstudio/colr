<?php

$dev = true;

if($dev) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
function dd($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die;
}

/**
 * @link              htts://wpcolr.com
 * @since             1.0.0
 * @package           Colr
 *
 * @wordpress-plugin
 * Plugin Name:       Colr
 * Plugin URI:        htts://wpcolr.com
 * Description:       Gives users the ability to control their personal color theme.
 * Version:           1.0.0
 * Author:            SiteBuilderStudio
 * Author URI:        htts://wpcolr.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       colr
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'COLR_VERSION', time() ); // TODO - after dev change to '1.0.0'
define( 'COLR_FILE_PATH', __FILE__ );
define( 'COLR_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'COLR_DIR_URL', plugin_dir_url( __FILE__ ) );

function activate_colr() {
	require_once COLR_DIR_PATH . 'includes/class-colr-activator.php';
	Colr_Activator::activate();
}

function deactivate_colr() {
	require_once COLR_DIR_PATH . 'includes/class-colr-deactivator.php';
	Colr_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_colr' );
register_deactivation_hook( __FILE__, 'deactivate_colr' );

require COLR_DIR_PATH . 'includes/class-colr.php';

function run_colr() {

	$plugin = new Colr();
	$plugin->run();

}
run_colr();

/**
 * shortcode for colr_picker
 */
add_shortcode( 'colr_picker', 'colr_picker' );
function colr_picker() {
    require_once COLR_DIR_PATH . 'public/class-colr-public.php';
    Colr_Public::colr_picker();
}

