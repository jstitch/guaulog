<?php use_stylesheet('foto.css') ?>

<div class="foto_form">
NUEVA FOTO
<br />
<?php echo strtoupper($form->getEntrada()->getNombreMes()) . " " . $form->getEntrada()->getAnio() ?>
<?php include_partial('form', array('form' => $form, 'register' => $register/*, 'toindex' => $toindex*/, 'entrada' => $form->getEntrada(), 'textoCancelar' => 'Cancelar')) ?>
</div>
