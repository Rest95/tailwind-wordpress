<?php
/**
 * Single variation cart button
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

global $product;

if ($product->is_type('simple')) { //if simple product
    $percentage = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
} else { //if variable product
    $percentage = apply_filters('get_variable_sale_percentage', $product);
}

$mensagem_promo = get_field("mensagem_promo", "option");
$entregas_e_devolucoes_b2c = get_field("entregas_e_devolucoes_b2c", "option");
$apoio_ao_cliente = get_field("apoio_ao_cliente", "option");


$related_colors = $product->get_upsell_ids();
$related_used = array();
$colors = array();

if (count($related_colors) > 0) {
    foreach ($related_colors as $related_color) {
        $related_color_object = wc_get_product($related_color);
        $taxonomy = 'pa_cor';
        $term_names = wp_get_post_terms($related_color_object->get_id(), $taxonomy);

        if (count($term_names) > 0) {
            foreach ($term_names as $term) {
                if (in_array($term->term_id, $related_used)) {
                    continue;
                }
                $attr = new stdClass();
                $attr->name = $term->name;
                $attr->id = $term->term_id;
                $attr->slug = $term->slug;

                $url = wp_get_attachment_image_url($related_color_object->get_image_id(), 'product_detail');
                if ($url) {
                    $attr->img = $url;
                } else {
                    $placeholder_image = get_option('woocommerce_placeholder_image', 0);
                    $attr->img = wp_get_attachment_image_url($placeholder_image, 'product_detail');
                }


                $attr->url = get_permalink($related_color_object->get_id());
                $attr->current = false;
                array_push($colors, $attr);
                array_push($related_used, $term->term_id);
            }
        }
        $prd_term_names = wp_get_post_terms($product->get_id(), $taxonomy);
        if (count($prd_term_names) > 0) {
            foreach ($prd_term_names as $term) {
                if (in_array($term->term_id, $related_used)) {
                    continue;
                }
                $attr = new stdClass();
                $attr->name = $term->name;
                $attr->id = $term->term_id;
                $attr->slug = $term->slug;


                $url = wp_get_attachment_image_url($product->get_image_id(), 'product_detail');
                if ($url) {
                    $attr->img = $url;
                } else {
                    $placeholder_image = get_option('woocommerce_placeholder_image', 0);
                    $attr->img = wp_get_attachment_image_url($placeholder_image, 'product_detail');
                }
                $attr->url = false;
                $attr->current = true;
                array_push($colors, $attr);
                array_push($related_used, $term->term_id);
            }
        }
    }
}

if (count($colors) > 0) {
    usort($colors, fn($a, $b) => strcmp($a->name, $b->name));
}

?>
<div class="woocommerce-variation-add-to-cart variations_button">
    <?php do_action('woocommerce_before_add_to_cart_button'); ?>
    <div class="add_to_cart_with_size">
 <p class="text-left w-full text-txtgray text-xs uppercase tracking-wide pb-4">
                    Tamanho
                </p>
        <div class="tamanhos">
            <div class="tamanhos_select">


                <div class="flex justify-start items-center w-full relative">
                    <div
                        class="variation-alert bg-red-500 rounded-3xl px-2 py-1 text-white min-w-[160px] uppercase text-xs font-roboto absolute -top-[32px] transition-all duration-200 ease-in-out opacity-0 z-10 pointer-events-none">
                        ⚠️ Selecione um tamanho
                    </div>
                    <?php
                    $available_variations = $product->get_available_variations();
                    $tempArray = [];
                    foreach ($available_variations as $variation) {
                        foreach ($variation['attributes'] as $key => $attribute) {
                            $terms = get_terms(array('taxonomy' => str_replace('attribute_', '', $key), 'hide_empty' => false));
                            $attribute_terms[$key] = $terms;
                        }
                    }
                    foreach ($available_variations as $variation) {
                        foreach ($variation['attributes'] as $key => $attribute) {
                            $found_key = array_search($attribute, array_column($attribute_terms[$key], 'slug'));
                            $variation_obj = new WC_Product_variation($variation['variation_id']);
                            $vo = new stdClass();
                            $vo->id = $variation_obj->get_id();
                            $vo->name = $attribute_terms[$key][$found_key]->name;
                            $vo->stock = $variation_obj->get_stock_quantity();
                            $vo->manage_stock = $variation_obj->get_manage_stock();
                            $vo->stock_status = $variation_obj->get_stock_status();
                            $vo->order = $found_key;
                            array_push($tempArray, $vo);
                        }
                    }
                    usort($tempArray, fn($a, $b) => strcmp($a->order, $b->order));
                    ?>
                    <div class="flex gap-1 items-center justify-center flex-wrap relative">
                        <?php foreach ($tempArray as $variation) { ?>
                            <button
                                class="tamanho_option  <?php echo ($variation->stock > 0 || $variation->stock_status === "instock") ? 'btn-quad' : 'btn-quad-disabled'?> "
                                data-value="<?php echo $variation->id ?>" data-name="<?php echo $variation->name ?>"
                                data-stock="<?php echo $variation->stock ?>">
                                <?php echo $variation->name ?></button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
</div>

            <?php if (count($colors) > 0) { ?>
                <div class="mb-12 md:hidden mt-12">
                    <p class="text-left w-full text-txtgray text-xs uppercase tracking-wide pb-4">
                        Cores
                    </p>
                    <div class="swiper swiper_colors_mobile">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <?php
                            foreach ($colors as $color) { ?>
                                <div class="swiper-slide flex justify-center items-center flex-col">
                                    <?php if ($color->url) { ?>
                                        <a href="<?php echo $color->url ?>" class="z-[2] relative w-full group">
                                        <?php } ?>
                                        <div class="w-full">
                                            <div
                                                class="relative aspect-productImg  origin-bottom <?php echo $color->current ? 'border-2   border-gray-400  scale-100' : 'scale-[0.97]' ?>">
                                                <img src="<?php echo $color->img ?>"
                                                    class="img-fill  <?php echo $color->current ? 'opacity-100 ' : 'opacity-70 group-hover:opacity-100 transition-all duration-200' ?>">
                                            </div>
                                            <h3 class="text-left w-full text-txtgray text-[10px] uppercase tracking-wide pt-1">
                                                <?php echo $color->name ?>
                                            </h3>
                                        </div>
                                        <?php if ($color->url) { ?>
                                        </a>
                                    <?php } ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php if (count($colors) >= 5) { ?>
                            <button
                                class="swiper-button-prev  opacity-30 text-secondary transition-all duration-300 hover:shadow-btn_hover  hover:opacity-100  rounded-full w-6 h-6 justify-center items-center text-2xl"
                                type="button" aria-label="Previous slide" aria-controls="splide01-track">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" viewBox="0 0 17 17"
                                    height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <g></g>
                                    <path d="M5.207 8.471l7.146 7.147-0.707 0.707-7.853-7.854 7.854-7.853 0.707 0.707-7.147 7.146z">
                                    </path>
                                </svg>
                            </button>
                            <button
                                class="swiper-button-next  opacity-30 text-secondary transition-all duration-300 hover:shadow-btn_hover  hover:opacity-100  rounded-full w-6 h-6 justify-center items-center  text-2xl"
                                type="button" aria-label="Next slide" aria-controls="splide01-track">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" viewBox="0 0 17 17"
                                    height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <g></g>
                                    <path
                                        d="M13.207 8.472l-7.854 7.854-0.707-0.707 7.146-7.146-7.146-7.148 0.707-0.707 7.854 7.854z">
                                    </path>
                                </svg>
                            </button>
                        <?php } ?>
                    </div>
                    <script>
                        const swiper_colors_mobile = new Swiper('.swiper_colors_mobile', {
                            slidesPerView: 5,
                            spaceBetween: 12,
                            loop: false,
                            resizeObserver: true,
                            navigation: {
                                nextEl: ".swiper-button-next",
                                prevEl: ".swiper-button-prev",
                            },
                            breakpoints: {
                                320: {
                                    slidesPerView: 3.5,
                                },
                                1280: {
                                    slidesPerView: 4,
                                }
                            }
                        });
                    </script>
                </div>
                <?php
                                } ?>

        <?php if (count($colors) > 0) { ?>
            <div class="my-6 hidden md:block">
                <p class="text-left w-full text-txtgray text-xs uppercase tracking-wide pb-4">
                    Cores
                </p>
                <div class="swiper swiper_colors">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($colors as $color) { ?>
                            <div class="swiper-slide flex justify-center items-center flex-col">
                                <?php if ($color->url) { ?>
                                    <a href="<?php echo $color->url ?>" class="z-[2] relative w-full group">
                                    <?php } ?>
                                    <div class="w-full">
                                        <div
                                            class="relative aspect-productImg  origin-bottom <?php echo $color->current ? 'border-2   border-gray-400  scale-100' : 'scale-[0.97]' ?>">
                                            <img src="<?php echo $color->img ?>"
                                                class="img-fill  <?php echo $color->current ? 'opacity-100 ' : 'opacity-70 group-hover:opacity-100 transition-all duration-200' ?>">
                                        </div>
                                        <h3 class="text-left w-full text-txtgray text-[10px] uppercase tracking-wide pt-1">
                                            <?php echo $color->name ?>
                                        </h3>
                                    </div>
                                    <?php if ($color->url) { ?>
                                    </a>
                                <?php } ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php if (count($colors) >= 5) { ?>
                        <button
                            class="swiper-button-prev  opacity-30 text-secondary transition-all duration-300 hover:shadow-btn_hover  hover:opacity-100  rounded-full w-6 h-6 justify-center items-center text-2xl"
                            type="button" aria-label="Previous slide" aria-controls="splide01-track">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" viewBox="0 0 17 17"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <g></g>
                                <path d="M5.207 8.471l7.146 7.147-0.707 0.707-7.853-7.854 7.854-7.853 0.707 0.707-7.147 7.146z">
                                </path>
                            </svg>
                        </button>
                        <button
                            class="swiper-button-next  opacity-30 text-secondary transition-all duration-300 hover:shadow-btn_hover  hover:opacity-100  rounded-full w-6 h-6 justify-center items-center  text-2xl"
                            type="button" aria-label="Next slide" aria-controls="splide01-track">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" viewBox="0 0 17 17"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <g></g>
                                <path d="M13.207 8.472l-7.854 7.854-0.707-0.707 7.146-7.146-7.146-7.148 0.707-0.707 7.854 7.854z">
                                </path>
                            </svg>
                        </button>
                    <?php } ?>
                </div>
                <script>
                    const swiper_colors = new Swiper('.swiper_colors', {
                        slidesPerView: 5,
                        spaceBetween: 12,
                        loop: false,
                        resizeObserver: true,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        breakpoints: {
                            320: {
                                slidesPerView: 2.5,
                            },
                            1280: {
                                slidesPerView: 4,
                            }
                        }
                    });
                </script>
            </div>
            <?php
                        } ?>
              <?php if($product->get_description()) : ?>
                <div class="mb-6 pt-6">
                  <p class="text-left w-full text-txtgray text-xs uppercase tracking-wide pb-2">
                      Descrição do produto
                  </p>
                  <div class="mb-4 text-secondary">
                    <?php echo $product->get_description() ?>
                  </div>
                </div>
              <?php endif; 
$composicao = get_field('composicao', $id); 
?>
 <?php if($composicao) : ?>
                <div>
                  <p class="text-left w-full text-txtgray text-xs uppercase tracking-wide pb-2">
Composição
                  </p>
                  <div class="mb-4 text-secondary">
                    <?php echo $composicao ?>
                  </div>
                </div>
              <?php endif; ?>


                <div class="flex justify-between  pt-6">
                       <button type="submit" class="variation_add_to_cart_button_b2c btn btn-primary alt">Adicionar ao carrinho</button>
        </div>
       <?php if ($percentage && $percentage > 0) : ?>
          <div class="uppercase font-roboto text-xs text-amarelo text-center py-4"><?php echo $mensagem_promo?></div>
        <?php endif; ?>

    </div>
    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
    <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
    <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
    <input type="hidden" name="variation_id" class="variation_id" value="0" />
<?php if($entregas_e_devolucoes_b2c || $apoio_ao_cliente){ ?>
    <div class="mt-8 lg:mt-16">
<?php if($entregas_e_devolucoes_b2c){ ?>
      <div class="grid grid-cols-[24px_auto] gap-2">
        <div>
          <svg width="24" height="16" viewBox="0 0 24 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g opacity="0.7">
              <path d="M2.75 9.5L2 8H7.25L6.65 6.5H1.75L1 5H8.8L8.2 3.5H0.86L0 2H3.75C3.75 1.46957 3.96071 0.960859 4.33579 0.585786C4.71086 0.210714 5.21957 0 5.75 0H17.75V4H20.75L23.75 8V13H21.75C21.75 13.7956 21.4339 14.5587 20.8713 15.1213C20.3087 15.6839 19.5456 16 18.75 16C17.9544 16 17.1913 15.6839 16.6287 15.1213C16.0661 14.5587 15.75 13.7956 15.75 13H11.75C11.75 13.7956 11.4339 14.5587 10.8713 15.1213C10.3087 15.6839 9.54565 16 8.75 16C7.95435 16 7.19129 15.6839 6.62868 15.1213C6.06607 14.5587 5.75 13.7956 5.75 13H3.75V9.5H2.75ZM18.75 14.5C19.1478 14.5 19.5294 14.342 19.8107 14.0607C20.092 13.7794 20.25 13.3978 20.25 13C20.25 12.6022 20.092 12.2206 19.8107 11.9393C19.5294 11.658 19.1478 11.5 18.75 11.5C18.3522 11.5 17.9706 11.658 17.6893 11.9393C17.408 12.2206 17.25 12.6022 17.25 13C17.25 13.3978 17.408 13.7794 17.6893 14.0607C17.9706 14.342 18.3522 14.5 18.75 14.5ZM20.25 5.5H17.75V8H22.21L20.25 5.5ZM8.75 14.5C9.14782 14.5 9.52936 14.342 9.81066 14.0607C10.092 13.7794 10.25 13.3978 10.25 13C10.25 12.6022 10.092 12.2206 9.81066 11.9393C9.52936 11.658 9.14782 11.5 8.75 11.5C8.35218 11.5 7.97064 11.658 7.68934 11.9393C7.40804 12.2206 7.25 12.6022 7.25 13C7.25 13.3978 7.40804 13.7794 7.68934 14.0607C7.97064 14.342 8.35218 14.5 8.75 14.5Z" fill="#767583"/>
            </g>
          </svg>
        </div>
        <div class="">
          <h4 class="text-txtgray uppercase text-xs">Entregas e devoluções grátis</h4>
          <div class="font-medium text-xs text-secondary info_box pt-1 tracking-[0.5px] opacity-70"><?=$entregas_e_devolucoes_b2c?></div>
        <div>
      </div>
    </div>
  </div>
<?php }?>
<?php if($apoio_ao_cliente){ ?>
      <div class="grid grid-cols-[24px_auto] gap-2 pt-8">
        <div>
          <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g opacity="0.7">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0207 16.1381C8.21175 16.1381 6.37396 15.0066 5.30139 13.509C0.155554 13.509 0 21.255 0 21.255H20.0401C20.0401 21.255 20.4441 13.4746 14.6572 13.4746C13.5859 14.9908 11.8296 16.1381 10.0207 16.1381V16.1381Z" fill="#767583"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3308 6.85198C14.3308 9.08061 12.4002 13.3422 10.0167 13.3422C7.63696 13.3422 5.70508 9.07928 5.70508 6.85198C5.70508 4.62468 7.63571 2.81641 10.0167 2.81641C12.4002 2.81773 14.3308 4.626 14.3308 6.85198V6.85198Z" fill="#767583"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M16.2558 4.92871C16.2558 4.51101 15.7039 4.17394 15.0189 4.1713V3.31078C15.0189 3.18256 15.0653 0.180664 10.0324 0.180664C5.00199 0.180664 5.04841 3.18256 5.04841 3.31078V4.2017C5.03586 4.2017 5.02583 4.19774 5.01454 4.19774C4.33336 4.19774 3.78516 4.52952 3.78516 4.94061V8.58096C3.78516 8.98941 4.33461 9.32251 5.01454 9.32251C5.69446 9.32251 6.24642 8.98941 6.24642 8.58096V4.94061C6.24642 4.88377 6.21255 4.83222 6.19248 4.77935V3.78664C6.19248 3.69544 5.8312 1.4298 10.0324 1.4298C14.2349 1.4298 13.7983 3.69544 13.7983 3.78664V4.83222C13.7908 4.86526 13.767 4.89435 13.767 4.92871V8.65234C13.767 9.07136 14.3227 9.41107 15.0114 9.41107C15.0265 9.41107 15.0377 9.40579 15.0528 9.40579V10.766H13.8184V12.0481H16.2684L16.2558 4.92871V4.92871Z" fill="#767583"/>
            </g>
          </svg>
        </div>
        <div class="">
          <h4 class="text-txtgray uppercase text-xs">Apoio ao cliente</h4>
          <div class="font-medium text-xs text-secondary info_box pt-1 tracking-[0.5px] opacity-70"><?= $apoio_ao_cliente ?></div>
        <div>
      </div>
<?php } ?>
  </div>
<?php } ?>
</div>
