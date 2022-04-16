<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              htts://wpcolr.com
 * @since             1.0.0
 * @package           Colr
 *
 * @wordpress-plugin
 * Plugin Name:       Colr
 * Plugin URI:        htts://wpcolr.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
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

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'COLR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-colr-activator.php
 */
function activate_colr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-colr-activator.php';
	Colr_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-colr-deactivator.php
 */
function deactivate_colr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-colr-deactivator.php';
	Colr_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_colr' );
register_deactivation_hook( __FILE__, 'deactivate_colr' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-colr.php';

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
    return "inside colr picker shortcode";
    //return "foo = {$atts['foo']}";
}
