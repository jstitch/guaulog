<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@detalle') ?>
  <table class="detalle_form">
    <tfoot>
      <tr>
        <td style="text-align:right;">
          <?php /*if (isset($toindex)): ?>
            <input type="hidden" name="toindex" id="toindex" value="<?php echo $toindex ?>" />
	    <?php endif*/ ?>
          <input type="submit" value="<?php echo 'OK' ?>" class="showButton" />
          </form>
        </td>
        <td style="text-align: left;">
          <?php /*if (isset($toindex)): ?>
            <?php echo button_to($texto, 'detalle',
                                 array('query_string' =>
				         http_build_query(array(
					                        'mes' => $entrada->getMes(),
								'anio' => $entrada->getAnio(),
								'toindex' => true
								)),
                                       'post' => false)) ?>
	  <?php else: */?>
            <form action="<?php echo url_for('entrada/show?' . http_build_query(array('mes'=>$entrada->getMes(), 'anio'=>$entrada->getAnio()))) ?>">
              <input type="submit" value="<?php echo $textoCancelar ?>" class="showButton" />
            </form>
          <?php /*endif;*/ ?>
        </td>
      </tr>
    </tfoot>

    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
</form>
