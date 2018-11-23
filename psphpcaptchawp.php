<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wp.peters-webcorner.de
 * @since             1.0.0
 * @package           Psphpcaptchawp
 *
 * @wordpress-plugin
 * Plugin Name:       PS PHPCaptcha for Wordpress
 * Plugin URI:        https://github.com/pstimpel/psphpcaptchawp
 * Description:       Dislike feeding remote tracking enterprises like Google with data just for verifying users? Well, here you go with your own captcha...
 * Version:           1.0.0
 * Author:            Peter Stimpel
 * Author URI:        https://wp.peters-webcorner.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       psphpcaptchawp
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-psphpcaptchawp-activator.php
 */
function activate_psphpcaptchawp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-psphpcaptchawp-activator.php';
	Psphpcaptchawp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-psphpcaptchawp-deactivator.php
 */
function deactivate_psphpcaptchawp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-psphpcaptchawp-deactivator.php';
	Psphpcaptchawp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_psphpcaptchawp' );
register_deactivation_hook( __FILE__, 'deactivate_psphpcaptchawp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-psphpcaptchawp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_psphpcaptchawp() {

	$plugin = new Psphpcaptchawp();
	$plugin->run();

}
run_psphpcaptchawp();
