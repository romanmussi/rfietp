<?php

class DepuradoresController extends AppController {

	var $name = 'Depuradores';
	var $helpers = array('Html', 'Form','Ajax');
	var $uses = array('Instit','Plan','Anio','Sector','Jurisdiccion', 'Tipoinstit',
                    'EstructuraPlan','JurisdiccionesEstructuraPlan','EstructuraPlanesAnio','Titulo');
	var $db;

        var $sesNames = array(
            'nombre' => 'Titulo.tituloName',
            'oferta'   => 'Titulo.oferta_id',
            'sector' => 'Titulo.sector_id',
            'subsector' => 'Titulo.subsector_id',
            'page' => 'Titulo.page',
        );
	
	
	function agregar_sectores(){
		App::import('Vendor', 'agrega_sectores/main');
		uses ('model' . DS . 'datasources' . DS . 'datasource');
		config('database');
		
		$this->autoRender = false;
			//conecto con la BD de cake default
			$this->db = new DATABASE_CONFIG();
			
			$depurador = new AgregaSectores($this->db->default);
			$depurador->main();	
	}
	
	
	/**
	 * 
	 * Esta funcion es la que depuraba los excel que armó Ramiro.
	 * La idea de esto era la de cargar los excel como tablas en BD
	 * luego se borraban los datos de la tabla tipoinstits y despues
	 * se ponian en cero los FK de la tabla instits 
	 * (campos departamentos_id, localidades_id)
	 * Despues de haber inicializado todo en cero, inputo nuevos registros 
	 * a tipoinstits, y los agrego como FK en la tabla instits
	 * 
	 * 
	 * @return nada
	 */
	//le pongo en private para que no se pueda tocar mas desde la web, ya que este script ya esta corrido y funcionando
	private function arreglar_tipoinstits(){
		App::import('Vendor', 'depura_tipoinstit/main');
		uses ('model' . DS . 'datasources' . DS . 'datasource');
		config('database');
		
			$this->autoRender = false;
			//conecto con la BD de cake default
			$this->db = new DATABASE_CONFIG();
			
			$depurador = new DepuraTipoinstits($this->db->default);
			$depurador->main();	
	}
	
	
	
	/**
	 * 
	 * Con este se depuran los departamentos y localidades que no estan 
	 * correctamente setteados en la tabla instits
	 * 
	 * @return unknown_type void
	 */
	function deptoyloc(){		
		//debug($this->data);die();
		if (!empty($this->data)) {
			if ($valor = $this->Instit->save($this->data)) {
				$this->Session->setFlash(__('Se ha guardado la Institución correctamente', true));
								
			} else {
				print_r($this->Instit->validationErrors);
				$this->Session->setFlash(__('La Institución no pudo ser guardada. Escriba nuevamente el campo incorrecto.', true));
			}
		}			
		
		$conditions = array('Instit.activo'=>1, array('OR'=> array('Instit.departamento_id'=>0, 'Instit.localidad_id'=>0)));
		
		$this->data =$this->Instit->find('first',array('conditions'=>$conditions,'order'=>'Instit.jurisdiccion_id DESC'));
		$total =$this->Instit->find('count',array('conditions'=>$conditions));
			
		//le pongo el valor vacio para que la vista muestre vacio. Luego el beforeSave se va a encargar d eagregarle un CERO para que cumpla con el NOT NULL de la BD
		if(isset($this->data['Instit']['anio_creacion']) && $this->data['Instit']['anio_creacion'] == 0){
			$this->data['Instit']['anio_creacion'] = '';
		}
		
		
		$tipoinstits = $this->Instit->Tipoinstit->find('list');
		$jurisdicciones = $this->Instit->Jurisdiccion->find('list');
		

		$tipoinstits = $this->Instit->Tipoinstit->find('list',array('conditions'=>'Tipoinstit.jurisdiccion_id = '.$this->data['Instit']['jurisdiccion_id'],'order'=>'Tipoinstit.name'));
		
		
		$departamentos = $this->Instit->Departamento->find('list',array('order'=>'name','conditions'=>array('jurisdiccion_id'=>$this->data['Instit']['jurisdiccion_id'])));
		$localidades = $this->Instit->Localidad->find('list',array('order'=>'name'));
		$this->set(compact('jurisdicciones','departamentos','localidades','tipoinstits'));	
		$this->set('falta_depurar',$total);
	}
	
	
	 /**
	 * Interfaz para depurar los tipointits
	 * 
	 * @return unknown_type void
	 */
	function tipoinstits(){				
		if (!empty($this->data)) {
			$this->data['Instit']['depurar_tipoinstit'] = 0; //la marco como "depurada"
			if ($valor = $this->Instit->save($this->data)) {
				$this->Session->setFlash(__('Se ha guardado la Institución correctamente', true));
								
			} else {
				debug($this->Instit->validationErrors);
				$this->Session->setFlash(__('La Institución no pudo ser guardada. Escriba nuevamente el campo incorrecto.', true));
			}
		}			
		
		$conditions = array('OR'=>array(
								'AND'=>array('Instit.activo'=>1,'Instit.tipoinstit_id'=>0),
								'Instit.depurar_tipoinstit'=>1
			)
		);
		
		$this->Instit->recursive = 1;
		$this->data =$this->Instit->find('first',array('conditions'=>$conditions,'order'=>'Instit.jurisdiccion_id DESC'));
		$total =$this->Instit->find('count',array('conditions'=>$conditions));
		

		if (!empty($this->data['Instit'])) {
                    //le pongo el valor vacio para que la vista muestre vacio. Luego el beforeSave se va a encargar d eagregarle un CERO para que cumpla con el NOT NULL de la BD
                    if(isset($this->data['Instit']['anio_creacion']) && $this->data['Instit']['anio_creacion'] == 0){
                            $this->data['Instit']['anio_creacion'] = '';
                    }
                    
                    $tipoinstis = $this->Instit->Tipoinstit->find('list',array('conditions'=>'Tipoinstit.jurisdiccion_id = '.$this->data['Instit']['jurisdiccion_id'],'order'=>'Tipoinstit.name'));
                    $this->set('tipoinstits', $tipoinstis);
                }
                
		$this->set('falta_depurar',$total);

	}
	
