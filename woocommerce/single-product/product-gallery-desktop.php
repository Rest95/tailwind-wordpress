<?php
global $product;
$icons = new Icons();
$gallery = $product->get_gallery_image_ids();
$gallery_final = array();

$video = get_field('video', $product->get_id());
if ($video) {
  $it = new \stdClass();
  $it->type = "video";
  $it->url = $video;
  $a = [$it];
  // array_splice($gallery_final, 1, 0, $a);
  array_push($gallery_final, $it);
}
foreach ($gallery as $image) {
  $url = wp_get_attachment_image_url($image, 'product_detail');
  $url_full = wp_get_attachment_image_url($image, 'full');
  $item = new \stdClass();
  $item->type = "image";
  $item->url = $url;
  $item->url_full = $url_full;
  array_push($gallery_final, $item);
}
?>
<div class="relative aspect-[720/860] flex items-center h-full ">
  <div class="swiper swipper-vertical w-full h-full">
    <div class="swiper-wrapper ">
      <?php foreach ($gallery_final as $key => $gallery_item) { ?>
        <div class="swiper-slide h-full trigger-lightbox" data-current_index="<?php echo $key ?>" data-slide_type="
          <?php echo $gallery_item->type ?>">
          <?php if ($gallery_item->type === "image") { ?>
            <img loading="lazy" src="<?php echo $gallery_item->url_full ?>"
              class="w-full h-full object-contain top-0 left-0 absolute" alt="banner <?php echo $key ?>" />
          <?php } else if ($gallery_item->type === "video") {
            $extension = pathinfo($gallery_item->url, PATHINFO_EXTENSION);
            ?>
              <video class="w-full h-full object-cover top-0 left-0 absolute" data-html5-video muted="true" preload="metadata"
                playsinline="playsinline" loop autoplay>
                <source src="<?php echo $gallery_item->url; ?>" type="video/mp4" />
                <source src="<?php echo $gallery_item->url; ?>" type="video/webm" />
              </video>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>
  <div class="absolute left-12 h-[395px]">
    <div thumbsSlider="" class="swiper thumbsSwipper h-full">
      <div class="swiper-wrapper">
        <?php foreach ($gallery_final as $key => $gallery_item) { ?>
          <div class="swiper-slide w-16 border border-black bg-white" data-slide_type="<?php echo $gallery_item->type ?>">
            <?php if ($gallery_item->type === "image") { ?>
              <img loading="lazy" src="<?php echo $gallery_item->url_full ?>"
                class="w-full h-full object-contain top-0 left-0 absolute" alt="banner <?php echo $key ?>" />
            <?php } else if ($gallery_item->type === "video") {
              $extension = pathinfo($gallery_item->url, PATHINFO_EXTENSION);
              ?>
                <div class="h-full relative">
                  <div class="bg-cacaca flex justify-center items-center h-full absolute w-full z-[1]">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <g clip-path="url(#clip0_226_458)">
                        <path
                          d="M16 0C20.2435 0 24.3131 1.68571 27.3137 4.68629C30.3143 7.68687 32 11.7565 32 16C32 20.2435 30.3143 24.3131 27.3137 27.3137C24.3131 30.3143 20.2435 32 16 32C11.7565 32 7.68687 30.3143 4.68629 27.3137C1.68571 24.3131 0 20.2435 0 16C0 11.7565 1.68571 7.68687 4.68629 4.68629C7.68687 1.68571 11.7565 0 16 0ZM3 16C3 19.4478 4.36964 22.7544 6.80761 25.1924C9.24558 27.6304 12.5522 29 16 29C19.4478 29 22.7544 27.6304 25.1924 25.1924C27.6304 22.7544 29 19.4478 29 16C29 12.5522 27.6304 9.24558 25.1924 6.80761C22.7544 4.36964 19.4478 3 16 3C12.5522 3 9.24558 4.36964 6.80761 6.80761C4.36964 9.24558 3 12.5522 3 16ZM12.758 10.454L21.286 15.572C21.3597 15.6165 21.4207 15.6793 21.463 15.7543C21.5053 15.8293 21.5275 15.9139 21.5275 16C21.5275 16.0861 21.5053 16.1707 21.463 16.2457C21.4207 16.3207 21.3597 16.3835 21.286 16.428L12.758 21.546C12.6822 21.5917 12.5956 21.6164 12.507 21.6177C12.4185 21.6189 12.3313 21.5966 12.2542 21.5531C12.1771 21.5096 12.1129 21.4464 12.0683 21.3699C12.0236 21.2935 12.0001 21.2065 12 21.118V10.884C11.9997 10.7953 12.023 10.7081 12.0675 10.6314C12.112 10.5547 12.1761 10.4912 12.2533 10.4474C12.3304 10.4036 12.4178 10.3812 12.5065 10.3823C12.5952 10.3835 12.682 10.4082 12.758 10.454Z"
                          fill="white" />
                      </g>
                      <defs>
                        <clipPath id="clip0_226_458">
                          <rect width="32" height="32" fill="white" />
                        </clipPath>
                      </defs>
                    </svg>
                  </div>
                </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>
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
              <div class="swiper-slide h-[80vh] flex justify-center items-center"
                data-slide_type="<?php echo $item_lightbox_gallery->type ?>">
                <?php if ($item_lightbox_gallery->type === "image") { ?>
                  <figure class="zoom" onmousemove="zoom(event)" onmouseleave="mouseleave(event)"
                    style="background-image: url(<?php echo $item_lightbox_gallery->url_full ?>)">
                    <img class="w-full h-full object-contain" src="<?php echo $item_lightbox_gallery->url_full ?>" />
                  </figure>
                <?php } else if ($item_lightbox_gallery->type === "video") {
                  $extension = pathinfo($item_lightbox_gallery->url, PATHINFO_EXTENSION);
                  ?>
                    <video id="video-player" class="w-full h-full object-contain top-0 left-0 absolute" data-html5-video
                      muted="true" preload="metadata" playsinline="playsinline" loop>
                      <source src="<?php echo $video; ?>" type="video/mp4" />
                      <source src="<?php echo $video; ?>" type="video/webm" />
                    </video>
                    <script>
                      //loadVideoBuffer(document.getElementById("video-player"), '<?php echo $item_lightbox_gallery->url ?>');
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
    let swiper = new Swiper(".thumbsSwipper", {
      spaceBetween: 10,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
      direction: "vertical",
    });

    let swiper2 = new Swiper(".swipper-vertical", {
      direction: "vertical",
      thumbs: {
        swiper: swiper,
      },
    });

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
      loop: false,
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

    function mouseleave(e) {
      var zoomer = e.currentTarget;
      zoomer.style.backgroundSize = "0%";
    }
    function zoom(e) {
      var zoomer = e.currentTarget;
      zoomer.style.backgroundSize = "340%";
      zoomer.style.width = "60%";
      e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
      e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
      x = offsetX / zoomer.offsetWidth * 100
      y = offsetY / zoomer.offsetHeight * 100
      zoomer.style.backgroundPosition = x + '% ' + y + '%';
    }
  </script>
</div>