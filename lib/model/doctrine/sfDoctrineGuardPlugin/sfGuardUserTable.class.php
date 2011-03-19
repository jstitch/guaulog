<?php

/**
 * sfGuardUserTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class sfGuardUserTable extends PluginsfGuardUserTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object sfGuardUserTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('sfGuardUser');
    }

  public function retrieveByUsername($username, $isActive = true)
  {
    $query = Doctrine_Core::getTable('sfGuardUser')->createQuery('u')
      ->where('u.username = ?', $username)
      ->addWhere('u.is_active = ?', $isActive)
      ->addWhere('u.is_super_admin = ?', false)
    ;

    return $query->fetchOne();
  }

  public function retrieveByUsernameOrEmailAddress($username, $isActive = true)
  {
    $query = Doctrine_Core::getTable('sfGuardUser')->createQuery('u')
      ->where('u.username = ? OR u.email_address = ?', array($username, $username))
      ->addWhere('u.is_active = ?', $isActive)
      ->addWhere('u.is_super_admin = ?', false)
    ;

    return $query->fetchOne();
  }
}