<?php
class ModalidadesController extends AppController {

	var $name = 'Modalidades';
	var $scafold = true;

	function index() {
		$this->set('modalidades', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Modalidad.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('modalidad', $this->Modalidad->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Modalidad->create();
			if ($this->Modalidad->save($this->data)) {
				$this->Session->setFlash(__('The Modalidad has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Modalidad could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Modalidad', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Modalidad->save($this->data)) {
				$this->Session->setFlash(__('The Modalidad has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Modalidad could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Modalidad->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Modalidad', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Modalidad->del($id)) {
			$this->Session->setFlash(__('Modalidad deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>