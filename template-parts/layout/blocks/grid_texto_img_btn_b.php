<?php
$items = get_sub_field("items");
$alinhamento_mobile = get_sub_field("alinhamento_mobile");
?>
<section class="px-4 md:px-6">
  <ul
    class="grid <?= ($alinhamento_mobile && $alinhamento_mobile === 'horizontal') ? 'grid-cols-2' : 'grid-cols-1' ?>  md:grid-cols-2 gap-4 md:gap-8">
    <?php foreach ($items as $key => $value): ?>
      <li
        class="relative <?= ($alinhamento_mobile && $alinhamento_mobile === 'horizontal') ? 'aspect-[968/1290]' : 'aspect-[598/518]' ?> md:aspect-[598/518] overflow-hidden flex items-center justify-center">
        <div class="w-full h-full absolute top-0 left-0 ">
          <img src="<?php echo $value['imagem'] ?>" class="img-fill" />
        </div>
        <div class="relative flex flex-col items-center justify-center space-y-4">
          <h3
            class="<?= ($alinhamento_mobile && $alinhamento_mobile === 'horizontal') ? 'text-2xl' : 'text-4xl' ?> text- md:text-6xl xl:text-7xl text-white font-bold font-roboto uppercase">
            <?php echo $value['titulo'] ?>
          </h3>
          <div>
            <a class="<?= ($alinhamento_mobile && $alinhamento_mobile === 'horizontal') ? 'btn-horizontal-layout' : 'btn' ?>  btn-negative"
              href="<?php echo $value['link_btn'] ?>"><?php echo $value['label_btn'] ?></a>
          </div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</section>