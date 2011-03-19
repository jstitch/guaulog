<?php use_stylesheet('entrada.css') ?>

<div class="entrada_form">
  <?php include_partial('form', array('form' => $form, 'entrada' => $entrada)) ?>
  <?php include_partial('cancelform', array('entrada' => $entrada, 'texto' => 'Cancelar')) ?>
  <table class="entrada_form"><tr><td>
    <?php echo GuaulogUtil::link_or_button('Borrar',
                                           'entrada/delete',
                                           array('query_string' => http_build_query(array(
											  'mes' => $entrada->getMes(),
											  'anio' => $entrada->getAnio())),
						 'confirm' => '¿Estás seguro?',
						 'class' => 'showButton'
						 )) ?>
    <br />
  </td></tr></table>
</div>
