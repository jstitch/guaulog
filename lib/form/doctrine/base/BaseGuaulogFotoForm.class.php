<?php

/**
 * GuaulogFoto form base class.
 *
 * @method GuaulogFoto getObject() Returns the current form's model object
 *
 * @package    guaulog
 * @subpackage form
 * @author     Javier Novoa C.
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGuaulogFotoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'entrada_id' => new sfWidgetFormInputHidden(),
      'foto'       => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'entrada_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('entrada_id')), 'empty_value' => $this->getObject()->get('entrada_id'), 'required' => false)),
      'foto'       => new sfValidatorString(array('max_length' => 255)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('guaulog_foto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GuaulogFoto';
  }

}
