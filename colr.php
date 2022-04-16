<?php

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
 * Author:            Joe Kneeland
 * Author URI:        htts://wpcolr.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       colr
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function dd($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die;
}

/**
 * Define constants
 */
define( 'COLR_VERSION', '1.0.0' );
define( 'COLR_FILE_PATH', __FILE__ );
define( 'COLR_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'COLR_DIR_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-colr-activator.php
 */
function activate_colr() {
	require_once COLR_DIR_PATH . 'includes/class-colr-activator.php';
	Colr_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-colr-deactivator.php
 */
function deactivate_colr() {
	require_once COLR_DIR_PATH . 'includes/class-colr-deactivator.php';
	Colr_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_colr' );
register_deactivation_hook( __FILE__, 'deactivate_colr' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require COLR_DIR_PATH . 'includes/class-colr.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
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

