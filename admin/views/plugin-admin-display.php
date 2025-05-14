<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      2.0.0
 * @package    Wp_After_Registration_Redirect_User_Advanced
 * @subpackage Wp_After_Registration_Redirect_User_Advanced/admin/views
 * @author     Sajjad Hossain Sagor <sagorh672@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Retrieve plugin settings.
$wparua_registration_redirect_enabled = get_option( 'wparua_registration_redirect_enable', 'off' );
$wparua_registration_redirect_to_url  = get_option( 'wparua_registration_redirect_to_url', '' );

?>

<div class="wrap">
	<h2><?php esc_html_e( 'Redirect User After Registration', 'wp-after-registration-redirect-user-advanced' ); ?></h2>
	<div class="notice wparua_registration_redirect_filter_message"><p></p></div><br>
	<form action="" method="post" id="wparua_wp_registration_redirect_form">
		<div class="form-group row mb-3">
			<div class="col-sm-2 wparua-enable-redirection">
				<?php esc_html_e( 'Enable Redirection', 'wp-after-registration-redirect-user-advanced' ); ?>
			</div>
			<div class="col-sm-10">
				<div class="form-check">
					<div class="wparua-filter-slider">
						<input type="checkbox" name="wparua-filter-slider" class="wparua-filter-slider-checkbox" id="wparua_registration_redirect_enable" <?php checked( 'on', $wparua_registration_redirect_enabled ); ?>>
						<label class="wparua-filter-slider-label" for="wparua_registration_redirect_enable">
							<span class="wparua-filter-slider-inner"></span>
							<span class="wparua-filter-slider-circle"></span>
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">
					<?php esc_html_e( 'Redirect User After Registration To', 'wp-after-registration-redirect-user-advanced' ); ?>
				</span>
			</div>
			<input type="text" class="form-control " id="wparua_registration_redirect_url" name="wparua_registration_redirect_url" placeholder="<?php esc_html_e( 'Enter Redirect URL...', 'wp-after-registration-redirect-user-advanced' ); ?>" value="<?php echo esc_url( $wparua_registration_redirect_to_url ); ?>">
		</div>
		<button type="submit" class="button button-primary" name="wparua_registration_redirect_filter_submit" id="wparua_registration_redirect_filter_submit">
			<?php esc_html_e( 'Save Changes', 'wp-after-registration-redirect-user-advanced' ); ?>
		</button>
		<?php wp_nonce_field( 'wparua_nonce', 'wparua_nonce' ); ?>
		<button type="submit" class="button button-secondary" name="wparua_registration_redirect_filter_reset" id="wparua_registration_redirect_filter_reset">
			<?php esc_html_e( 'Reset', 'wp-after-registration-redirect-user-advanced' ); ?>
		</button>
	</form>
</div>
