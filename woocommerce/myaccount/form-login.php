<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if(version_compare( get_option( 'woocommerce_version' ),'3.5.0', '<' ) ){
wc_print_notices(); 
}

do_action( 'woocommerce_before_customer_login_form' ); ?>
		<form class="woocomerce-form woocommerce-form-login login" method="post">

			<h3><?php esc_html_e( 'Sign In', 'lapindos' ); ?></h3>

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<div id="form-login-username" class="form-group">
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Username or email address', 'lapindos' ); ?>" name="username" id="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</div>
			<div id="form-login-password" class="form-group">
				<input class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Password', 'lapindos' ); ?> " type="password" name="password" id="password" />
			</div>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<div id="form-login-submit" class="form-group">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<input type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Sign In', 'lapindos' ); ?>" />
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'lapindos' ); ?></span>
				</label>
			</div>
			<div id="form-login-acction" class="form-group">
				<a id="new-account" href="<?php echo esc_url( lapindos_registration_url() ); ?>"><?php esc_html_e( 'Create Account', 'lapindos' ); ?></a>
				<a id="lost-password" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'lapindos' ); ?></a>
			</div>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
