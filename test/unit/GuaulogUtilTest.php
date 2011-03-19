<?php
require_once (dirname(__FILE__).'/../bootstrap/unit.php');

//GuaulogTestUnit::init();

$t = new lime_test(2);

$t->comment("::$meses - Array de meses");
$t->is(count(GuaulogUtil::$meses), 12, 'debe contener 12 elementos');
$t->is(array_diff(array_keys(GuaulogUtil::$meses),
		  array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)),
       array(), 'cada elemento debe tener los numeros 1-12 como llaves');
