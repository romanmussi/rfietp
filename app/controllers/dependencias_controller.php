<?php
class DependenciasController extends AppController {

	var $name = 'Dependencias';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Dependencia->recursive = 0;
		$this->set('dependencias', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Dependencia.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('dependencia', $this->Dependencia->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Dependencia->create();
			if ($this->Dependencia->save($this->data)) {
				$this->Session->setFlash(__('The Dependencia has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Dependencia could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Dependencia', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Dependencia->save($this->data)) {
				$this->Session->setFlash(__('The Dependencia has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Dependencia could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Dependencia->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Dependencia', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Dependencia->del($id)) {
			$this->Session->setFlash(__('Dependencia deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>