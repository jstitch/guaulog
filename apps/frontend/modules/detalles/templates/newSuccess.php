<?php use_stylesheet('detalle.css') ?>

<div class="detalle_form">
NUEVO DETALLE
<br />
<?php echo strtoupper($form->getEntrada()->getNombreMes()) . " " . $form->getEntrada()->getAnio() ?>
<br />
<?php if ($form->getEntrada()->getGuaulogFoto()->getFoto() != null): ?>
  <img src="/uploads/.thumbnails/<?php echo $form->getEntrada()->getGuaulogFoto()->getFoto() ?>" alt="Foto del mes" />
<?php endif ?>
<?php include_partial('form', array('form' => $form/*, 'toindex' => $toindex*/, 'entrada' => $form->getEntrada(), 'textoCancelar' => 'Cancelar')) ?>
<?php /*include_partial('cancelform', array('entrada' => $form->getEntrada()/*, 'toindex' => $toindex*//*))*/ ?>
</div>
