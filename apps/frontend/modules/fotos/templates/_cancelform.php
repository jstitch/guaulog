<?php if (!isset($texto)) $texto = 'Cancelar' ?>

<table class="foto_form"><tr><td>
<?php /*if (isset($toindex)): ?>
<?php echo button_to($texto, 'foto',
                     array('query_string' =>
			     http_build_query(array(
						    'mes' => $entrada->getMes(),
						    'anio' => $entrada->getAnio(),
						    'toindex' => true
						    )),
			   'post' => false)) ?>
<?php else: */?>
<form action="<?php echo url_for('entrada/show?' . http_build_query(array('mes'=>$entrada->getMes(), 'anio'=>$entrada->getAnio()))) ?>">
  <input type="submit" value="<?php echo $texto ?>" class="showButton" />
</form>
<?php /*endif;*/ ?>
</td></tr></table>
