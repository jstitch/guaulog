<?php use_stylesheet('entrada.css') ?>

<div class="entrada_form">
  <?php include_partial('form', array('form' => $form, 'entrada' => $entrada, 'textoCancelar' => 'Cancelar')) ?>
  <table class="entrada_form"><tr><td>
    <?php if (sfConfig::get('app_use_buttons')): ?>
      <form action="<?php echo url_for('@entrada_delete?' . 'slug=' . $entrada->getSlug()) ?>" method="post" >
        <input type="hidden" name="sf_method" value="delete" />
        <input class="showButton" type="submit" value="Borrar" onclick="if (confirm('¿Estás seguro?')) { } else return false;" />
      </form>
    <?php else: ?>
      <?php echo GuaulogUtil::link_or_button('Borrar',
                                             '@entrada_delete?' . 'slug=' . $entrada->getSlug(),
                                             array(
						   'confirm' => '¿Estás seguro?',
						   'method' => 'delete',
						   'class' => 'showButton'
						   )) ?>
    <?php endif ?>
  </td></tr></table>
</div>
