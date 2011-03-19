<?php use_helper('I18N') ?>

<div class="login">
  <div class="nombre" id="div-nombre">
    <?php echo sfConfig::get('app_nombre') ?>
    <br />
    <img src="/uploads/<?php echo sfConfig::get('app_logo') ?>" alt="logo" />
  </div>
  <br />
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <table class="login">
    <tbody>
      <tr>
        <td colspan="2"><div class="error"><?php echo $form->renderGlobalErrors() ?></div></td>
      </tr>
      <tr>
        <td colspan="2"><div class="error"><?php echo $form['username']->renderError() ?></div></td>
      </tr>
      <tr>
        <th><?php echo $form['username']->renderLabel() ?></th>
        <td><?php echo $form['username'] ?> </td>
      </tr>
      <tr>
        <td colspan="2"><div class="error"><?php echo $form['password']->renderError() ?></div></td>
      </tr>
      <tr>
        <th><?php echo $form['password']->renderLabel() ?></th>
        <td><?php echo $form['password'] ?></td>
      </tr>
      <?php echo $form['_csrf_token'] ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <input type="submit" class="loginButton" value="<?php echo __('OK', null, 'sf_guard') ?>" />
        </td>
      </tr>
    </tfoot>
  </table>
</form>
</div>
