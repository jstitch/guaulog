<?php use_stylesheet('entrada.css') ?>

<div class="top">
  <div class="nav-prev">
  <?php if ($entrada->hasAnterior()): ?>
    <?php echo GuaulogUtil::link_or_button('Anterior',
                                           '@entrada_show?' . http_build_query(array('slug' => $entrada->getAnterior()->getSlug())),
                                           array(
						 'id' => 'Anterior',
						 'class' => 'showButton')) ?>
  <?php endif ?>
  </div>
  <div class="nav-sig">
  <?php if ($entrada->hasSiguiente()): ?>
    <?php echo GuaulogUtil::link_or_button('Siguiente',
                                           '@entrada_show?' . http_build_query(array('slug' => $entrada->getSiguiente()->getSlug())),
                                           array(
						 'id' => 'Siguiente',
						 'class' => 'showButton')) ?>
  <?php endif ?>
  </div>
</div>

<div class="info">
  <div class="foto_mes">
    <?php if ($entrada->getGuaulogFoto()->getFoto() != null): ?>
      <img src="/uploads/.reduced/<?php echo $entrada->getGuaulogFoto()->getFoto() ?>" alt="Foto del mes" />
    <?php else: ?>
      No hay foto seleccionada para este mes.
    <?php endif ?>
  </div>

  <div class="entrada">
    <div class="fecha">
      <?php echo strtoupper($entrada->getNombreMes()) ?> <?php echo $entrada->getAnio() ?>
    </div>
    <div class="data">
      <div class="medida">
        Midió: <?php echo $entrada->getMide() ?>
      </div>
      <div class="peso">
        Pesó: <?php echo $entrada->getPesa() ?>
      </div>
      <div class="pc">
        P.C.: <?php echo $entrada->getPc() ?>
      </div>
    </div>

    <div class="botones-show detailButton">
      <div class="salir">
        <?php echo GuaulogUtil::link_or_button('Inicio', '@entrada', array('class' => 'showButton')) ?>
      </div>
      <?php if ($sf_user->hasCredential('admin')): ?>
        <div class="editar">
          <?php echo GuaulogUtil::link_or_button('Editar Entrada',
                                                 '@entrada_edit?' . 'slug=' . $entrada->getSlug(),
                                                 array(
						       'class' => 'editar showButton'
						       )) ?>
        </div>
      <?php endif ?>
    </div>
  </div>
</div>

<div class="fotos">
  <table>
    <tr>
      <?php $i = 0; foreach ($entrada->getGuaulogFotos() as $foto): ?>
        <?php if ($i % 7 == 0) { echo "</tr><tr>"; } ?>
        <td class="foto" id="foto_<?php echo $foto->getId() ?>">
          <span class="imgalt"><img id="img_<?php echo $foto->getId() ?>" src="/uploads/.thumbnails/<?php echo $foto->getFoto() ?>" alt="Miniatura de la foto" /></span>
          <br />
          <?php if ($sf_user->hasCredential('admin')): ?>
            <?php echo GuaulogUtil::link_or_button('Cambiar',
                                                   '@foto_edit?' . http_build_query(array('id' => $foto->getId())),
                                                   array(
							 'class' => 'detailButton editar',
							 'id' => 'foto_edit_' . $foto->getId()
							 )) ?>
          <?php endif ?>
          <br />
          <?php if ($sf_user->hasCredential('admin')): ?>
            <?php if (sfConfig::get('app_use_buttons')): ?>
              <form action="<?php echo url_for('@foto_delete?' . 'id=' . $foto->getId()) ?>" method="post" >
                <input type="hidden" name="sf_method" id="foto_delete_<?php echo $foto->getId() ?>" value="delete" />
                <input class="detailButton borrar" type="submit" value="Borrar" onclick="if (confirm('¿Estás seguro?')) { } else return false;" />
              </form>
            <?php else: ?>
              <?php echo GuaulogUtil::link_or_button('Borrar',
                                                     '@foto_delete?' . 'id=' . $foto->getId(),
                                                     array(
							   'confirm' => '¿Estás seguro?',
							   'method' => 'delete',
							   'class' => 'detailButton borrar',
							   'id' => 'foto_delete_' . $foto->getId()
							   )) ?>
            <?php endif ?>
          <?php endif ?>
        </td>
        <?php $i++ ?>
      <?php endforeach ?>
    </tr>
  </table>
  <?php if ($sf_user->hasCredential('admin')): ?>
    <?php echo GuaulogUtil::link_or_button('Agregar',
                                           '@foto_new',
                                           array(
						 'query_string' => http_build_query(array('entrada' => $entrada->getSlug())),
						 'class' => 'detailButton agregar',
						 'id' => 'foto_new'
						 )) ?>
  <?php endif ?>
  <?php /*echo link_to('Fotos', 'foto',
                       array('mes' => $entrada->getMes(),
		             'anio' => $entrada->getAnio(),
			     'toindex' => true
			    ))*/ ?>
</div>

<div class="detalles">
  <?php foreach ($entrada->getGuaulogDetalles() as $detalle): ?>
    <div class="detalle" id="detalle_<?php echo $detalle->getId()?>">
      <span class="texto" id="texto_<?php echo $detalle->getId()?>"><?php echo $detalle->getDetalle() ?></span>
      <br />
      <?php if ($sf_user->hasCredential('admin')): ?>
        <?php echo GuaulogUtil::link_or_button('Editar',
                                               '@detalle_edit?' . http_build_query(array('id' => $detalle->getId())),
                                               array(
						     'class' => 'detailButton editar',
						     'id' => 'detalle_edit_' . $detalle->getId()
						     )) ?>
      <?php endif ?>
      <span class="detailButton">-</span>
      <?php if ($sf_user->hasCredential('admin')): ?>
        <?php if (sfConfig::get('app_use_buttons')): ?>
          <form action="<?php echo url_for('@detalle_delete?' . 'id=' . $detalle->getId()) ?>" method="post" >
            <input type="hidden" name="sf_method" id="detalle_delete_<?php echo $detalle->getId() ?>" value="delete" />
            <input class="detailButton borrar" type="submit" value="Borrar" onclick="if (confirm('¿Estás seguro?')) { } else return false;" />
          </form>
        <?php else: ?>
          <?php echo GuaulogUtil::link_or_button('Borrar',
                                                 '@detalle_delete?' . 'id=' . $detalle->getId(),
                                                 array(
						       'confirm' => '¿Estás seguro?',
						       'method' => 'delete',
						       'class' => 'detailButton borrar',
						       'id' => 'detalle_delete_' . $detalle->getId()
						       )) ?>
        <?php endif ?>
      <?php endif ?>
      <hr />
    </div>
  <?php endforeach ?>
  <?php if ($sf_user->hasCredential('admin')): ?>
    <?php echo GuaulogUtil::link_or_button('Agregar',
                                           '@detalle_new',
                                           array(
						 'query_string' => http_build_query(array('entrada' => $entrada->getSlug())),
						 'class' => 'detailButton agregar',
						 'id' => 'detalle_new'
						 )) ?>
  <?php endif ?>
  <?php /*echo link_to('Detalles', 'detalle',
                       array('mes' => $entrada->getMes(),
		             'anio' => $entrada->getAnio(),
			     'toindex' => true
			    ))*/ ?>
