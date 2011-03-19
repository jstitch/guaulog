<?php

/**
 * GuaulogUtil
 * 
 * @package    guaulog
 * @subpackage lib
 * @author     Javier Novoa C.
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class GuaulogUtil
{
  /**
   * Nombres de los meses del año
   */
  public static
    $meses = array(
		   1 => 'Enero',
		   2 => 'Febrero',
		   3 => 'Marzo',
		   4 => 'Abril',
		   5 => 'Mayo',
		   6 => 'Junio',
		   7 => 'Julio',
		   8 => 'Agosto',
		   9 => 'Septiembre',
		   10 => 'Octubre',
		   11 => 'Noviembre',
		   12 => 'Diciembre'
		   );

  /**
   * Muestra un link como boton o como link, dependiendo configuracion
   */
  public static function link_or_button($nombre='', $url='', $params=array())
  {
    if (sfConfig::get('app_use_buttons'))
      {
	return button_to($nombre, $url, $params);
      }
    return link_to($nombre, $url, $params);
  }

  /**
   * Generate thumbnails for given image
   *
   * @param string path & filename
   * @param string dest where to store generated image below web/uploads
   * @param integer w desired width
   * @param integet h desired height
   * @param string ext desired extension (if '' given, use original)
   */
  public static function generateThumbnail($filename = '', $dest = '.thumbnails',
					   $w = 640, $h = 480,
					   $ext = '')
  {
    try
      {
	$fn_comps = pathinfo($filename);

	$path = sfConfig::get('sf_upload_dir') . '/' . $dest . '/' .
	  $fn_comps['filename'] . '.' . ($ext == '' ? $fn_comps['extension'] : $ext);
	$image = new sfThumbnail($w, $h, true, true, 10, 'sfImageMagickAdapter');
	$image->loadFile($filename);
	$image->save($path, 'image/' . ($ext == '' ? $fn_comps['extension'] : $ext));
      }
    catch (Exception $e)
      {
	return false;
      }
    return true;
  }

  /**
   * Deletes foto file in disk, also reduced and thumbnails
   */
  public static function deleteFotoFiles($foto)
  {
    if (file_exists(sfConfig::get('sf_upload_dir') . '/fotos/' . $foto))
      {
	unlink(sfConfig::get('sf_upload_dir') . '/fotos/' . $foto);
      }
    if (file_exists(sfConfig::get('sf_upload_dir') . '/.reduced/' . $foto))
      {
	unlink(sfConfig::get('sf_upload_dir') . '/.reduced/' . $foto);
      }
    if (file_exists(sfConfig::get('sf_upload_dir') . '/.thumbnails/' . $foto))
      {
	unlink(sfConfig::get('sf_upload_dir') . '/.thumbnails/' . $foto);
      }
  }

  /**
   * Backups foto files in to destdir
   */
  public static function backupFotoFiles($destdir)
  {
    if (opendir($destdir)):
      if ($handle = opendir(sfConfig::get('sf_upload_dir') . '/fotos')):
	while (false !== ($file = readdir($handle))):
	  if (!is_dir($file)):
	    copy(sfConfig::get('sf_upload_dir') . '/fotos/' . $file,
		 $destdir . '/' . $file);
          endif;
        endwhile;
      endif;
    endif;
  }
}
