<?php

/**
 * BaseGuaulogFoto
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $entrada_id
 * @property string $foto
 * @property GuaulogEntrada $GuaulogEntrada
 * 
 * @method integer        getId()             Returns the current record's "id" value
 * @method integer        getEntradaId()      Returns the current record's "entrada_id" value
 * @method string         getFoto()           Returns the current record's "foto" value
 * @method GuaulogEntrada getGuaulogEntrada() Returns the current record's "GuaulogEntrada" value
 * @method GuaulogFoto    setId()             Sets the current record's "id" value
 * @method GuaulogFoto    setEntradaId()      Sets the current record's "entrada_id" value
 * @method GuaulogFoto    setFoto()           Sets the current record's "foto" value
 * @method GuaulogFoto    setGuaulogEntrada() Sets the current record's "GuaulogEntrada" value
 * 
 * @package    guaulog
 * @subpackage model
 * @author     Javier Novoa C.
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGuaulogFoto extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('guaulog_foto');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('entrada_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('foto', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('GuaulogEntrada', array(
             'local' => 'entrada_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}