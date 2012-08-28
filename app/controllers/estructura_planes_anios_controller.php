<?php
class EstructuraPlanesAniosController extends AppController {

	var $name = 'EstructuraPlanesAnios';
	var $helpers = array('Html', 'Form');
        var $paginate = array('order'=>array('EstructuraPlanesAnio.anio_escolaridad'=>'asc'));

	function index() {
		//$this->EstructuraPlanesAnio->recursive = 0;
                $this->paginate['EstructuraPlanesAnio'] = array(
                    'contain' => array('EstructuraPlan.Etapa'),
                    'limit' => 30

                    );
                $ea = $this->paginate('EstructuraPlanesAnio');
		$this->set('estructuraPlanesAnios', $ea);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid EstructuraPlanesAnio.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('EstructuraPlanesAnio', $this->EstructuraPlanesAnio->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->EstructuraPlanesAnio->create();
			if ($this->EstructuraPlanesAnio->save($this->data)) {
				$this->Session->setFlash(__('The EstructuraPlanesAnio has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EstructuraPlanesAnio could not be saved. Please, try again.', true));
			}
		}
		$estructuraPlanes = $this->EstructuraPlanesAnio->Trayecto->find('list');
		$etapas = $this->EstructuraPlanesAnio->Etapa->find('list');
		$this->set(compact('estructuraPlanes', 'etapas'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid EstructuraPlanesAnio', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->EstructuraPlanesAnio->save($this->data)) {
				$this->Session->setFlash(__('El año de la estructura fue editado', true));
				$this->redirect(array('controller'=>'EstructuraPlanes', 'action'=>'edit', $this->data['EstructuraPlanesAnio']['estructura_plan_id']));
			} else {
				$this->Session->setFlash(__('El año de la estructura no pudo ser editado. Por favor intente nuevamente', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EstructuraPlanesAnio->read(null, $id);
		}

		$this->set(compact('estructuraPlanes','etapas'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for EstructuraPlanesAnio', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EstructuraPlanesAnio->del($id)) {
			$this->Session->setFlash(__('EstructuraPlanesAnio deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>