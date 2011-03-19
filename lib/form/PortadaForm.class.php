<?php

/**
 * Portada form.
 *
 * @package    guaulog
 * @subpackage form
 * @author     Javier Novoa C.
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PortadaForm extends BaseGuaulogEntradaForm
{
  protected static
    $years = array();

  public function init()
  {
    //inicializa arreglo de años: tomados de los años en los que hay entradas
    self::$years = array();
    $years = Doctrine_Core::getTable('GuaulogEntrada')->getAnios();
    foreach ($years as $year):
      if (!in_array($year->get('anio'), self::$years)):
        self::$years[] = $year->get('anio');
      endif;
    endforeach;

    //busca la primer entrada (ordenando por fecha) para dar el valor default a mes/año
    $this->primerEntrada = Doctrine_Core::getTable('GuaulogEntrada')->getPrimera();
  }

  public function configure()
  {
    $this->init();
    unset($this['id'], $this['foto'], $this['slug'], $this['created_at'], $this['updated_at'], $this['mide'], $this['pesa'], $this['pc']);

    if (count(self::$years) > 0):
      $this->widgetSchema['mes'] = new sfWidgetFormChoice(array('choices' => GuaulogUtil::$meses));
      $this->widgetSchema['anio'] = new sfWidgetFormChoice(array('label' => 'Año',
								 'choices' => array_combine(self::$years, self::$years)));

      $this->setValidators(array(
				 'mes' => new sfValidatorChoice(array('choices' => array_keys(GuaulogUtil::$meses)),
								array('invalid' => 'Opción inválida')),
				 'anio' => new sfValidatorChoice(array('choices' => self::$years),
								 array('invalid' => 'Opción inválida'))
			   ));
      $this->mergePostValidator(new sfValidatorCallback(array('callback' => array($this, 'validateNoRecordFound'))));

      $this->setDefaults(array('mes' => $this->primerEntrada->getMes(),
			       'anio' => $this->primerEntrada->getAnio()
			       ));
      $this->disableCSRFProtection();
    else:
      unset($this['mes']);
      unset($this['anio']);
    endif;
  }

  /**
   * Post-validator, checa que solo se consulten entradas ya existentes en la BD
   */
  public function validateNoRecordFound($validator, $values, $arguments)
  {
    $entrada = Doctrine_Core::getTable('GuaulogEntrada')->getEntradaByMesAnio($values['mes'], $values['anio']);
    if (!$entrada)
      {
	throw new sfValidatorError($validator, "¡No existe registro para la fecha indicada!");
      }
    return $values;
  }
}