	/**
	 * 
	 * @return unknown_type
	 */
	function sectores($jur_id=0){		
		if (!empty($this->data)) 
		{				
				if(isset($this->data['Instit']['jurisdiccion_id']))
				{
					$jur_id = $this->data['Instit']['jurisdiccion_id'];
				}
				else
				{
					$this->Plan->id = $this->data['Plan']['id']; 
					if (!empty($this->data['Plan']['sector_id'])):
			  			if ($this->data['Plan']['sector_id'] != '' || $this->data['Plan']['sector_id'] != 0): 
			  				$this->Sector->recursive = -1;
			  				$this->Sector->id = $this->data['Plan']['sector_id'];
			  				$sec_aux = $this->Sector->read();
			  				$this->data['Plan']['sector'] = $sec_aux['Sector']['name'];
			  			endif;
			  		endif;
	  		  		
			  		$fields = array('nombre', 'sector_id', 'subsector_id');
			  		if($this->data['Plan']['sector_id'])
					{
						$fields[] = 'sector';
					}	
	  		
					
					if ($valor = $this->Plan->save(	$this->data ,array('validate'=>true,'fieldList'=>$fields))) {	
						$this->Session->setFlash(__('Se ha guardado el Plan correctamente', true));
										
					} else {
						debug($this->Plan->validationErrors);
						$this->Session->setFlash(__('El Plan no pudo ser guardada. Escriba nuevamente el campo incorrecto.', true));
					}
				}
		}
		
		$conditions = array('Instit.activo'=>1, 'Plan.sector_id'=>0);
		if($jur_id!=0) $conditions['Instit.jurisdiccion_id'] =  $jur_id;
		
		$this->Plan->recursive = 1;
		$this->data =$this->Plan->find('first',array('conditions'=>$conditions));
		$total =$this->Plan->find('count',array('conditions'=>$conditions));

		$instit = $this->Plan->Instit->find('first',array('conditions'=>array('Instit.id'=>$this->data['Instit']['id'])));
		$this->data['Instit']['nombre'] = $instit['Instit']['nombre_completo'];

		$sectores = $this->Plan->Titulo->Sector->find('list',array('order'=>'Sector.name'));
		$sectores[0]="SIN DATOS";
		$this->set('sectores',$sectores);

		$jurisdicciones = $this->Jurisdiccion->find('list',array('order'=>'Jurisdiccion.name'));
		$this->set('jurisdicciones',$jurisdicciones);
		$this->set('falta_depurar',$total);
		$this->set('jur_id',$jur_id);
		
		
		/***********************************/
		/*           Sugerencia            */
		/***********************************/
		$sector_sug = $this->Plan->Titulo->Sector->find('first',array('conditions'=>array('name'=>$this->data['Plan']['sector'])));
		$sector_sug = ($sector_sug['Sector']['id']!="")?$sector_sug['Sector']['id']:'0';
		$this->set('sector_sug',$sector_sug);
			
		$subsectores = $this->Plan->Titulo->Subsector->con_sector('list',$sector_sug);
		$this->set('subsectores',$subsectores);
	}
	
	function clases_y_etp()
	{		
		if (!empty($this->data)) 
		{	
			/*
			if ($this->Instit->save($this->data ,false, array('claseinstit_id, etp_estado_id'))) {	
				$this->Session->setFlash(__('Se ha guardado la institución correctamente', true));
			} else {
				debug($this->Instit->validationErrors);
				$this->Session->setFlash(__('La institución no pudo ser guardada. Escriba nuevamente el campo incorrecto.', true));
			}
			*/
			$this->Instit->id =  $this->data['Instit']['id'];
			
			
			if($this->Instit->saveField('claseinstit_id',  $this->data['Instit']['claseinstit_id']) &&
				$this->Instit->saveField('etp_estado_id',  $this->data['Instit']['etp_estado_id']) &&
				$this->Instit->saveField('depurar_tipoinstit',  0)
			)
			{
				$this->Session->setFlash(__('Se ha guardado la institución correctamente', true));
			}else{
				debug($this->Instit->validationErrors);
				$this->Session->setFlash(__('La institución no pudo ser guardada. Escriba nuevamente el campo incorrecto.', true));
			}
		}		
		
		$conditions = array('activo' =>1,'Instit.depurar_tipoinstit'=>1);
		
		
		$falta_depurar = $this->Instit->find('count',array('conditions'=>$conditions));
		$this->data = $this->Instit->find('first',array('conditions'=>$conditions));
		
		$tipoinstit = $this->Instit->Tipoinstit->find('list', array('conditions'=>array('jurisdiccion_id'=>$this->data['Instit']['jurisdiccion_id']) ));
		
		$this->Instit->Plan->unbindModel(array('belongsTo' => array('Instit')));
		$planes = $this->Instit->Plan->find('all',array(
                    'conditions' => array(
                        'Plan.instit_id'=>$this->data['Instit']['id']),
                    'contain' => array(
                        'Oferta', 
                        'Titulo' => array(
                            'SectoresTitulo' => array( 'Sector', 'Subsector')
                        ), 
                        'EstructuraPlan', 
                        'Anio'
                    )
                ));
		
		$claseinstits = $this->Instit->Claseinstit->find('list');
		$claseinstits[0] = "Seleccione";
		
		$etp_estados = $this->Instit->EtpEstado->find('list',array('order'=>'id DESC'));
		
		$this->set('falta_depurar', $falta_depurar);
		$this->set(compact('etp_estados', 'claseinstits','planes','tipoinstit'));
	}
	
