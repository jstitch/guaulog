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
	    $this->redirect('entrada_show', $this->entrada);
	  }
	$this->nombre = sfConfig::get('app_nombre');
	$this->logo = sfConfig::get('app_logo');
	$this->setTemplate('index');
      }
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->entrada = $this->getRoute()->getObject();
    $this->forward404Unless($this->entrada,
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
    //    $this->entrada = $this->getRoute()->getObject();
    $this->entrada = Doctrine_Core::getTable('GuaulogEntrada')
      ->getEntradaByMesAnio($request->getParameter('mes'),
    			    $request->getParameter('anio'));
    $this->forward404Unless($this->entrada,
			    sprintf('Object guaulog_entrada does not exist (%s).', $request->getParameter('id')));

    $this->form = new GuaulogEditEntradaForm($this->entrada);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($guaulog_entrada = Doctrine_Core::getTable('GuaulogEntrada')
			    ->find(array($request->getParameter('id'))),
			    sprintf('Object guaulog_entrada does not exist (%s).', $request->getParameter('id')));
    
    $arr = $request->getParameter('guaulog_entrada');
    if (isset($arr['foto']))
      {
	$this->form = new GuaulogEditEntradaForm($guaulog_entrada);
      }
    else
      {
	$this->form = new GuaulogEntradaForm($guaulog_entrada);
      }


    $this->processForm($request, $this->form);

    $this->entrada = Doctrine_Core::getTable('GuaulogEntrada')->find(array($request->getParameter('id')));
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //    $request->checkCSRFProtection();
    $guaulog_entrada = Doctrine_Core::getTable('GuaulogEntrada')
      ->getEntradaByMesAnio($request->getParameter('mes'),
			    $request->getParameter('anio'));
    $this->forward404Unless($guaulog_entrada, sprintf('Object guaulog_entrada does not exist (%s).', $request->getParameter('id')));
    $guaulog_entrada->delete();

    $this->getUser()->setFlash('notice',
			       sprintf('Entrada eliminada: %s de %s',
				       $guaulog_entrada->getNombreMes(), $guaulog_entrada->getAnio()));
    $this->redirect('entrada/index');
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
		$this->redirect('fotos/new?' . http_build_query(array(
								      'mes'       => $entrada->getMes(),
								      'anio'      => $entrada->getAnio(),
								      'register'  => true)
								));
	      }
	    $this->redirect('entrada/show?' . http_build_query(array(
								     'mes' => $entrada->getMes(),
								     'anio' => $entrada->getAnio())
							       ));
      }
    else
      {
	$this->getUser()->setFlash('error', sprintf('Ocurrio un error al %s la entrada', $new ? 'crear' : 'editar'));
      }
  }
}
