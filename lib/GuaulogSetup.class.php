<?php
/**
 * GuaulogSetup
 *
 * Utility class for setting up the webapp
 *
 * @package    guaulog
 * @subpackage init
 * @author     Javier Novoa C.
 */
class GuaulogSetup
{
  /**
   * Genera thumbnails de fotos del sitio
   */
  public static function generateThumbnails()
  {
    //Foto de portada
    $portada_fname = sfConfig::get('app_portada_fname');
    if ( !file_exists(sfConfig::get('sf_upload_dir') . '/.reduced/' . $portada_fname . '.' . sfConfig::get('app_portada_thmb_ext')) )
      {
	GuaulogUtil::generateThumbnail(sfConfig::get('sf_upload_dir') . '/' . $portada_fname . '.' . sfConfig::get('app_portada_fext'),
				       '.reduced',
				       640, 480,
				       sfConfig::get('app_portada_thmb_ext'));
      }
  }
}
