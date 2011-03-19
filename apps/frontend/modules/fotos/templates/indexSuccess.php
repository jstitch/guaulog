<?php /*
FOTOS
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
</table>

<?php foreach ($fotos as $foto): ?>
  <img src="/uploads/.thumbnails/<?php echo $foto->getFoto() ?>" alt="Foto" /> -
  <?php echo link_to('Editar', 'fotos/edit', $array('query_string' => http_build_query(array('id' => $foto->getId(), 'toindex' => $toindex)))) ?> -
  <?php echo link_to('Borrar', 'fotos/delete', array('query_string' => http_build_query(array('id' => $foto->getId(), 'toindex' => $toindex)), 'confirm' => '¿Estás seguro?')) ?><br />
<?php endforeach ?>
<?php echo link_to('Agregar', 'foto_new', array('mes' => $mes, 'anio' => $anio, 'toindex' => $toindex)) ?><br />
<?php echo link_to('Regresar', 'entrada/' . $entrada->getId(), array('post' => false)) ?>
      */