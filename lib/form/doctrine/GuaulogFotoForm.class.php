<?php

/**
 * GuaulogFoto form.
 *
 * @package    guaulog
 * @subpackage form
 * @author     Javier Novoa C.
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GuaulogFotoForm extends BaseGuaulogFotoForm
{
  public function configure()
  {
    $this->prevFotoFilename = '';

    unset($this['created_at'], $this['updated_at']);

    $this->widgetSchema['entrada_id'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['entrada_id'] = new sfValidatorPass();
    $this->widgetSchema['foto'] = new sfWidgetFormInputFileEditable(array(
									  'file_src' => sfConfig::get('sf_upload_dir') . '/.thumbnails/',
									  'edit_mode' => true,
									  'is_image' => true,
									  'with_delete' => false
									  ));

    $this->mergePostValidator(new sfValidatorCallback(array('callback' => array($this, 'getPreviousFotoFilename'))));

    $this->validatorSchema['foto'] = new sfValidatorFile(array(
							       'required'   => true,
							       'path'       => sfConfig::get('sf_upload_dir') . '/fotos',
							       'mime_types' => 'web_images',
							       'validated_file_class' => 'CustomValidatedFile'
							       ),
							 array('required' => 'Campo requerido'));

    $this->mergePostValidator(new sfValidatorCallback(array('callback' => array($this, 'deletePreviousFotoFiles'))));
  }

  /**
   * Pre-validator, guarda nombre de archivo de foto anterior en caso de actualizacion
   */
  public function getPreviousFotoFilename($validator, $values, $arguments)
  {
    if (isset($values['id']) && $values['id'] != null && $values['id'] != '' &&
	isset($values['entrada_id']) && $values['entrada_id'] != null && $values['entrada_id'] != '')
      {
	$foto = Doctrine_Core::getTable('GuaulogFoto')->find(array($values['id'], $values['entrada_id']));
	$this->prevFotoFilename = $foto->getFoto();
      }
    return $values;
  }

  /**
   * Post-validator, elimina archivos de fotos anteriores en caso de actualizacion
   */
  public function deletePreviousFotoFiles($validator, $values, $arguments)
  {
    if (isset($values['id']) && $values['id'] != null && $values['id'] != '' &&
	isset($values['entrada_id']) && $values['entrada_id'] != null && $values['entrada_id'] != '' &&
	isset($values['foto']) && $values['foto'] != null && $values['foto'] != '')
      {
	GuaulogUtil::deleteFotoFiles($this->prevFotoFilename);
      }
    return $values;
  }

  /**
   * Establece la entrada con la cual se relaciona la foto
   *
   * @param GuaulogEntrada $entrada la entrada
   */
  public function setEntrada($entrada)
  {
    if (!($entrada instanceof GuaulogEntrada))
      {
	throw new sfError404Exception('Debe proporcionar una entrada válida');
      }
    $this->entrada = $entrada;
    $this->widgetSchema['entrada_id']->setAttribute('value', $entrada->getId());
  }

  /**
   * Devuelve la entrada con la cual se relaciona la foto, o null si no se ha relacionado
   */
  public function getEntrada()
  {
    if (isset($this->entrada))
      {
	return $this->entrada;
      }
    return null;
  }
}

/**
 * CustomValidatedFile class
 *
 * @package    guaulog
 * @subpackage form
 * @author     Javier Novoa C.
 */
class CustomValidatedFile extends sfValidatedFile
{
  /**
   * Saves the uploaded file.
   */
  public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777)
  {
    $fn = parent::save($file, $fileMode, $create, $dirMode);

    $fn_comps = pathinfo($this->getPath() . '/' . $fn);

    if (!GuaulogUtil::generateThumbnail($this->getPath() . '/' . $fn, '.reduced', 640, 480))
      {
	copy($this->getPath() . '/' . $fn, sfConfig::get('sf_upload_dir') . '/.reduced/' . $fn);
      }
    if (!GuaulogUtil::generateThumbnail($this->getPath() . '/' . $fn, '.thumbnails', 80, 60))
      {
	copy($this->getPath() . '/' . $fn, sfConfig::get('sf_upload_dir') . '/.thumbnails/' . $fn);
      }

    return $fn;
  }
}
