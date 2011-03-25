<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new GuaulogTestFunctional(new sfBrowser());
$browser->setTester('doctrine', 'sfTesterDoctrine');
$browser->loadData();
//$browser->info('Preparing data files...');
//$browser->prepareFiles();

//shows photos in entry show action
$browser->
  get('/')->
  click('OK', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  get('/')->
  click('Ver', array('guaulog_entrada' => array('mes' => '12',
						'anio' => '2010'
						)))->
  followRedirect()->
  info('1 - The display')->
  with('response')->begin()->
    checkElement('td.foto', 2)->
    checkElement('td.foto:first img[src="/uploads/.thumbnails/diciembre2010.jpg"]', true)->
  end()->

  click('Agregar', array(), array('position' => 1))->
  info('2 - The add')->
  info('  2.1 - Carga la pantalla con los campos limpios')->
  with('request')->begin()->
    isParameter('module', 'fotos')->
    isParameter('action', 'new')->
  end()->
  with('response')->begin()->
    checkElement('div.div_title', true)->
  end()->

  click('Cancelar')->
  info('  2.2 - Cancelar lleva a pantalla show,  sin cambios')->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'show')->
  end()->
  with('response')->begin()->
    checkElement('td.foto', 2)->
    checkElement('td.foto:first img[src="/uploads/.thumbnails/diciembre2010.jpg"]', true)->
  end()->

  click('Agregar', array(), array('position' => 1))->
  info('  2.3 - Errores de validacion si datos en formulario son invalidos')->
  info('      - datos nulos')->
  /* click('OK', array('guaulog_foto' => array('foto' => '')))-> */
  /* with('form')->begin()-> */
  /*   hasErrors(1)-> */
  /*   isError('foto', 'required')-> */
  /* end()-> */
  /* with('response')->begin()-> */
  /*   checkElement('div.flash_error', '/Ocurrio un error al agregar la foto/')-> */
  /* end()-> */

  info('  2.4 - Ok guarda nueva foto en la BD')->
  click('OK', array('guaulog_foto' => array('foto' => sfConfig::get('sf_test_dir').'/fixtures/files/susi_metro.jpg')))->
  with('form')->begin()->
    hasErrors(false)->
  end()->
  with('response')->begin()->
    isRedirected()->
  end()->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'show')->
  end()->
  with('response')->begin()->
//    checkElement('td.foto', 3)->
//    checkElement('td.foto:contains("")', true)->
    checkElement('div.flash_notice', '/Foto agregada correctamente/')->
  end();
$foto_nueva = Doctrine_Core::getTable('GuaulogFoto')->createQuery('f')
  ->whereIn('foto',
	    array('diciembre2010.jpg', 'foto_susi.jpg', 'noviembre2010.jpg',
		  'octubre2010.png', 'julio2010.jpg', 'junio2010.jpg',
		  'foto_susi_dormida.jpg', 'foto_susi_abuelitos.png',
		  'foto_susi_lore.jpg', 'mayo2010.jpg'),
	    true)
  ->fetchOne();
$browser->
  with('doctrine')->begin()->
    check('GuaulogFoto', array('foto' => $foto_nueva->getFoto()), 1)->
  end()->

  click('Cambiar', array(), array('position' => 2))->
  info('3 - The edit')->
  info('  3.1 - Carga la pantalla con los datos a editar')->
  with('request')->begin()->
    isParameter('module', 'fotos')->
    isParameter('action', 'edit')->
  end()->
  with('response')->begin()->
    checkElement('div.div_title', true)->
  end()->

  click('Cancelar')->
  info('  3.2 - Cancelar lleva a pantalla show sin hacer cambios')->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'show')->
  end()->
  with('doctrine')->begin()->
    check('GuaulogFoto', array('foto' => 'foto_susi.jpg'), 1)->
  end()->

 click('Cambiar', array(), array('position' => 2))->
  info('  3.3 - Errores de validacion si datos en formulario son invalidos')->
  info('      - datos nulos')->
  /* click('OK', array('guaulog_foto' => array('foto' => '')))-> */
  /* with('form')->debug()->begin()-> */
  /*   hasErrors(1)-> */
  /*   isError('foto', 'required')-> */
  /* end()-> */
  /* with('response')->begin()-> */
  /*   checkElement('div.flash_error', '/Ocurrio un error al cambiar la foto/')-> */
  /* end()-> */

  info('  3.4 - Ok realiza los cambios en la foto y guarda en la BD')->
  click('OK', array('guaulog_foto' => array('foto' => sfConfig::get('sf_test_dir').'/fixtures/files/RECO0759.jpg')))->
  with('form')->begin()->
    hasErrors(false)->
  end()->
  with('response')->begin()->
    isRedirected()->
  end()->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'show')->
  end()->
  with('response')->begin()->
//    checkElement('td.foto', 3)->
//    checkElement('td.foto:contains("")', true)->
//    checkElement('div.flash_error', '/Foto cambiada correctamente/')->
  end();
$foto_editada = Doctrine_Core::getTable('GuaulogFoto')->createQuery('f')
  ->whereIn('foto',
	    array('diciembre2010.jpg', 'foto_susi.jpg', 'noviembre2010.jpg',
		  'octubre2010.png', 'julio2010.jpg', 'junio2010.jpg',
		  'foto_susi_dormida.jpg', 'foto_susi_abuelitos.png',
		  'foto_susi_lore.jpg', 'mayo2010.jpg', $foto_nueva->getFoto()),
	    true)
  ->fetchOne();