	/**
         *
         * @return unknown_type
         */
        function sectores_por_sectores($sec_id=0,$subsec_id=0) {
            $plan_nombre = '';
            $conditions = array();
            $instit_activa = '';
            if (!empty($this->data)) {
                if(isset($this->data['Plan']['sector_id_filtro'])) {
                    $sec_id = $this->data['Plan']['sector_id_filtro'];
                }
                 if(isset($this->data['Plan']['subsector_id_filtro'])) {
                    $subsec_id = $this->data['Plan']['subsector_id_filtro'];
                }
                else {
                    $this->Plan->id = $this->data['Plan']['id'];
                    if (!empty($this->data['Plan']['sector_id'])):
                        if ($this->data['Plan']['sector_id'] != '' || $this->data['Plan']['sector_id'] != 0):
                            $this->data['Plan']['sector'] = "1";
                        endif;
                    endif;

                    $fields = array('nombre', 'sector_id', 'subsector_id');
                    if($this->data['Plan']['sector_id']) {
                        $fields[] = 'sector';
                    }

                    if ($valor = $this->Plan->save(	$this->data ,array('validate'=>true,'fieldList'=>$fields))) {
                        $this->Session->setFlash(__('Se ha guardado el Plan correctamente', true));

                    } else {
                        debug($this->Plan->validationErrors);
                        $this->Session->setFlash(__('El Plan no pudo ser guardada. Escriba nuevamente el campo incorrecto.', true));
                    }
                }

                if(isset($this->data['Plan']['plan_nombre'])) {
                    $plan_nombre = $this->data['Plan']['plan_nombre'];
                }

                if (!empty($this->data['Plan']['instit_activa'])){
                    $conditions += array('Instit.activo'=>1);
                    $instit_activa = $this->data['Plan']['instit_activa'];
                }
            }

            if(isset($this->passedArgs['plan_nombre'])) {
                    $plan_nombre = $this->passedArgs['plan_nombre'];
                }

            $conditions += array('Plan.sector_id'=>0);

            
            
            if($sec_id!=0) $conditions['Plan.sector_id'] =  $sec_id;
            if($subsec_id!=0) $conditions['Plan.subsector_id'] = $subsec_id;
            if($plan_nombre!='') $conditions["to_ascii(lower(Plan.nombre)) SIMILAR TO ?"] =  array(convertir_para_busqueda_avanzada($plan_nombre));

            $this->Plan->recursive = 1;
            $this->data =$this->Plan->find('first',array('conditions'=>$conditions));
            $total =$this->Plan->find('count',array('conditions'=>$conditions));

            $instit = $this->Plan->Instit->find('first',array('conditions'=>array('Instit.id'=>$this->data['Instit']['id'])));
            $this->data['Instit']['nombre'] = $instit['Instit']['nombre_completo'];

            $sectores = $this->Plan->Titulo->Sector->find('list',array('order'=>'Sector.name'));

            $condicion_sec = array();
            
            $subsectoreslist = $this->Plan->Titulo->Subsector->con_sector('list',$sec_id);

            $this->set(compact('sectores','subsectoreslist'));
            $this->set('falta_depurar',$total);
            $this->set('sec_id',$sec_id);
            $this->set('subsec_id',$subsec_id);
            $this->set('plan_nombre',$plan_nombre);


            /***********************************/
            /*           Sugerencia            */
            /***********************************/
            $sector_sug['Sector']['id'] = "";
            $subsector_sug['Subsector']['id'] = "";
            if(isset($this->data['Plan'])) {
                $sector_sug = $this->Plan->Titulo->Sector->find('first',array('conditions'=>array('Sector.id'=>$this->data['Plan']['sector_id'])));
                $subsector_sug = $this->Plan->Titulo->Subsector->find('first',array('conditions'=>array('Subsector.id'=>$this->data['Plan']['subsector_id'])));
            }

            $this->data['Plan']['instit_activa'] = $instit_activa;

            $sector_sug = ($sector_sug['Sector']['id']!="")?$sector_sug['Sector']['id']:'0';
            $this->set('sector_sug',$sector_sug);

            $subsector_sug = ($subsector_sug['Subsector']['id']!="")?$subsector_sug['Subsector']['id']:'0';
            $this->set('subsector_sug',$subsector_sug);

            $subsectores = $this->Plan->Titulo->Subsector->con_sector('list',$sector_sug);
            $this->set('subsectores',$subsectores);
        }

	
    function depurar_similares() {
		$vectorcito = array();
    	$this->paginate['recursive'] = -1;
    	$this->paginate['limit'] = 50;
    	$instits = $this->paginate();
    	$conta = 0;
    	foreach($instits as $i) {
    		$similares = $this->Instit->getSimilars($i);
    		
    		if ( count($similares) > 0 ) {
    			$vectorcito[$conta] = $i;
    			$vectorcito[$conta]['Similares'] = $similares;
    			$vectorcito[$conta]['Error'] = $this->Instit->validationErrors;
    			$conta++;
    		}		    		
    	}
    	
    	$this->set('instits_similars',$vectorcito);
    	
    }
    
