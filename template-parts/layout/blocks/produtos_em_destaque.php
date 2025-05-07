<?php
$titulo = get_sub_field("titulo");
$produtos = get_sub_field("produtos");
?>
<section class="px-4 md:px-6">
  <div class="border-b border-gray-400"></div>
  <?php if ($titulo): ?>
    <h2 class="uppercase font-roboto text-center text-2xl md:text-4xl font-bold py-4 border-b border-gray-400">
      <?php echo $titulo; ?>
    </h2>
  <?php endif; ?>
  <ul class="grid grid-cols-2 lg:grid-cols-4 col-span-2 md:col-span-3 gap-4 lg:gap-6 mt-4 md:mt-8">
    <?php foreach ($produtos as $key => $item):

      setup_postdata($GLOBALS['post'] = &$item); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
      wc_get_template_part('content', 'product');

    endforeach;
    wp_reset_postdata();
    ?>
  </ul>
  <div class="border-b border-gray-400 mt-4 md:mt-8"></div>
</section>