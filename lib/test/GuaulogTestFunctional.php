<?php

class GuaulogTestFunctional extends sfTestFunctional
{
  public function loadGuardData()
  {
    Doctrine_Core::loadData(sfConfig::get('sf_test_dir').'/fixtures/guard');

    return $this;
  }

  public function loadData()
  {
    return $this->loadDefaultData();//->loadFase2Data();
  }

  public function loadDefaultData()
  {
    Doctrine_Core::loadData(sfConfig::get('sf_test_dir').'/fixtures/data');

    return $this;
  }

  public function loadFase2Data()
  {
    Doctrine_Core::loadData(sfConfig::get('sf_test_dir').'/fixtures/fase2');

    return $this;
  }

  public function truncateData()
  {
    Doctrine_Core::getTable('GuaulogEntrada')->truncate();

    return $this;
  }

  public function prepareFiles()
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