    function depurar_orientacion() {
        //// dejo un log de ingreso
        $username = $this->Auth->user('nombre').' '.$this->Auth->user('apellido').' ('.$this->Auth->user('username').')';
        $grupo = $this->Session->read('User.group_alias');
        $this->Instit->logDepuradores($username, $grupo, "orientacion");
        
        $tipoinstit_seleccionado = 0;


        $condicionJurisdiccion = array();

        if (!empty($this->passedArgs['jurisdiccion_id'])){
            $condicionJurisdiccion = array('Instit.jurisdiccion_id'=>$this->passedArgs['jurisdiccion_id']);
        }
        if (!empty( $this->data['Plan']['jurisdiccion_id'])){
             $condicionJurisdiccion = array('Instit.jurisdiccion_id'=>$this->data['Plan']['jurisdiccion_id']);
        } elseif (!empty( $this->data['Instit']['jurisdiccion_id'])){
            $condicionJurisdiccion = array('Instit.jurisdiccion_id'=>$this->data['Instit']['jurisdiccion_id']);
        }

        if (empty($this->data['Form']['claseinstit_id'])) {
            if (!empty($this->data['Instit'])) {
                $this->Instit->id =  $this->data['Instit']['id'];
                if($this->Instit->saveField('orientacion_id',  $this->data['Instit']['orientacion_id'])) {
                    $this->Session->setFlash(__('Se ha guardado la institución correctamente', true));
                }else {
                    debug($this->Instit->validationErrors);
                    $this->Session->setFlash(__('La institución no pudo ser guardada. Escriba nuevamente el campo incorrecto.', true));
                }
            }
        }


        $conditions = array('activo' =>1, 'Instit.orientacion_id'=>0);
        if ( !empty($this->data['Form']['claseinstit_id']) ) {
            $tipoinstit_seleccionado = $this->data['Form']['claseinstit_id'];
            $conditions['Instit.claseinstit_id'] = $this->data['Form']['claseinstit_id'];
        }
        else {
            if (!empty($this->data['Instit']['claseinstit_id'])) {
                $tipoinstit_seleccionado = $this->data['Instit']['claseinstit_id'];
                $conditions['Instit.claseinstit_id'] = $this->data['Instit']['claseinstit_id'];
            }
        }

        $conditions = $conditions + $condicionJurisdiccion;


        $falta_depurar = $this->Instit->find('count',array('conditions'=>$conditions));
        $this->data = $this->Instit->find('first',array(
                'conditions'=>$conditions
        ));

        $tipoinstits = $this->Instit->Claseinstit->find('list');
        //$tipoinstits = $this->Instit->Tipoinstit->dameConJurisdiccion('list');

        $planes = $this->Instit->Plan->find('all',array('conditions'=>array('Plan.instit_id'=>$this->data['Instit']['id']),
                'contain'=>array(
                    'Titulo'=> array( 'Subsector' =>array('Sector.Orientacion')),
                    'Anio' => array('Ciclo'),
        )));


        $orientaciones = $this->Instit->Plan->Titulo->Sector->Orientacion->find('list');


        $jurisdicciones = $this->Instit->Jurisdiccion->find('list');

        $etp_estados = $this->Instit->EtpEstado->find('list',array('order'=>'id DESC'));

        $this->Instit->id = $this->data['Instit']['id'];
        $orientacionSugerida = $this->Instit->getOrientacionSegunSusPlanes();

        $this->set('falta_depurar', $falta_depurar);
        $this->set('tipoinstit_seleccionado', $tipoinstit_seleccionado);
        $this->set(compact( 'etp_estados', 'orientaciones','planes','tipoinstits',
                'orientacionSugerida', 'jurisdicciones'));

    }
    
    


    // depurador de planes
    function depurar_estructura_planes() {
        // no hace falta loguear, apunta a depurador_planes_controller, ahi si se loguea
        // 
        // planes que contienen solo un ciclo con etapas mezcladas
        $planes_con_un_ciclo_de_etapas_mezclas = $this->Anio->find('all', array(
                    'fields' => array('plan_id'),
                    'conditions' => array('oferta_id'=> 3, 'z_depurado'=>0),
                    'order' => array('plan_id'),
                    'group' => array('plan_id HAVING count(DISTINCT(ciclo_id)) = 1 AND count(DISTINCT(etapa_id)) = 2'),
                    'limit' => 500
        ));

        foreach ($planes_con_un_ciclo_de_etapas_mezclas as $plan) {
            $planes_id_con_un_ciclo[] = $plan['Anio']['plan_id'];
        }

        if (empty($planes_id_con_un_ciclo))
            return;

        // planes completos con sus años
        $planes = $this->Plan->find('all', array(
                    'contain' => array('Anio' => array('order'=>array('etapa_id', 'anio'))),
                    'conditions' => array('Plan.id'=> $planes_id_con_un_ciclo)
        ));

        $i = 0;
        foreach ($planes as $plan) {
            if (!empty($plan['Anio']))
            {
                $etapa_ant = $plan['Anio']['0']['etapa_id'];
                $cant_etapas_distintas = 1;
                $plan_creado = false;
                $plan_last_id = '';

                foreach ($plan['Anio'] as &$anio)
                {
                    if ($anio['etapa_id'] == $etapa_ant)
                    {
                        $planes_nuevos[$i][$anio['id']] = $anio;
                        // se crea el nuevo plan con los primeros años (por ej: CB)
                        // solo el segundo usaria el mismo plan, de esta manera se
                        // asegura que el plan original le queda a uno o mas años
                        // en la mayoria de los casos (CB - CS), le queda el titulo a CS
                        if ($i != 2) {
                            if (!$plan_creado) {
                                // solo entra cuando i == 0
                                $this->Plan->create();
                                $newPlan = Array();
                                $newPlan['id'] = '';
                                if ($anio['etapa_id'] == 1 || $anio['etapa_id'] == 4) {
                                    $newPlan['sector_id'] = 5;
                                    $newPlan['subsector_id'] = 0;
                                }
                                $newPlan['z_depurado'] = 2;
                                // faltaria titulo, normativa... a definir

                                $this->Plan->save($newPlan);

                                $plan_creado = true;
                                $plan_last_id = $this->Plan->id;

                                debug($plan_last_id);
                            }
                            // le asigna el nuevo plan a sus años
                            $anio['old_plan_id'] = $anio['plan_id'];
                            $anio['plan_id'] = $plan_last_id;

                            $this->Anio->save($anio);

                            debug($anio);
                        }
                    }
                    else {
                        $i++;
                        $cant_etapas_distintas++;
                        $etapa_ant = $anio['etapa_id'];

                        $plan['Plan']['z_depurado'] = 1;
                        $this->Plan->save($plan['Plan']);

                        $plan_creado = false;

                        // si tiene mas de 2 etapas crea el nuevo plan
                        // A CONFIRMAR!!!
                        /*if ($i > 2) {
                            $newPlan = $plan;
                            $newPlan['id'] = '';
                            $newPlan['sector_id'] = 5;
                            $newPlan['subsector_id'] = 0;
                            $newPlan['depurado'] = 2;
                            // faltaria titulo, normativa... a definir

                            //$this->Plan->save($newPlan);
                        }*/
                    }
                }

                if ($cant_etapas_distintas > 2) {
                    $casos_mas_de_2[] = $plan['Plan']['id'];
                }
            }
        }
        //debug($casos_mas_de_2);
    }


