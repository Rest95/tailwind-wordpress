<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (is_user_logged_in()) {
	return;
}

?>
<form class="woocommerce-form woocommerce-form-login login mt-4" method="post" <?php echo ($hidden) ? 'style="display:none;"' : ''; ?>>

	<?php do_action('woocommerce_login_form_start'); ?>

	<?php echo ($message) ? wpautop(wptexturize($message)) : ''; // @codingStandardsIgnoreLine ?>

	<div class="max-w-xs my-4">
		<p class="form-row form-row-first">
			<label class="uppercase text-sm font-semibold tracking-wide" for="username">
				<?php esc_html_e('Username or email', 'woocommerce'); ?>&nbsp;<span class="required">*</span>
			</label>
			<input type="text" class="input-text w-full px-4 py-2 tracking-wide border text-xs rounded-none h-10"
				name="username" id="username" autocomplete="username" />
		</p>
		<p class="form-row form-row-last mt-2">
			<label class="uppercase text-sm font-semibold tracking-wide" for="password">
				<?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span>
			</label>
			<input class="input-text w-full px-4 py-2 tracking-wide border text-xs rounded-none h-10" type="password"
				name="password" id="password" autocomplete="current-password" />
		</p>
	</div>
	<div class="clear"></div>

	<?php do_action('woocommerce_login_form'); ?>

	<p class="form-row">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox text-sm" name="rememberme" type="checkbox"
				id="rememberme" value="forever" /> <span>
				<?php esc_html_e('Remember me', 'woocommerce'); ?>
			</span>
		</label>
		<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
		<input type="hidden" name="redirect" value="<?php echo esc_url($redirect); ?>" />
	<div class="my-4">
		<button type="submit"
			class="woocommerce-button button woocommerce-form-login__submit btn btn-primary flex justify-center" name="login"
			value="<?php esc_attr_e('Login', 'woocommerce'); ?>"><?php esc_html_e('Login', 'woocommerce'); ?></button>
	</div>
	</p>
	<p class="lost_password">
		<a class="underline" href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
	</p>

	<div class="clear"></div>

	<?php do_action('woocommerce_login_form_end'); ?>

</form>