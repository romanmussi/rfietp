<?php
class FondosController extends AppController {

	var $name = 'Fondos';
	var $helpers = array('Html', 'Form');
        var $components = array('Filter');

        function beforeFilter() {
            parent::beforeFilter();
            $this->rutaUrl_for_layout[] =array('name'=> 'Buscador','link'=>'/Instits/search_form' );
        }
        
	function index_x_instit($id=null) {

            if ($id) {
                $instit = $this->Fondo->Instit->read(null, $id);

                // chequea que lo vea usuario de la jurisdiccion (condicion)
                if ($this->Session->read('User.group_alias') == strtolower(Configure::read('grupo_referentes')) ||
                    $this->Session->read('User.group_alias') == strtolower(Configure::read('grupo_ministros'))) {
                    if ($this->Session->read('User.jurisdiccion_id') != $instit['Instit']['jurisdiccion_id']) {
                        $this->Session->setFlash(__($this->Auth->planesMejoraError, true));
                        $this->redirect(array('controller'=>'Instits', 'action'=>'view', $id));
                    }

                    // solo ve dependencias provinciales (desde v1.6.3)
                    $this->paginate['conditions']['Instit.dependencia_id'] = DEPENDENCIA_PROVINCIAL;
                }
                // fin de chequeo

                $this->paginate['conditions']['Fondo.instit_id'] = $id;
                $this->paginate['order'] = array('Fondo.anio DESC','Fondo.trimestre DESC','Fondo.jurisdiccion_id DESC');
            }
            else {
                $this->Session->setFlash(__('No especifica institución', true));
                $this->redirect(array('action'=>'index'));
                //$this->paginate = array('conditions'=>array('Fondo.instit_id !='=>0),'order' => array('Fondo.anio DESC','Fondo.trimestre DESC','Fondo.jurisdiccion_id DESC'));
            }

            $this->Fondo->recursive = 1;
            //$this->set('sumalineas',  $this->Fondo->FondosLineasDeAccion->find('sum',array('conditions'=>array('Fondo.instit_id'=>$id) ) ) );
            
            $condicion['Fondo.instit_id'] = $id;

            $this->set('sumalineas', $this->Fondo->FondosLineasDeAccion->find('sum', array('conditions'=>$condicion)) );

            $this->set('instit', $instit);
            $this->set('fondos', $this->paginate());
	}

        function index_x_jurisdiccion($id=null) {
            $this->rutaUrl_for_layout[] =array('name'=> 'Listado de Jurisdicciones','link'=>'/Jurisdicciones/listado' );
            
            if ($id) {
                // chequea que lo vea usuario de la jurisdiccion (condicion)
                if ($this->Session->read('User.group_alias') == strtolower(Configure::read('grupo_referentes')) ||
                    $this->Session->read('User.group_alias') == strtolower(Configure::read('grupo_ministros'))) {
                    if ($this->Session->read('User.jurisdiccion_id') != $id) {
                        $this->Session->setFlash(__($this->Auth->planesMejoraError, true));
                        $this->redirect(array('controller'=>'Jurisdicciones', 'action'=>'view', $id));
                    }
                }
                // fin de chequeo

                $this->paginate = array('conditions'=>array('Fondo.instit_id'=> 0,'Fondo.jurisdiccion_id'=>$id),'order' => array('Fondo.anio DESC','Fondo.trimestre DESC','Fondo.jurisdiccion_id DESC'));
            }
            else {
                $this->Session->setFlash(__('No especifica jurisdicción', true));
                $this->redirect(array('controller'=>'jurisdicciones','action'=>'listado'));
                //$this->paginate = array('conditions'=>array('Fondo.instit_id'=> 0), 'order' => array('Fondo.anio DESC','Fondo.trimestre DESC','Fondo.jurisdiccion_id DESC'));
            }

            $this->Fondo->recursive = 1;

            $condicion = array('Fondo.instit_id'=> 0, 'Fondo.jurisdiccion_id'=>$id);

            $this->set('sumalineas',  $this->Fondo->FondosLineasDeAccion->find('sum', array('conditions'=>$condicion)) );

            $this->set('jurisdiccion', $this->Fondo->Jurisdiccion->read(null, $id));
            $this->set('fondos', $this->paginate());
	}