    function depurar_ortografia () {
        $conditions = array();
        /* corregidos
        $this->Tipoinstit->recursive = -1;
        $this->paginate['recursive'] = -1;
        $this->paginate['fields'] = array('id', 'name');
        $tipoinstits = $this->paginate('Tipoinstit');
        * corregidos
        $this->Titulo->recursive = -1;
        $this->paginate['recursive'] = -1;
        $this->paginate['limit'] = 300;
        $this->paginate['fields'] = array('id', 'name');
        $titulos = $this->paginate('Titulo');
        */
        $this->Plan->recursive = -1;
        $this->paginate['recursive'] = -1;
        $this->paginate['limit'] = 1000;
        $this->paginate['fields'] = array('id','perfil');
        $this->paginate['conditions'] = array('perfil <>'=>'');
        $planes = $this->paginate('Plan');

        $this->set(compact('tipoinstits', 'titulos','planes'));
    }


    function depurar_planes_sin_titulo() {
        //// dejo un log de ingreso
        $username = $this->Auth->user('nombre').' '.$this->Auth->user('apellido').' ('.$this->Auth->user('username').')';
        $grupo = $this->Session->read('User.group_alias');
        $this->Instit->logDepuradores($username, $grupo, "planes_sin_titulo");
                
        $this->Plan->recursive = -1;
        $this->paginate['contain'] = array('Instit'=>'Tipoinstit', 'Oferta' );
        $this->paginate['conditions'] = array('Plan.titulo_id' => 0);

        $this->set('planes', $this->paginate('Plan'));
    }


