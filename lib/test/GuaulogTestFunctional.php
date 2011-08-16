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
    GuaulogTest::prepareFiles();
  }
}
