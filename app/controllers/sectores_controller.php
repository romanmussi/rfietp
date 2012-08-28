<?php
class SectoresController extends AppController {

	var $name = 'Sectores';
	var $helpers = array('Html', 'Form');

	function index() {
		//$this->Sector->recursive = 0;
		$this->paginate = array ('contain' => 'Orientacion');
		$this->set('sectores', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Sector.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('sector', $this->Sector->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Sector->create();
			if ($this->Sector->save($this->data)) {
				$this->Session->setFlash(__('El Sector ha sido creado', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('El Sector no puede guardarse. Por favor, intente nuevamente.', true));
			}
		}
		
		$this->set('orientaciones', $this->Sector->Orientacion->find('list'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Sector', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Sector->save($this->data)) {
				$this->Session->setFlash(__('El Sector ha sido guardado', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('El Sector no puede guardarse. Por favor, intente nuevamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Sector->read(null, $id);
		}
		$this->set('orientaciones', $this->Sector->Orientacion->find('list'));
	}

	function delete($id = null) {	
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Sector', true));
			$this->redirect(array('action'=>'index'));
		}
                else {
                    /*** validaciones ***/
                    // Si el Subsector esta asociado a algun Sector
                    $this->Sector->Subsector->recursive = -1;
                    $titulo = $this->Sector->Subsector->find('first', array(
                        'conditions' => array('Subsector.sector_id' => $id),
                    ));

                    if (!empty($titulo)) {
                        $this->Session->setFlash(__('El Sector no puede eliminarse debido a que tiene asociados uno o más Subsectores', true));
                        $this->redirect(array('action'=>'index'));
                    }

                    //Si el sector esta asociado a algun título no debe eliminar
                    $this->Sector->SectoresTitulo->recursive = -1;
                    $titulo = $this->Sector->SectoresTitulo->find('first', array(
                        'conditions' => array('SectoresTitulo.sector_id' => $id),
                    ));

                    if (!empty($titulo)) {
                        $this->Session->setFlash(__('El Sector no puede eliminarse debido a que está asociado a uno o más Títulos de Referencia', true));
                        $this->redirect(array('action'=>'index'));
                    }

                    if ($this->Sector->del($id)) {
                            $this->Session->setFlash(__('Sector eliminado', true));
                            $this->redirect(array('action'=>'index'));
                    }
                }
                
	}
}
?>