$browser->
  with('doctrine')->begin()->
    check('GuaulogFoto', array('foto' => $foto_editada->getFoto()), 1)->
  end()->

  click('Borrar', array(), array('method' => 'delete', 'position' => 2))->
  info('4 - The delete')->
  info('  4.1 - borra la foto de la BD')->
  with('doctrine')->begin()->
    check('GuaulogFoto', array('foto' => $foto_editada->getFoto()), false)->
  end()->
  with('response')->begin()->
    isRedirected()->
  end()->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'show')->
  end()->
  with('response')->begin()->
    checkElement('td.foto', 2)->
//    checkElement('div.detalle:contains("")', false)->
//    checkElement('div.flash_error', '/Foto eliminada/')->
  end()
;

// new entry gives new foto
$browser->
  info('5 - Entries relation')->
  info('  5.1 - Saving new entry goes to new photo and saves it as default month photo')->
  get('/')->
  click('Registrar')->
  click('OK', array('guaulog_entrada' => array('mes' => '2',
					       'anio' => '2011',
					       'mide' => '3.14',
					       'pesa' => '2.72',
					       'pc' => '1.41'
					       )))->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'fotos')->
    isParameter('action', 'new')->
  end()->
  with('response')->begin()->
    checkElement('div.div_title', true)->
  end()->
  click('OK', array('guaulog_foto' => array('foto' => sfConfig::get('sf_test_dir').'/fixtures/files/RECO0759.jpg')))->
  with('form')->begin()->
    hasErrors(false)->
  end()->
  with('response')->begin()->
    isRedirected()->
  end()->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'show')->
  end()->
  with('response')->begin()->
   checkElement('div.flash_notice', '/Foto agregada correctamente/')->
    checkElement('div.fecha', '/FEBRERO 2011/')->
//    checkElement('div.foto_mes img[alt="Foto del mes"]', true)->
    checkElement('div.medida', '/3.14/')->
    checkElement('div.peso', '/2.72/')->
    checkElement('div.pc', '/1.41/')->
  end();
$foto_nuevaentrada = Doctrine_Core::getTable('GuaulogFoto')->createQuery('f')
  ->whereIn('foto',
	    array('diciembre2010.jpg', 'foto_susi.jpg', 'noviembre2010.jpg',
		  'octubre2010.png', 'julio2010.jpg', 'junio2010.jpg',
		  'foto_susi_dormida.jpg', 'foto_susi_abuelitos.png',
		  'foto_susi_lore.jpg', 'mayo2010.jpg', $foto_nueva->getFoto(),
		  $foto_editada->getFoto()),
	    true)
  ->fetchOne();
$browser->
  with('doctrine')->begin()->
    check('GuaulogFoto', array('foto' => $foto_nuevaentrada->getFoto()), 1)->
  end()->

  info('  5.2 - Deleting entry deletes all photos too')->
  get('/')->
  click('Ver', array('guaulog_entrada' => array('mes' => '2',
						'anio' => '2011'
						)))->
  followRedirect()->
  click('Editar Entrada')->
  click('Borrar', array(), array('method' => 'delete'))->
  info('  5.1 - borra la entrada de la BD')->
  with('doctrine')->begin()->
    check('GuaulogEntrada', array(
				  'mes' => '2',
				  'anio' => '2011'
				  ),
	  false)->
  end()->
  with('doctrine')->begin()->
    check('GuaulogFoto', array('foto' => $foto_nuevaentrada->getFoto()), false)->
  end()
;

$fotos = Doctrine_Core::getTable('GuaulogFoto')->getFotosForEntrada('12', '2010');
$foto = $fotos[0];
$browser->
  info('6 - The security')->
  get('/')->click('Salir')->get('/')->
  click('OK', array('signin' => array('username' => 'user', 'password' => 'user')))->
  get('/')->
  click('Ver', array('guaulog_entrada' => array('mes' => '12',
						'anio' => '2010'
						)))->
  followRedirect()->

  info('  6.1 - Normal user cannot add photo')->
  with('response')->begin()->
    checkElement('td.fotos a.agregar', false)->
  end()->
  get('/foto/new?slug='.$foto->getGuaulogEntrada()->getSlug())->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('  6.2 - Normal user cannot edit photo')->
  with('response')->begin()->
    checkElement('td.fotos div.foto a.editar', false)->
  end()->
  get('/foto/'.$foto->getId().'/edit')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('  6.3 - Normal user cannot delete photo')->
  with('response')->begin()->
    checkElement('td.fotos div.foto a.borrar', false)->
  end()->
  call('/foto/'.$foto->getId(), 'delete')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('  6.4 - Normal user cannot create photo')->
  post('/foto')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('  6.5 - Normal user cannot update photo')->
  call('/foto/'.$foto->getId(), 'put')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  get('/')->click('Salir')->get('/')->

  /* info('  6.6 - Guest user cannot index photos')-> */
  /* get('/detalle/new?mes=12&amp;anio=2010')-> */
  /* with('response')->begin()-> */
  /*   isStatusCode(401)-> */
  /* end()-> */

  info('  6.7 - Guest user cannot add photo')->
  get('/foto/new?slug='.$foto->getGuaulogEntrada()->getSlug())->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  info('  6.8 - Guest user cannot edit photo')->
  get('/foto/'.$foto->getId().'/edit')->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  info('  6.9 - Guest user cannot delete photo')->
  call('/foto/'.$foto->getId(), 'delete')->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  info('  6.10 - Normal user cannot create photo')->
  post('/foto')->
  with('response')->begin()->
//    isStatusCode(401)->
    checkElement('form input[name="signin[username]"]', true)->
    checkElement('form input[name="signin[password]"]', true)->
  end()->

  info('  6.11 - Guest user cannot update photo')->
  call('/foto/'.$foto->getId(), 'put')->
  with('response')->begin()->
    isStatusCode(401)->
  end()
;
