<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php if (!isset($textoCancelar)) $textoCancelar = 'Cancelar' ?>

<?php if (isset($entrada)): ?>
  <?php echo form_tag_for($form, '@entrada', array('slug'=>$entrada->getSlug())) ?>
<?php else: ?>
  <?php echo form_tag_for($form, '@entrada') ?>
<?php endif; ?>
  <table class="entrada_form">
    <tbody>
     <?php echo $form ?>
      <!--tr>
        <td colspan="2"><div class="error"><?php echo $form->renderGlobalErrors() ?></div></td>
      </tr>
      <tr>
        <td colspan="2"><div class="error"><?php echo $form['mes']->renderError() ?></div></td>
        <td colspan="2"><div class="error"><?php echo $form['anio']->renderError() ?></div></td>
        <td></td>
      </tr>
      <tr>
        <th class="label right"><?php echo $form['mes']->renderLabel() ?></th>
        <td class="field left"><?php echo $form['mes'] ?></td>
      </tr>
      <tr>
        <th class="label right"><?php echo $form['anio']->renderLabel() ?></th>
        <td class="field left"><?php echo $form['anio'] ?></td>
      </tr>
      <tr>
        <th class="label right"><?php echo $form['mide']->renderLabel() ?></th>
        <td class="field left"><?php echo $form['mide'] ?> cm</td>
      </tr>
      <tr>
        <th class="label right"><?php echo $form['pesa']->renderLabel() ?></th>
        <td class="field left"><?php echo $form['pesa'] ?> gr</td>
      </tr>
      <tr>
        <th class="label right"><?php echo $form['pc']->renderLabel() ?></th>
        <td class="field left"><?php echo $form['pc'] ?> cm</td>
        <input type="hidden" name="guaulog_entrada[_csrf_token]" value="<?php /*echo $form->getCSRFToken()*/ ?>" id="guaulog_entrada__csrf_token" /-->
      </tr>
    </tbody>

    <tfoot>
      <tr>
        <td class="right">
          <input type="submit" value="<?php echo 'OK' ?>" class="showButton" />
</form>
        </td>
        <td class="left">
          <?php if (isset($entrada)): ?>
            <form action="<?php echo url_for('@entrada_show?' . 'slug=' . $entrada->getSlug()) ?>">
          <?php else: ?>
            <form action="<?php echo url_for('@homepage') ?>">
          <?php endif; ?>
              <input type="submit" value="<?php echo $textoCancelar ?>" class="showButton" />
            </form>
        </td>
      </tr>
    </tfoot>
  </table>
