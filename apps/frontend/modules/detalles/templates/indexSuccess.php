<?php /*
DETALLES
<table>
  <tr>
    <td>
      Mes
    </td>
    <td>
      <?php echo $entrada->getNombreMes() ?>
    </td>
  </tr>
  <tr>
    <td>
      Año
    </td>
    <td>
      <?php echo $entrada->getAnio() ?>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <?php if (count($entrada->getGuaulogFotos()) > 0): ?>
        <img src="/uploads/.thumbnails/<?php echo $entrada->getGuaulogFotos()->getFirst()->getFoto() ?>" alt="Foto" />
      <?php endif ?>
    </td>
  </tr>
</table>

<?php foreach ($detalles as $detalle): ?>
  <?php echo $detalle->getDetalle() ?> -
  <?php echo link_to('Editar', 'detalles/edit', array('query_string' => http_build_query(array('id' => $detalle->getId(), 'toindex' => $toindex)))) ?> -
  <?php echo link_to('Borrar', 'detalles/delete', array('query_string' => http_build_query(array('id' => $detalle->getId(), 'toindex' => $toindex)), 'confirm' => '¿Estás seguro?')) ?><br />
<?php endforeach ?>
  <?php echo link_to('Agregar', 'detalle_new', array('mes' => $mes, 'anio' => $anio, 'toindex' => $toindex)) ?><br />
<?php echo link_to('Regresar', 'entrada/' . $entrada->getId(), array('post' => false)) ?>
      */
