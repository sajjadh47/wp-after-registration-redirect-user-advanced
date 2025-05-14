<?php
/**
 * This file contains the definition of the WP_Edit_Username_Admin class, which
 * is used to load the plugin's admin-specific functionality.
 *
 * @package       Wp_After_Registration_Redirect_User_Advanced
 * @subpackage    Wp_After_Registration_Redirect_User_Advanced/admin
 * @author        Sajjad Hossain Sagor <sagorh672@gmail.com>
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version and other methods.
 *
 * @since    2.0.0
 */
class Wp_After_Registration_Redirect_User_Advanced_Admin {
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
	 * Ajax Response Messages.
	 *
	 * @since     2.0.0
	 * @access    private
	 * @var       array $messages Responses Message Array.
	 */
	private $messages;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @param     string $plugin_name The name of this plugin.
	 * @param     string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function enqueue_styles() {
		$current_screen = get_current_screen();

		// check if current page is plugin settings page.
		if ( 'toplevel_page_wp-after-registration-redirect-user-advanced' === $current_screen->id ) {
			wp_enqueue_style( $this->plugin_name, WP_AFTER_REGISTRATION_REDIRECT_USER_ADVANCED_PLUGIN_URL . 'admin/css/admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function enqueue_scripts() {
		$current_screen = get_current_screen();

		// check if current page is plugin settings page.
		if ( 'toplevel_page_wp-after-registration-redirect-user-advanced' === $current_screen->id ) {
			wp_enqueue_script( $this->plugin_name, WP_AFTER_REGISTRATION_REDIRECT_USER_ADVANCED_PLUGIN_URL . 'admin/js/admin.js', array( 'jquery', 'jquery-ui-autocomplete' ), $this->version, false );

			$post_types = get_post_types(
				array(
					'public'   => true,
					'_builtin' => false,
				),
				'names',
				'or'
			);

			$url_sugestions  = array();
			$all_posts_pages = get_posts(
				array(
					'posts_per_page' => -1,
					'post_type'      => $post_types,
				)
			);

			foreach ( $all_posts_pages as $post ) {
				$url_sugestions[] = esc_url( get_the_permalink( $post->ID ) );
			}

			wp_localize_script(
				$this->plugin_name,
				'WpAfterRegistrationRedirectUserAdvanced',
				array(
					'ajaxurl'                     => admin_url( 'admin-ajax.php' ),
					'redirectUrlCannotBeEmptyTxt' => __( 'Redirect URL Can not be Empty!', 'wp-after-registration-redirect-user-advanced' ),
					'savingTxt'                   => __( 'Saving Settings...', 'wp-after-registration-redirect-user-advanced' ),
					'settingsSavedTxt'            => __( 'Settings Saved', 'wp-after-registration-redirect-user-advanced' ),
					'saveChangesTxt'              => __( 'Save Changes', 'wp-after-registration-redirect-user-advanced' ),
					'urlSugestions'               => $url_sugestions,
				)
			);
		}
	}

	/**
	 * Adds a settings link to the plugin's action links on the plugin list table.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @param     array $links The existing array of plugin action links.
	 * @return    array $links The updated array of plugin action links, including the settings link.
	 */
	public function add_plugin_action_links( $links ) {
		$links[] = sprintf( '<a href="%s">%s</a>', esc_url( admin_url( 'admin.php?page=wp-after-registration-redirect-user-advanced' ) ), __( 'Settings', 'wp-after-registration-redirect-user-advanced' ) );

		return $links;
	}

	/**
	 * Adds the plugin settings page to the WordPress dashboard menu.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function admin_menu() {
		add_menu_page(
			__( 'Registration Redirect', 'wp-after-registration-redirect-user-advanced' ),
			__( 'Registration Redirect', 'wp-after-registration-redirect-user-advanced' ),
			'manage_options',
			'wp-after-registration-redirect-user-advanced',
			array( $this, 'menu_page' ),
			'dashicons-menu'
		);
	}

	/**
	 * Renders the plugin menu page content.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function menu_page() {
		require WP_AFTER_REGISTRATION_REDIRECT_USER_ADVANCED_PLUGIN_PATH . 'admin/views/plugin-admin-display.php';
	}

	/**
	 * Displays admin notices in the admin area.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function admin_notices() {
		/**
		 * Filters the list of response messages.
		 *
		 * This filter is applied to the array of messages used for ajax response.
		 *
		 * @since     2.0.0
		 * @param     array $messages An array of messages.
		 */
		$this->messages = apply_filters( 'wplra_registration_redirect_messages', array() );

		if ( isset( $_POST['wparua_registration_redirect_filter_reset'] ) ) {
			// Check nonce for security.
			if ( ! isset( $_POST['wparua_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wparua_nonce'] ) ), 'wparua_nonce' )
				) {
				// Invalid request.
				echo '<div class="notice notice-error is-dismissible">';
					echo '<p>' . esc_html( $this->messages['nonce_error_msg']['message'] ) . '</p>';
				echo '</div>';

				// No further processing.
				return;
			}

			// Check if current is an administrator.
			if ( current_user_can( 'manage_options' ) ) {
				// Reset the redirection list.
				update_option( 'wparua_registration_redirect_filter', array() );

				// Disable the redirection.
				update_option( 'wparua_registration_redirect_enable', 'off' );

				// Show reset successful message.
				echo '<div class="notice notice-success is-dismissible">';
					echo '<p>' . esc_html( $this->messages['reset_success_msg']['message'] ) . '</p>';
				echo '</div>';
			} else {
				// User is not an admin.
				echo '<div class="notice notice-error is-dismissible">';
					echo '<p>' . esc_html( $this->messages['permission_denied_msg']['message'] ) . '</p>';
				echo '</div>';
			}
		}
	}

	/**
	 * Saves the enable/disable toggle setting for registration redirects.
	 *
	 * This function handles the AJAX request to save the enable/disable toggle setting
	 * for registration redirects. It verifies the nonce, checks user permissions, and updates
	 * the option in the database.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @return    void
	 */
	public function save_enable_disable_toggle() {
		/**
		 * Filters the list of response messages.
		 *
		 * This filter is applied to the array of messages used for ajax response.
		 *
		 * @since     2.0.0
		 * @param     array $messages An array of messages.
		 */
		$this->messages = apply_filters( 'wplra_registration_redirect_messages', array() );

		if ( ! isset( $_POST['wparua_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wparua_nonce'] ) ), 'wparua_nonce' )
			) {
			// Invalid request.
			wp_send_json( $this->messages['nonce_error_msg'] );
		}

		if ( isset( $_POST['wparua_registration_redirect_enable'] ) && ! empty( $_POST['wparua_registration_redirect_enable'] ) ) {
			if ( 'on' === $_POST['wparua_registration_redirect_enable'] ) {
				// Check if current is an administrator.
				if ( current_user_can( 'manage_options' ) ) {
					// Enable the redirection.
					update_option( 'wparua_registration_redirect_enable', 'on' );

					// Send enabled message back to the response.
					wp_send_json( $this->messages['filter_enabled_msg'] );
				} else {
					// User is not an admin.
					wp_send_json( $this->messages['permission_denied_msg'] );
				}
			} elseif ( 'off' === $_POST['wparua_registration_redirect_enable'] ) {
				// Check if current is an administrator.
				if ( current_user_can( 'manage_options' ) ) {
					// Disable the redirection.
					update_option( 'wparua_registration_redirect_enable', 'off' );

					// Send disabled message back to the response.
					wp_send_json( $this->messages['filter_disabled_msg'] );
				} else {
					// User is not an admin.
					wp_send_json( $this->messages['permission_denied_msg'] );
				}
			}
		}

		wp_send_json( $this->messages['default_msg'] );
	}

	/**
	 * Saves the filter setting for registration redirects.
	 *
	 * This function handles the AJAX request to save the filter setting
	 * for registration redirects. It verifies the nonce, checks user permissions, and updates
	 * the option in the database.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @return    void
	 */
	public function save_redirect_filter() {
		/**
		 * Filters the list of response messages.
		 *
		 * This filter is applied to the array of messages used for ajax response.
		 *
		 * @since     2.0.0
		 * @param     array $messages An array of messages.
		 */
		$this->messages = apply_filters( 'wplra_registration_redirect_messages', array() );

		if ( ! isset( $_POST['wparua_nonce'] )
				|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wparua_nonce'] ) ), 'wparua_nonce' )
			) {
			// Invalid request.
			wp_send_json( $this->messages['nonce_error_msg'] );
		}

		if ( isset( $_POST['wparua_registration_redirect_to_url'] ) ) {
			// Check if current is an administrator.
			if ( current_user_can( 'manage_options' ) ) {
				// Update the redirect filters list.
				update_option( 'wparua_registration_redirect_to_url', sanitize_url( wp_unslash( $_POST['wparua_registration_redirect_to_url'] ) ) );

				// Send success message back to the response.
				wp_send_json( $this->messages['success_msg'] );
			} else {
				// User is not an admin.
				wp_send_json( $this->messages['permission_denied_msg'] );
			}
		}

		wp_send_json( $this->messages['default_msg'] );
	}

	/**
	 * Filters the list of ajax response messages.
	 *
	 * This filter allows you to modify the list of ajax response messages.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @param     array $messages The list of default messages.
	 * @return    array $messages The modified list of messages.
	 */
	public function messages( $messages ) {
		$new_messages = array(
			'default_msg'           => array(
				'type'    => 'notice-error',
				'message' => __( 'Something Went Wrong! Please Try Again.', 'wp-after-registration-redirect-user-advanced' ),
			),
			'permission_denied_msg' => array(
				'type'    => 'notice-error',
				'message' => __( 'Permission Denied! You Are Not Allowed To Modify.', 'wp-after-registration-redirect-user-advanced' ),
			),
			'success_msg'           => array(
				'type'    => 'notice-success',
				'message' => __( 'Settings Saved Successfully!', 'wp-after-registration-redirect-user-advanced' ),
			),
			'nonce_error_msg'       => array(
				'type'    => 'notice-error',
				'message' => __( 'Sorry, your nonce did not verify.', 'wp-after-registration-redirect-user-advanced' ),
			),
			'reset_success_msg'     => array(
				'type'    => 'notice-success',
				'message' => __( 'Filters Successfully Reset.', 'wp-after-registration-redirect-user-advanced' ),
			),
			'filter_enabled_msg'    => array(
				'type'    => 'notice-success',
				'message' => __( 'Filters Enabled!', 'wp-after-registration-redirect-user-advanced' ),
			),
			'filter_disabled_msg'   => array(
				'type'    => 'notice-success',
				'message' => __( 'Filters Disabled!', 'wp-after-registration-redirect-user-advanced' ),
			),
		);

		return array_merge( $new_messages, $messages );
	}
}
