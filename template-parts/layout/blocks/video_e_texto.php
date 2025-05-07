<?php
$titulo = get_sub_field("titulo");
$video = get_sub_field("video");
$video_mobile = get_sub_field("video_mobile");
$label_btn = get_sub_field("label_botao");
$link_btn = get_sub_field("link_botao");
?>
<section class="px-4 md:px-6">
  <div class="aspect-[968/1290] md:aspect-[1280/852] w-full max-h-[90vh] md:max-h-[85vh] relative overflow-hidden">
    <video autoplay loop playsinline muted
      class="w-full h-full object-cover <?= $video_mobile ? 'hidden md:block' : '' ?>">
      <source src="<?php echo $video ?>" type="video/mp4" />
    </video>
    <?php if ($video_mobile): ?>
      <video autoplay loop playsinline muted class="w-full h-full object-cover block md:hidden">
        <source src="<?php echo $video_mobile ?>" type="video/mp4" />
      </video>
    <?php endif; ?>
    <div class="absolute max-w-lg top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
      <?php if ($titulo): ?>
        <h1 class="font-roboto font-bold text-3xl sm:text-4xl md:text-5xl uppercase text-center text-white">
          <?php echo $titulo; ?>
        </h1>
      <?php endif; ?>
      <?php if ($link_btn): ?>
        <a class="btn btn-negative" href="<?php echo $link_btn ?>"><?php echo $label_btn ?></a>
      <?php endif; ?>
    </div>
  </div>
</section>