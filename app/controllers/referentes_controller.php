<?php
class ReferentesController extends AppController {

	var $name = 'Referentes';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Referente->recursive = 0;
		$this->set('referentes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Referente.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('referente', $this->Referente->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Referente->create();
			if ($this->Referente->save($this->data)) {
				$this->Session->setFlash(__('The Referente has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Referente could not be saved. Please, try again.', true));
			}
		}
		$tipodocs = $this->Referente->Tipodoc->find('list');
		$jurisdicciones = $this->Referente->Jurisdiccion->find('list');
		$this->set(compact('tipodocs', 'jurisdicciones'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Referente', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Referente->save($this->data)) {
				$this->Session->setFlash(__('The Referente has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Referente could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Referente->read(null, $id);
		}
		$tipodocs = $this->Referente->Tipodoc->find('list');
		$jurisdicciones = $this->Referente->Jurisdiccion->find('list');
		$this->set(compact('tipodocs','jurisdicciones'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Referente', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Referente->del($id)) {
			$this->Session->setFlash(__('Referente deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>