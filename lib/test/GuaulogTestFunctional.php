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
    copy(sfConfig::get('sf_test_dir').'/fixtures/files/diciembre2010.jpg', sfConfig::get('sf_upload_dir').'/fotos/diciembre2010.jpg');
    copy(sfConfig::get('sf_test_dir').'/fixtures/files/diciembre2010.jpg_thumb', sfConfig::get('sf_upload_dir').'/.thumbnails/diciembre2010.jpg');
    copy(sfConfig::get('sf_test_dir').'/fixtures/files/diciembre2010.jpg_reduced', sfConfig::get('sf_upload_dir').'/.reduced/diciembre2010.jpg');
    copy(sfConfig::get('sf_test_dir').'/fixtures/files/foto_susi.jpg', sfConfig::get('sf_upload_dir').'/fotos/foto_susi.jpg');
    copy(sfConfig::get('sf_test_dir').'/fixtures/files/foto_susi.jpg_thumb', sfConfig::get('sf_upload_dir').'/.thumbnails/foto_susi.jpg');
    copy(sfConfig::get('sf_test_dir').'/fixtures/files/foto_susi.jpg_reduced', sfConfig::get('sf_upload_dir').'/.reduced/foto_susi.jpg');
  }
}
