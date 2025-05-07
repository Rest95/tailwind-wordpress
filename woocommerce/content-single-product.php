<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.3.0
 */

defined("ABSPATH") || exit();

$icons = new Icons();

global $product;
$id = $product->get_id();

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action("woocommerce_before_single_product");

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

$is_b2b = false;
$mensagem_promo = get_field("mensagem_promo", "option");

$pre_venda_ativo = get_field("pre_venda_ativo", $product->get_id());
$pre_venda_mensagem = get_field("pre_venda_mensagem", $product->get_id());

$mensagem_promo = get_field("mensagem_promo", "option");
$mensagem_promocional = get_field("mensagem_promocional", $product->get_id());

$collection_gallery = get_field("collection_gallery", $id);

$percentage = 0;
if (!$is_b2b) {
    if ($product->is_type("simple")) {
        //if simple product
        if ($product->sale_price) {
            $percentage = round(
                ((floatval($product->regular_price) -
                    floatval($product->sale_price)) /
                    floatval($product->regular_price)) *
                    100
            );
        }
    } else {
        //if variable product
        $percentage = apply_filters("get_variable_sale_percentage", $product);
    }
}

$gamas = wp_get_post_terms($id, ["gamas"], ["fields" => "names"]);
?>
<section class="px-4 md:px-6">
  <div id="product-<?php the_ID(); ?>" <?php wc_product_class("", $product); ?>>
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_1fr]">
      <div>
        <div class="hidden lg:block h-auto overflow-hidden">
          <?php get_template_part(
              "woocommerce/single-product/product-gallery-desktop"
          ); ?>
        </div>
        <div class="block lg:hidden h-[460px]">
          <?php get_template_part(
              "woocommerce/single-product/product-image-gallery"
          ); ?>
        </div>
      </div>
      <div class="py-4 lg:py-12 lg:px-4 lg:pl-32 relative">
        <div class="flex flex-col max-w-[545px] sticky top-[170px]">
          <div class="order-1 lg:order-2 flex-col lg:flex-row flex justify-between items-start mt-4">
            <div class="flex flex-col">
              <h2 class="uppercase font-roboto text-sm mb-1 lg:mb-4 text-black text-left font-normal">
                <?php echo $gamas ? "GAMA " . $gamas[0] : ""; ?>
              </h2>
              <h1
                class="font-roboto text-base md:text-[24px] text-black  xl:text-[32px] xl:leading-9 text-left font-semibold uppercase ">
                <?php echo $product->get_name(); ?>
              </h1>
              <?php if ($product->get_sku()): ?>
                <div class="text-[#9CA3AF] font-roboto text-sm uppercase tracking-wide mt-1 lg:mt-2">
                  Ref.ª
                  <?php echo $product->get_sku(); ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="flex lg:hidden justify-between items-start font-normal pt-2 pb-4 order-4">
            <div class="flex w-full items-center">
              <div class="text-secondary price-box uppercase text-center font-roboto text-2xl">
                <?php echo $product->get_price_html(); ?>
              </div>
              <?php if ($percentage && $product->is_on_sale()) { ?>
                <div>
                  <span class="bg-amarelo text-white rounded-sm text-sm px-1 py-px sm:px-2 sm:py-1 font-roboto">
                    <?php echo "-" . $percentage; ?>%
                  </span>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="hidden lg:flex w-full justify-between items-center mt-4 font-normal lg:order-5 pt-2 pb-8">
            <input type="hidden" name="current_price" value="<?php echo $product->get_price(); ?>" id="current_price">
            <div class="flex w-full items-center">
              <div class="text-secondary price-box uppercase text-center font-roboto text-2xl">
                <?php echo $product->get_price_html(); ?>
              </div>
              <?php if ($percentage && $product->is_on_sale()) { ?>
                <div>
                  <span class="bg-amarelo text-white rounded-sm text-sm px-1 py-px sm:px-2 sm:py-1 font-roboto">
                    <?php echo "-" . $percentage; ?>%
                  </span>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="order-3 lg:order-3">
            <?php if ($pre_venda_ativo): ?>
              <div class="uppercase font-roboto text-xs text-amarelo text-left py-4 ">
                <?php echo $pre_venda_mensagem; ?>
              </div>
            <?php endif; ?>
            <?php if ($percentage && $percentage > 0 && $product->is_on_sale()):
                if (
                    isset($mensagem_promocional) &&
                    $mensagem_promocional != ""
                ): ?>
                           <div class="uppercase font-roboto text-xs text-amarelo text-left py-4 ">
                             <?php echo $mensagem_promocional; ?>
                           </div>
                           <?php elseif (
                    isset($mensagem_promo) &&
                    $mensagem_promo != ""
                ): ?>
                           <div class="uppercase font-roboto text-xs text-amarelo text-left py-4 ">
                             <?php echo $mensagem_promo; ?>
                           </div>
                           <?php endif;
            endif; ?>
          </div>
          <?php if ($product->get_type() === "variable") { ?>
            <div class="mt-6 order-4 lg:order-5">
              <?php get_template_part(
                  "woocommerce/single-product/add-to-cart/variations",
                  null,
                  ["is_b2b" => $is_b2b]
              ); ?>
            </div>
          <?php } ?>
          <?php get_template_part(
              "woocommerce/single-product/add-to-cart/colors",
              null,
              ["is_b2b" => $is_b2b]
          ); ?>
          <div class="pt-0 lg:pt-8 order-7 lg:order-7">
            <?php get_template_part(
                "woocommerce/single-product/add-to-cart/descricao-composicao",
                null,
                ["is_b2b" => $is_b2b]
            ); ?>
          </div>
          <div class="pt-8 lg:pt-6 order-8 lg:order-8">
            <?php if ($product->get_type() === "simple") {
                get_template_part(
                    "woocommerce/single-product/add-to-cart/simple",
                    null,
                    ["is_b2b" => $is_b2b]
                );
            } elseif ($product->get_type() === "variable") {
                get_template_part(
                    "woocommerce/single-product/add-to-cart/variable",
                    null,
                    ["is_b2b" => $is_b2b]
                );
            } ?>
          </div>
          <div class="pt-4 lg:pt-8 order-5 lg:order-9">
            <?php get_template_part(
                "woocommerce/single-product/add-to-cart/entregas-devolucoes",
                null,
                ["is_b2b" => $is_b2b]
            ); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-8">
      <ul
        class="border-t border-b border-gray-400 py-3 flex flex-col space-y-2 md:space-y-0 md:flex-row md:justify-around font-roboto uppercase">
        <li class="flex items-center space-x-2">
          <span class="text-xl">
            <?php echo $icons->get_icon("AiFillGift"); ?>
          </span>
          <span class="text-sm">
            Envio grátis em compras superiores a 60€
          </span>
        </li>
        <li class="flex items-center space-x-2">
          <span class="text-xl">
            <?php echo $icons->get_icon("FaShippingFast"); ?>
          </span>
          <span class="text-sm">Envios em 24h rápidos e seguros</span>
        </li>
        <li class="flex items-center space-x-2">
          <span class="text-xl">
            <?php echo $icons->get_icon("RiSecurePaymentFill"); ?>
          </span>
          <span class="text-sm">Pagamentos seguros</span>
        </li>
      </ul>
    </div>
    <?php if ($collection_gallery) { ?>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 relative mt-8">
        <?php if (count($collection_gallery) == 2): ?>
          <?php foreach ($collection_gallery as $key => $item): ?>
            <div class="w-full aspect-[10/15] relative">
              <img src="<?php echo $item; ?>" class="img-fill" alt="<?php echo $product->get_name(); ?>" />
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <?php foreach ($collection_gallery as $key => $item): ?>
            <div
              class="<?php echo $key == 0
                  ? "md:col-span-2 aspect-[1.6/1]"
                  : "col-span-1 aspect-[1/1.6]"; ?> w-full  relative">
              <img src="<?php echo $item; ?>" class="img-fill" alt="<?php echo $product->get_name(); ?>" />
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    <?php } ?>

  </div>
  </div>
</section>

<section class="px-4 md:px-6">
  <?php get_template_part("woocommerce/single-product/related"); ?>
</section>
<?php do_action("woocommerce_after_single_product"); ?>
