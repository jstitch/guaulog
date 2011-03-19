<?php

/**
 * GuaulogDetalle form.
 *
 * @package    guaulog
 * @subpackage form
 * @author     Javier Novoa C.
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GuaulogDetalleForm extends BaseGuaulogDetalleForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at']);

    $this->widgetSchema['entrada_id'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['entrada_id'] = new sfValidatorPass();
    $this->widgetSchema['detalle'] = new sfWidgetFormTextarea();
    $this->validatorSchema['detalle'] = new sfValidatorString(array('max_length' => 255,
								    'required' => true),
							      array('max_length' => 'Longitud máxima: 255 caracteres',
								    'required' => 'Campo requerido'));
  }

  /**
   * Establece la entrada con la cual se relaciona el detalle
   *
   * @param GuaulogEntrada $entrada la entrada
   */
  public function setEntrada($entrada)
  {
    if (!($entrada instanceof GuaulogEntrada))
      {
	throw new sfError404Exception('Debe proporcionar una entrada valida');
      }
    $this->entrada = $entrada;
    $this->widgetSchema['entrada_id']->setAttribute('value', $entrada->getId());
  }

  /**
   * Devuelve la entrada con la cual se relaciona el detalle, o null si no se ha relacionado
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
