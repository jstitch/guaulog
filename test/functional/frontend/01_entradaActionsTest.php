<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new GuaulogTestFunctional(new sfBrowser());
$browser->setTester('doctrine', 'sfTesterDoctrine');
$browser->info('Initializing database: truncate')->truncateData();
$browser->info('Initializing database: guard data')->loadGuardData();

$browser->info('0 - Signing in as administrator (should have permission to everything)')->
  get('/')->
  with('user')->begin()->
    isAuthenticated(false)->
  end()->
  with('response')->begin()->
    checkElement('div.div_title', false)->
  end()->
  click('OK', array('signin' => array('username' => 'admin', 'password' => 'admin')))->
  with('form')->begin()->
    hasErrors(0)->
  end()->
  with('user')->begin()->
    isAuthenticated(true)->
    hasCredential('admin')->
  end()->
  get('/')->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('div.registrar', true)->
  end()->

// goto Index
  get('/')->
  with('request')->begin()->
  info('1 - The homepage')->
    isParameter('module', 'entrada')->
    isParameter('action', 'index')->
  end()->
  with('response')->begin()->
    checkElement('div.div_title', false)->
  end()->

// validate no data found
with('response')->begin()->
  info('  1.1 - Si no hay registros muestra mensaje')->
    checkElement('div.ver', '/Aún no hay entradas/')->
  end()->

// goto Register
// values in fields must be 0, since there is no previous data in DB
  get('/')->
  click('Registrar')->
  with('response')->begin()->
  info('  1.2 - Al pedir nueva entrada, sin datos, los campos se inicializan en 0 (cf prueba 4.1)')->
    checkElement('form input[name="guaulog_entrada[mide]"][value="0"]', true)->
    checkElement('form input[name="guaulog_entrada[pesa]"][value="0"]', true)->
    checkElement('form input[name="guaulog_entrada[pc]"][value="0"]', true)->
  end()
;

$browser->restart();
$browser->info('Initializing database: fixtures')->loadData();
$browser->info('Preparing data files...');
$browser->prepareFiles();
$browser->get('/')->click('OK', array('signin' => array('username' => 'admin', 'password' => 'admin')))->

// validate data found
// goto Show
  get('/')->
  with('response')->begin()->
  info('  1.3 - Si si hay registros, mes y año seleccionados en la entrada mas antigua')->
    checkElement('form select#guaulog_entrada_mes option[value="4"][selected="selected"]', 'Abril')->
    checkElement('form select#guaulog_entrada_anio option[value="2011"][selected="selected"]', '2011')->
  info('  1.4 - Solo debe haber opciones de año para los años de las entradas existentes')->
    checkElement('form select#guaulog_entrada_anio option[value="2011"]', '2011')->
    checkElement('form select#guaulog_entrada_anio option', 1)->
  end()->

// validate error on unexistent entries
  click('Ver', array('guaulog_entrada' => array('mes' => '1',
						'anio' => '2010'
						)))->
  info('  1.5 - Seleccionar una fecha sin entrada relacionada marca error')->
  with('form')->begin()->
    hasGlobalError("¡No existe registro para la fecha indicada!")->
  end()->
  with('response')->begin()->
    isRedirected()->
  end()->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'index')->
  end()->
  with('response')->begin()->
    checkElement('div.flash_error', '/¡No existe registro para la fecha indicada!/')->
  end()->
  info('  1.6 - Seleccionar luego de error una entrada existente no provoca error')->
  click('Ver', array('guaulog_entrada' => array('mes' => '4',
						'anio' => '2011'
						)))->
  with('response')->begin()->
    isRedirected()->
  end()->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'show')->
  end()->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('div.fecha', '/ABRIL 2011/')->
  end()
;

// goto Show for certain selected input
$browser->
  info('2 - The show')->
  info('  2.1 - Seleccionar una fecha con entrada lleva al show de esa entrada')->
  get('/')->
  click('Ver', array('guaulog_entrada' => array('mes' => '6',
						'anio' => '2011'
						)))->
  with('response')->begin()->
    isRedirected()->
  end()->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'show')->
  end()->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('div.div_title', true)->
    checkElement('div.editar', true)->
    checkElement('div.fecha', '/JUNIO 2011/')->
    checkElement('div.foto_mes', '/No hay foto seleccionada para este mes./')->
    checkElement('div.medida', '/0.90/')->
    checkElement('div.peso', '/1.90/')->
    checkElement('div.pc', '/2.90/')->
    checkElement('#Anterior', true)->
    checkElement('#Siguiente', true)->
  end()->

