<?php

/**
 * GuaulogEntrada filter form base class.
 *
 * @package    guaulog
 * @subpackage filter
 * @author     Javier Novoa C.
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGuaulogEntradaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mes'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'anio'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mide'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pesa'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'pc'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'foto'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('GuaulogFoto'), 'add_empty' => true)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mes'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'anio'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mide'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'pesa'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'pc'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'foto'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('GuaulogFoto'), 'column' => 'id')),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('guaulog_entrada_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GuaulogEntrada';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'mes'        => 'Number',
      'anio'       => 'Number',
      'mide'       => 'Number',
      'pesa'       => 'Number',
      'pc'         => 'Number',
      'foto'       => 'ForeignKey',
      'created_at' => 'Date',
      'updated_at' => 'Date',
      'slug'       => 'Text',
    );
  }
}
