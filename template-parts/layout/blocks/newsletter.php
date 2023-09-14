<?php $index = $args['index']; ?>
<div class="max-w-lg mx-auto">
<form class="flex flex-col space-y-6" id="newsletter">
  <div class="max-w-lg flex flex-col space-y-2">
    <div class="flex flex-col space-y-4 lg:space-y-0 lg:grid lg:grid-cols-2 lg:gap-4 ">
      <div class="">
        <label class="text-xs font-medium text-primary">
          Nome *
          <input class="w-full px-4 py-2 tracking-wide border text-sm rounded-none h-12 mt-1"
            name="first_name" type="text" required>
        </label>
      </div>
      <div>
        <label class="text-xs font-medium text-primary">
          Data de Aniversário
          <input class="w-full px-4 py-2 tracking-wide border text-sm rounded-none h-12 mt-1"
            name="birth_date" type="date">
        </label>
      </div>
      <div class="col-span-2">
        <label class="text-xs font-medium text-primary">
          Email *
          <input class="w-full px-4 py-2 tracking-wide border text-sm rounded-none h-12 mt-1"
           name="email" type="email" required>
        </label>
      </div>
      <div class="col-span-2">
        <label class="text-xs font-medium text-txtgray tracking-wider">
          <input type="checkbox" name="accept_terms" required />
          Aceito a <a href="<?php echo get_privacy_policy_url() ?>" class="underline">política de
            privacidade</a>.
        </label>
      </div>
      <div class="flex col-span-2 justify-center">
        <button type="submit" class="btn btn-primary">
          <?php echo __('Subscrever agora', 'theme_tailwind'); ?>
        </button>
      </div>
    </div>
  </div>
  <div id="newsletter_sub_status" class="text-sm">

  </div>
</form>
</div>
