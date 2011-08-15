<?php
require_once (dirname(__FILE__).'/../../bootstrap/Doctrine.php');

$t = new lime_test(5);

$t->comment('::deleteFotoFiles()');
copy(sfConfig::get('sf_test_dir').'/fixtures/files/fotos/44f2c5dec13920b59f4ed97870ae5f9edd137f5a.jpg',
     sfConfig::get('sf_upload_dir').'/fotos/test.jpg');
copy(sfConfig::get('sf_test_dir').'/fixtures/files/reduced/44f2c5dec13920b59f4ed97870ae5f9edd137f5a.jpg',
     sfConfig::get('sf_upload_dir').'/.thumbnails/test.jpg');
copy(sfConfig::get('sf_test_dir').'/fixtures/files/thumbnails/44f2c5dec13920b59f4ed97870ae5f9edd137f5a.jpg',
     sfConfig::get('sf_upload_dir').'/.reduced/test.jpg');
$foto = new GuaulogFoto();
$foto->setFoto('test.jpg');
$foto->deleteFotoFiles();
$t->ok(!file_exists(sfConfig::get('sf_upload_dir').'/fotos/test.jpg'), 'elimina la foto subida');
$t->ok(!file_exists(sfConfig::get('sf_upload_dir').'/.thumbnails/test.jpg'), 'elimina el thumbnail');
$t->ok(!file_exists(sfConfig::get('sf_upload_dir').'/.reduced/test.jpg'), 'elimina la foto reducida');

$t->comment("Table::getFotosForEntrada()");
$fotos = Doctrine_Core::getTable('GuaulogFoto')->getFotosForEntrada('6', '2011');
$t->is(count($fotos), 1, 'obtiene las fotos relacionadas con una entrada dada por los parametros mes/año');
$t->is($fotos[0]->getFoto(), '59262387b2cea9abc6c3aa6a2d47c8b5d6f886be.jpg');
