<?php
class AniosController extends AppController {

	var $name = 'Anios';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Anio->recursive = 0;
		$this->set('anios', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Anio.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('anio', $this->Anio->read(null, $id));
	}


        /**
         * Guarda anios. Funciona tanto para el add como para el edit
         * 
         * @param integer $plan_id
         * @param <type> $duracion_hs Guarda los anios
         */
        function saveAll($plan_id = null,$duracion_hs = null){
            if(!empty($this->data['Info']['plan_id'])){
                    $plan_id = $this->data['Info']['plan_id'];
            }
            if(!empty($this->data['Info']['estructura_plan_id'])){
                $this->Anio->Plan->guardarEstructuraSiNoLaTiene($this->data['Info']['estructura_plan_id'], $this->data['Info']['plan_id']);
            }
            if(!empty($this->data['Info']['ciclo_id'])){
                    $ciclo_id = $this->data['Info']['ciclo_id'];
            }

            if (!empty($this->data)) {
                    $this->Anio->create();
                    $aniosGuardar = array();
                    foreach ($this->data['Anio'] as &$anios){
                        $anios['ciclo_id'] = $ciclo_id;
                        $anios['plan_id'] = $plan_id;
                        $estruct = $this->Anio->EstructuraPlanesAnio->find('first', array(
                            'contain'=> array('EstructuraPlan.(etapa_id)'),
                            'conditions'=> array('EstructuraPlanesAnio.id'=> $anios['estructura_planes_anio_id']),
                            ));
                        $anios['anio'] = $estruct['EstructuraPlanesAnio']['nro_anio'];
                        $anios['etapa_id'] = $estruct['EstructuraPlan']['etapa_id'];
                        /*if (    !empty($anios['matricula']) ||
                                !empty($anios['secciones']) ||
                                !empty($anios['hs_taller'])) {*/
                            $aniosGuardar[] = $anios;
                       /* }*/

                    }
                    if ($this->Anio->saveAll($aniosGuardar)) {
                        $this->Session->setFlash(__('Se ha guardado un nuevo año', true));
                        $this->redirect('/planes/view/'.$plan_id);

                    } else {
                        $txt = '<br>'.$this->Anio->listarErroresDeValidacionEnHtml();
                        $this->Session->setFlash(__('Intente de nuevo. No se pudo guardar el dato.'.$txt, true));
                        $this->redirect('/planes/view/'.$plan_id);
                    }
            }
        }


        /**
         * Guarda anios. Funciona tanto para el add como para el edit
         *
         * @param integer $plan_id
         * @param <type> $duracion_hs Guarda los anios
         */
        function save($plan_id = null,$duracion_hs = null){
            if (!empty($this->data)) {
//                    $this->Anio->create();
//                debug($this->data);
                    if ($this->Anio->save($this->data)) {
                        $this->Session->setFlash(__('Se ha guardado un nuevo año', true));
                        $this->redirect('/planes/view/'.$this->data['Anio']['plan_id']);

                    } else {
                        $txt = $this->Anio->listarErroresDeValidacionEnHtml();
                        $this->Session->setFlash(__('Intente de nuevo. No se pudo guardar el dato.'. '<br>'.$txt, true));
                        $this->redirect('/planes/view/'.$this->data['Anio']['plan_id']);
                    }
            }
        }


        function addSecTec($plan_id = null,$duracion_hs = null) {
            if (!empty($this->data['Info']['plan_id'])) {
                    $plan_id = $this->data['Info']['plan_id'];
            }

            $estructuraPlanId = $this->Anio->Plan->getEstructuraSugerida($plan_id);

            $trayectosDisponibles = $this->Anio->EstructuraPlanesAnio->EstructuraPlan->find('first', array(
                'contain'=> array('EstructuraPlanesAnio'=>array('order'=>array('EstructuraPlanesAnio.edad_teorica'))),
                'conditions'=> array(
                    'EstructuraPlan.id'=>$estructuraPlanId),
            ));

            /**
             * esto es para generar una vista distinta
             * para los años que son de una oferta FP
             */
            $this->Anio->Plan->recursive = -1;
            $plan   = $this->Anio->Plan->find('all',array(
                'conditions' => array('Plan.id'=>$plan_id))
                    );

            $this->set('trayectosDisponibles',$trayectosDisponibles);
            $this->set('plan_id',$plan_id);
            $this->set('duracion_hs',$duracion_hs);

            // solo los que aun no haya agregado informacion
            $ciclosUsados = $this->Anio->ciclosUsados($plan_id);
            $cond = array();
            if (count($ciclosUsados) == 1) {
                $cond = array("Ciclo.id <>" => array_pop($ciclosUsados));
            } elseif(count($ciclosUsados) > 1) {
                $cond = array("Ciclo.id NOT" => $ciclosUsados);
            }
            $ciclos = $this->Anio->Ciclo->find('list', array(
                'conditions'=>$cond
                ));

            $etapas = $this->Anio->Etapa->find('list');
            $this->set(compact('planes', 'ciclos', 'etapas'));
        }


