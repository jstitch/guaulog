<?php

/**
 * entrada actions.
 *
 * @package    guaulog
 * @subpackage entrada
 * @author     Javier Novoa C.
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class entradaActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->nombre = sfConfig::get('app_nombre');
    $this->logo = sfConfig::get('app_logo');
    $this->form = new PortadaForm();

    if ($request->isMethod('post'))
      {
	$this->form = new PortadaForm();
	$this->form->bind($request->getParameter($this->form->getName()),
			  $request->getFiles($this->form->getName()));
	if($this->form->isValid())
	  {
	    $arr = $request->getParameter($this->form->getName());
	    $this->entrada = Doctrine_Core::getTable('GuaulogEntrada')->
	      getEntradaByMesAnio($arr['mes'], $arr['anio']);
	    $this->redirect('@entrada_show?' . 'slug=' . $this->entrada->getSlug());
	  }
	foreach ($this->form->getGlobalErrors() as $error):
	  $this->getUser()->setFlash('error', sprintf($error->getMessage()));
	endforeach;
	foreach ($this->form->getErrorSchema()->getErrors() as $error):
	  $this->getUser()->setFlash('error', sprintf($error->getMessage()));
	endforeach;
	$this->nombre = sfConfig::get('app_nombre');
	$this->logo = sfConfig::get('app_logo');
	$this->redirect('@homepage');
      }
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($this->entrada = $this->getRoute()->getObject(),
			    sprintf('Object guaulog_entrada does not exist (%s).', $request->getParameter('id')));
  }

  public function executeNew(sfWebRequest $request)
  {
    $lastentrada = Doctrine_Core::getTable('GuaulogEntrada')->getUltima();
    $entrada = new GuaulogEntrada();
    if ($lastentrada)
      {
	$entrada->setMide($lastentrada->getMide());
	$entrada->setPesa($lastentrada->getPesa());
	$entrada->setPc($lastentrada->getPc());
      }
    $this->form = new GuaulogEntradaForm($entrada);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new GuaulogEntradaForm();
    $this->processForm($request, $this->form, true);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($this->entrada = $this->getRoute()->getObject(),
			    sprintf('Object guaulog_entrada does not exist (%s).', $request->getParameter('id')));
    $this->form = new GuaulogEditEntradaForm($this->entrada);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($this->entrada = $this->getRoute()->getObject(), sprintf('Object guaulog_entrada does not exist.'));
    
    $arr = $request->getParameter('guaulog_entrada');
    if (isset($arr['foto']))
      {
	$this->form = new GuaulogEditEntradaForm($this->entrada);
      }
    else
      {
	$this->form = new GuaulogEntradaForm($this->entrada);
      }


    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::DELETE));
    //    $request->checkCSRFProtection();
    $this->forward404Unless($this->entrada = $this->getRoute()->getObject(), sprintf('Object guaulog_entrada does not exist.'));

    $this->entrada->delete();

    $this->getUser()->setFlash('notice',
			       sprintf('Entrada eliminada: %s de %s',
				       $this->entrada->getNombreMes(), $this->entrada->getAnio()));
    $this->redirect('@entrada');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $new = false)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
      {
	    $entrada = $form->save();
	    $this->getUser()->setFlash('notice',
				       sprintf('Entrada %s correctamente para %s de %s',
					       $new ? 'creada' : 'editada',
					       $entrada->getNombreMes(), $entrada->getAnio()));
	    if ($new == true)
	      {
		$this->redirect('@foto_new?' . http_build_query(array(
								       'entrada'      => $entrada->getSlug(),
								       'register'  => true)
								));
	      }
	    $this->redirect('@entrada_show?' . 'slug=' . $entrada->getSlug());
      }
    else
      {
	$this->getUser()->setFlash('error', sprintf('Ocurrio un error al %s la entrada', $new ? 'crear' : 'editar'));
      }
  }
}
