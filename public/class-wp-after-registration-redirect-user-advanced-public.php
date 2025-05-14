<?php
/**
 * This file contains the definition of the Wp_After_Registration_Redirect_User_Advanced_Public class, which
 * is used to load the plugin's public-facing functionality.
 *
 * @package       Wp_After_Registration_Redirect_User_Advanced
 * @subpackage    Wp_After_Registration_Redirect_User_Advanced/public
 * @author        Sajjad Hossain Sagor <sagorh672@gmail.com>
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version and other methods.
 *
 * @since    2.0.0
 */
class Wp_After_Registration_Redirect_User_Advanced_Public {
	/**
	 * The ID of this plugin.
	 *
	 * @since     2.0.0
	 * @access    private
	 * @var       string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since     2.0.0
	 * @access    private
	 * @var       string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @param     string $plugin_name The name of the plugin.
	 * @param     string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Filters the registration redirect URL based on user criteria.
	 *
	 * This function modifies the registration redirect URL based on user ID, email, role, or username,
	 * according to the settings configured in the plugin's options.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @param     string $redirect_to The redirect destination URL.
	 * @return    string              The filtered redirect URL.
	 */
	public function registration_redirect( $redirect_to ) {
		// Retrieve plugin settings.
		$wparua_registration_redirect_enabled = get_option( 'wparua_registration_redirect_enable', 'off' );
		$wparua_registration_redirect_to_url  = get_option( 'wparua_registration_redirect_to_url', $redirect_to );

		// Check if registration redirect is enabled.
		if ( 'on' === $wparua_registration_redirect_enabled ) {
			// Check if redirect filters are defined.
			if ( ! empty( $wparua_registration_redirect_to_url ) ) {
				return esc_url( $wparua_registration_redirect_to_url );
			}
		}

		// Return the original redirect URL if no filter matches.
		return $redirect_to;
	}
}