        function index()
        {
            // guardo para despues tener los mismos datos seleccionados
            $dataTemp = $this->data;
            
            $this->Fondo->recursive = 0;
            $this->Fondo->order = array('Fondo.created DESC','Fondo.anio DESC', 'Fondo.trimestre','Fondo.jurisdiccion_id ASC');
            $condition = '';

            if(isset($this->passedArgs['Fondo.tipo'])){
                $this->data['Fondo']['tipo'] = $this->passedArgs['Fondo.tipo'];
            }

            if(isset($this->passedArgs['Fondo.jurisdiccion_id'])){
                $this->data['Fondo']['jurisdiccion_id'] = $this->passedArgs['Fondo.jurisdiccion_id'];
            }

            if(isset($this->passedArgs['Fondo.anio'])){
                $this->data['Fondo']['anio'] = $this->passedArgs['Fondo.anio'];
            }

            if(isset($this->passedArgs['Fondo.trimestre'])){
                $this->data['Fondo']['trimestre'] = $this->passedArgs['Fondo.trimestre'];
            }

            if(isset($this->passedArgs['Fondo.memo'])){
                $this->data['Fondo']['memo'] = $this->passedArgs['Fondo.memo'];
            }


            if(isset($this->data['Fondo']['tipo'])){
                if ( $this->data['Fondo']['tipo'] == 'i') {
                    $condition = array('Fondo.instit_id >' => 0);
                }
                elseif ($this->data['Fondo']['tipo'] == 'j') {
                    $condition = array('Fondo.instit_id' => 0);
                }
            }

            $tipo = @$this->data['Fondo']['tipo'];

            $this->data['Fondo']['tipo'] = '';
            
            $filter = $this->Filter->process($this);

            $urlFilter = $this->Filter->url ;

            if (is_array($condition)){
                $filter = $filter + $condition;
                $urlFilter = $urlFilter . "/Fondo.tipo:" . $tipo;
            }

            unset($filter['Fondo.url_conditions']);

            $todos = array('' => 'Todos');
            
            $jurisdicciones = $this->Fondo->Jurisdiccion->find('list', array('order'=>'name'));
            $jurisdicciones = $todos + $jurisdicciones;
            
            for($i=date('Y'); $i >= 2006; $i--) {
                $anios[$i] = $i;
            }
            $anios = $todos + $anios;

            //debug($this->Filter->url);

            $this->data = $dataTemp;
            $this->set(compact('jurisdicciones','anios'));
            $this->set('url_conditions',$urlFilter);
            $this->set('fondos', $this->paginate(null,$filter));
            $this->set('total', number_format($this->Fondo->FondosLineasDeAccion->find('sum',array('conditions'=>$filter)),2,",","."));
            
	}

	/*function search($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Fondo', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('fondo', $this->Fondo->read(null, $id));
	}*/

