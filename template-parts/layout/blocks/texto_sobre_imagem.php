<?php
$titulo = get_sub_field("titulo");
$imagem = get_sub_field("imagem");
$imagem_mobile = get_sub_field("imagem_de_fundo_mobile");
$label_btn = get_sub_field("label_botao");
$link_btn = get_sub_field("link_botao");
$label_btn_secondario = get_sub_field("label_botao_secundario");
$link_btn_secondario = get_sub_field("link_botao_secundario");
$alinhamento_dos_botoes = get_sub_field("alinhamento_dos_botoes");
$alinhamento_dos_botoes_mobile = get_sub_field("alinhamento_dos_botoes_mobile");
?>

<section class="px-4 md:px-6 relative">
  <div class="relative max-h-[80vh] aspect-[968/1290] md:aspect-[1280/852] w-full flex items-center justify-center">
    <div class="absolute w-full h-full top-0 left-0">
      <img src="<?php echo $imagem; ?>" alt="<?php echo $titulo; ?>"
        class="img-fill <?= $imagem_mobile ? 'hidden md:block' : '' ?>" />
      <?php if ($imagem_mobile): ?>
        <img src="<?php echo $imagem_mobile; ?>" alt="<?php echo $titulo; ?>" class="img-fill block md:hidden" />
      <?php endif; ?>
    </div>
    <div class="relative flex flex-col items-center justify-center space-y-8">
      <?php if ($titulo): ?>
        <h1
          class="text-white text-3xl sm:text-4xl md:text-5xl font-bold uppercase max-w-[300px] md:max-w-[430px] text-center font-roboto">
          <?php echo $titulo; ?>
        </h1>
      <?php endif; ?>
      <div
        class="flex md:hidden gap-4 <?= $alinhamento_dos_botoes_mobile === "horizontal" ? 'flex-row' : 'flex-col items-center' ?>">
        <?php if ($link_btn): ?>
          <a class="btn btn-negative" href="<?php echo $link_btn ?>"><?php echo $label_btn ?></a>
        <?php endif; ?>
        <?php if ($link_btn_secondario): ?>
          <a class="btn btn-negative" href="<?php echo $link_btn_secondario ?>"><?php echo $label_btn_secondario ?></a>
        <?php endif; ?>
      </div>
      <div
        class="hidden md:flex gap-4 <?= $alinhamento_dos_botoes === "horizontal" ? 'flex-row' : 'flex-col items-center' ?>">
        <?php if ($link_btn): ?>
          <a class="btn btn-negative" href="<?php echo $link_btn ?>"><?php echo $label_btn ?></a>
        <?php endif; ?>
        <?php if ($link_btn_secondario): ?>
          <a class="btn btn-negative" href="<?php echo $link_btn_secondario ?>"><?php echo $label_btn_secondario ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>