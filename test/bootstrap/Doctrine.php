<?php
include(dirname(__FILE__).'/unit.php');

$config = ProjectConfiguration::getApplicationConfiguration('frontend', 'test', true);

new sfDatabaseManager($config);

Doctrine_Core::loadData(sfConfig::get('sf_test_dir'.'/fixtures'));
Doctrine_Core::loadData(sfConfig::get('sf_test_dir'.'/fixtures/fase2'));
