<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_reset_password_form');
?>

<div class="w-full">
    <?php if (!is_front_page()): ?>
        <section class="font-roboto text-sm my-4 md:my-8">
            <div class="border-t border-b border-gray-400 py-2">
                <?php echo do_shortcode(' [wpseo_breadcrumb] '); ?>
            </div>
        </section>
    <?php endif; ?>
</div>
<form method="post" class="woocommerce-ResetPassword lost_reset_password font-roboto">
    <div class="flex flex-col max-w-screen-sm mx-auto space-y-4  py-4 my-4">
        <h3 class="text-xl md:text-3xl uppercase font-bold my-4">
            <?php echo apply_filters('woocommerce_reset_password_message', esc_html__('Enter a new password below.', 'woocommerce')); ?>
        </h3>
        <?php // @codingStandardsIgnoreLine ?>

        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label class="uppercase text-sm font-normal tracking-wide" for="password_1">
                <?php esc_html_e('New password', 'woocommerce'); ?>&nbsp;<span class="required">*</span>
            </label>
            <input type="password"
                class="woocommerce-Input woocommerce-Input--text input-text w-full px-4 py-2 tracking-wide border text-sm rounded-none h-10"
                name="password_1" id="password_1" autocomplete="new-password" />
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label class="uppercase text-sm font-normal tracking-wide" for="password_2">
                <?php esc_html_e('Re-enter new password', 'woocommerce'); ?>&nbsp;<span class="required">*</span>
            </label>
            <input type="password"
                class="woocommerce-Input woocommerce-Input--text input-text w-full px-4 py-2 tracking-wide border text-sm rounded-none h-10"
                name="password_2" id="password_2" autocomplete="new-password" />
        </p>

        <input type="hidden" name="reset_key" value="<?php echo esc_attr($args['key']); ?>" />
        <input type="hidden" name="reset_login" value="<?php echo esc_attr($args['login']); ?>" />

        <div class="clear"></div>

        <?php do_action('woocommerce_resetpassword_form'); ?>

        <p class="woocommerce-form-row form-row">
            <input type="hidden" name="wc_reset_password" value="true" />
            <button type="submit" class="woocommerce-Button btn btn-primary flex justify-center"
                value="<?php esc_attr_e('Save', 'woocommerce'); ?>"><?php esc_html_e('Save', 'woocommerce'); ?></button>
        </p>

        <?php wp_nonce_field('reset_password', 'woocommerce-reset-password-nonce'); ?>
    </div>
</form>
<?php
do_action('woocommerce_after_reset_password_form');