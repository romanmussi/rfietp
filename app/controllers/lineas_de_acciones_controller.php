<?php
class LineasDeAccionesController extends AppController {

	var $name = 'LineasDeAcciones';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->LineasDeAccion->recursive = 0;
		$this->set('lineasDeAcciones', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid LineasDeAccion', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('lineasDeAccion', $this->LineasDeAccion->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->LineasDeAccion->create();
			if ($this->LineasDeAccion->save($this->data)) {
				$this->Session->setFlash(__('The LineasDeAccion has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The LineasDeAccion could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid LineasDeAccion', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->LineasDeAccion->save($this->data)) {
				$this->Session->setFlash(__('The LineasDeAccion has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The LineasDeAccion could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->LineasDeAccion->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for LineasDeAccion', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->LineasDeAccion->del($id)) {
			$this->Session->setFlash(__('LineasDeAccion deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The LineasDeAccion could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>