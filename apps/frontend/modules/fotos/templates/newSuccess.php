<?php use_stylesheet('foto.css') ?>

<div class="foto_form">
NUEVA FOTO
<br />
<?php echo strtoupper($form->getEntrada()->getNombreMes()) . " " . $form->getEntrada()->getAnio() ?>
<?php include_partial('form', array('form' => $form, 'register' => $register/*, 'toindex' => $toindex*/)) ?>
<?php include_partial('cancelform', array('entrada' => $form->getEntrada(), 'register' => $register/*, 'toindex' => $toindex*/)) ?>
</div>
