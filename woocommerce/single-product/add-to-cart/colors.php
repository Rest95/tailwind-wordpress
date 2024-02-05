<?php
defined('ABSPATH') || exit;

global $product;

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

if (count($colors) > 0) { ?>
  <div class="lg:pt-8 order-5 lg:order-6">
    <div class="mb-12 md:hidden pt-8">
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
                    class="relative aspect-productImg bg-[#efefef]  origin-bottom <?php echo $color->current ? 'border  border-cacaca  scale-100' : 'scale-[0.97]' ?>">
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
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" viewBox="0 0 17 17" height="1em"
              width="1em" xmlns="http://www.w3.org/2000/svg">
              <g></g>
              <path d="M5.207 8.471l7.146 7.147-0.707 0.707-7.853-7.854 7.854-7.853 0.707 0.707-7.147 7.146z">
              </path>
            </svg>
          </button>
          <button
            class="swiper-button-next  opacity-30 text-secondary transition-all duration-300 hover:shadow-btn_hover  hover:opacity-100  rounded-full w-6 h-6 justify-center items-center  text-2xl"
            type="button" aria-label="Next slide" aria-controls="splide01-track">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" viewBox="0 0 17 17" height="1em"
              width="1em" xmlns="http://www.w3.org/2000/svg">
              <g></g>
              <path d="M13.207 8.472l-7.854 7.854-0.707-0.707 7.146-7.146-7.146-7.148 0.707-0.707 7.854 7.854z">
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
  </div>
  <?php
} ?>


<?php if (count($colors) > 0) { ?>
  <div class="lg:pt-8 order-5 lg:order-6">
    <div class="my-6 hidden md:block">
      <div class="swiper swiper_colors">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
          <?php
          foreach ($colors as $color) { ?>
            <div class="swiper-slide flex justify-center items-center flex-col w-[118px]">
              <?php if ($color->url) { ?>
                <a href="<?php echo $color->url ?>" class="z-[2] relative w-full group">
                <?php } ?>
                <div class="w-full">
                  <div
                    class="relative aspect-productImg bg-[#efefef]  origin-bottom <?php echo $color->current ? 'border  border-black  scale-100' : 'border border-cacaca' ?>">
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
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" viewBox="0 0 17 17" height="1em"
              width="1em" xmlns="http://www.w3.org/2000/svg">
              <g></g>
              <path d="M5.207 8.471l7.146 7.147-0.707 0.707-7.853-7.854 7.854-7.853 0.707 0.707-7.147 7.146z">
              </path>
            </svg>
          </button>
          <button
            class="swiper-button-next  opacity-30 text-secondary transition-all duration-300 hover:shadow-btn_hover  hover:opacity-100  rounded-full w-6 h-6 justify-center items-center  text-2xl"
            type="button" aria-label="Next slide" aria-controls="splide01-track">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" viewBox="0 0 17 17" height="1em"
              width="1em" xmlns="http://www.w3.org/2000/svg">
              <g></g>
              <path d="M13.207 8.472l-7.854 7.854-0.707-0.707 7.146-7.146-7.146-7.148 0.707-0.707 7.854 7.854z">
              </path>
            </svg>
          </button>
        <?php } ?>
      </div>
      <script>
        const swiper_colors = new Swiper('.swiper_colors', {
          slidesPerView: 6,
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
              slidesPerView: 6,
            },
            1440: {
              slidesPerView: 5,
            }
          }
        });
      </script>
    </div>
  </div>
  <?php
} ?>