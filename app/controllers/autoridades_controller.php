<?php
class AutoridadesController extends AppController {

	var $name = 'Autoridades';
	var $helpers = array('Html', 'Form', 'Time');

        function beforeFilter() {
            parent::beforeFilter();
            $this->rutaUrl_for_layout[] =array('name'=> 'Listado de Jurisdicciones','link'=>'/Jurisdicciones/listado' );
        }
        
	function index($id = null) {

            $this->rutaUrl_for_layout[] =array('name'=> 'Datos Jurisdicción','link'=>'/Jurisdicciones/view/' . $id );
            if (!$id) {
                    $this->Session->setFlash(__('Invalid Autoridad', true));
                    $this->redirect(array('controller'=>'Jurisdicciones','action' => 'index'));
            }

            $this->Autoridad->recursive = 0;

            $this->paginate['conditions']['Autoridad.jurisdiccion_id'] = $id ;
            $this->paginate['contain'] = array('Jurisdiccion','Cargo'=>array('order'=>'Cargo.rango')) ;

            $this->set('autoridades', $this->paginate());
            $this->set('jurisdiccion_id',$id);
            $this->set('jurisdiccion',$this->Autoridad->Jurisdiccion->find('first',array('conditions'=>array('Jurisdiccion.id'=>$id))));
	}

        function index_x_jurisdiccion($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Autoridad', true));
			$this->redirect(array('controller'=>'Jurisdiccion','action' => 'index'));
		}

		$this->Autoridad->recursive = 0;

                $this->paginate['conditions']['Autoridad.jurisdiccion_id'] = $id ;
                $this->paginate['contain'] = array(
                    'Cargo'=>array(
                        'order'=>array('Cargo.rango'),
                        'conditions' => array('Cargo.rango != 1')
                        
                        ),
                    'Localidad',
                    'Departamento',
                    'Jurisdiccion'
                    ) ;

                $autoridades = $this->paginate();
                $aux = array();
                $i = 0;

                foreach($autoridades as $autoridad){
                    foreach($autoridad['Cargo'] as $cargo){
                        $aux[$i]['Cargo'] = $cargo;
                        $aux[$i]['Autoridad'] = $autoridad['Autoridad'];
                        $aux[$i]['Autoridad']['Localidad'] = $autoridad['Localidad'];
                        $aux[$i]['Autoridad']['Departamento'] = $autoridad['Departamento'];
                        $aux[$i]['Autoridad']['Jurisdiccion'] = $autoridad['Jurisdiccion'];

                        $i++;
                    }
                }

                usort($aux, array( $this, 'comparador_por_rango' ));

                $this->set('jurisdiccion', $this->Autoridad->Jurisdiccion->find('first',array('conditions'=>array('Jurisdiccion.id'=>$id))));
		$this->set('autoridades', $aux);
                $this->set('jurisdiccion_id',$id);
	}

        function comparador_por_rango($a, $b)
        {
            $a_order = $a['Cargo']['rango'];
            $b_order = $b['Cargo']['rango'];

            if ($a_order == $b_order) {
                return 0;
            }
            return ($a_order > $b_order) ? +1 : -1;
        }

	function view($id = null) {
                $this->data = $this->Autoridad->read(null, $id);

                $this->rutaUrl_for_layout[] =array('name'=> 'Autoridades','link'=>'/Autoridades/index/' . $this->data['Autoridad']['jurisdiccion_id'] );

		if (!$id) {
			$this->Session->setFlash(__('Invalid Autoridad', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('autoridad', $this->data);
	}

	function add($id = null) {
                $this->rutaUrl_for_layout[] =array('name'=> 'Datos Jurisdicción','link'=>'/Jurisdicciones/view/' . $id );
                $this->rutaUrl_for_layout[] =array('name'=> 'Autoridades','link'=>'/Autoridades/index/' . $id );
		if (!empty($this->data)) {
                    $this->Autoridad->create();
                        if(!(empty($this->data['Jurisdiccion']['']))){

                        }
			if ($this->Autoridad->saveAll($this->data)) {
				$this->Session->setFlash(__('La Autoridad ha sido creada', true));
				$this->redirect(array('controller' => 'Autoridades','action' => 'index',$this->data['Autoridad']['jurisdiccion_id']));
			} else {
				$this->Session->setFlash(__('La Autoridad no se pudo crear. Intente nuevamente.', true));
			}
		}
                $jurisdicciones = $this->Autoridad->Jurisdiccion->find('list');
                $localidades = $this->Autoridad->Localidad->find('list');
                $departamentos = $this->Autoridad->Departamento->find('list');

                $ministros = $this->Autoridad->Cargo->find('list',array('fields' => array('Cargo.id', 'Cargo.nombre'),'conditions'=>array('rango'=> 1)));
                $referentes = $this->Autoridad->Cargo->find('list',array('fields' => array('Cargo.id', 'Cargo.nombre'),'conditions'=>array( 'NOT' => array( 'rango'=> 1))));

                $this->set(compact('jurisdicciones', 'localidades', 'departamentos','ministros','referentes'));
                $this->set('jurisdiccion_id',$id);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Autoridad', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
                        $this->Autoridad->AutoridadesCargo->deleteAll(array('AutoridadesCargo.autoridad_id' => $id));
                        if ($this->Autoridad->save($this->data)) {
				$this->Session->setFlash(__('La Autoridad ha sido creada', true));
				$this->redirect(array('controller' => 'Autoridades','action' => 'index',$this->data['Autoridad']['jurisdiccion_id']));
			} else {
				$this->Session->setFlash(__('La Autoridad no se pudo crear. Intente nuevamente.', true));
			}
		}
		else{
			$this->data = $this->Autoridad->read(null, $id);
            debug($this->data);

                        $this->rutaUrl_for_layout[] =array('name'=> 'Datos Jurisdicción','link'=>'/Jurisdicciones/view/' . $this->data['Autoridad']['jurisdiccion_id']);
                        $this->rutaUrl_for_layout[] =array('name'=> 'Autoridades','link'=>'/Autoridades/index/' . $this->data['Autoridad']['jurisdiccion_id'] );

                        $locdep = array();
                        $locdep['Localidad'] = array('id'=>$this->data['Localidad']['id'],'name'=>$this->data['Localidad']['name']);
                        $locdep['Departamento'] = array('id'=>$this->data['Departamento']['id'],'name'=>$this->data['Departamento']['name']);
                }
                $jurisdicciones = $this->Autoridad->Jurisdiccion->find('list');

                $ministros = $this->Autoridad->Cargo->find('list',array('fields' => array('Cargo.id', 'Cargo.nombre'),'conditions'=>array('rango'=> 1)));
                $referentes = $this->Autoridad->Cargo->find('list',array('fields' => array('Cargo.id', 'Cargo.nombre'),'conditions'=>array( 'NOT' => array( 'rango'=> 1))));
                
                $this->set(compact('jurisdicciones', 'localidades', 'departamentos','ministros','referentes'));
                $this->set('jurisdiccion_id',$this->data['Autoridad']['jurisdiccion_id']);
                $this->set('locdep',$locdep);
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Autoridad', true));
			$this->redirect(array('action' => 'index'));
		}
                $this->data = $this->Autoridad->read(null, $id);
                
		if ($this->Autoridad->del($id)) {
			$this->Session->setFlash(__('Autoridad eliminada', true));
			$this->redirect(array('controller' => 'Autoridades','action' => 'index',$this->data['Autoridad']['jurisdiccion_id']));
		}
		$this->Session->setFlash(__('The Autoridad could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>