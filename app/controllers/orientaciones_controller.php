<?php
class OrientacionesController extends AppController {

	var $name = 'Orientaciones';
	var $scafold = true;

	function index() {
		//$this->Sector->recursive = 0;
		$this->set('orientaciones', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Orientacion.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('orientacion', $this->Orientacion->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Orientacion->create();
			if ($this->Orientacion->save($this->data)) {
				$this->Session->setFlash(__('The Orientacion has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Orientacion could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Orientacion', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Orientacion->save($this->data)) {
				$this->Session->setFlash(__('The Orientacion has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Orientacion could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Orientacion->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Orientacion', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Orientacion->del($id)) {
			$this->Session->setFlash(__('Orientacion deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>