// navigate
  click('Anterior')->
  info('  2.2 - Click en "Anterior" lleva a show de la anterior entrada')->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'show')->
  end()->
  with('response')->begin()->
    checkElement('div.fecha', '/MAYO 2011/')->
    checkElement('#Anterior', true)->
    checkElement('#Siguiente', true)->
  end()->

  click('Anterior')-> //a Abril
  with('response')->begin()->
    checkElement('div.fecha', '/ABRIL 2011/')->
    checkElement('#Anterior', false)->
    checkElement('#Siguiente', true)->
  end()->
  click('Siguiente')->
  click('Siguiente')->
  click('Siguiente')->
  with('response')->begin()->
    checkElement('div.fecha', '/JULIO 2011/')->
    checkElement('#Anterior', true)->
    checkElement('#Siguiente', false)->
  end()->

// validate 'Inicio'
// goto Index from show
  click('Inicio')->
  info('  2.3 - Estando en show, al dar click en Inicio regresa al indice')->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'index')->
  end()->
  with('response')->begin()->
    isStatusCode(200)->
  end()
;

// edit entry
$browser->
  info('3 - Edit entry')->
  get('/')->
  click('Ver', array('guaulog_entrada' => array('mes' => '6',
						'anio' => '2011'
						)))->
  followRedirect()->
  click('Editar Entrada')->
  info('  3.1 - Pedir editar entrada lleva a formulario con datos de la entrada')->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'edit')->
  end()->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('div.div_title', true)->
    checkElement('form select#guaulog_entrada_mes option[value="6"][selected="selected"]', 'Junio')->
    checkElement('form select#guaulog_entrada_anio option[value="2011"][selected="selected"]', '2011')->
    checkElement('form input[name="guaulog_entrada[mide]"][value="0.90"]', true)->
    checkElement('form input[name="guaulog_entrada[pesa]"][value="1.90"]', true)->
    checkElement('form input[name="guaulog_entrada[pc]"][value="2.90"]', true)->
  end()->

  click('Cancelar')->
  info('  3.2 - Cancelar regresa a show de la entrada que se iba a editar, sin cambios')->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'show')->
  end()->
  with('doctrine')->begin()->
    check('GuaulogEntrada', array(
				  'mes' => '6',
				  'anio' => '2011',
				  'foto' => null,
				  'mide' => '0.90',
				  'pesa' => '1.90',
				  'pc' => '2.90'
				  ))->
  end()->

  click('Editar Entrada')->
  info('  3.3 - Errores de validacion si datos en formulario son invalidos')->
  info('      - fecha ya existente / datos nulos')->
  click('OK', array('guaulog_entrada' => array('mes' => '5',
					       'anio' => '2011',
					       'mide' => '',
					       'pesa' => '',
					       'pc' => ''
					       )))->
  with('form')->begin()->
    hasErrors(4)->
    isError('mes', 'invalid')->
    isError('mide', 'required')->
    isError('pesa', 'required')->
    isError('pc', 'required')->
  end()->
  with('response')->begin()->
    checkElement('div.flash_error', '/Ocurrio un error al editar la entrada/')->
  end()->
  info('  3.4 - Errores de validacion si datos en formulario son invalidos')->
  info('      - fecha en el futuro / datos invalidos')->
  click('OK', array('guaulog_entrada' => array('mes' => date('n') == 12 ? 1 : date('n') + 1,
					       'anio' => date('n') == 12 ? date('Y') + 1 : date('Y'),
					       'mide' => '-1',
					       'pesa' => '-1',
					       'pc' => '-1'
					       )))->
  with('form')->begin()->
    hasErrors(4)->
    hasGlobalError("¡La fecha no puede estar en el futuro!")->//fallara si se prueba en diciembre de cada año por el año = date('Y')+1
    isError('mide', 'min')->
    isError('pesa', 'min')->
    isError('pc', 'min')->
  end()->
  with('response')->begin()->
    checkElement('div.flash_error', '/Ocurrio un error al editar la entrada/')->
  end();

