<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@foto') ?>
  <table class="foto_form">
    <tfoot>
      <tr>
        <td colspan="2">
          <?php /*if (isset($toindex)): ?>
            <input type="hidden" name="toindex" id="toindex" value="<?php echo $toindex ?>" />
          <?php endif*/ ?>
          <?php if (isset($register)): ?>
            <input type="hidden" name="register" id="register" value="<?php echo $register ?>" />
          <?php endif ?>
          <input type="submit" value="<?php echo 'OK' ?>" class="showButton" />
        </td>
    </tfoot>

    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
</form>
