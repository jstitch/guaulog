<?php use_stylesheet('entrada.css') ?>

<div class="top">
  <div class="nav-prev">
  <?php if ($entrada->hasAnterior()): ?>
    <?php echo GuaulogUtil::link_or_button('Anterior',
                                           'entrada/show?' .http_build_query(array(
										   'mes' => $entrada->getAnterior()->getMes(),
										   'anio' => $entrada->getAnterior()->getAnio())),
                                           array(
						 'id' => 'Anterior',
						 'class' => 'showButton')) ?>
  <?php endif ?>
  </div>
  <div class="nav-sig">
  <?php if ($entrada->hasSiguiente()): ?>
    <?php echo GuaulogUtil::link_or_button('Siguiente',
                                           'entrada/show?' . http_build_query(array(
										    'mes' => $entrada->getSiguiente()->getMes(),
										    'anio' => $entrada->getSiguiente()->getAnio())),
                                           array('id' => 'Siguiente',
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
        <?php echo GuaulogUtil::link_or_button('Inicio', '@homepage', array('class' => 'showButton')) ?>
      </div>
      <?php if ($sf_user->hasCredential('admin')): ?>
        <div class="editar">
          <?php echo GuaulogUtil::link_or_button('Editar Entrada',
                                                 'entrada/edit',
                                                 array('query_string' => http_build_query(array('mes' => $entrada->getMes(),
												'anio' => $entrada->getAnio())),
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
          <span><img src="/uploads/.thumbnails/<?php echo $foto->getFoto() ?>" alt="Miniatura de la foto" /></span>
          <br />
          <?php if ($sf_user->hasCredential('admin')): ?>
            <?php echo GuaulogUtil::link_or_button('Cambiar',
                                                   'fotos/edit',
                                                   array('query_string' => http_build_query(array('id' => $foto->getId(),
												  'mes' => $entrada->getMes(),
												  'anio' => $entrada->getAnio())),
							 'class' => 'detailButton editar',
							 'id' => 'foto_'.$foto->getId()
							 )) ?>
          <?php endif ?>
          <br />
          <?php if ($sf_user->hasCredential('admin')): ?>
            <?php echo GuaulogUtil::link_or_button('Borrar',
                                                   'fotos/delete',
                                                   array('query_string' => http_build_query(array('id' => $foto->getId(),
												  'mes' => $entrada->getMes(),
												  'anio' => $entrada->getAnio())),
							 'confirm' => '¿Estás seguro?',
							 'class' => 'detailButton borrar',
							 'id' => 'foto_'.$foto->getId()
							 )) ?>
          <?php endif ?>
        </td>
        <?php $i++ ?>
      <?php endforeach ?>
    </tr>
  </table>
  <?php if ($sf_user->hasCredential('admin')): ?>
    <?php echo GuaulogUtil::link_or_button('Agregar',
                                           'foto/new',
                                           array('query_string' => http_build_query(array('mes' => $entrada->getMes(),
											  'anio' => $entrada->getAnio())),
						 'class' => 'detailButton agregar',
						 'id' => 'foto'
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
                                               'detalles/edit',
                                               array('query_string' => http_build_query(array('id' => $detalle->getId(),
											      'mes' => $entrada->getMes(),
											      'anio' => $entrada->getAnio())),
						     'class' => 'detailButton editar',
						     'id' => 'detalle_'.$detalle->getId()
						     )) ?>
      <?php endif ?>
      <span class="detailButton">-</span>
      <?php if ($sf_user->hasCredential('admin')): ?>
        <?php echo GuaulogUtil::link_or_button('Borrar',
                                               'detalles/delete',
                                               array('query_string' => http_build_query(array('id' =>$detalle->getId(),
											      'mes' => $entrada->getMes(),
											      'anio' => $entrada->getAnio())),
						     'confirm' => '¿Estás seguro?',
						     'class' => 'detailButton borrar',
						     'id' => 'detalle_'.$detalle->getId()
						     )) ?>
      <?php endif ?>
      <hr />
    </div>
  <?php endforeach ?>
  <?php if ($sf_user->hasCredential('admin')): ?>
    <?php echo GuaulogUtil::link_or_button('Agregar',
                                           'detalle/new',
                                           array('query_string' => http_build_query(array('mes' => $entrada->getMes(),
											  'anio' => $entrada->getAnio())),
						 'class' => 'detailButton agregar',
						 'id' => 'detalle'
						 )) ?>
  <?php endif ?>
  <?php /*echo link_to('Detalles', 'detalle',
                       array('mes' => $entrada->getMes(),
		             'anio' => $entrada->getAnio(),
			     'toindex' => true
			    ))*/ ?>
