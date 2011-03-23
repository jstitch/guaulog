<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php if (!isset($textoCancelar)) $textoCancelar = 'Cancelar' ?>

<?php if (isset($entrada)): ?>
  <?php echo form_tag_for($form, '@entrada', array('mes'=>$entrada->getMes(), 'anio' => $entrada->getAnio())) ?>
<?php else: ?>
  <?php echo form_tag_for($form, '@entrada') ?>
<?php endif; ?>
  <table class="entrada_form">
    <tfoot>
      <tr>
        <td class="right">
          <input type="submit" value="<?php echo 'OK' ?>" class="showButton" />
          </form>
        </td>
        <td class="left">
          <?php if (isset($entrada)): ?>
            <form action="<?php echo url_for('entrada/show?' . http_build_query(array('mes'=>$entrada->getMes(), 'anio'=>$entrada->getAnio()))) ?>">
          <?php else: ?>
            <form action="<?php echo url_for('@homepage') ?>">
          <?php endif; ?>
              <input type="submit" value="<?php echo $textoCancelar ?>" class="showButton" />
            </form>
        </td>
      </tr>
    </tfoot>

    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
