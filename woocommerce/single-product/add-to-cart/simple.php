<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

global $product;
$icons = new Icons();

if (!$product->is_purchasable()) {
    return;
}

do_action('woocommerce_before_add_to_cart_form'); ?>

<?php if (!$product->is_in_stock()) { ?>
    <div>
        <span class="bg-secondary text-white px-2 py-1 uppercase text-xs">Esgotado</span>
    </div>
<?php } ?>

<form class="cart flex flex-col space-y-4"
    action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
    method="post" enctype='multipart/form-data'>


    <?php do_action('woocommerce_before_add_to_cart_button'); ?>
    <div class="flex justify-between pt-4 lg:pt-6 pb-8 w-full">
        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"
            class="single_add_to_cart_button btn btn-primary w-full justify-center disabled:opacity-40" <?php echo !$product->is_in_stock() ? 'disabled' : '' ?>>
            <?php echo _e("Adicionar ao carrinho", "wlb_theme") ?>
        </button>
    </div>
    <?php do_action('woocommerce_after_add_to_cart_button'); ?>

</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>