	function add($id=null) {
            $this->rutaUrl_for_layout[0] =array('name'=> 'Listado de Fondos','link'=>'/fondos' );
            $instit = '';

            if (empty($Title)) {
                $Title = "Crear Fondo";
            }

            $jurisdicciones = $this->Fondo->Jurisdiccion->find('list', array('order'=>'name'));
            $lineasDeAccion = $this->Fondo->LineasDeAccion->find('list', array('fields' => array('LineasDeAccion.id','LineasDeAccion.description'), 'order'=> array('orden','name')));

            /*
             * Preparar anios y trimestres activos
             */
            $trimestres_aux = explode(",", Configure::read('trimestre_activo'));

            foreach($trimestres_aux as $trimestre){
                $aux = explode("-",$trimestre);
                $anios[$aux[1]] = $aux[1];
                $trimestresXAnio[$aux[1]][$aux[0]] =  $aux[0];
            }


            $trimestres = end($trimestresXAnio);


            if (!empty($this->data)) {

                $this->Fondo->create();

                if ($this->data['Fondo']['tipo'] == 'j') {
                    $this->data['Fondo']['instit_id'] = 0;
                }
                
                $trimestres_aux = explode(",", Configure::read('trimestre_activo'));

                $trimestreActual = $this->data['Fondo']['trimestre'] . "-" . $this->data['Fondo']['anio'];
                
                if (!in_array($trimestreActual, $trimestres_aux)) {
                     $this->Session->setFlash(__('El fondo no pertenece al Trimestre Activo', true));
                     $this->redirect(array('action' => 'index'));
                }

                if ($id != null) {
                    // incluye id para editar
                    $this->data['Fondo']['id'] = $id;

                    //Borrar los registros borrados
                    $fondo_antes_actualizar = $this->Fondo->read(null, $id);
                    
                    foreach ($fondo_antes_actualizar['FondosLineasDeAccion'] as $linea_anterior) {
                        $existe = false;
                        foreach ($this->data['FondosLineasDeAccion'] as &$linea_actual) {
                            if($linea_anterior["lineas_de_accion_id"] == $linea_actual["lineas_de_accion_id"]){
                                $existe = true;
                                $linea_actual['id'] = $linea_anterior['id'];
                            }
                        }
                        if(!$existe){
                            $this->Fondo->FondosLineasDeAccion->delete($linea_anterior["id"]);
                        }
                    }
                }

                if ($this->Fondo->saveAll($this->data)) {
                    $this->Session->setFlash(__('Se ha guardado el Fondo', true));

                    if (!empty($this->data['Fondo']['redirect'])) {
                        $this->redirect($this->data['Fondo']['redirect']);
                    }
                    else {
                        $this->redirect(array('action' => 'index'));
                    }
                }
                else {
                    $this->Session->setFlash(__('El Fondo no ha podido ser guardado. Por favor, intente nuevamente.', true));
                }
            }
            elseif ($id != null) {
                $this->data = $this->Fondo->read(null, $id);

                if (!empty($this->data['Fondo']['instit_id'])) {
                    $this->Fondo->Instit->recursive = 0;
                    $instit = $this->Fondo->Instit->find('first', array('conditions'=>array('Instit.id'=>$this->data['Fondo']['instit_id'])));
                }

                $Title = "Editar Fondo";

                /*
                 * Permiso de Actualizacion trimestral
                 */

                $trimestres_aux = explode(",", Configure::read('trimestre_activo'));

                $trimestreActual = $this->data['Fondo']['trimestre'] . "-" . $this->data['Fondo']['anio'];
                
                if (!in_array($trimestreActual, $trimestres_aux)) {
                     $this->Session->setFlash(__('El fondo no pertenece al Trimestre Activo, por lo tanto no puede ser editado', true));
                     $this->redirect(array('action' => 'index'));
                }
                else{
                    $trimestres = $trimestresXAnio[$this->data['Fondo']['anio']];
                }

            }
            elseif (!empty($this->passedArgs['instit_id']) && is_numeric($this->passedArgs['instit_id'])) {
                $this->Fondo->Instit->recursive = 0;
                $instit = $this->Fondo->Instit->find('first', array('conditions'=>array('Instit.id'=>$this->passedArgs['instit_id'])));

                $this->data['Fondo']['instit_id'] = $this->passedArgs['instit_id'];
                $this->data['Fondo']['tipo'] = 'i';
                $this->data['Fondo']['jurisdiccion_id'] = $instit['Instit']['jurisdiccion_id'];
                $this->data['Instit'] = $instit['Instit'];

                $Title = "Crear Fondo para Institución";
            }
            elseif (!empty($this->passedArgs['jurisdiccion_id']) && is_numeric($this->passedArgs['jurisdiccion_id'])) {
                $this->data['Fondo']['instit_id'] = 0;
                $this->data['Fondo']['tipo'] = 'j';
                $this->data['Fondo']['jurisdiccion_id'] = $this->passedArgs['jurisdiccion_id'];

                $Title = "Crear Fondo para Jurisdicción";
            }
            
            $this->set('jurisdicciones', $jurisdicciones);
            $this->set('anios', $anios);
            $this->set('trimestres', $trimestres);
            $this->set('trimestresXAnio', $trimestresXAnio);
            $this->set('lineasDeAccion', $lineasDeAccion);
            $this->set('instit', $instit);
            $this->set('Title', $Title);
	}

	function edit($id = null) {
                //$this->redirect(array('action' => 'index'));
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Fondo', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Fondo->save($this->data)) {
				$this->Session->setFlash(__('Se ha guardado el Fondo', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Fondo could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Fondo->read(null, $id);
		}
	}

	function delete($id = null) {
                //$this->redirect(array('action' => 'index'));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Fondo', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Fondo->del($id)) {
			$this->Session->setFlash(__('Fondo eliminado', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('El fondo no puede ser eliminado', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>