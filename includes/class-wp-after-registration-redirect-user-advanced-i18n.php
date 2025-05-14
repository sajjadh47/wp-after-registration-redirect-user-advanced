<?php
/**
 * This file contains the definition of the Wp_After_Registration_Redirect_User_Advanced_I18n class, which
 * is used to load the plugin's internationalization.
 *
 * @package       Wp_After_Registration_Redirect_User_Advanced
 * @subpackage    Wp_After_Registration_Redirect_User_Advanced/includes
 * @author        Sajjad Hossain Sagor <sagorh672@gmail.com>
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since    2.0.0
 */
class Wp_After_Registration_Redirect_User_Advanced_I18n {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'wp-after-registration-redirect-user-advanced',
			false,
			dirname( WP_AFTER_REGISTRATION_REDIRECT_USER_ADVANCED_PLUGIN_BASENAME ) . '/languages/'
		);
	}
}