$foto_prueba = Doctrine_Core::getTable('GuaulogFoto')->createQuery('f')->where('f.foto = ?', '59262387b2cea9abc6c3aa6a2d47c8b5d6f886be.jpg')->fetchOne();
$browser->info('Foto prueba: ' . $foto_prueba->getFoto());

$browser->info('  3.5 - Ok realiza los cambios en la entrada y guarda en la BD')->
  click('OK', array('guaulog_entrada' => array('mes' => '6',
					       'anio' => '2011',
					       'mide' => '1.80',
					       'pesa' => '3.80',
					       'pc' => '5.80',
					       'foto' => $foto_prueba->getId()
					       )))->
  with('form')->begin()->
    hasErrors(false)->
  end()->
  with('doctrine')->begin()->
    check('GuaulogEntrada', array(
				  'mes' => '6',
				  'anio' => '2011',
				  'mide' => '1.80',
				  'pesa' => '3.80',
				  'pc' => '5.80',
				  'foto' => $foto_prueba->getId()
				  ))->
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
    checkElement('div.flash_notice', '/Entrada editada correctamente para Junio de 2011/')->
    checkElement('div.fecha', '/JUNIO 2011/')->
  //    checkElement('div.foto_mes img[alt="Foto del mes"]', true)-> // what's the tester for this one?
    checkElement('div.medida', '/1.80/')->
    checkElement('div.peso', '/3.80/')->
    checkElement('div.pc', '/5.80/')->
  end()
;

// goto Register
$browser->
  info('4 - The register')->
  get('/')->
  click('Registrar')->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'new')->
  end()->

// values in fields must be the same as the last entry in DB
  info('  4.1 - Los campos de la nueva entrada precargan con datos de la ultima entrada en DB (cf prueba 1.2)')->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('div.div_title', true)->
    checkElement('form input[name="guaulog_entrada[mide]"][value="1.00"]', true)->
    checkElement('form input[name="guaulog_entrada[pesa]"][value="2.00"]', true)->
    checkElement('form input[name="guaulog_entrada[pc]"][value="3.00"]', true)->
  end()->

  click('Cancelar')->
  info('  4.2 - Cancelar regresa a index, sin cambios')->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'index')->
  end()->

  click('Registrar')->
  info('  4.3 - Errores de validacion si datos en formulario son invalidos')->
  info('      - fecha ya existente / datos nulos')->
  click('OK', array('guaulog_entrada' => array('mes' => '5',
					       'anio' => '2011',
					       'mide' => '',
					       'pesa' => '',
					       'pc' => ''
					       )))->
  with('form')->begin()->
    hasErrors(4)->
    isError('mes', 'invalid')->
    isError('mide', 'required')->
    isError('pesa', 'required')->
    isError('pc', 'required')->
  end()->
  with('response')->begin()->
    checkElement('div.flash_error', '/Ocurrio un error al crear la entrada/')->
  end()->
  info('  4.4 - Errores de validacion si datos en formulario son invalidos')->
  info('      - fecha en el futuro / datos invalidos')->
  click('OK', array('guaulog_entrada' => array('mes' => date('n') == 12 ? 1 : date('n') + 1,
					       'anio' => date('n') == 12 ? date('Y') + 1 : date('Y'),
					       'mide' => '-1',
					       'pesa' => '-1',
					       'pc' => '-1'
					       )))->
  with('form')->begin()->
    hasErrors(4)->
    hasGlobalError("¡La fecha no puede estar en el futuro!")->
    isError('mide', 'min')->
    isError('pesa', 'min')->
    isError('pc', 'min')->
  end()->
  with('response')->begin()->
    checkElement('div.flash_error', '/Ocurrio un error al crear la entrada/')->
  end()->

  info('  4.5 - Ok guarda los cambios de la nueva entrada en la BD')->
  click('OK', array('guaulog_entrada' => array('mes' => '8',
					       'anio' => '2011',
					       'mide' => '3.14',
					       'pesa' => '2.72',
					       'pc' => '1.41'
					       )))->
  with('form')->begin()->
    hasErrors(false)->
  end()->
  with('doctrine')->begin()->
    check('GuaulogEntrada', array(
				  'mes' => '8',
				  'anio' => '2011',
				  'foto' => null,
				  'mide' => '3.14',
				  'pesa' => '2.72',
				  'pc' => '1.41'
				  ))->
  end()->
  with('response')->begin()->
    isRedirected()->
  end()->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'fotos')->
    isParameter('action', 'new')->
  end()->
  with('response')->begin()->
    checkElement('div.flash_notice', '/Entrada creada correctamente para Agosto de 2011/')->
  end()->

