<?php

/**
 * GuaulogFoto
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    guaulog
 * @subpackage model
 * @author     Javier Novoa C.
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class GuaulogFoto extends BaseGuaulogFoto
{
  /**
   * Antes de borrar registro de foto, borrar archivos fisicos de la foto
   */
  public function preDelete($event)
  {
    $this->deleteFotoFiles();
  }

  /**
   * Deletes foto files in disk
   */
  public function deleteFotoFiles()
  {
    GuaulogUtil::deleteFotoFiles($this->foto);
  }
}
