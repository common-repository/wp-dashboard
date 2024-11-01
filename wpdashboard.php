<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpdashboard.io
 * @since             1.0.0
 * @package           Wpdashboard
 *
 * @wordpress-plugin
 * Plugin Name:       WP Dashboard
 * Plugin URI:        https://wpdashboard.io
 * Description:       Manage your Wordpress installations in one place.
 * Version:           2.0.10
 * Author:            WP Dashboard
 * Author URI:        https://wpdashboard.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpdashboard
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WP_DASHBOARD_VERSION', '2.0.10' );
define( 'WP_DASHBOARD_PLUGIN_DIRECTORY', plugin_dir_path( __DIR__ ) );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpdashboard-activator.php
 */
function activate_wpdashboard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpdashboard-activator.php';
	Wpdashboard_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpdashboard-deactivator.php
 */
function deactivate_wpdashboard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpdashboard-deactivator.php';
	Wpdashboard_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpdashboard' );
register_deactivation_hook( __FILE__, 'deactivate_wpdashboard' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpdashboard.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-wpdashboard-updates.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpdashboard() {

	$plugin = new Wpdashboard();
	$plugin->run();

    add_action( 'wpdashboard_send_updates_available', 'wpdashboard_send_updates_available_now', 10, 0 );

}


function generate_wpdashboard_admin() {
    $plugin = new Wpdashboard();
    $plugin->generate_admin();
}

function wpdashboard_send_updates_available_now( ) {
    WpDashboard_Updates::send();
}

run_wpdashboard();
