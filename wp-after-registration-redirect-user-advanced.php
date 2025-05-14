<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package           Wp_After_Registration_Redirect_User_Advanced
 * @author            Sajjad Hossain Sagor <sagorh672@gmail.com>
 *
 * Plugin Name:       After Registration Redirect
 * Plugin URI:        https://wordpress.org/plugins/wp-after-registration-redirect-user-advanced/
 * Description:       Redirect User After Registration To Any Page You Select.
 * Version:           2.0.0
 * Requires at least: 6.5
 * Requires PHP:      8.0
 * Author:            Sajjad Hossain Sagor
 * Author URI:        https://sajjadhsagor.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-after-registration-redirect-user-advanced
 * Domain Path:       /languages
 * Requires Plugins:  woocommerce
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'WP_AFTER_REGISTRATION_REDIRECT_USER_ADVANCED_PLUGIN_VERSION', '2.0.0' );

/**
 * Define Plugin Folders Path
 */
define( 'WP_AFTER_REGISTRATION_REDIRECT_USER_ADVANCED_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

define( 'WP_AFTER_REGISTRATION_REDIRECT_USER_ADVANCED_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'WP_AFTER_REGISTRATION_REDIRECT_USER_ADVANCED_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-after-registration-redirect-user-advanced-activator.php
 *
 * @since    2.0.0
 */
function on_activate_wp_after_registration_redirect_user_advanced() {
	require_once WP_AFTER_REGISTRATION_REDIRECT_USER_ADVANCED_PLUGIN_PATH . 'includes/class-wp-after-registration-redirect-user-advanced-activator.php';

	Wp_After_Registration_Redirect_User_Advanced_Activator::on_activate();
}

register_activation_hook( __FILE__, 'on_activate_wp_after_registration_redirect_user_advanced' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-after-registration-redirect-user-advanced-deactivator.php
 *
 * @since    2.0.0
 */
function on_deactivate_wp_after_registration_redirect_user_advanced() {
	require_once WP_AFTER_REGISTRATION_REDIRECT_USER_ADVANCED_PLUGIN_PATH . 'includes/class-wp-after-registration-redirect-user-advanced-deactivator.php';

	Wp_After_Registration_Redirect_User_Advanced_Deactivator::on_deactivate();
}

register_deactivation_hook( __FILE__, 'on_deactivate_wp_after_registration_redirect_user_advanced' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 *
 * @since    2.0.0
 */
require WP_AFTER_REGISTRATION_REDIRECT_USER_ADVANCED_PLUGIN_PATH . 'includes/class-wp-after-registration-redirect-user-advanced.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.0.0
 */
function run_wp_after_registration_redirect_user_advanced() {
	$plugin = new Wp_After_Registration_Redirect_User_Advanced();

	$plugin->run();
}

run_wp_after_registration_redirect_user_advanced();