    function corrector_de_planes() {
        //// dejo un log de ingreso
        $username = $this->Auth->user('nombre').' '.$this->Auth->user('apellido').' ('.$this->Auth->user('username').')';
        $grupo = $this->Session->read('User.group_alias');
        $this->Instit->logDepuradores($username, $grupo, "corrector_de_planes");
        
        /********************** GUARDADO DE LOS PLANES SELECCIONADOS *******/
        if (!empty($this->data['Plan'])) {
            $planesGuardar = array();

            foreach ($this->data['Plan']['planes'] as $checkbox) {
                //$this->redirect(array('corrector_de_planes', @$this->data['Plan']['url_conditions']));
                if ($checkbox['selected'] == 1) {
                    $planesGuardar[] = $checkbox['id'];
                }
            }

            if (empty($planesGuardar)) {
                $this->Session->setFlash(__('Debe seleccionar uno o más Planes'));
            }
            if (empty($this->data['Plan']['titulo_id'])) {
                $this->Session->setFlash(__('Debe seleccionar un Título'));
            }

            if (!empty($planesGuardar) && $this->data['Plan']['titulo_id'] > 0)
            {
                $this->Titulo->Plan->recursive = -1;
                $PlanesData = $this->Titulo->Plan->find('all', array(
                            'fields' => array('Plan.id', 'Plan.oferta_id'),
                            'conditions' => array('Plan.id' => $planesGuardar)));

                $this->Titulo->recursive = -1;
                $tituloData = $this->Titulo->find('first', array(
                                    'fields' => array('Titulo.id', 'Titulo.oferta_id'),
                                    'conditions' => array('Titulo.id' => $this->data['Plan']['titulo_id'])));

                // comprobar que no se va a asignar un titulo de una determinada oferta a un
                // plan que pertenece a una oferta distinta
                $correctos = $incorrectos = 0;
                $planesGuardarDefinitivo = array();
                foreach ($PlanesData as $plan) {
                    if ($plan['Plan']['oferta_id'] == $tituloData['Titulo']['oferta_id']) {
                        $planesGuardarDefinitivo[] = $plan['Plan']['id'];
                        $correctos++;
                    }
                    else {
                        $incorrectos++;
                    }
                }
                if (!empty($planesGuardarDefinitivo)) {
                    $this->Titulo->Plan->updateAll(
                            array('Plan.titulo_id' => $this->data['Plan']['titulo_id']),
                            array('Plan.id' => $planesGuardarDefinitivo)
                    );
                }

                if ($incorrectos == 0) {
                    $this->Session->setFlash(__('Se ha asignado el Título '.$this->data['Plan']['tituloName'].' a '.$correctos.' Planes', true));
                }
                else {
                    $this->Session->setFlash(__('Se ha asignado el Título '.$this->data['Plan']['tituloName'].' a '.$correctos.' Planes. No se ha asignado a '.$incorrectos.' Planes por pertenecer a una oferta distinta a la del Título de Referencia.', true));
                }
            }

            $this->redirect(array('corrector_de_planes', @$this->data['Plan']['url_conditions']));
            $url_conditions['Plan.titulo_id'] = $this->data['Plan']['titulo_id'];
        }
        /***************************** FIN GUARDADO DE LOS PLANES ***************/

        /********************** BUSCADOR DE PLANES *******/

        // para el paginator que pueda armar la url
        $url_conditions = array();

        /**
         *     OFERTA
         */
        $oferta_id = '';
        if(!empty($this->data['FPlan']['oferta_id'])) {
            $oferta_id = $this->data['FPlan']['oferta_id'];
        }
        elseif(!empty($this->passedArgs['Plan.oferta_id'])) {
            $oferta_id = $this->passedArgs['Plan.oferta_id'];
            $this->data['FPlan']['oferta_id'] = $oferta_id;
        }

        if (!empty($oferta_id)) {
            $this->paginate['conditions']['Plan.oferta_id'] = $oferta_id;
            $url_conditions['Plan.oferta_id'] = $oferta_id;
        }

        /**
         *     SECTOR
         */
        $sector_id = '';
        if(!empty($this->data['FPlan']['sector_id'])) {
            $sector_id = $this->data['FPlan']['sector_id'];
        }
        elseif(!empty($this->passedArgs['Titulo.sector_id'])) {
            $sector_id = $this->passedArgs['Titulo.sector_id'];
            $this->data['FPlan']['sector_id'] = $sector_id;
        }

        if(!empty($sector_id)) {
            $this->paginate['conditions']['SectoresTitulo.sector_id'] = $sector_id;

            $url_conditions['Titulo.sector_id'] = $sector_id;
        }

        /**
         *     SUBSECTOR
         */
        if(isset($this->data['FPlan']['subsector_id']) && $this->data['FPlan']['subsector_id']!=="") {
            $subsector_id = $this->data['FPlan']['subsector_id'];
        }
        elseif(isset($this->passedArgs['Titulo.subsector_id'])) {
            $subsector_id = $this->passedArgs['Titulo.subsector_id'];
            $this->data['FPlan']['subsector_id'] = $subsector_id;
        }
        if( isset($subsector_id)  ) {
            $this->paginate['conditions']['SectoresTitulo.subsector_id'] = $subsector_id;
            $url_conditions['Titulo.subsector_id'] = $subsector_id;
        } else {
            $subsector_id = '';
        }

        /**
         *     JURISDICCION
         */
        $jurisdiccion_id = '';
        if(!empty($this->data['FPlan']['jurisdiccion_id'])) {
            $jurisdiccion_id = $this->data['FPlan']['jurisdiccion_id'];
        }
        elseif(!empty($this->passedArgs['Instit.jurisdiccion_id'])) {
            $jurisdiccion_id = $this->passedArgs['Instit.jurisdiccion_id'];
            $this->data['FPlan']['jurisdiccion_id'] = $subsector_id;
        }

        if(!empty($jurisdiccion_id)) {
            $this->paginate['conditions']['Instit.jurisdiccion_id'] = $jurisdiccion_id;
            $url_conditions['Instit.jurisdiccion_id'] = $jurisdiccion_id;
        }

        /**
         *  Por Plan
         */

        $plan_nombre = '';
        if(!empty($this->data['FPlan']['plan_nombre'])) {
            $plan_nombre = $this->data['FPlan']['plan_nombre'];
        }
        elseif(!empty($this->passedArgs['Plan.plan_nombre'])) {
            $plan_nombre = utf8_decode($this->passedArgs['Plan.plan_nombre']);
            $this->data['FPlan']['plan_nombre'] = $plan_nombre;
        }

        if(!empty($plan_nombre)) {
            $this->paginate['conditions']["to_ascii(lower(Plan.nombre)) SIMILAR TO ?"] = array(convertir_para_busqueda_avanzada($plan_nombre));
            $array_condiciones['Nombre del Plan'] = $plan_nombre;
            $url_conditions['Plan.plan_nombre'] = $plan_nombre;
        }

        /*
         *  Por Título
         *
         */

        $titulo_id = '';
        if(!empty($this->data['FPlan']['titulo_id'])) {
            $titulo_id = $this->data['FPlan']['titulo_id'];
        }
        elseif(!empty($this->passedArgs['Plan.titulo_id'])) {
            $titulo_id = $this->passedArgs['Plan.titulo_id'];
            $this->data['FPlan']['titulo_id'] = $titulo_id;
        }

        if(!empty($titulo_id)) {
            $this->paginate['conditions']["Plan.titulo_id"] = $titulo_id;
            $url_conditions['Plan.titulo_id'] = $titulo_id;
        }

        /*
         *  Todos/Con/Sin Título
         *
         */
        $con_titulo = '';
        if (!empty($this->data['FPlan']['con_titulo'])) {
            $con_titulo = $this->data['FPlan']['con_titulo'];
        }
        elseif(!empty($this->passedArgs['Plan.con_titulo'])) {
            $con_titulo = $this->passedArgs['Plan.con_titulo'];
            $this->data['FPlan']['con_titulo'] = $con_titulo;
        }

        if (!empty($con_titulo)) {
            if ($con_titulo == 'con') {
                $this->paginate['conditions']['Plan.titulo_id >'] = 0;
            }
            else {
                $this->paginate['conditions']['Plan.titulo_id ='] = 0;
            }

            $url_conditions['Plan.con_titulo'] = $this->data['FPlan']['con_titulo'];
        }

        //-----------------------------------------------------------------    */
        //                               Busqueda                              */
        //-----------------------------------------------------------------    */

        //datos de paginacion
        $this->paginate['order'] = array('Plan.nombre' => 'ASC');
        if(!empty($this->data['FPlan']['last_page'])) {
            $this->paginate['page'] = $this->data['FPlan']['last_page'];
        }

        // limit
        $this->paginate['limit'] = 10;
        if(!empty($this->data['FPlan']['limit'])) {
            $limit = $this->data['FPlan']['limit'];
        }
        elseif(!empty($this->passedArgs['FPlan.limit'])) {
            $limit = $this->passedArgs['FPlan.limit'];
            $this->data['FPlan']['limit'] = $limit;
        }

        if(!empty($limit)) {
            $url_conditions['FPlan.limit'] = $limit;
            $this->paginate['limit'] = $limit;
        }

        // Condicion necesaria
        $titulo_id=0;
        if(!empty($this->data['Plan']['titulo_id'])) {
            $url_conditions['Plan.titulo_id'] = $this->data['Plan']['titulo_id'];
            $titulo_id = $this->data['Plan']['titulo_id'];
        }

        if(!empty($this->passedArgs['Plan.titulo_id'])) {
            $url_conditions['Plan.titulo_id'] = $this->passedArgs['Plan.titulo_id'];
            $titulo_id = $this->passedArgs['Plan.titulo_id'];
        }

        $this->paginate['contain'] = array(
                'Instit',
                'Oferta',
                'Titulo' => array('SectoresTitulo' => array('Sector','Subsector.Sector')),
                'EstructuraPlan.Etapa',
                'Anio'
        );
        $this->paginate['recursive'] = 3;
        $planes = $this->paginate('Plan');

        $this->set('url_conditions', $url_conditions);

        $this->Titulo->Oferta->recursive = -1;
        $ofertas = $this->Titulo->Oferta->find('list');

        $this->Titulo->SectoresTitulo->Sector->recursive = -1;
        $this->Titulo->SectoresTitulo->Sector->order ='Sector.name';
        $sectores = $this->Titulo->SectoresTitulo->Sector->find('list');

        $subsectores = array();
        if (!empty($this->data['FPlan']['sector_id'])) {
            $subsecConditions = array();
            if (!empty($this->data['FPlan']['sector_id'])) {
                $subsecConditions = array('Subsector.sector_id'=>$this->data['FPlan']['sector_id']);
            }
            $this->Titulo->SectoresTitulo->Subsector->recursive = -1;
            $this->Titulo->SectoresTitulo->Subsector->order ='Subsector.name';
            $subsectores = $this->Titulo->SectoresTitulo->Subsector->find('list', array('conditions'=>$subsecConditions));
            $subsectores[0] = 'Sin Subsector';
        }
        
        $this->Titulo->Plan->Instit->Jurisdiccion->recursive = -1;
        $this->Titulo->Plan->Instit->Jurisdiccion->order = 'Jurisdiccion.name';
        $jurisdicciones = $this->Titulo->Plan->Instit->Jurisdiccion->find('list');

        $condicion = array();
        if(!empty($this->data['FPlan']['oferta_id']))
            $condicion['conditions']['oferta_id'] = $this->data['FPlan']['oferta_id'];
        $this->Titulo->recursive = -1;
        $titulos = $this->Titulo->find('list', $condicion);

        $this->set('titulo_id', $titulo_id);
        $this->set(compact('planes','titulos','ofertas',
                'sectores','subsectores','jurisdicciones'));
    }



