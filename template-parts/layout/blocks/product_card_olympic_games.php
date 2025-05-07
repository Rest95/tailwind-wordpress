<?php $index = $args['index'];

$nome = get_sub_field("nome");
$descricao = get_sub_field("descricao");
$image_front = get_sub_field("image_front");
$image_back = get_sub_field("image_back");
?>
<section class="px-4 md:px-6 ">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 border-t border-t-primary border-opacity-25 py-12 lg:py-8">
    <div class="grid grid-cols-2 gap-4 lg:gap-8 p-4 lg:p-12">
      <div class="relative aspect-[285/329]">
        <img src="<?= $image_front ?>" class="img-fill" alt="<?= $nome ?>" />
      </div>
      <div class="relative aspect-[285/329]">
        <img src="<?= $image_back ?>" class="img-fill" alt="<?= $nome ?>" />
      </div>
    </div>
    <div class="flex flex-col justify-center items-center">
      <div class="max-w-[550px]">
        <h3 class="font-medium text-xl lg:text-2xl text-primary tracking-[0.9px] font-roboto">
          <?= $nome ?>
        </h3>
        <div class="font-garamond text-lg tracking-[0.9px] pt-4">
          <?= $descricao ?>
        </div>
      </div>
    </div>
  </div>
</section>