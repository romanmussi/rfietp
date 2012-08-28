<?php
class HistorialCue extends AppModel {

	var $name = 'HistorialCue';
	var $validate = array(
		'instit_id' => array('numeric'),
		'cue' => array(
			/*
			 * Esta validacion controla que el cue sea ingersado correctamente. 
			 * En este caso, corrobora que los 2 primeros digitos correspondan a los
			 * codigos de cada provincia, establecidos tal como se utilizan en la 
			 * oficina de informacion 309
			 * 
			 * 
			 */
			'jurisdiccion_correcta' => array(
				'rule' => '/^(2|6|02|06|10|14|18|22|26|30|34|38|42|46|50|54|58|62|66|70|74|78|82|86|90|94)[0-9]{5}$/',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'El CUE ingresado no es válido. No concuerda con el código de jurisdicción'
			
			),
			'notEmpty' => array( // or: array('ruleName', 'param1', 'param2' ...)
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'El CUE no puede quedar vacío.'
			),
			'number' => array(
				'rule' => VALID_NUMBER,
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Debe ingresar un valor numérico para el CUE.'
			
			),
			'between' => array(
				'rule' => array('between','6','7'),
				'required' => true,
				'allowEmpty' => false,
				'message' => 'El CUE debe ser de 6 ó 7 dígitos. No es necesario el cero inicial en CUEs de 6 dígitos. Ej: 600118, 5000216.'
			
			)		
   		),
		'anexo' => array(
			'notEmpty' => array( // or: array('ruleName', 'param1', 'param2' ...)
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'El Número de Anexo no puede quedar vacío.'
			),
			'number' => array(
				'rule' => VALID_NUMBER,
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Debe ingresar un número de Anexo.'
			
			),
			'between' => array(
				'rule' => array('between','1','2'),
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Válidos: 0 a 99.'
			
			)	
   		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
                        'Instit',
	);
	
	
	/**
	 *  me guarda el cue anterior en el historico de CUEs
	 * @param cue $datosCueAnterior
	 * @return boolean si se guardo bien o no
	 */
	function hacerCambioDeCue($datosCueAnterior){
		$this->create();
		return $this->save($datosCueAnterior);
	}
	
	
	/**
	 * me devuelve los cues hitoricos de una institucion
	 * @param $instit_id
	 * @return array de HistorialCue con cues y anexos
	 */
	function cuesDeInstit($instit_id){
		$this->recursive = -1;
		return $this->find('all',array('conditions'=>array('instit_id'=>$instit_id)));
	}

	
	/**
	 * Esta funcion modifica el belongsTo con Instit de acuerdo
	 * al parametro que recibe
	 * @param string $type
	 * @return unknown_type
	 */
	function _setBelongsToInstitType($type){
		$this->belongsTo['Instit']['type'] = $type;
	}	
	
	/**
	 * Esta funcion modifica el belongsTo con Instit para
	 * que sea un full join
	 * @return unknown_type
	 */
	function setBelongsToInstitTypeFull(){
		$this->_setBelongsToInstitType("FULL");
	}	
}
?>