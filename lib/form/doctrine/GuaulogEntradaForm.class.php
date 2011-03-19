<?php

/**
 * GuaulogEntrada form.
 *
 * @package    guaulog
 * @subpackage form
 * @author     Javier Novoa C.
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GuaulogEntradaForm extends BaseGuaulogEntradaForm
{
  protected static
    $years = array();

  /**
   * Inicializa el formulario. Como se utiliza en este y otras clases hijas
   * que comparten codigo, se hace aqui en vez de en Configure()
   */
  public function init()
  {
    unset($this['slug'], $this['created_at'], $this['updated_at']);

    self::$years = range(date('Y'), date('Y') - sfConfig::get('app_limite_anios'));

    $this->widgetSchema['mes'] = new sfWidgetFormChoice(array('choices' => GuaulogUtil::$meses));
    $this->widgetSchema['anio'] = new sfWidgetFormChoice(array('label' => 'Año',
							       'choices' => array_combine(self::$years, self::$years)));
    $this->widgetSchema['mide']->setOption('label', 'Midió');
    $this->widgetSchema['pesa']->setOption('label', 'Pesó');
    $this->widgetSchema['pc']->setOption('label', 'Perímetro cefálico');

    $this->validatorSchema['mes'] = new sfValidatorChoice(array('choices' => array_keys(GuaulogUtil::$meses)),
							  array('invalid' => 'Opción inválida'));
    $this->validatorSchema['anio'] = new sfValidatorChoice(array('choices' => self::$years),
							   array('invalid' => 'Opción inválida'));
    $this->validatorSchema['mide'] = new sfValidatorNumber(array('min' => 0, 'required' => true),
							   array('min' => 'Número inválido',
								 'required' => 'Campo requerido'));
    $this->validatorSchema['pesa'] = new sfValidatorNumber(array('min' => 0, 'required' => true),
							   array('min' => 'Número inválido',
								 'required' => 'Campo requerido'));
    $this->validatorSchema['pc'] = new sfValidatorNumber(array('min' => 0, 'required' => true),
							 array('min' => 'Número inválido',
							       'required' => 'Campo requerido'));
    $this->mergePostValidator(new sfValidatorCallback(array('callback' => array($this, 'validateNoFutureDates'))));

    $this->setDefaults(array('mes' => date('n'),
			     'anio' => date('Y')
			     ));
  }

  public function configure()
  {
    $this->init();
    unset($this['foto']);
  }

  /**
   * Post-validator, checa que no se quieran registrar entradas con fechas en el futuro
   */
  public function validateNoFutureDates($validator, $values, $arguments)
  {
    if ($values['anio'] == date('Y') && $values['mes'] > date('n'))
      {
	throw new sfValidatorError($validator, "¡La fecha no puede estar en el futuro!");
      }
    return $values;
  }
}

/**
 * GuaulogEditEntrada form.
 *
 * @package    guaulog
 * @subpackage form
 * @author     Javier Novoa C.
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GuaulogEditEntradaForm extends GuaulogEntradaForm
{
  public function configure()
  {
    $this->init();
    $this->imagepath = '/uploads/.thumbnails/';

    $fotos = Doctrine_Core::getTable('GuaulogFoto')->queryFotosForEntrada($this->getObject()->get('mes'), $this->getObject()->get('anio'))->execute();
    $choices = array('' => 'Sin foto');
    foreach ($fotos as $foto):
      $choices[$foto->getId()] = $foto->getId();
    endforeach;

    $this->widgetSchema['foto'] = new sfWidgetFormSelectRadio(array(
    								    'choices' => $choices,
								    'formatter' => array($this, 'showAsImages')
    								    ));
    $this->validatorSchema['foto'] = new sfValidatorChoice(array(
								 'choices' => $choices,
								 'required' => false
								 ),
							   array('invalid' => 'Opción inválida'));
  }

  /**
   * Formatter to display choices as thumbnails of images
   */
  public function showAsImages($widget, $inputs)
  {
    $rows = array();
    foreach ($inputs as $input)
      {
	$domdoc = new DOMDocument();
	$domdoc->loadHTML($input['label']);
	$node = $domdoc->getElementsByTagName('label')->item(0);
	$foto = Doctrine_Core::getTable('GuaulogFoto')->find(array($node->nodeValue, $this->getObject()->get('id')));
	if ($foto != null)
	  {
	    $input['label'] = '<label '.$node->attributes->item(0)->name.'="'.$node->attributes->item(0)->value.'">' .
	      '<img src="'.$this->imagepath.$foto->getFoto().'" alt="Foto" />' .
	      '</label>';
	  }
	$rows[] = $widget->renderContentTag('li', $input['input'].$widget->getOption('label_separator').$input['label']);
      }
    return $widget->renderContentTag('ul', implode($widget->getOption('separator'), $rows), array('class' => $widget->getOption('class')));
  }
}
