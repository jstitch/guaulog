<?php
require_once (dirname(__FILE__).'/../../bootstrap/Doctrine.php');

$t = new lime_test(5);

$t->comment('::deleteFotoFiles()');
copy(sfConfig::get('sf_test_dir').'/fixtures/files/diciembre2010.jpg',
     sfConfig::get('sf_upload_dir').'/fotos/test.jpg');
copy(sfConfig::get('sf_test_dir').'/fixtures/files/diciembre2010.jpg_thumb',
     sfConfig::get('sf_upload_dir').'/.thumbnails/test.jpg');
copy(sfConfig::get('sf_test_dir').'/fixtures/files/diciembre2010.jpg_reduced',
     sfConfig::get('sf_upload_dir').'/.reduced/test.jpg');
$foto = new GuaulogFoto();
$foto->setFoto('test.jpg');
$foto->deleteFotoFiles();
$t->ok(!file_exists(sfConfig::get('sf_upload_dir').'/fotos/test.jpg'), 'elimina la foto subida');
$t->ok(!file_exists(sfConfig::get('sf_upload_dir').'/.thumbnails/test.jpg'), 'elimina el thumbnail');
$t->ok(!file_exists(sfConfig::get('sf_upload_dir').'/.reduced/test.jpg'), 'elimina la foto reducida');

$t->comment("Table::getFotosForEntrada()");
$fotos = Doctrine_Core::getTable('GuaulogFoto')->getFotosForEntrada('5', '2010');
$t->is(count($fotos), 1, 'obtiene las fotos relacionadas con una entrada dada por los parametros mes/año');
$t->is($fotos[0]->getFoto(), 'mayo2010.jpg');
