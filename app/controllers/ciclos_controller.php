<?php
class CiclosController extends AppController {

	var $name = 'Ciclos';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Ciclo->recursive = 0;
		$this->set('ciclos', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Ciclo.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('ciclo', $this->Ciclo->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Ciclo->create();
			if ($this->Ciclo->save($this->data)) {
				$this->Session->setFlash(__('The Ciclo has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Ciclo could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Ciclo', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Ciclo->save($this->data)) {
				$this->Session->setFlash(__('The Ciclo has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Ciclo could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Ciclo->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Ciclo', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Ciclo->del($id)) {
			$this->Session->setFlash(__('Ciclo deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	
	
	
	/**
	 * 
	 * 
	 *  RequestAction
	 */
	function dame_ciclos(){
		$this->Ciclo->recursive = -1;
		return $this->Ciclo->find('list');
	}

}
?>