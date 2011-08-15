<?php
require_once (dirname(__FILE__).'/../../bootstrap/Doctrine.php');

$t = new lime_test(3);

$t->comment("Table::getDetallesForEntrada()");
$detalles = Doctrine_Core::getTable('GuaulogDetalle')->getDetallesForEntrada('6', '2011');
$t->is(count($detalles), 3, "obtiene todos los detalles de la entrada que coincide con los criterios de mes/años dados");
$t->is($detalles[0]->getGuaulogEntrada()->getMes(), '6');
$t->is($detalles[0]->getGuaulogEntrada()->getAnio(), '2011');
