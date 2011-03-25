<?php

/**
 * detalles actions.
 *
 * @package    guaulog
 * @subpackage detalles
 * @author     Javier Novoa C.
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class detallesActions extends sfActions
{
  /*  public function executeIndex(sfWebRequest $request)
  {
    $this->mes = $request->getParameter('mes');
    $this->anio = $request->getParameter('anio');
    $this->toindex = $request->getParameter('toindex');

    $this->detalles = Doctrine_Core::getTable('GuaulogDetalle')
      ->getDetallesForEntrada($this->mes,
			      $this->anio);
    $this->entrada = Doctrine_Core::getTable('GuaulogEntrada')
      ->getEntradaByMesAnio($this->mes,
			    $this->anio);
			    }*/

  public function executeNew(sfWebRequest $request)
  {
    $this->forward404Unless($entrada = Doctrine_Core::getTable('GuaulogEntrada')->getEntradaBySlug(array('slug' => $request->getParameter('entrada'))),
			    sprintf('Object entrada does not exists (%s)', $request->getParameter('entrada')));

    //    $this->toindex = $request->getParameter('toindex');

    $this->form = new GuaulogDetalleForm();
    $this->form->setEntrada($entrada);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new GuaulogDetalleForm();

    //    $this->toindex = $request->getPostParameter('toindex');

    $this->processForm($request, $this->form, true);

    $formvalues = $request->getParameter($this->form->getName());

    $this->form->setEntrada(Doctrine_Core::getTable('GuaulogEntrada')
			    ->find(array($formvalues['entrada_id'])));
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($detalle = $this->getRoute()->getObject(),
			    sprintf('Object detalle does not exist.'));

    //    $this->toindex = $request->getParameter('toindex');

    $this->form = new GuaulogDetalleForm($detalle);

    $this->form->setEntrada($detalle->getGuaulogEntrada());
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($detalle = $this->getRoute()->getObject(),
			    sprintf('Object detalle does not exist.'));

    //    $this->toindex = $request->getPostParameter('toindex');

    $this->form = new GuaulogDetalleForm($detalle);

    $this->processForm($request, $this->form);

    $formvalues = $request->getParameter($this->form->getName());

    $this->form->setEntrada($detalle->getGuaulogEntrada());
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::DELETE));
    //    $request->checkCSRFProtection();
    $this->forward404Unless($detalle = $this->getRoute()->getObject(),
			    sprintf('Object detalle does not exist.'));

    $slug = $detalle->getGuaulogEntrada()->getSlug();
    $detalle->delete();

    /*    if ($request->getParameter('toindex'))
      {
	$this->redirect('detalle', array('mes' => $mes, 'anio' => $anio, 'toindex' => true));
	}*/
    $this->getUser()->setFlash('notice', sprintf('Detalle eliminado'));
    $this->redirect('@entrada_show?' . 'slug=' . $slug);
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $new = false)
  {
    $form->bind(
                $request->getParameter($form->getName()),
                $request->getFiles($form->getName())
                );

    if ($form->isValid())
      {
	$this->detalle = $form->save();

	$this->getUser()->setFlash('notice', sprintf('Detalle %s correctamente', $new ? 'creado' : 'editado'));
	/*	if (isset($this->toindex) && $this->toindex)
	  {
	    $this->redirect('detalle/index?' . http_build_query(array(
								      'mes' => $entrada->getMes(),
								      'anio' => $entrada->getAnio(),
								      'toindex' => true
								      ))
			    );
			    }*/
	$this->redirect('@entrada_show?' . 'slug=' . $this->detalle->getGuaulogEntrada()->getSlug());
      }
    else
      {
	$this->getUser()->setFlash('error', sprintf('Ocurrio un error al %s el detalle', $new ? 'crear' : 'editar'));
      }
  }
}
