<?php

class GuaulogTest
{
  public static function prepareFiles()
  {
    Doctrine_Core::getTable('GuaulogFoto')->deleteUnreferencedFotoFiles();
    $files = scandir(sfConfig::get('sf_test_dir') . '/fixtures/files/fotos');
    foreach ($files as $file) {
      if ($file != '.' && $file != '..') {
	if (!file_exists(sfConfig::get('sf_upload_dir').'/fotos/'.$file)) {
	  copy(sfConfig::get('sf_test_dir').'/fixtures/files/fotos/'.$file,
	       sfConfig::get('sf_upload_dir').'/fotos/'.$file);
	}
	if (!file_exists(sfConfig::get('sf_upload_dir').'/.thumbnails/'.$file)) {
	  copy(sfConfig::get('sf_test_dir').'/fixtures/files/thumbnails/'.$file,
	       sfConfig::get('sf_upload_dir').'/.thumbnails/'.$file);
	}
	if (!file_exists(sfConfig::get('sf_upload_dir').'/.reduced/'.$file)) {
	  copy(sfConfig::get('sf_test_dir').'/fixtures/files/reduced/'.$file,
	       sfConfig::get('sf_upload_dir').'/.reduced/'.$file);
	}
      }
    }
  }
}
