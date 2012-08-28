<?php
class OfertasController extends AppController {

	var $name = 'Ofertas';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Oferta->recursive = 0;
		$this->set('ofertas', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Oferta.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('oferta', $this->Oferta->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Oferta->create();
			if ($this->Oferta->save($this->data)) {
				$this->Session->setFlash(__('The Oferta has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Oferta could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Oferta', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Oferta->save($this->data)) {
				$this->Session->setFlash(__('The Oferta has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Oferta could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Oferta->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Oferta', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Oferta->del($id)) {
			$this->Session->setFlash(__('Oferta deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	
	
	
	
	/********************************************************************
	 * 
	 * 
	 *  RequestAction
	 * 
	 * 
	 */
	/**
	 * Request action
	 * Devuelve el nombre de la oferta ID que se le pase
	 *
	 * @param $oferta_id
	 * @return String, devuelve el nombre
	 */
	function dame_nombre($oferta_id){
		$this->Oferta->recursive = -1;
		$oferta =  $this->Oferta->read(null,$oferta_id);
		return $oferta['Oferta']['name'];		
	}
	
	/**
	 * Request action
	 * Devuelve la abreviatura de la oferta ID que se le pase
	 *
	 * @param $oferta_id
	 * @return String, devuelve la abreviatura, FP, MT, etc
	 */
	function dame_abrev($oferta_id){
		$this->Oferta->recursive = -1;
		$oferta =  $this->Oferta->read(null,$oferta_id);
		return $oferta['Oferta']['abrev'];		
	}

}
?>