    function fusionar_titulos() {
        //// dejo un log de ingreso
        $username = $this->Auth->user('nombre').' '.$this->Auth->user('apellido').' ('.$this->Auth->user('username').')';
        $grupo = $this->Session->read('User.group_alias');
        $this->Instit->logDepuradores($username, $grupo, "fusionar_titulos");
        
        $ofertas = $this->Titulo->Oferta->find('list');
        $sectores = $this->Titulo->Sector->find('list',array('order'=>'Sector.name'));

        if (!empty($this->passedArgs['limpiar'])) {
            // limpia session
            foreach ($this->sesNames as $sesName) {
                $this->Session->write($sesName, '');
            }
        }

        $bySession = false;
        // si existe búsqueda en Session, realiza búsqueda
        if ($this->Session->read($this->sesNames['nombre'])) {
            $this->data['Depurador']['tituloName'] = $this->passedArgs['tituloName'] = $this->Session->read($this->sesNames['nombre']);
            $bySession = true;
        }
        if ($this->Session->read($this->sesNames['oferta'])) {
            $this->data['Depurador']['oferta_id'] = $this->passedArgs['ofertaId'] = $this->Session->read($this->sesNames['oferta']);
            $bySession = true;
        }
        if ($this->Session->read($this->sesNames['sector'])) {
            $this->data['Depurador']['sector_id'] = $this->passedArgs['sectorId'] = $this->Session->read($this->sesNames['sector']);
            $bySession = true;

            $subsectores = $this->Titulo->Subsector->con_sector('list', $this->Session->read($this->sesNames['sector']));
        }
        if ($this->Session->read($this->sesNames['subsector'])) {
            $this->data['Depurador']['subsector_id'] = $this->passedArgs['subsectorId'] = $this->Session->read($this->sesNames['subsector']);
            $bySession = true;
        }
        if ($this->Session->read($this->sesNames['page'])) {
            $bySession = true;
        }

        if (empty($subsectores)) {
            $subsectores = $this->Titulo->Subsector->con_sector('list');
        }

        $this->Titulo->recursive = 0;
        $this->set('titulos', $this->paginate());
        $this->set(compact('ofertas', 'sectores', 'subsectores', 'bySession'));
    }

    function fusionar() {
        if (empty($this->passedArgs) && empty($this->data['Depurador'])) {
            $this->Session->setFlash(__('No es posible fusionar', true));
            $this->redirect('/depuradores/fusionar_titulos');
        }

        if (!empty($this->data['Depurador'])) {
            $titulos = explode(',', $this->data['Depurador']['titulos']);
            $titulos_a_tratar = array();
            foreach($titulos as $titulo) {
                if ($titulo != $this->data['Depurador']['titulo_definitivo'])
                    $titulos_a_tratar[] = $titulo;
            }

            // asigna el titulo definitivo a los planes de los otros titulos que se fusionan
            $this->Titulo->Plan->updateAll(
                    array('Plan.titulo_id' => $this->data['Depurador']['titulo_definitivo']),
                    array('Plan.titulo_id' => $titulos_a_tratar)
            );

            // se eliminan los titulos que no se fusionaron
            $this->Titulo->deleteAll(array('Titulo.id' => $titulos_a_tratar), false);

            $this->Session->setFlash(__('Los Títulos se han fusionado correctamente', true));
            $this->redirect('/depuradores/fusionar_titulos');
        }

        if (!empty($this->passedArgs)) {
            $this->Titulo->recursive = -1;
            $titulos = $this->Titulo->find('list', array(
                    'conditions' => array('Titulo.id' => $this->passedArgs)
            ));

            $this->set('titulos', $titulos);
        }
    }


