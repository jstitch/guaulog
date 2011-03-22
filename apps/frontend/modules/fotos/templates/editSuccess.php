<?php use_stylesheet('foto.css') ?>

<div class="foto_form">
EDITAR FOTO
<br />
<?php echo strtoupper($form->getEntrada()->getNombreMes()) . " " . $form->getEntrada()->getAnio() ?>
<br />
<img src="/uploads/.thumbnails/<?php echo $foto->getFoto() ?>" alt="Foto" />
<?php include_partial('form', array('form' => $form/*, 'toindex' => $toindex*/, 'entrada' => $form->getEntrada(), 'textoCancelar' => 'Cancelar')) ?>
<?php /*include_partial('cancelform', array('entrada' => $form->getEntrada()/*, 'toindex' => $toindex*//*))*/ ?>
</div>
