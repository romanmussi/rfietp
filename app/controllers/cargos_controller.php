<?php
class CargosController extends AppController {

	var $name = 'Cargos';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Cargo->recursive = 0;
		$this->set('cargos', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Cargo', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('cargo', $this->Cargo->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Cargo->create();
			if ($this->Cargo->save($this->data)) {
				$this->Session->setFlash(__('The Cargo has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Cargo could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Cargo', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Cargo->save($this->data)) {
				$this->Session->setFlash(__('The Cargo has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Cargo could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Cargo->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Cargo', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Cargo->del($id)) {
			$this->Session->setFlash(__('Cargo deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Cargo could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>