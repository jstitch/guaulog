<?php

/**
 * fotos actions.
 *
 * @package    guaulog
 * @subpackage fotos
 * @author     Javier Novoa C.
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class fotosActions extends sfActions
{
  /*  public function executeIndex(sfWebRequest $request)
  {
    $this->mes = $request->getParameter('mes');
    $this->anio = $request->getParameter('anio');
    $this->toindex = $request->getParameter('toindex');

    $this->fotos = Doctrine_Core::getTable('GuaulogFoto')
      ->getFotosForEntrada($this->mes,
			   $this->anio);
    $this->entrada = Doctrine_Core::getTable('GuaulogEntrada')
      ->getEntradaByMesAnio($this->mes,
			    $this->anio);
			    }*/

  public function executeNew(sfWebRequest $request)
  {
    $mes = $request->getParameter('mes');
    $anio = $request->getParameter('anio');
    //    $this->toindex = $request->getParameter('toindex');
    $this->register = $request->getParameter('register');

    $this->form = new GuaulogFotoForm();
    $entrada = Doctrine_Core::getTable('GuaulogEntrada')
      ->getEntradaByMesAnio($mes,
			    $anio);
    $this->form->setEntrada($entrada);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new GuaulogFotoForm();
    //    $this->toindex = $request->getPostParameter('toindex');
    $this->register = $request->getPostParameter('register');

    $this->processForm($request, $this->form, true);

    $formvalues = $request->getParameter($this->form->getName());
    $this->form->setEntrada(Doctrine_Core::getTable('GuaulogEntrada')
			    ->find(array($formvalues['entrada_id'])));
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    //    $this->foto = $this->getRoute()->getObject();
    $entrada = Doctrine_Core::getTable('GuaulogEntrada')->getEntradaByMesAnio($request->getParameter('mes'), $request->getParameter('anio'));
    $this->forward404Unless($this->foto = Doctrine_Core::getTable('GuaulogFoto')->find(array($request->getParameter('id'),
											     $entrada->getId())),
			    sprintf('Object foto does not exist (%s).', $request->getParameter('id')));
    //    $this->toindex = $request->getParameter('toindex');

    $this->form = new GuaulogFotoForm($this->foto);
    $this->form->setEntrada($this->foto->getGuaulogEntrada());
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->form = new GuaulogFotoForm($this->getRoute()->getObject());
    //    $this->toindex = $request->getPostParameter('toindex');

    $this->processForm($request, $this->form);

    $formvalues = $request->getParameter($this->form->getName());

    $this->form->setEntrada(Doctrine_Core::getTable('GuaulogEntrada')
			    ->find(array($formvalues['entrada_id'])));
    $this->foto = Doctrine_Core::getTable('GuaulogFoto')
      ->find(array($formvalues['id']));
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $entrada = Doctrine_Core::getTable('GuaulogEntrada')->getEntradaByMesAnio($request->getParameter('mes'), $request->getParameter('anio'));
    $this->forward404Unless($foto = Doctrine_Core::getTable('GuaulogFoto')->find(array($request->getParameter('id'),
										       $entrada->getId())),
			    sprintf('Object foto does not exist (%s).', $request->getParameter('id')));

    $mes = $foto->getGuaulogEntrada()->getMes();
    $anio = $foto->getGuaulogEntrada()->getAnio();
    $foto->delete();

    /*    if ($request->getParameter('toindex'))
      {
	$this->redirect('foto', array('mes' => $mes, 'anio' => $anio, 'toindex' => true));
	}*/
    $this->getUser()->setFlash('notice', sprintf('Foto eliminada'));
    $this->redirect('entrada/' . $entrada->getId());
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $new = false)
  {
    $form->bind(
                $request->getParameter($form->getName()),
                $request->getFiles($form->getName())
                );

    if ($form->isValid())
      {
	$this->foto = $form->save();

	$entrada = $this->foto->getGuaulogEntrada();
	$this->getUser()->setFlash('notice', sprintf('Foto %s correctamente', $new ? 'agregada' : 'cambiada'));
	if (isset($this->register) && $this->register)
	  {
	    $entrada->updateSetFoto($this->foto);
	  }
	/*	if (isset($this->toindex) && $this->toindex)
	  {
	    $this->redirect('foto/index?' . http_build_query(array(
								   'mes' => $entrada->getMes(),
								   'anio' => $entrada->getAnio(),
								   'toindex' => true
							   ))
			    );
			    }*/
	$this->redirect('entrada_show', $entrada);
      }
    else
      {
	$this->getUser()->setFlash('error', sprintf('Ocurrio un error al %s la foto', $new ? 'agregar' : 'cambiar'));
      }
  }
}
