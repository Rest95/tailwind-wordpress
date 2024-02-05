<?php
$titulo = get_sub_field("titulo");
$produtos = get_sub_field("produtos");
?>
<section class="px-4 md:px-6">
  <div class="border-b border-gray-400 mb-4"></div>
  <?php if ($titulo): ?>
    <h2 class="uppercase font-roboto text-center text-2xl md:text-4xl font-bold py-4 md:py-8 border-b border-gray-400">
      <?php echo $titulo; ?>
    </h2>
  <?php endif; ?>
  <ul class="grid grid-cols-2 gap-4 lg:gap-16 sm:grid-cols-2 lg:grid-cols-4">
    <?php foreach ($produtos as $key => $item):
      $produto = wc_get_product($item);

      $percentage = 0;
      if ($produto->is_type('simple')) { //if simple produto
        if ($produto->sale_price && $produto->is_on_sale()) {
          $percentage = round(((floatval($produto->regular_price) - floatval($produto->sale_price)) / floatval($produto->regular_price)) * 100);
        }
      } else { //if variable produto
        $percentage = apply_filters('get_variable_sale_percentage', $produto);
      }

      $nome = $produto->get_name();
      $ids_imagens = $produto->get_gallery_image_ids();
      $imagens = [];
      $variations = [];
      $available_variations = $produto->get_available_variations();
      foreach ($available_variations as $variation) {
        foreach ($variation['attributes'] as $key => $attribute) {
          $variation_obj = new WC_Product_variation($variation['variation_id']);
          $order = 0;
          if ($attribute === "xxs") {
            $order = 0;
          }
          if ($attribute === "xs") {
            $order = 10;
          }
          if ($attribute === "s") {
            $order = 20;
          }
          if ($attribute === "m") {
            $order = 30;
          }
          if ($attribute === "l") {
            $order = 40;
          }
          if ($attribute === "xl") {
            $order = 50;
          }
          if ($attribute === "xxl") {
            $order = 60;
          }
          if ($attribute === "3xl") {
            $order = 70;
          }
          if ($attribute === "4xl") {
            $order = 80;
          }
          if ($attribute === "5xl") {
            $order = 90;
          }

          array_push($variations, array('order' => $order, 'name' => $attribute, 'stock' => $variation_obj->get_stock_quantity()));
        }
      }
      asort($variations);

      foreach ($ids_imagens as $key => $id_imagem) {
        array_push($imagens, wp_get_attachment_image_url($id_imagem, "full"));
      }
      ?>
      <li class="relative group">
        <a href="<?php echo get_permalink($produto->get_id()); ?>">
          <div class="relative aspect-productImg w-full  ">
            <?php foreach ($imagens as $key => $imagem): ?>
              <div
                class="bg-white absolute left-1/2 aspect-productImg h-full -translate-x-1/2 <?php echo $key !== 0 ? 'opacity-0 pointer-events-none' : '' ?> transition-all duration-300 group-hover:opacity-100">
                <img src="<?php echo $imagem ?>" alt="<?php echo $nome ?>" class="object-contain" />
              </div>
            <?php endforeach; ?>
            <ul class="hidden lg:flex flex-wrap px-2 gap-2 justify-center items-center absolute bottom-5 w-full">
              <?php foreach ($variations as $key => $variation): ?>
                <li
                  class="font-roboto uppercase text-xs md:text-sm <?php echo $variation['stock'] <= 0 ? 'line-through text-gray-400' : '' ?>">
                  <?php echo $variation['name'] ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="font-roboto">
            <h3 class="text-sm md:text-base uppercase px-2 text-center mb-2 font-roboto">
              <?php echo $nome; ?>
            </h3>
            <?php if ($price_html = $produto->get_price_html()): ?>
              <div class="flex justify-center items-center space-x-2">
                <span class="loop-price text-base uppercase text-center">
                  <?php echo $price_html; ?>
                </span>
                <?php if ($percentage && $percentage > 0) { ?>
                  <div>
                    <span class="bg-amarelo text-white rounded-sm text-sm px-1 py-px sm:px-2 sm:py-1 font-roboto">
                      <?php echo '-' . $percentage ?>%
                    </span>
                  </div>
                <?php } ?>
              </div>
            <?php endif; ?>
          </div>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
  <div class="border-b border-gray-400 mt-4 md:mt-8"></div>
</section>