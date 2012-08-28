<?php
// test
class Anio extends AppModel {

	var $name = 'Anio';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'EstructuraPlanesAnio' => array('className' => 'EstructuraPlanesAnio',
								'foreignKey' => 'estructura_planes_anio_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
                        'Plan' => array('className' => 'Plan',
								'foreignKey' => 'plan_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Ciclo' => array('className' => 'Ciclo',
								'foreignKey' => 'ciclo_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Etapa' => array('className' => 'Etapa',
								'foreignKey' => 'etapa_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);
	

	
	var $validate = array(
		'anio' => array(
			'notEmpty'=> array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Debe ingresar un número de año.'
			),
			'rango1a7'=> array(
				'rule' => '/^([1-9]|99)$/',
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'Debe ingresar un número de año entre 1 y 7.'
			),
                        'existeCicloEnPlan'=> array(
				'rule' => 'existeCicloEnPlan',
                                'on' => 'create',
				'message' => 'El ciclo y Año ya existe en el Plan.'
			),

		),
		'etapa_id'=>array(
			'notEmpty'=> array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'Debe ingresar la etapa a la que corresponde el año seleccionado. (CB, EGB3, Polimodal, etc).'
			),
		),
		'secciones'=>array(
			'seccion_it_sup'=>array(
				'rule' => 'seccion_it_sup',
				'message' => 'Debe ingresar un valor en Secciones.'
			),
			'notEmpty'=> array(
				'rule' => VALID_NUMBER,
				'required' => false,
				'allowEmpty' => true,
				//'on' => 'create', // or: 'update'
				'message' => 'Debe ingresar un valor numérico.'	
			),
		),
		'hs_taller'=>array(
			'horas_fp'=>array(
				'rule' => 'horas_fp',
				'message' => 'Debe ingresar un valor de Duración en Horas.'
			),
			'notEmpty'=> array(
				'rule' => VALID_NUMBER,
				'required' => false,
				'allowEmpty' => true,
				//'on' => 'create', // or: 'update'
				'message' => 'Debe ingresar un valor numérico.'	
			),
		),
		'matricula'=>array(
			'matricula_it_sup'=>array(
				'rule' => 'matricula_it_sup',
				'message' => 'Debe ingresar valor en Matrícula.'
			),
			'notEmpty'=> array(
				'rule' => VALID_NUMBER,
				'required' => false,
				'allowEmpty' => true,
				//'on' => 'create', // or: 'update'
				'message' => 'Debe ingresar un valor numérico.'	
			)
		),
        'etapa_id' => array(
            'it_es_polimodal' => array(
                'rule' => 'it_es_polimodal',
                'message' => 'Un IT debe ser de Etapa Polimodal'
	        )
	    ),

//                'estructura_planes_anio_id'=>array(
////			'estructuraValida'=> array(
////				'rule' => 'validacionEstructura',
////				'required' => false,
////				'allowEmpty' => true,
////				'message' => 'La estructura de la oferta no es correcta, verificarla junto a la estructura del plan (polimodal, CS, CB, etc).'
////			),
//                        'elPlanTieneEstructuraDefinida'=> array(
//				'rule' => 'elPlanTieneEstructuraDefinida',
//				'required' => false,
//				'allowEmpty' => true,
//				'message' => 'El Plan no tiene ninguna estructura definida. Edite el plan antes de ingresar datos de los años'
//			),
//		),
	);
        
        
    function matricula_it_sup(){
    	$this->Plan->recursive = -1;
    	$plan = $this->Plan->findById($this->data['Anio']['plan_id']);
    	if($plan['Plan']['oferta_id'] == FP_ID || 
    		$plan['Plan']['oferta_id'] == SUP_ID || 
    		$plan['Plan']['oferta_id'] == SUP_TEC_ID ){
    		if(empty($this->data['Anio']['matricula'])){
    			return false;
    		}
    	}
    	return true;
    }
    function seccion_it_sup(){
    	$this->Plan->recursive = -1;
    	$plan = $this->Plan->findById($this->data['Anio']['plan_id']);
    	if($plan['Plan']['oferta_id'] == FP_ID || 
    		$plan['Plan']['oferta_id'] == SUP_ID || 
    		$plan['Plan']['oferta_id'] == SUP_TEC_ID ){
    		if(empty($this->data['Anio']['secciones'])){
    			return false;
    		}
    	}
    	return true;
    }
    function horas_fp(){
    	$this->Plan->recursive = -1;
    	$plan = $this->Plan->findById($this->data['Anio']['plan_id']);
    	if($plan['Plan']['oferta_id'] == FP_ID){
    		if(empty($this->data['Anio']['hs_taller'])){
    			return false;
    		}
    	}
    	return true;
    }

    /**
     * Devuelve true en caso de que un itinerario sea con etapa Polimodal
     * caso contrario devuelve false.
     * sirve para validar ya que todos los IT deberian ser Polimodales
     * @return boolean
     */
    function it_es_polimodal(){
		$this->Plan->recursive = -1;
    	$plan = $this->Plan->findById($this->data['Anio']['plan_id']);
    	if($plan['Plan']['oferta_id'] == ITINERARIO_ID){
            if ($this->data['Anio']['etapa_id'] != ETAPA_POLIMODAL) {
                return false;
            }
        }
        return true;
    }
	
	/**
	 * Me devuelve un array con el total de matriculas del plan
	 *	retorna un array cuya 'key' es el id del plan y el valor, es la matricula
	 * @param $plan_id
	 * @return Array $aux_vec('plan_id'=>'matricula')
	 */
	function matricula_del_plan($plan_id){
		$aux_vec[$plan_id] = 0;
		$this->recursive = -1;
		$temp= $this->find('all',array(
						'conditions'=>array('plan_id'=>$plan_id),
						'group'=>array('ciclo_id','plan_id'),
						'order'=>array('ciclo_id DESC'),					
						'fields'=>array('sum(matricula) as "matricula"','plan_id','ciclo_id')));	


		//esta linea es para que solo muestre los datos de matricula del 
		//ULTIMO ciclo (año lectivo) cargado
		if($temp){	
			$ciclo_aux = $temp[0]['Anio']['ciclo_id'];
		} 
		
		//reordeno el vector para que quede de una manera linda para recorrerlo con foreach en la vista
		foreach($temp as $v){
			//como el array vine ordenado por cicl_id descendiente, si leo otro ciclo y 
			//es distinto es porque estoy en un año anterir, por lo tanto 
			//debo cortar la ejecucion y entregar el array como quedó
			if ($ciclo_aux != $v['Anio']['ciclo_id']) break; 
			
			$aux_vec[$v['Anio']['plan_id']] = $v[0]['matricula'];
		}
		
		return $aux_vec;
	}
	
	/**
	 * Me dice en que ciclo lectivo estan las ultimas matriculas del plan
	 * o sea, me dice, cual es el ultimo ciclo lectivo del plan
	 *
	 * @param $plan_id
	 * @return Id Ciclo_ID (en realidad es un año, 2006,2008,2009, etc)
	 */
	function ciclo_lectivo_matricula_del_plan($plan_id){
		$this->recursive = -1;
		$temp= $this->find('first',array(
						'conditions'=>array('plan_id'=>$plan_id),
						'order'=>array('ciclo_id DESC'),
						'fields'=>array('plan_id','ciclo_id')));	

		return $temp['Anio']['ciclo_id'];
	}


        /**
         *  Se fija si el plan padre tiene la estructura definida
         * @param integer $plan_id
         * @return boolean
         */
        function elPlanTieneEstructuraDefinida(){
            
            $plan_id = $this->data['Anio']['plan_id'];

             $et = $this->Plan->tieneEstructuraDefinida($plan_id);

             return $et;

        }


        /**
         *  Se fija que el año tenga la misma estructura del Plan
         *  o sea verifica que no estoy insertando algo que rompa la relacion
         * Plan-> EstructuraPlan ->EstructuraPlanesAnio->Anio->Plan
         * @param integer $plan_id
         * @return boolean
         */
        function validacionEstructura() {
            $plan_id = $this->data['Anio']['plan_id'];

            $etapaAnio = $this->EstructuraPlanesAnio->find('first', array(
                'contain'  => array(
                    'EstructuraPlan' => array(
                        'Plan' => array('conditions' => array('Plan.id' => $plan_id))
                        ),
                ),
                'conditions' => array(
                    'EstructuraPlanesAnio.id' => $this->data['Anio']['estructura_planes_anio_id'],
                )
            ));

            if (!empty($etapaAnio['EstructuraPlan']['Plan']))
                return true;
            else
                return false;

        }


        /**
         *  Listado de ciclos_id utilizados por ese plan para los anios
         * @param integer $plan_id
         * @return array find list
         */
        function ciclosUsados($plan_id) {
             $ciclosUsados = $this->find('list',array(
                    'fields'=>array('Anio.ciclo_id','Anio.ciclo_id'),
                    'conditions'=>array(
                        'Anio.plan_id'=>$plan_id),
                    'group'=>array('Anio.ciclo_id', 'Anio.plan_id'),
                    'order'=>array('Anio.ciclo_id'),
                        ));
             return $ciclosUsados;
        }

        function existeCicloEnPlan() {
            $anios = $this->find('first', array(
                'conditions' => array(
                    'ciclo_id' => $this->data['Anio']['ciclo_id'],
                    'anio' => $this->data['Anio']['anio'],
                    'plan_id' => $this->data['Anio']['plan_id'],
                    //'oferta_id' => FP_ID
                )
            ));

            return (empty($anios));
        }
        


        /**
         * Trae todos los anios de un determinado plan
         * si el ciclo_id es CERO trae la informacion del ULTIMO ciclo lectivo
         * del cual el Plan cuenta con informacion
         *
         * @param integer $plan_id
         * @param integer $ciclo_id
         * @return array del find all de Anios
         */
        function getAniosDePlanPorCiclo($plan_id, $ciclo_id = 0) {
            $conds['Anio.plan_id'] = $plan_id;
            if (!empty($ciclo_id)) {
                $conds['Anio.ciclo_id'] = $ciclo_id;
            }

            $aniosPlan = $this->find('all', array(
                    'contain' => array('EstructuraPlanesAnio','Etapa'),
                    'order' => array('Anio.ciclo_id','Anio.anio'),
                    'conditions' => $conds,
            ));
            $i = 0;
            foreach ($aniosPlan as &$a) {
                $a = $a['Anio'] + $a;
                unset($a['Anio']);
            }
            return $aniosPlan;
        }
}
?>