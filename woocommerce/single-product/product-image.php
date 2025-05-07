<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (!function_exists('wc_get_gallery_image_html')) {
    return;
}
$icons = new Icons();
global $product;

$gallery = $product->get_gallery_image_ids();

$columns = apply_filters('woocommerce_product_thumbnails_columns', 1);
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes = apply_filters(
    'woocommerce_single_product_image_gallery_classes',
    array(
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--' . ($post_thumbnail_id ? 'with-images' : 'without-images'),
    'woocommerce-product-gallery--columns-' . absint(2),
    'images',
    )
);

$gallery_final = array();

foreach ($gallery as $image) {
    $url = wp_get_attachment_image_url($image, 'product_detail');
    $url_full = wp_get_attachment_image_url($image, 'full');
    $item = new \stdClass();
    $item->type = "image";
    $item->url = $url;
    $item->url_full = $url_full;
    array_push($gallery_final, $item);
}


if (count($gallery_final) === 0) {
    $placeholder_image = get_option('woocommerce_placeholder_image', 0);
    $url = wp_get_attachment_image_url($placeholder_image, 'product_detail');
    $url_full = wp_get_attachment_image_url($placeholder_image, 'full');

    $item = new \stdClass();
    $item->type = "image";
    $item->url = $url;
    $item->url_full = $url_full;
    array_push($gallery_final, $item);
}
$video = get_field('video', $product->get_id());
if ($video) {
    $it = new \stdClass();
    $it->type = "video";
    $it->url = $video;
    $a = [$it];
    array_splice($gallery_final, 1, 0, $a);
}

?>

