<?php
class GestionesController extends AppController {

	var $name = 'Gestiones';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Gestion->recursive = 0;
		$this->set('gestiones', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Gestion.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('gestion', $this->Gestion->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Gestion->create();
			if ($this->Gestion->save($this->data)) {
				$this->Session->setFlash(__('The Gestion has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Gestion could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Gestion', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Gestion->save($this->data)) {
				$this->Session->setFlash(__('The Gestion has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Gestion could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Gestion->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Gestion', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Gestion->del($id)) {
			$this->Session->setFlash(__('Gestion deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>