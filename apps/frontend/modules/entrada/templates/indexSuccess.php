<?php use_stylesheet('entrada.css') ?>
<?php GuaulogSetup::generateThumbnails(); ?>

<div class="index">
  <div class="col-izq">
    <div class="foto" id="div-foto">
      <img id="img-foto" src="/uploads/.reduced/<?php echo sfConfig::get('app_portada_fname') . '.' . sfConfig::get('app_portada_thmb_ext') ?>" alt="" />
    </div>

    <div class="botones_control" id="div-botones_control">
      <div class="album" id="div-album">
        <?php echo GuaulogUtil::link_or_button('Album / Calendario', 'entrada', array('class' => 'showButton')) ?>
      </div>

      <div class="control" id="div-control">
        <?php if ($sf_user->isSuperAdmin()): ?>
          <?php echo GuaulogUtil::link_or_button('Usuarios', 'sf_guard_user', array('class' => 'showButton')) ?>
        <?php endif ?>
          <?php echo GuaulogUtil::link_or_button('Salir', 'sf_guard_signout', array('class' => 'showButton')) ?>
      </div>
    </div>
  </div>

  <div class="col-der">
    <div class="botones-ind" id="div-botones">
      <div class="nombre" id="div-nombre">
        <?php echo $nombre ?>
        <br />
        <img src="/uploads/<?php echo $logo ?>" alt="logo" />
      </div>

      <br /><br />

      <?php if ($sf_user->hasCredential('admin')): ?>
        <div class="registrar" id="div-registrar">
          <?php echo GuaulogUtil::link_or_button('Registrar', 'entrada/new', array('class' => 'showButton')) ?>
        </div>
      <?php endif ?>

      <div class="ver" id="div-ver">
        <br />
        <?php try {if ($form->getWidget('mes') != null): ?>
 <?php /*echo form_tag_for($form, '@entrada_index')*/ ?>
 <?php /*echo form_tag_for($form, 'entrada/index')*/ ?>
 <?php echo $form->renderFormTag('entrada/index/') ?>
            <table align="center" id="entrada_form">
              <tr>
                <th class="label"><?php echo $form['mes']->renderLabel() ?></th>
                <td class="field"><?php echo $form['mes'] ?></td>
                <th class="label"><?php echo $form['anio']->renderLabel() ?></th>
                <td class="field"><?php echo $form['anio'] ?></td>
                <td class="submit"><input type="submit" value="Ver" class="showButton" /></td>
              </tr>
              <tr>
                <td colspan="5"><div class="error"><?php echo $form->renderGlobalErrors() ?></div></td>
              </tr>
              <tr>
                <td colspan="2"><div class="error"><?php echo $form['mes']->renderError() ?></div></td>
                <td colspan="2"><div class="error"><?php echo $form['anio']->renderError() ?></div></td>
                <td></td>
              </tr>
            </table>
          </form>
        <?php endif;?>
        <?php } catch(InvalidArgumentException $e) { echo "Aún no hay entradas"; } ?>
        <br />
      </div>
    </div>
  </div>
</div>
