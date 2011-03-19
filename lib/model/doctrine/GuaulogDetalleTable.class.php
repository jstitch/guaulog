<?php

/**
 * GuaulogDetalleTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class GuaulogDetalleTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object GuaulogDetalleTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('GuaulogDetalle');
    }

    /**
     * Truncates data in table
     */
    public function truncate()
    {
      $q = $this->createQuery('q')
	->delete()
	;
      return $q->execute();
    }

    /**
     * Obtiene los detalles para una entrada determinada
     *
     * @param string $mes mes
     * @param string $anio año
     */
    public function getDetallesForEntrada($mes, $anio)
    {
      $q = Doctrine_Query::create()
	->from('GuaulogDetalle d')
	->leftJoin('d.GuaulogEntrada e')
	->where('e.mes = ?', $mes)
	->addWhere('e.anio = ?', $anio)
	;

      return $q->execute();
    }
}