	function add($plan_id = null,$duracion_hs = null) {
            if (!empty($this->data['Info']['plan_id'])) {
                    $plan_id = $this->data['Info']['plan_id'];
            }         
		
            /**
             * esto es para generar una vista distinta
             * para los años que son de una oferta FP
             */
            $ciclosUsados = array();
            $this->Anio->Plan->recursive = -1;
            $plan   = $this->Anio->Plan->read(null,$plan_id);
            switch ($plan['Plan']['oferta_id']):
                case FP_ID://es un FP, asique mostrar la vista de años para FP
                case 7://es CL, asique mostrar la vista de años para FP
                    //$this->data['Anio']['hs_taller'] = $plan['Plan']['duracion_hs'];
                    $viewToRender = '/anios/add_fp';
            
                    if (empty($duracion_hs)) {
                        $duracion_hs = $plan['Plan']['duracion_hs'];
                    }

                    $ciclosUsados = $this->Anio->find('list', array(
                                    'fields' => array('Anio.ciclo_id'),
                                    'conditions' => array('Anio.plan_id' => $plan_id)
                    ));
                    break;
                case ITINERARIO_ID: // IT
                case SEC_ID: //SEC NO TECNICO
                    $viewToRender = '/anios/add_it';
                    break;
                case SUP_ID: //SUP NO TECNICO
                case SUP_TEC_ID: //SNU
                    $viewToRender = '/anios/add_snu';
                    break;
                default: // si no va con ninguno mostrar error
                    $this->Session->setFlash('Oferta no válida');
                    $this->redirect('/');
                    break;
            endswitch;
            $this->set('plan_id',$plan_id);
            $this->set('duracion_hs',$duracion_hs);

            if (!empty($ciclosUsados)) {
                $ciclosUsados = $this->Anio->find('list', array(
                                    'fields' => array('Anio.ciclo_id'),
                                    'conditions' => array('Anio.plan_id' => $plan_id)
                    ));

                $ciclos = $this->Anio->Ciclo->find('list', array('conditions' => array(
                                    'not' => array('id' => array_values($ciclosUsados)))
                    ));
            }
            else {
                $ciclos = $this->Anio->Ciclo->find('list');
            }
            $etapas = $this->Anio->Etapa->find('list');

            $this->set(compact('planes', 'ciclos', 'etapas'));
            $this->render($viewToRender);
	}

	function edit($id = null) {
            $aPlan = $this->Anio->find('first', array(
                'conditions'=>array('Anio.id'=>$id),
                //'fields'=>array('Anio.plan_id','Anio.ciclo_id')
                ));
            
            $plan_id = $aPlan['Anio']['plan_id'];
                       
            
            $this->data = $aPlan;
            
            if(!empty($this->data['Info']['plan_id'])){
                    $plan_id = $this->data['Info']['plan_id'];
            }

            $estructuraPlanId = $this->Anio->Plan->getEstructuraSugerida($plan_id);
            $trayectosDisponibles = $this->Anio->EstructuraPlanesAnio->EstructuraPlan->find('first', array(
                'contain'=> array('EstructuraPlanesAnio'=>array('order'=>array('EstructuraPlanesAnio.edad_teorica'))),
                'conditions'=> array(
                    'EstructuraPlan.id'=>$estructuraPlanId),
            ));

            /**
             * esto es para generar una vista distinta
             * para los años que son de una oferta FP
             */
            $this->Anio->Plan->recursive = -1;
            $plan   = $this->Anio->Plan->find('all',array('conditions'=>array('Plan.id'=>$plan_id)));
            switch ($plan[0]['Plan']['oferta_id']):
                case FP_ID://es un FP, asique mostrar la vista de años para FP
                case 7://es CL, asique mostrar la vista de años para FP
                    $viewToRender = '/anios/edit_fp';
                    break;
                case ITINERARIO_ID: // IT
                case SEC_TEC_ID: //MT
                case SEC_ID: //SEC NO TECNICO
                    $viewToRender = '/anios/edit';
                    break;
                case SUP_ID: //SUP NO TECNICO
                case SUP_TEC_ID: //SNU
                    $viewToRender = '/anios/edit_snu';
                    break;
                default: // si no va con ninguno mostrar el de MT
                    $viewToRender = '/anios/edit';
                    break;
            endswitch;

            $this->set('ciclo_seleccionado', $aPlan['Anio']['ciclo_id']);
            $this->set('trayectosDisponibles',$trayectosDisponibles);
            $this->set('plan_id',$plan_id);
            //$this->set('duracion_hs',$duracion_hs);
            $anios = $this->Anio->find('all', array(
                'recursive'=>1,
                'conditions'=>array(
                    'Anio.plan_id'=>$plan_id,
                    'Anio.ciclo_id'=>$aPlan['Anio']['ciclo_id']
                    ),
                'order' => array('EstructuraPlanesAnio.anio_escolaridad')
                ));


            $ciclos = $this->Anio->Ciclo->find('list');
            $etapas = $this->Anio->Etapa->find('list');
            
            $this->set(compact('anios', 'ciclos', 'etapas'));
            $this->render($viewToRender);
	}


