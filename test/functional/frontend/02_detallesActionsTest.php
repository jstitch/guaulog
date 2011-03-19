<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new GuaulogTestFunctional(new sfBrowser());
$browser->setTester('doctrine', 'sfTesterDoctrine');
$browser->loadData();

//shows details in entry show action
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
    checkElement('div.detalle', 2)->
    checkElement('div.detalle:first span', '/detalle de diciembre 2010/')->
  end()->

  click('Editar', array(), array('position' => 1))->
  info('2 - The edit')->
  info('  2.1 - Carga la pantalla con los datos a editar')->
  with('request')->begin()->
    isParameter('module', 'detalles')->
    isParameter('action', 'edit')->
  end()->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('div.div_title', true)->
    checkElement('textarea', '/detalle de diciembre 2010/')->
  end()->

  click('Cancelar')->
  info('  2.2 - Cancelar lleva a pantalla show sin hacer cambios')->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'show')->
  end()->
  with('doctrine')->begin()->
    check('GuaulogDetalle', array('detalle' => 'detalle de diciembre 2010'), 1)->
  end()->

  click('Editar', array(), array('position' => 1))->
  info('  2.3 - Errores de validacion si datos en formulario son invalidos')->
  info('      - datos nulos')->
  click('OK', array('guaulog_detalle' => array('detalle' => '')))->
  with('form')->begin()->
    hasErrors(1)->
    isError('detalle', 'required')->
  end()->
  with('response')->begin()->
    checkElement('div.flash_error', '/Ocurrio un error al editar el detalle/')->
  end()->
  info('  2.4 - Errores de validacion si datos en formulario son invalidos')->
  info('      - datos excesivamente largos')->
  click('OK', array('guaulog_detalle' => array('detalle' => '12345678901234567890123456789012345678901234567890'.
					       '12345678901234567890123456789012345678901234567890'.
					       '12345678901234567890123456789012345678901234567890'.
					       '12345678901234567890123456789012345678901234567890'.
					       '12345678901234567890123456789012345678901234567890'.
					       '123456')))->
  with('form')->begin()->
    hasErrors(1)->
    isError('detalle', 'max_length')->
  end()->
  with('response')->begin()->
    checkElement('div.flash_error', '/Ocurrio un error al editar el detalle/')->
  end()->

  info('  2.5 - Ok realiza los cambios en el detalle y guarda en la BD')->
  click('OK', array('guaulog_detalle' => array('detalle' => 'prueba de edicion de detalle')))->
  with('form')->begin()->
    hasErrors(false)->
  end()->
  with('doctrine')->begin()->
    check('GuaulogDetalle', array('detalle' => 'prueba de edicion de detalle'), 1)->
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
    checkElement('div.detalle:contains("prueba de edicion de detalle")', true)->
    checkElement('div.flash_notice', '/Detalle editado correctamente/')->
  end()->

  click('Agregar', array(), array('position' => 2))->
  info('3 - The add')->
  info('  3.1 - Carga la pantalla con los campos limpios')->
  with('request')->begin()->
    isParameter('module', 'detalles')->
    isParameter('action', 'new')->
  end()->
  with('response')->begin()->
    checkElement('div.div_title', true)->
  end()->

  click('Cancelar')->
  info('  3.2 - Cancelar lleva a pantalla show,  sin cambios')->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'show')->
  end()->
  with('response')->begin()->
    checkElement('div.detalle', 2)->
  end()->

  click('Agregar', array(), array('position' => 2))->
  info('  3.3 - Errores de validacion si datos en formulario son invalidos')->
  info('      - datos nulos')->
  click('OK', array('guaulog_detalle' => array('detalle' => '')))->

  with('form')->begin()->
    hasErrors(1)->
    isError('detalle', 'required')->
  end()->
  with('response')->begin()->
    checkElement('div.flash_error', '/Ocurrio un error al crear el detalle/')->
  end()->
  info('  3.4 - Errores de validacion si datos en formulario son invalidos')->
  info('      - datos excesivamente largos')->
  click('OK', array('guaulog_detalle' => array('detalle' => '12345678901234567890123456789012345678901234567890'.
					       '12345678901234567890123456789012345678901234567890'.
					       '12345678901234567890123456789012345678901234567890'.
					       '12345678901234567890123456789012345678901234567890'.
					       '12345678901234567890123456789012345678901234567890'.
					       '123456')))->
  with('form')->begin()->
    hasErrors(1)->
    isError('detalle', 'max_length')->
  end()->
  with('response')->begin()->
    checkElement('div.flash_error', '/Ocurrio un error al crear el detalle/')->
  end()->

  info('  3.5 - Ok guarda nuevo detalle en la BD')->
  click('OK', array('guaulog_detalle' => array('detalle' => 'prueba de agregar un detalle')))->
  with('form')->begin()->
    hasErrors(false)->
  end()->
  with('doctrine')->begin()->
    check('GuaulogDetalle', array('detalle' => 'prueba de agregar un detalle'), 1)->
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
    checkElement('div.flash_notice', '/Detalle creado correctamente/')->
    checkElement('div.detalle:contains("prueba de agregar un detalle")', true)->
  end()

  /* click('Borrar', array(), array('position' => 5))-> */
  /* info('4 - The delete')-> */
  /* info('  4.1 - borra el detalle de la BD')-> */
  /* with('doctrine')->begin()-> */
  /*   check('GuaulogDetalle', array('detalle' => 'prueba de agregar un detalle'), false)-> */
  /* end()-> */
  /* with('response')->begin()-> */
  /*   isRedirected()-> */
  /* end()-> */
  /* followRedirect()-> */
  /* with('request')->begin()-> */
  /*   isParameter('module', 'entrada')-> */
  /*   isParameter('action', 'show')-> */
  /* end()-> */
  /* with('response')->begin()-> */
  /*   checkElement('div.flash_notice', '/Detalle eliminado/')-> */
  /*   checkElement('div.detalle:contains("prueba de agregar un detalle")', false)-> */
  /* end() */
