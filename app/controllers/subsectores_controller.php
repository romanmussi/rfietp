<?php
class SubsectoresController extends AppController {

	var $name = 'Subsectores';
	var $helpers = array('Html', 'Form');
        var $components = array('RequestHandler');

	function index() {
		$this->Subsector->recursive = 0;
		$this->set('subsectores', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Subsector.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('subsector', $this->Subsector->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Subsector->create();
			if ($this->Subsector->save($this->data)) {
				$this->Session->setFlash(__('El Subsector ha sido creado', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('El Subsector no puede guardarse. Por favor, intente nuevamente.', true));
			}
		}
		$sectores = $this->Subsector->Sector->find('list');
		$this->set(compact('sectores'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Subsector', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			
			if ($this->Subsector->save($this->data)) {
				
				if($this->data['Subsector']['old_sector_id'] != $this->data['Subsector']['sector_id']) {
					$sql = "UPDATE planes SET sector_id=".$this->data['Subsector']['sector_id']. 
							" WHERE sector_id=".$this->data['Subsector']['old_sector_id']." AND subsector_id=".$this->data['Subsector']['id'];

					$this->Subsector->query($sql);
				}			
				
				$this->Session->setFlash(__('El Subsector ha sido guardado', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('El Subsector no puede guardarse. Por favor, intente nuevamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Subsector->read(null, $id);
		}
		
		$sectores = $this->Subsector->Sector->find('list');
		$this->data['Subsector']['old_sector_id'] = $this->data['Subsector']['sector_id']; 
		
		$this->set(compact('sectores'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Subsector', true));
			$this->redirect(array('action'=>'index'));
		}
                else {
                    /*** validaciones ***/
                    // Si el Subsector esta asociado a algun título no debe eliminar
                    $this->Subsector->SectoresTitulo->recursive = -1;
                    $titulo = $this->Subsector->SectoresTitulo->find('first', array(
                        'conditions' => array('SectoresTitulo.subsector_id' => $id),
                    ));

                    if (!empty($titulo)) {
                        $this->Session->setFlash(__('El Subsector no puede eliminarse debido a que está asociado a uno o más Títulos de Referencia', true));
                        $this->redirect(array('action'=>'index'));
                    }

                    if ($this->Subsector->del($id)) {
                            $this->Session->setFlash(__('Subsector eliminado', true));
                            $this->redirect(array('action'=>'index'));
                    }
                }
	}
	
	function ajax_select_subsector_form_por_sector(){
		 $this->layout = 'ajax';
                 Configure::write('debug',0);
                 $sector_id = 0;
                 
                 if (!empty($this->data['Plan']['sector_id'])) {
                        $sector_id = $this->data['Plan']['sector_id'];
                 }
                 else if(!empty($this->data['SectoresTitulo']['sector_id'])){
                        $sector_id = $this->data['SectoresTitulo']['sector_id'];
                 }
                 else{
                     if ($sector = current($this->data)):
                            if (isset($sector)):
                                    $sector_id = $sector['sector_id'];
                            endif;
                     endif;
                 }
                 
                 $subsectores = $this->Subsector->con_sector('all',$sector_id);

                 $this->set('todos', ($sector_id != 0 )?false:true);
                 $this->set('subsectores', $subsectores);                  
         
		 //prevent useless warnings for Ajax
	     $this->render('ajax_select_subsector_form_por_sector','ajax');
	}

        function getSubSectoresBySector(){
            $this->autoRender = false;

            if ( $this->RequestHandler->isAjax() ) {
              Configure::write ( 'debug', 0 );
            }
            
            $sector = $this->params['url']['sector'];
            $items = $this->Subsector->find("all", 
                                            array('conditions'=> array("sector_id" => $sector))
                    );

            $result = array();


            foreach ($items as $item) {

                array_push($result, array(
                        "id" => $item['Subsector']['id'],
                        "name" => utf8_encode($item['Subsector']['name'])
                ));
            }

            return json_encode($result);
        }
}
?>