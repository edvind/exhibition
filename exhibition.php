<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://twitter.com/edvfind
 * @since             1.0.0
 * @package           Exhibition
 *
 * @wordpress-plugin
 * Plugin Name:       Exhibition
 * Plugin URI:        https://github.com/edvind/exhibition
 * Description:       Adds an exhibition post type to WordPress that synchronizes with DigitaltMuseum.
 * Version:           1.0.0
 * Author:            Joel Bergroth
 * Author URI:        https://twitter.com/edvfind
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       exhibition
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-exhibition-activator.php
 */
function activate_exhibition() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-exhibition-activator.php';
	Exhibition_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-exhibition-deactivator.php
 */
function deactivate_exhibition() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-exhibition-deactivator.php';
	Exhibition_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_exhibition' );
register_deactivation_hook( __FILE__, 'deactivate_exhibition' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-exhibition.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_exhibition() {

	$plugin = new Exhibition();
	$plugin->run();

}
run_exhibition();