        /**
         *
         * @param integer $plan_id
         * @param integer $ciclo_id
         */
        function editCiclo($plan_id = null, $ciclo_id = null) {
            $conditions = array();
            
            // datos que pueden venir del formulario
            if(!empty($this->data['Info']['plan_id'])){
                    $plan_id = $this->data['Info']['plan_id'];
            }
            if(!empty($this->data['Info']['ciclo_id'])){
                    $ciclo_id = $this->data['Info']['ciclo_id'];
            }

                // agarro la Info del Plan para plan_id y su ciclo
                $aPlan = $this->Anio->find('first', array(
                    'conditions'=>array('Anio.plan_id'=>$plan_id,
                                        'Anio.ciclo_id'=>$ciclo_id
                                       ),
                    'contain' => array('EstructuraPlanesAnio.EstructuraPlan'),
                    'order' => 'Anio.anio',
                    ));
                $this->data = $aPlan;


            // agarro la estructura y su trayecto con los años
            $estructuraPlanId = $this->Anio->Plan->getEstructuraSugerida($plan_id);
            $trayectosDisponibles = $this->Anio->EstructuraPlanesAnio->EstructuraPlan->find('first', array(
                'contain'=> array(
                    'EstructuraPlanesAnio'=>array(
                        'order'=>array('EstructuraPlanesAnio.edad_teorica')
                        )),
                'conditions'=> array(
                    'EstructuraPlan.id'=>$estructuraPlanId),
            ));

            /**
             * esto es para generar una vista distinta
             * para los años que son de una oferta FP
             */
            $this->Anio->Plan->recursive = -1;
            $plan   = $this->Anio->Plan->find('all',array(
                'conditions'=>array('Plan.id'=>$plan_id)));
            switch ($plan[0]['Plan']['oferta_id']):
                case FP_ID://es un FP, asique mostrar la vista de años para FP
                case 7://es CL, asique mostrar la vista de años para FP
                    $viewToRender = '/anios/edit_fp';
                    break;
                case ITINERARIO_ID: // IT
                    $viewToRender = '/anios/edit';
                    break;
                case SEC_TEC_ID: //MT
                case SEC_ID: //SEC NO TECNICO
                    $viewToRender = '/anios/edit_sectec';
                    break;
                case SUP_ID: //SUP NO TECNICO
                case SUP_TEC_ID: //SNU
                    $viewToRender = '/anios/edit_snu';
                    break;
                default: // si no va con ninguno mostrar el de MT
                    $viewToRender = '/anios/edit';
                    break;
            endswitch;

            
            $this->set('ciclo_seleccionado', $aPlan['Anio']['ciclo_id']);
            $this->set('trayectosDisponibles',$trayectosDisponibles);
            $this->set('plan_id',$plan_id);
            //$this->set('duracion_hs',$duracion_hs);
            $anios = $this->Anio->find('all', array(
                'contain'=> array('EstructuraPlanesAnio'),
                'conditions'=>array(
                    'Anio.plan_id'=>$plan_id,
                    'Anio.ciclo_id'=>$aPlan['Anio']['ciclo_id']
                    ),
                'order' => array('Anio.anio'),
                ));


            $ciclos = $this->Anio->Ciclo->find('list');
            $etapas = $this->Anio->Etapa->find('list');

            $this->set(compact('anios', 'ciclos', 'etapas'));
            $this->render($viewToRender);
	}
        
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Id de Año inválido', true));
			$this->redirect(array('controller'=>'Pages','action'=>'default'));
		}
		
		$this->Anio->recursive = -1;
		$plan = $this->Anio->read('plan_id',$id);
		if ($this->Anio->del($id)) {
	
			$this->Session->setFlash(__('Año eliminado', true));
			$this->redirect(array('controller'=>'Planes' ,'action'=>'view/'.$plan['Anio']['plan_id']));
		}
	}

        function deleteCiclo($plan_id = null, $ciclo_id = null) {
		if ($this->Anio->deleteAll(array('Anio.plan_id ='. $plan_id, 'Anio.ciclo_id ='. $ciclo_id))) {

			$this->Session->setFlash(__('Año eliminado', true));
			$this->redirect(array('controller'=>'Planes' ,'action'=>'view/'.$plan_id));
		}
	}

}
?>