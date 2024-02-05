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
$entregas_e_devolucoes_b2c = get_field("entregas_e_devolucoes_b2c", "option");
$apoio_ao_cliente = get_field("apoio_ao_cliente", "option");
// echo wc_get_stock_html($product); // WPCS: XSS ok.


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

  <?php
  // do_action('woocommerce_before_add_to_cart_quantity');
  
  // woocommerce_quantity_input(
  //     array(
  //         'input_class' => 'qty',
  //         'min_value' => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
  //         'max_value' => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
  //         'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
  //         // WPCS: CSRF ok, input var ok.
  //     )
  // );
  
  // do_action('woocommerce_after_add_to_cart_quantity');
  ?>



  <div class="flex justify-between pt-4 pb-8  w-full">
    <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"
      class="single_add_to_cart_button btn btn-primary w-full justify-center disabled:opacity-40" <?php echo !$product->is_in_stock() ? 'disabled' : '' ?>>
      <?php echo _e("Adicionar ao carrinho", "wlb_theme") ?>
    </button>
  </div>


  <?php do_action('woocommerce_after_add_to_cart_button'); ?>

  <?php if ($entregas_e_devolucoes_b2c || $apoio_ao_cliente) { ?>
    <div class="mt-8 lg:mt-16">
      <?php if ($entregas_e_devolucoes_b2c) { ?>
        <div class="grid grid-cols-[24px_auto] gap-2">
          <div>
            <svg width="24" height="16" viewBox="0 0 24 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g opacity="0.7">
                <path
                  d="M2.75 9.5L2 8H7.25L6.65 6.5H1.75L1 5H8.8L8.2 3.5H0.86L0 2H3.75C3.75 1.46957 3.96071 0.960859 4.33579 0.585786C4.71086 0.210714 5.21957 0 5.75 0H17.75V4H20.75L23.75 8V13H21.75C21.75 13.7956 21.4339 14.5587 20.8713 15.1213C20.3087 15.6839 19.5456 16 18.75 16C17.9544 16 17.1913 15.6839 16.6287 15.1213C16.0661 14.5587 15.75 13.7956 15.75 13H11.75C11.75 13.7956 11.4339 14.5587 10.8713 15.1213C10.3087 15.6839 9.54565 16 8.75 16C7.95435 16 7.19129 15.6839 6.62868 15.1213C6.06607 14.5587 5.75 13.7956 5.75 13H3.75V9.5H2.75ZM18.75 14.5C19.1478 14.5 19.5294 14.342 19.8107 14.0607C20.092 13.7794 20.25 13.3978 20.25 13C20.25 12.6022 20.092 12.2206 19.8107 11.9393C19.5294 11.658 19.1478 11.5 18.75 11.5C18.3522 11.5 17.9706 11.658 17.6893 11.9393C17.408 12.2206 17.25 12.6022 17.25 13C17.25 13.3978 17.408 13.7794 17.6893 14.0607C17.9706 14.342 18.3522 14.5 18.75 14.5ZM20.25 5.5H17.75V8H22.21L20.25 5.5ZM8.75 14.5C9.14782 14.5 9.52936 14.342 9.81066 14.0607C10.092 13.7794 10.25 13.3978 10.25 13C10.25 12.6022 10.092 12.2206 9.81066 11.9393C9.52936 11.658 9.14782 11.5 8.75 11.5C8.35218 11.5 7.97064 11.658 7.68934 11.9393C7.40804 12.2206 7.25 12.6022 7.25 13C7.25 13.3978 7.40804 13.7794 7.68934 14.0607C7.97064 14.342 8.35218 14.5 8.75 14.5Z"
                  fill="#767583" />
              </g>
            </svg>
          </div>
          <div class="">
            <h4 class="text-txtgray uppercase text-xs">Entregas e devoluções grátis</h4>
            <div class="font-medium text-xs text-secondary info_box pt-1 tracking-[0.5px] opacity-70">
              <?= $entregas_e_devolucoes_b2c ?>
            </div>
            <div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if ($apoio_ao_cliente) { ?>
        <div class="grid grid-cols-[24px_auto] gap-2 pt-8">
          <div>
            <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g opacity="0.7">
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M10.0207 16.1381C8.21175 16.1381 6.37396 15.0066 5.30139 13.509C0.155554 13.509 0 21.255 0 21.255H20.0401C20.0401 21.255 20.4441 13.4746 14.6572 13.4746C13.5859 14.9908 11.8296 16.1381 10.0207 16.1381V16.1381Z"
                  fill="#767583" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M14.3308 6.85198C14.3308 9.08061 12.4002 13.3422 10.0167 13.3422C7.63696 13.3422 5.70508 9.07928 5.70508 6.85198C5.70508 4.62468 7.63571 2.81641 10.0167 2.81641C12.4002 2.81773 14.3308 4.626 14.3308 6.85198V6.85198Z"
                  fill="#767583" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M16.2558 4.92871C16.2558 4.51101 15.7039 4.17394 15.0189 4.1713V3.31078C15.0189 3.18256 15.0653 0.180664 10.0324 0.180664C5.00199 0.180664 5.04841 3.18256 5.04841 3.31078V4.2017C5.03586 4.2017 5.02583 4.19774 5.01454 4.19774C4.33336 4.19774 3.78516 4.52952 3.78516 4.94061V8.58096C3.78516 8.98941 4.33461 9.32251 5.01454 9.32251C5.69446 9.32251 6.24642 8.98941 6.24642 8.58096V4.94061C6.24642 4.88377 6.21255 4.83222 6.19248 4.77935V3.78664C6.19248 3.69544 5.8312 1.4298 10.0324 1.4298C14.2349 1.4298 13.7983 3.69544 13.7983 3.78664V4.83222C13.7908 4.86526 13.767 4.89435 13.767 4.92871V8.65234C13.767 9.07136 14.3227 9.41107 15.0114 9.41107C15.0265 9.41107 15.0377 9.40579 15.0528 9.40579V10.766H13.8184V12.0481H16.2684L16.2558 4.92871V4.92871Z"
                  fill="#767583" />
              </g>
            </svg>
          </div>
          <div class="">
            <h4 class="text-txtgray uppercase text-xs">Apoio ao cliente</h4>
            <div class="font-medium text-xs text-secondary info_box pt-1 tracking-[0.5px] opacity-70">
              <?= $apoio_ao_cliente ?>
            </div>
            <div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>