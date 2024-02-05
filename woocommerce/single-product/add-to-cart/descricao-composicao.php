<?php
global $product;
$composicao = get_field('composicao', $product->get_id());
$care = get_field('care', $id);


$careIndex = [
  'A temperatura máxima da água para lavagem da peça é de 40 graus.' => 'cuidados_1.webp',
  'Lavagem à máquina em ciclo delicado com temperatura maxima de 40 graus.' => 'cuidados_2.webp',
  'A temperatura máxima da água para lavagem da peça é de 30 graus.' => 'cuidados_3.webp',
  'Não secar na máquina.' => 'cuidados_4.webp',
  'A peça não suporta branqueamento nem pré-tratamento de nódoas com produtos à base de cloro ou oxigénio. Verifique o rótulo dos produtos de limpeza antes de utilizar.' => 'cuidados_5.webp',
  'Limpeza a seco somente percloroetileno.' => 'cuidados_6.webp',
  'Engomar a média temperatura (até 150 oC).' => 'cuidados_7.webp',
  'Não limpar a seco. Não usar produtos tira-nódoas que contenham solventes.' => 'cuidados_8.webp',
  'Não engomar.' => 'cuidados_9.webp',
  'Lavar à mão.' => 'cuidados_10.webp',
];

?>
<div class="mx-auto max-w-2xl w-full lg:mt-8">
  <ul class="w-full relative">
    <li class="w-full border-b border-gray-400 py-2 px-2 md:px-4">
      <button data-target="acordeao_0_descricao"
        class="btn-acordeao w-full flex justify-between items-center font-roboto uppercase text-sm lg:text-xl py-2">
        Descrição do Produto
        <div class="is_open hidden">
          <img width="15" src="<?php echo get_theme_file_uri('/assets/images/minus.webp') ?>" />
        </div>
        <div class="is_close">
          <img width="15" src="<?php echo get_theme_file_uri('/assets/images/add.webp') ?>" />
        </div>
      </button>
      <div id="acordeao_0_descricao" class="transition-all duration-300 font-garamond h-0 overflow-hidden">
        <?php echo $product->get_description(); ?>
      </div>
    </li>
    <li class="w-full border-b border-gray-400 py-2 px-2 md:px-4">
      <button data-target="acordeao_1_cuidados"
        class="btn-acordeao w-full flex justify-between items-center font-roboto uppercase text-sm lg:text-xl py-2">
        Cuidados
        <div class="is_open hidden">
          <img width="15" src="<?php echo get_theme_file_uri('/assets/images/minus.webp') ?>" />
        </div>
        <div class="is_close">
          <img width="15" src="<?php echo get_theme_file_uri('/assets/images/add.webp') ?>" />
        </div>
      </button>
      <div id="acordeao_1_cuidados" class="transition-all duration-300 font-garamond h-0 overflow-hidden">
        <?php if ($care) { ?>
          <ul class="grid grid-cols-1 gap-2 pt-4">
            <?php foreach ($care as $careItem) { ?>
              <li class="flex items-start space-x-4 justify-start">
                <div class="relative w-6 h-6 flex-none">
                  <img width="24" src="<?php echo get_theme_file_uri('/assets/images/' . $careIndex[$careItem]) ?>" />
                </div>

                <span
                  class="font-garamond text-sm border-b border-b-transparent mb-2 font-light transition-all duration-200 leading-loose relative">
                  <?php echo $careItem ?>
                </span>
              </li>
            <?php } ?>
          </ul>
        <?php } ?>
      </div>
    </li>
  </ul>
</div>