;

$detalles = Doctrine_Core::getTable('GuaulogDetalle')->getDetallesForEntrada('12', '2010');
$detalle = $detalles[0];
$browser->
  info('5 - The security')->
  get('/')->click('Salir')->get('/')->
  click('OK', array('signin' => array('username' => 'user', 'password' => 'user')))->
  get('/')->
  click('Ver', array('guaulog_entrada' => array('mes' => '12',
						'anio' => '2010'
						)))->
  followRedirect()->

  info('  5.1 - Normal user cannot add detail')->
  with('response')->begin()->
    checkElement('td.detalles a.agregar', false)->
  end()->
  get('/detalle/new?mes=12&amp;anio=2010')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('  5.2 - Normal user cannot edit detail')->
  with('response')->begin()->
    checkElement('td.detalles div.detalle a.editar', false)->
  end()->
  get('/detalles/edit?id=' . $detalle->getId() . '&mes=12&anio=2010')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('  5.3 - Normal user cannot delete detail')->
  with('response')->begin()->
    checkElement('td.detalles div.detalle a.borrar', false)->
  end()->
  get('/detalles/delete?id=' . $detalle->getId() . '&mes=12&anio=2010')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('  5.4 - Normal user cannot create detail')->
  get('/detalles/create')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('  5.5 - Normal user cannot update detail')->
  get('/detalles/update')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  get('/')->click('Salir')->get('/')->

  /* info('  5.6 - Guest user cannot index details')-> */
  /* get('/detalle/new?mes=12&amp;anio=2010')-> */
  /* with('response')->begin()-> */
  /*   isStatusCode(401)-> */
  /* end()-> */

  info('  5.7 - Guest user cannot add detail')->
  get('/detalle/new?mes=12&amp;anio=2010')->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  info('  5.8 - Guest user cannot edit detail')->
  get('/detalles/edit?id=' . $detalle->getId() . '&mes=12&anio=2010')->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  info('  5.9 - Guest user cannot delete detail')->
  get('/detalles/delete?id=' . $detalle->getId() . '&mes=12&anio=2010')->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  info('  5.10 - Guest user cannot create detail')->
  get('/detalles/create')->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  info('  5.11 - Guest user cannot update detail')->
  get('/detalles/update')->
  with('response')->begin()->
    isStatusCode(401)->
  end()
;
