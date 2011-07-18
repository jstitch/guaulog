<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
   <?php if (($sf_request->getParameter('module') != 'entrada' || $sf_request->getParameter('action') != 'index')
            &&
             ($sf_request->getParameter('module') != 'sfGuardAuth' || $sf_request->getParameter('action') != 'signin')): ?>
      <div class="div_title">
        <a href='<?php echo url_for("entrada") ?>'>
          <?php echo sfConfig::get('app_nombre')?> <img id="minilogo" src="/uploads/<?php echo sfConfig::get('app_minilogo') ?>" alt="logo" /></a>
      </div>
    <?php endif ?>
    <?php if ($sf_user->hasFlash('notice')): ?>
      <div class="flash_notice"><?php echo $sf_user->getFlash('notice') ?></div>
    <?php endif ?>
    <?php if ($sf_user->hasFlash('error')): ?>
      <div class="flash_error"><?php echo $sf_user->getFlash('error') ?></div>
    <?php endif ?>
      <div class="content">
        <?php echo $sf_content ?>
      </div>
      <div class="foot">
        <ul>
        <li id="about"><a href="http://guaulog.invernalia.homelinux.net">Guau! Baby Log</a> <img src="/uploads/<?php echo sfConfig::get('app_aboutlogo') ?>" alt="logo" />
        by <a href="http://invernalia.homelinux.net/jstitch">JNC</a></li>
        <li id="source"><a href="http://git.invernalia.homelinux.net/?a=summary&p=guaulog">Source code</a></li>
      </div>
  </body>
</html>

