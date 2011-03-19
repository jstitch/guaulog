<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php if (isset($entrada)): ?>
  <?php echo form_tag_for($form, '@entrada', array('mes'=>$entrada->getMes(), 'anio' => $entrada->getAnio())) ?>
<?php else: ?>
  <?php echo form_tag_for($form, '@entrada') ?>
<?php endif; ?>
  <table class="entrada_form">
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" value="<?php echo 'OK' ?>" class="showButton" />
        </td>
    </tfoot>

    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
</form>