<div class="<?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 md:gap-4 xl:gap-10">
    <?php if (count($gallery_final) >= 1) { ?>
        <?php foreach ($gallery_final as $index => $item_galeria) {
            if ($item_galeria->type === "image") {
                ?>
          <div style="box-shadow: 0 2px 8px 2px rgba(0,0,0,0.017);">
            <div class="woocommerce-product-gallery__trigger cursor-zoom-in aspect-productImg relative trigger-lightbox"
              data-current_index="<?php echo $index + 1 ?>">
              <img loading="lazy" src="<?php echo $item_galeria->url ?>" alt="<?php echo $product->get_name() ?>"
                class="img-fill" width="400" />
            </div>
          </div>
            <?php } else {
                $extension = pathinfo($item_galeria->url, PATHINFO_EXTENSION);
                ?>
          <div style="box-shadow: 0 2px 8px 2px rgba(0,0,0,0.017);">
            <div class="aspect-productImg relative overflow-hidden trigger-lightbox " data-current_index="<?php echo $index + 1 ?>">
              <video data-html5-video muted="true" preload="metadata" playsinline="playsinline"
                alt="<?php echo $product->get_name() ?>" class="video-fill" autoplay loop id="video_player">
                <source src="<?php echo $video;?>" type="video/mp4" />
                <source src="<?php echo $video;?>" type="video/webm" />
              </video>
            </div>
            <script>
             // loadVideoBuffer(document.getElementById("video_player"), '<?php echo $item_galeria->url?>');
            </script>
          </div>
            <?php }
        } ?>
    <?php } ?>
  </div>
  <div id="lightbox" data-current_index="0">
    <div class="fixed top-0 left-0 w-full h-screen bg-white z-[99999]">
      <div class="w-full h-full flex justify-center items-center">
        <div class="p-4 md:p-8  absolute top-4 right-4">
          <button class="self-start flex-none text-black text-xl lg:text-3xl close-lightbox">
            <?php echo $icons->get_icon('Cross') ?>
          </button>
        </div>
        <div class="swiper product-lightbox-images w-full px-8">
          <div class="swiper-wrapper ">
            <?php foreach ($gallery_final as $key => $item_lightbox_gallery) {
                ?>
              <div class="swiper-slide h-[80vh]" data-slide_type="<?php echo $item_lightbox_gallery->type ?>">              <?php if ($item_lightbox_gallery->type === "image") { ?>
                  <img loading="lazy" src="<?php echo $item_lightbox_gallery->url_full ?>"
                    class="w-full h-full object-contain top-0 left-0 absolute" alt="banner <?php echo $key ?>" />
             <?php } else if ($item_lightbox_gallery->type === "video") {
                                                                      $extension = pathinfo($item_lightbox_gallery->url, PATHINFO_EXTENSION);
                                                                        ?>
                    <video id="video-player" class="w-full h-full object-contain top-0 left-0 absolute" data-html5-video
                      muted="true" preload="metadata" playsinline="playsinline" loop>
                <source src="<?php echo $video;?>" type="video/mp4" />
                <source src="<?php echo $video;?>" type="video/webm" />
                    </video>
                    <script>
                    //loadVideoBuffer(document.getElementById("video-player"), '<?php echo $item_lightbox_gallery->url?>');
                    </script>
             <?php } ?>
              </div>
            <?php } ?>
          </div>
          <?php if (count($gallery_final) > 1) { ?>
            <button
              class="swiper-button-prev  opacity-30 text-secondary transition-all duration-300 hover:shadow-btn_hover  hover:opacity-100  rounded-full w-6 h-6 justify-center items-center text-4xl ml-8"
              type="button" aria-label="Previous slide" aria-controls="splide01-track">
              <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" viewBox="0 0 17 17"
                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <g></g>
                <path d="M5.207 8.471l7.146 7.147-0.707 0.707-7.853-7.854 7.854-7.853 0.707 0.707-7.147 7.146z"></path>
              </svg>
            </button>
            <button
              class="swiper-button-next  opacity-30 text-secondary transition-all duration-300 hover:shadow-btn_hover  hover:opacity-100  rounded-full w-6 h-6 justify-center items-center  text-4xl mr-8"
              type="button" aria-label="Next slide" aria-controls="splide01-track">
              <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.1" viewBox="0 0 17 17"
                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <g></g>
                <path d="M13.207 8.472l-7.854 7.854-0.707-0.707 7.146-7.146-7.146-7.148 0.707-0.707 7.854 7.854z"></path>
              </svg>
            </button>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <script>
    // variable 
    let VIDEO_PLAYING_STATE = {
      "PLAYING": "PLAYING",
      "PAUSE": "PAUSE"
    }

    let videoPlayStatus = VIDEO_PLAYING_STATE.PAUSE
    let timeout = null
    let waiting = 3000

    let swiperImages = new Swiper(
      '.product-lightbox-images', {
      loop: <?php echo count($gallery_final) > 1 ? 'true' : 'false' ?>,
      spaceBetween: 32,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });


    let player = document.getElementById('video-player');
    if (player) {

      player.addEventListener('ended', () => {
        next()
      })

      // swiper object
      swiperImages.on('slideChangeTransitionEnd', function () {
        let index = swiperImages.activeIndex
        let currentSlide = swiperImages.slides[index]
        let currentSlideType = currentSlide.dataset.slide_type;

        if (videoPlayStatus === VIDEO_PLAYING_STATE.PLAYING) {
          player.pause()
        }

        clearTimeout(timeout)

        switch (currentSlideType) {
          case 'image':
            runNext()
            break;
          case 'video':
            player.currentTime = 0;
            player.play()
            videoPlayStatus = VIDEO_PLAYING_STATE.PLAYING
            break;
          default:
            throw new Error('invalid slide type');
        }
      })
      function prev() {
        swiperImages.slidePrev();
      }

      function next() {
        swiperImages.slideNext();
      }


      const trigger_lightbox_elems = document.querySelectorAll('.trigger-lightbox');
      if (trigger_lightbox_elems) {
        trigger_lightbox_elems.forEach(it => {
          it.addEventListener('click', function () {
            let index = it.dataset.current_index;
            swiperImages.slideTo(index, 0, false);
            player.currentTime = 0;
            player.play()
            videoPlayStatus = VIDEO_PLAYING_STATE.PLAYING
          })
        })
      }

    }

  </script>
</div>
