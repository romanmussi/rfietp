<?php
class FondosLineasDeAccionesController extends AppController {

	var $name = 'FondosLineasDeAcciones';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->FondosLineasDeAccion->recursive = 0;
		$this->set('fondosLineasDeAcciones', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid FondosLineasDeAccion', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('fondosLineasDeAccion', $this->FondosLineasDeAccion->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->FondosLineasDeAccion->create();
			if ($this->FondosLineasDeAccion->save($this->data)) {
				$this->Session->setFlash(__('The FondosLineasDeAccion has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The FondosLineasDeAccion could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid FondosLineasDeAccion', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->FondosLineasDeAccion->save($this->data)) {
				$this->Session->setFlash(__('The FondosLineasDeAccion has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The FondosLineasDeAccion could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->FondosLineasDeAccion->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for FondosLineasDeAccion', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->FondosLineasDeAccion->del($id)) {
			$this->Session->setFlash(__('FondosLineasDeAccion deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The FondosLineasDeAccion could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>