    function titulos_ajax_index_search() {

        //para mostrar en vista los patrones de busqueda seleccionados
        $array_condiciones = array();
        // para el paginator que pueda armar la url
        $url_conditions = array();

        if (!empty($this->data)) {
            // si se realizó una búsqueda se limpia la session
            foreach ($this->sesNames as $sesName) {
                if ($sesName != $this->sesNames['page']) {
                    $this->Session->write($sesName, '');
                }
            }

            if (!empty($this->data['Depurador']['busquedanueva']) && !$this->data['Depurador']['bysession']) {
                $this->Session->write($this->sesNames['page'], '');
            }

            if(!empty($this->data['Depurador']['tituloName'])) {
                $this->passedArgs['tituloName'] = $this->data['Depurador']['tituloName'];
                $this->Session->write($this->sesNames['nombre'], $this->data['Depurador']['tituloName']);
            }
            if(!empty($this->data['Depurador']['oferta_id'])) {
                $this->passedArgs['ofertaId'] = $this->data['Depurador']['oferta_id'];
                $this->Session->write($this->sesNames['oferta'], $this->data['Depurador']['oferta_id']);
            }
            if(!empty($this->data['Depurador']['sector_id'])) {
                $this->passedArgs['sectorId'] = $this->data['Depurador']['sector_id'];
                $this->Session->write($this->sesNames['sector'], $this->data['Depurador']['sector_id']);
            }
            if(!empty($this->data['Depurador']['subsector_id'])) {
                $this->passedArgs['subsectorId'] = $this->data['Depurador']['subsector_id'];
                $this->Session->write($this->sesNames['subsector'], $this->data['Depurador']['subsector_id']);
            }
        }

        if(!empty($this->passedArgs['tituloName'])) {
            $q = utf8_decode(strtolower($this->passedArgs['tituloName']));
            $this->paginate['conditions']['lower(Titulo.name) SIMILAR TO ?'] = convertir_texto_plano($q);
        }
        if(!empty($this->passedArgs['ofertaId'])) {
            $q = utf8_decode($this->passedArgs['ofertaId']);
            $this->paginate['conditions']['Titulo.oferta_id'] = $q;
        }
        if(!empty($this->passedArgs['sectorId']) || !empty($this->passedArgs['subsectorId']) ) {

            $conditions_sector = array();
            if(!empty($this->passedArgs['sectorId'])){
                $q = utf8_decode($this->passedArgs['sectorId']);
                $this->paginate['conditions']['SectoresTitulo.sector_id'] = $q;
            }
            if(!empty($this->passedArgs['subsectorId'])){
                $q = utf8_decode($this->passedArgs['subsectorId']);
                $this->paginate['conditions']['SectoresTitulo.subsector_id'] = $q;
            }

            $this->paginate['joins'] = array(
                array('table'=>'sectores_titulos',
                      'type' => 'LEFT',
                      'alias' => 'SectoresTitulo',
                      'conditions'=> array('SectoresTitulo.titulo_id = Titulo.id')
                    )
                );
        }

        if (!empty($this->passedArgs['page'])) {
            //$this->paginate['page'] = $this->passedArgs['page'];
            $this->Session->write($this->sesNames['page'], $this->passedArgs['page']);
        }
        elseif ($this->Session->read($this->sesNames['page'])) {
            $this->paginate['page'] = $this->Session->read($this->sesNames['page']);
        }

        //datos de paginacion
        $this->paginate['fields'] = array('DISTINCT ("Titulo"."id")', 'Titulo.name','Titulo.marco_ref', 'Titulo.oferta_id', 'Oferta.abrev');
        $this->paginate['order'] = array('Titulo.name ASC, Titulo.oferta_id ASC');

        $titulos = $this->paginate('Titulo');

        $this->set('titulos', $titulos);
        $this->set('url_conditions', $url_conditions);
        //devuelve un array para mostrar los criterios de busqueda
        $this->set('conditions', $array_condiciones);

        $this->render('titulos_ajax_index_search');
    }
    
    
    function modalidades($jur_id=0)
	{		
		if (!empty($this->data)) 
		{	
			/*
			if ($this->Instit->save($this->data ,false, array('claseinstit_id, etp_estado_id'))) {	
				$this->Session->setFlash(__('Se ha guardado la institución correctamente', true));
			} else {
				debug($this->Instit->validationErrors);
				$this->Session->setFlash(__('La institución no pudo ser guardada. Escriba nuevamente el campo incorrecto.', true));
			}
			*/
			$this->Instit->id =  $this->data['Instit']['id'];
			
			
			if($this->Instit->saveField('modalidad_id',  $this->data['Instit']['modalidad_id']))
			{
				$this->Session->setFlash(__('Se ha guardado la modalidad de la institución correctamente', true));
			}else{
				debug($this->Instit->validationErrors);
				$this->Session->setFlash(__('La modalidad de la institución no pudo ser guardada. Escriba nuevamente el campo incorrecto.', true));
			}
		}		
		
		$conditions = array('activo' =>1,'Instit.modalidad_id'=>0);
		if($jur_id!=0) $conditions['Instit.jurisdiccion_id'] =  $jur_id;
		
		$falta_depurar = $this->Instit->find('count',array('conditions'=>$conditions));
		$this->data = $this->Instit->find('first',array('conditions'=>$conditions));
		$jurisdicciones = $this->Jurisdiccion->find('list',array('order'=>'Jurisdiccion.name'));
		$tipoinstit = $this->Instit->Tipoinstit->find('list', array('conditions'=>array('jurisdiccion_id'=>$this->data['Instit']['jurisdiccion_id']) ));
		
		$this->Instit->Plan->unbindModel(array('belongsTo' => array('Instit')));
		$planes = $this->Instit->Plan->find('all',array(
                    'conditions' => array(
                        'Plan.instit_id'=>$this->data['Instit']['id']),
                    'contain' => array(
                        'Oferta', 
                        'Titulo' => array(
                            'SectoresTitulo' => array( 'Sector', 'Subsector')
                        ), 
                        'EstructuraPlan', 
                        'Anio'
                    )
                ));
				
		$modalidades = $this->Instit->Modalidad->find('list');
        
		$this->set(compact('modalidades', 'claseinstts','planes','tipoinstit', 'jurisdicciones'));
		$this->set('falta_depurar', $falta_depurar);
        $this->set('jur_id',$jur_id);
	}
}

?>