get('/')->
  click('Ver', array('guaulog_entrada' => array('mes' => '8',
						'anio' => '2011'
						)))->
  followRedirect()->
  with('response')->begin()->
    checkElement('div.fecha', '/AGOSTO 2011/')->
    checkElement('div.foto_mes', '/No hay foto seleccionada para este mes./')->
    checkElement('div.medida', '/3.14/')->
    checkElement('div.peso', '/2.72/')->
    checkElement('div.pc', '/1.41/')->
  end()
;

// delete entry
$browser->
  info('5 - The delete')->
  get('/')->
  click('Ver', array('guaulog_entrada' => array('mes' => '8',
						'anio' => '2011'
						)))->
  followRedirect()->
  click('Editar Entrada')->
  click('Borrar', array(), array('method' => 'delete'))->
  info('  5.1 - borra la entrada de la BD')->
  with('doctrine')->begin()->
    check('GuaulogEntrada', array(
				  'mes' => '8',
				  'anio' => '2011'
				  ),
	  false)->
  end()->
  with('response')->begin()->
    isRedirected()->
  end()->
  followRedirect()->
  with('request')->begin()->
    isParameter('module', 'entrada')->
    isParameter('action', 'index')->
  end()->
  with('response')->begin()->
    checkElement('div.flash_notice', '/Entrada eliminada: Agosto de 2011/')->
  end()->
  click('Ver', array('guaulog_entrada' => array('mes' => '8',
						'anio' => '2011'
						)))->
  with('form')->begin()->
    hasGlobalError("¡No existe registro para la fecha indicada!")->
  end()
;

$entrada = Doctrine_Core::getTable('GuaulogEntrada')->getEntradaByMesAnio('7', '2011');
// Security
$browser->
  info('6 - The security')->
  info('  6.1 - Logout')->
  get('/')->
  click('Salir')->
  get('/')->
  with('response')->begin()->
    isStatusCode(401)->
  end()->
  with('user')->begin()->
    isAuthenticated(false)->
  end()->

  info('  6.2 - Login as normal user')->
  click('OK', array('signin' => array('username' => 'user', 'password' => 'user')))->
  with('form')->begin()->
    hasErrors(0)->
  end()->
  with('user')->begin()->
    isAuthenticated(true)->
    hasCredential('')->
  end()->

  info('  6.3 - Normal user cannot register')->
  get('/')->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('div.registrar', false)->
  end()->
  get('/entrada/new')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('  6.4 - Normal user cannot edit')->
  get('/')->
  click('Ver', array('guaulog_entrada' => array('mes' => '7',
						'anio' => '2011'
						)))->
  followRedirect()->
  with('response')->begin()->
    checkElement('div.editar', false)->
  end()->
  get('/entrada/7-2011/edit')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('  6.5 - Normal user cannot delete')->
  call('/entrada/7-2011', 'delete')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('  6.6 - Normal user cannot update')->
  call('/entrada/7-2011', 'put')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  info('  6.7 - Normal user cannot create')->
  post('/entrada')->
  with('response')->begin()->
    isStatusCode(403)->
  end()->

  get('/')->
  click('Salir')->

  info('  6.9 - Guest user cannot see index')->
  get('/entrada/index')->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  info('  6.10 - Guest user cannot show')->
  get('/entrada/show?'.http_build_query(array('mes'=>$entrada->getMes(), 'anio'=>$entrada->getAnio())))->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  info('  6.11 - Guest user cannot register')->
  get('/entrada/new')->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  info('  6.12 - Guest user cannot edit')->
  get('/entrada/edit?mes=7&anio=2011')->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  info('  6.13 - Guest user cannot delete')->
  call('/entrada/7-2011', 'delete')->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  info('  6.14 - Guest user cannot update')->
  call('/entrada/7-2011', 'put')->
  with('response')->begin()->
    isStatusCode(401)->
  end()->

  info('  6.15 - Guest user cannot create')->
  post('/entrada')->
  with('response')->begin()->
//    isStatusCode(401)-> // apparently, bug in symfony, should give 401 but gives 200 instead
    checkElement('form input[name="signin[username]"]', true)->
    checkElement('form input[name="signin[password]"]', true)->
  end()
;
