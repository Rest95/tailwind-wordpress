<?php 
$titulo = get_sub_field("titulo");
$texto = get_sub_field("texto");
$imagem = get_sub_field("imagem");
$full_width = get_sub_field("full-width");
?>
<section class="px-4 md:px-6">
  <?php if($titulo) :?>
  <h1 class="font-roboto text-3xl md:text-5xl font-bold mb-4 md:mb-8 uppercase"><?php echo $titulo ?></h1>
  <?php endif; ?>
  <?php if($imagem) : ?>
  <div class="w-full aspect-[852/1280] md:aspect-[1280/852] max-h-[60vh] md:max-h-[80vh] relative mb-4 md:mb-8">
    <img src="<?php echo $imagem ?>" class="img-fill" alt="<?php echo $titulo ?>"/> 
  </div>
  <?php endif; ?>
  <?php if($texto) : ?>
<div class="font-garamond text-lg <?php $full_width ? '':'max-w-screen-2xl '?> mx-auto columns-1 md:columns-2 gap-8 md:gap-16 xl:gap-32">
        <?php echo $texto ?>
  </div>
  <?php endif; ?>
</section>
