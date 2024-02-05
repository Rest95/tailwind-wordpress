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
  $url = wp_get_attachment_image_url($image, 'single');
  $item = new \stdClass();
  $item->type = "image";
  $item->url = $url;
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
<div class="h-full <?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>">
  <div class="swiper product-images-gallery w-full h-full bg-[#efefef]" style="max-width: calc(100vw - 34px)">
    <div class="swiper-wrapper">
      <?php foreach ($gallery_final as $image) { ?>
        <div class="swiper-slide woocommerce-product-gallery__trigger slider-product-image relative"
          data-slide_type="<?php echo $image->type ?>">
          <?php if ($image->type === "image") { ?>
            <img loading="lazy" src="<?php echo $image->url ?>" alt="<?php echo $product->get_name() ?>" width="400"
              class="img-fit" />
          <?php } else if ($image->type === "video") {
            $extension = pathinfo($image->url, PATHINFO_EXTENSION);
            ?>
              <video id="video-player-mobile" width="400" class="img-fill" data-html5-video muted="true" preload="metadata"
                playsinline="playsinline" loop>
                <source src="<?php echo $video; ?>" type="video/mp4" />
                <source src="<?php echo $video; ?>" type="video/webm" />
              </video>
              <script>
                // loadVideoBuffer(document.getElementById("video-player-mobile"), '<?php //echo $image->url ?>');
              </script>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
    <?php if (count($gallery_final) > 1) { ?>
      <button
        class="swiper-button-prev  opacity-80 text-primary transition-all duration-300 hover:shadow-btn_hover  hover:opacity-100  rounded-full w-8 h-8 justify-center items-center"
        type="button" aria-label="Previous slide" aria-controls="splide01-track">
        <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20.4167 10.2083L13.125 17.5L20.4167 24.7917" stroke="#606060" stroke-linecap="round"
            stroke-linejoin="round" />
        </svg>

      </button>
      <button
        class="swiper-button-next  opacity-80 text-primary transition-all duration-300 hover:shadow-btn_hover  hover:opacity-100  rounded-full w-8 h-8 justify-center items-center"
        type="button" aria-label="Next slide" aria-controls="splide01-track">
        <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M14.5833 24.7917L21.875 17.5L14.5833 10.2083" stroke="black" stroke-linecap="round"
            stroke-linejoin="round" />
        </svg>

      </button>
    <?php } ?>
  </div>
</div>

<script>

  // variable 
  let VIDEO_MOBILE_PLAYING_STATE = {
    "PLAYING": "PLAYING",
    "PAUSE": "PAUSE"
  }

  let videoMobilePlayStatus = VIDEO_MOBILE_PLAYING_STATE.PAUSE
  let mobileTimeout = null
  let delay = 3000

  let swiperMobile = new Swiper(
    '.product-images-gallery', {
    loop: <?php echo count($gallery_final) > 1 ? 'true' : 'false' ?>,
    spaceBetween: 32,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });


  let mobilePlayer = document.getElementById('video-player-mobile');
  if (mobilePlayer) {
    mobilePlayer.addEventListener('ended', () => {
      next()
    })

    // swiper object
    swiperMobile.on('slideChangeTransitionEnd', function () {
      let index = swiperMobile.activeIndex
      let currentSlide = swiperMobile.slides[index]
      let currentSlideType = currentSlide.dataset.slide_type;

      if (videoMobilePlayStatus === VIDEO_MOBILE_PLAYING_STATE.PLAYING) {
        mobilePlayer.pause()
      }

      clearTimeout(mobileTimeout)

      switch (currentSlideType) {
        case 'image':
          runNext()
          break;
        case 'video':
          mobilePlayer.currentTime = 0;
          mobilePlayer.play()
          videoMobilePlayStatus = VIDEO_MOBILE_PLAYING_STATE.PLAYING
          break;
        default:
          throw new Error('invalid slide type');
      }
    })

    function prev() {
      swiperMobile.slidePrev();
    }

    function next() {
      swiperMobile.slideNext();
    }

    function runNext() {
      mobileTimeout = setTimeout(function () {
        next()
      }, delay)
    }

    runNext()
  }

</script>