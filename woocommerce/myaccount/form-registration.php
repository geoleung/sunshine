<?php
/**
 * Registration Form
 *
 * This template split off templates/woocommerce/myaccount/form-login.php.
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
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="woocommerce">
<?php wc_print_notices(); ?>
<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
<form class="woocomerce-form ejuwal-login woocommerce-form-login register" method="post">

	<h2><?php esc_html_e( 'Register', 'lapindos' ); ?></h2>

	<?php do_action( 'woocommerce_register_form_start' ); ?>

	<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

	<div id="form-login-username" class="form-group">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Username or email address', 'lapindos' ); ?> " name="username" id="reg_username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
	</div>
	<?php endif; ?>
	<div id="form-login-email" class="form-group">
		<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Email address', 'lapindos' ); ?>" name="email" id="reg_email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>

	</div>
	<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
	<div id="form-login-password" class="form-group">
		<label for="password"><?php esc_html_e( 'Password', 'lapindos' ); ?> <span class="required">*</span></label>
		<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
	</div>
	<?php endif; ?>
	<!-- Spam Trap -->
	<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php esc_html_e( 'Anti-spam', 'lapindos' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" autocomplete="off" /></div>

	<?php do_action( 'woocommerce_register_form' ); ?>

	<div id="form-login-submit" class="form-group">
		<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
		<input type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'lapindos' ); ?>" />
	</div>
	<div id="form-login-or" class="form-group">
		<span class="or-devider"><span><?php esc_html_e( 'or', 'lapindos');?></span></span><br/><br/>
		<a id="new-account" class="btn-primary btn" href="<?php print esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e('return to shop','lapindos');?></a>
	</div>

	<?php do_action( 'woocommerce_register_form_end' ); ?>

</form>
<?php else:
woocommerce_login_form(); ?>
<?php endif;?>
</div>
