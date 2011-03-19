<?php
require_once (dirname(__FILE__).'/../../bootstrap/Doctrine.php');

$t = new lime_test(16);

$t->comment("::getNombreMes()");
$ent = Doctrine_Query::create()->from('GuaulogEntrada')->where('anio = ?', '2010');
$t->is($ent->andWhere('mes = ?', '5')->fetchOne()->getNombreMes(),
       'Mayo', 'obtiene el nombre del mes en forma de cadena de texto');
/* $t->is($ent->andWhere('mes = ?', '6')->fetchOne()->getNombreMes(), */
/*        'Junio', 'obtiene el nombre del mes en forma de cadena de texto'); */
/* $t->is($ent->andWhere('mes = ?', '7')->fetchOne()->getNombreMes(), */
/*        'Julio', 'obtiene el nombre del mes en forma de cadena de texto'); */
/* $t->is($ent->andWhere('mes = ?', '8')->fetchOne()->getNombreMes(), */
/*        'Agosto', 'obtiene el nombre del mes en forma de cadena de texto'); */
/* $t->is($ent->andWhere('mes = ?', '9')->fetchOne()->getNombreMes(), */
/*        'Septiembre', 'obtiene el nombre del mes en forma de cadena de texto'); */
/* $t->is($ent->andWhere('mes = ?', '10')->fetchOne()->getNombreMes(), */
/*        'Octubre', 'obtiene el nombre del mes en forma de cadena de texto'); */
/* $t->is($ent->andWhere('mes = ?', '11')->fetchOne()->getNombreMes(), */
/*        'Noviembre', 'obtiene el nombre del mes en forma de cadena de texto'); */
/* $t->is($ent->andWhere('mes = ?', '12')->fetchOne()->getNombreMes(), */
/*        'Diciembre', 'obtiene el nombre del mes en forma de cadena de texto'); */

$t->comment("Table::getEntradaByMesAnio()");
$entrada = Doctrine_Core::getTable('GuaulogEntrada')->getEntradaByMesAnio("12", "2010");
$t->is($entrada->getMes().' '.$entrada->getAnio(), '12 2010', 'obtiene una entrada para el mes y año dados');

$t->comment("Table::getAnios()");
$anios = Doctrine_Core::getTable('GuaulogEntrada')->getAnios();
$t->is($anios[0]->getAnio(), '2010', 'obtiene las entradas ordenadas por año descendentemente');

$t->comment("Table::getPrimera()");
$entrada = Doctrine_Core::getTable('GuaulogEntrada')->getPrimera();
$t->is($entrada->getMes().' '.$entrada->getAnio(), '5 2010', 'obtiene la primer entrada de la base, ordenandolas por mes,año ascendentemente');

$t->comment("Table::getUltima()");
$entrada = Doctrine_Core::getTable('GuaulogEntrada')->getUltima();
$t->is($entrada->getMes().' '.$entrada->getAnio(), '12 2010', 'obtiene la ultima entrada de la base, ordenandolas por mes,año descendentemente');

$t->comment("::hasAnterior()");
$entrada = Doctrine_Core::getTable('GuaulogEntrada')->getPrimera();
$t->is($entrada->hasAnterior(), false, 'regresa false si no hay entrada anterior de acuerdo a mes/año de entrada actual');
$entrada = Doctrine_Core::getTable('GuaulogEntrada')->getEntradaByMesAnio("8", "2010");
$t->is($entrada->hasAnterior(), true, 'regresa true en cualquier otro caso');

$t->comment("::hasSiguiente()");
$entrada = Doctrine_Core::getTable('GuaulogEntrada')->getUltima();
$t->is($entrada->hasSiguiente(), false, 'regresa false si no hay entrada siguiente de acuerdo a mes/año de entrada actual');
$entrada = Doctrine_Core::getTable('GuaulogEntrada')->getEntradaByMesAnio("8", "2010");
$t->is($entrada->hasSiguiente(), true, 'regresa true en cualquier otro caso');

$t->comment("::getAnterior()");
$anterior = Doctrine_Core::getTable('GuaulogEntrada')->getEntradaByMesAnio("8", "2010")->getAnterior();
$t->is($anterior->getMes().' '.$anterior->getAnio(), '7 2010', 'regresa la entrada anterior a la que llama el metodo');
$anterior = Doctrine_Core::getTable('GuaulogEntrada')->getPrimera()->getAnterior();
$t->is($anterior, false, 'regresa false si no hay entrada anterior');

$t->comment("::getSiguiente()");
$siguiente = Doctrine_Core::getTable('GuaulogEntrada')->getEntradaByMesAnio("8", "2010")->getSiguiente();
$t->is($siguiente->getMes().' '.$siguiente->getAnio(), '9 2010', 'regresa la entrada siguiente a la que llama el metodo');
$siguiente = Doctrine_Core::getTable('GuaulogEntrada')->getUltima()->getSiguiente();
$t->is($siguiente, false, 'regresa false si no hay entrada siguiente');

$t->comment("::quitaFoto()");
$entrada = Doctrine_Core::getTable('GuaulogEntrada')->getEntradaByMesAnio("12", "2010");
$foto = $entrada->quitaFoto();
$t->is($entrada->getGuaulogFoto(), null, 'elimina la relacion entrada-foto default');

$fotos = Doctrine_Core::getTable('GuaulogFoto')->getFotosForEntrada('12', '2010');
$foto = $fotos[0];
$t->comment("::updateSetFoto()");
$t->is($entrada->getGuaulogFoto(), null, 'si no se ha ejecutado, no hay foto asociada a la entrada');
$entrada->updateSetFoto($foto);
$t->is($entrada->getGuaulogFoto()->getFoto(), $foto->getFoto(), 'relaciona una foto de la entrada como foto por default de la misma');
