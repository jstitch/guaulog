<?php

/**
 * GuaulogEntrada form base class.
 *
 * @method GuaulogEntrada getObject() Returns the current form's model object
 *
 * @package    guaulog
 * @subpackage form
 * @author     Javier Novoa C.
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGuaulogEntradaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'mes'        => new sfWidgetFormInputText(),
      'anio'       => new sfWidgetFormInputText(),
      'mide'       => new sfWidgetFormInputText(),
      'pesa'       => new sfWidgetFormInputText(),
      'pc'         => new sfWidgetFormInputText(),
      'foto'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('GuaulogFoto'), 'add_empty' => true)),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'slug'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'mes'        => new sfValidatorInteger(),
      'anio'       => new sfValidatorInteger(),
      'mide'       => new sfValidatorNumber(array('required' => false)),
      'pesa'       => new sfValidatorNumber(array('required' => false)),
      'pc'         => new sfValidatorNumber(array('required' => false)),
      'foto'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('GuaulogFoto'), 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
      'slug'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'GuaulogEntrada', 'column' => array('mes', 'anio'))),
        new sfValidatorDoctrineUnique(array('model' => 'GuaulogEntrada', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('guaulog_entrada[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GuaulogEntrada';
  }

}
