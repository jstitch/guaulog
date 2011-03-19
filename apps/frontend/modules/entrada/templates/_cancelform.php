<?php if (!isset($texto)) $texto = 'Cancelar' ?>

<table class="entrada_form"><tr><td>
  <?php if (isset($entrada)): ?>
    <form action="<?php echo url_for('entrada/show?' . http_build_query(array('mes'=>$entrada->getMes(), 'anio'=>$entrada->getAnio()))) ?>">
  <?php else: ?>
    <form action="<?php echo url_for('@homepage') ?>">
  <?php endif; ?>
      <input type="submit" value="<?php echo $texto ?>" class="showButton" />
    </form>
</td></tr></table>
