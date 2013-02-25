<?php
class Instit extends AppModel {

	var $name = 'Instit';

        var $order = array('Instit.cue', 'Instit.anexo');

        /* @var $nombreCompleto String */
        /* es el nombre de la institucion adicionandole el tipoinstit + n° instit + nombre propio */
        var $nombreCompleto = '';
	
	/**
	 * Esto es para el paginador customizado
	 * @var boolean
	 */
	var $asociarPlan = false;
        
	var $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(			
			'Dependencia' => array('className' => 'Dependencia',
								'foreignKey' => 'dependencia_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Tipoinstit' => array('className' => 'Tipoinstit',
								'foreignKey' => 'tipoinstit_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Jurisdiccion' => array('className' => 'Jurisdiccion',
								'foreignKey' => 'jurisdiccion_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Departamento' => array('className' => 'Departamento',
								'foreignKey' => 'departamento_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Localidad' => array('className' => 'Localidad',
								'foreignKey' => 'localidad_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Claseinstit' => array('className' => 'Claseinstit',
								'foreignKey' => 'claseinstit_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'EtpEstado' => array('className' => 'EtpEstado',
								'foreignKey' => 'etp_estado_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
                        'Orientacion',
			'Modalidad' => array('className' => 'Modalidad',
								'foreignKey' => 'modalidad_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
                        'Gestion' => array('className' => 'Gestion',
								'foreignKey' => 'gestion_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
	);

	var $hasMany = array(
                        'Plan' => array('className' => 'Plan',
                                        'foreignKey' => 'instit_id',
                                        'dependent'=> true, // borra en cascada
                                        'conditions' => '',
                                        'fields' => '',
                                        'order' => '',
                                        'limit' => '',
                                        'offset' => '',
                                        'exclusive' => '',
                                        'finderQuery' => '',
                                        'counterQuery' => ''
                        ),
                        'HistorialCue' => array('className' => 'HistorialCue',
                                                'foreignKey' => 'instit_id',
                                                'dependent'=> true, // borra en cascada
                                                'conditions' => '',
                                                'fields' => '',
                                                'order' => 'HistorialCue.created DESC',
                                                'limit' => '',
                                                'offset' => '',
                                                'exclusive' => '',
                                                'finderQuery' => '',
                                                'counterQuery' => ''
                        ),
                        'Ticket' => array('className' => 'Ticket',
                                        'foreignKey' => 'instit_id',
                                        'dependent' => true,
                                        'conditions' => '',
                                        'fields' => '',
                                        'order' => '',
                                        'limit' => '',
                                        'offset' => '',
                                        'exclusive' => '',
                                        'finderQuery' => '',
                                        'counterQuery' => ''
                        )
	);

	var $validate = array(
            'cue' => array(
			/**
			 * Aca se verifica que los numeros iniciales del  CUE sean
			 * macheados con la jurisdiccion para comprobar la validez del CUE.
			 * 
			 */
			'cue_y_anexo_unico' => array(
				'rule' => array('cue_y_anexo_unico'),
				'message'=> 'El CUE o el ANEXO ya existen.'
			),

			/**
			 * Aca se verifica que los numeros iniciales del  CUE sean
			 * macheados con la jurisdiccion para comprobar la validez del CUE.
			 * 
			 */
			'jurisdiccion_y_cue_match' => array(
				'rule' => array('controlar_coincidencia_cue_jurisdiccion'),
				'message'=> 'El CUE no corresponde a la Jurisdicción.'
			),

			
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
			
			),
                        'instit_con_anexo_marcado' => array(
                            'rule' => array('instit_con_anexo_marcado'),
                            'message' => 'El número de anexo es igual a 0, sin embargo está tildada la opción "es anexo". Verificar inconsistencia.',
                            
                        ),
                        'instit_con_anexo_desmarcado' => array(
                            'rule' => array('instit_con_anexo_desmarcado'),
                            'message' => 'El número de anexo es mayor a 0, sin embargo no esta tildada la opción "es anexo". Verificar inconsistencia.',
                            
                        ),
   		),
   		'anio_creacion' => array(
   			'year' => array(
				'rule' => VALID_YEAR,
				'required' => false,
				'allowEmpty' => true,
				'message' => 'Debe ingresar un año de 4 dígitos. Si no conoce la fecha de creación, debe dejar el campo vacío.'
			),
		),
		'direccion' => array(
			'notEmpty' => array( // or: array('ruleName', 'param1', 'param2' ...)
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'La dirección no puede quedar vacía.'
			),
		),
		'departamento_id' => array(
			'rule' => array('controlar_coincidencia_jurisdiccion_departamento'),
			'message'=> 'El departamento no corresponde a esa jurisdicción.',	
		),
		'localidad_id' => array(
			'rule' => array('controlar_coincidencia_departamento_localidad'),
			'message'=> 'La localidad no corresponde a ese Departamento.'
		),
		'cp' => array(
			'notEmpty' => array( // or: array('ruleName', 'param1', 'param2' ...)
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'El Código Postal no puede quedar vacío.'
			),
		),
		'mail' => array(
			'email' => array(
				'rule' => VALID_EMAIL,
				'required' => false,
				'allowEmpty' => true,
				//'on' => 'create', // or: 'update'
				'message' => 'La dirección de e-mail no es válida.'
			)
		),
		'mail_alternativo' => array(
			'email' => array(
				'rule' => VALID_EMAIL,
				'required' => false,
				'allowEmpty' => true,
				'message' => 'La dirección de e-mail no es válida.'
			)
		),
   		'dir_nombre' => array(
   			'nombre' => array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Debe ingresar un Nombre y Apellido del director.'
			),
		),
		'dir_tipodoc_id' => array(
			'notEmpty' => array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Seleccione un Tipo de Documento.'
			),
		),
   		'dir_nrodoc' => array(
   			'number' => array(
				'rule' => VALID_NUMBER,
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Debe ingresar un valor numérico.'
			),
		),
		'dir_mail' => array(
			'email' => array(
				'rule' => VALID_EMAIL,
				'required' => false,
				'allowEmpty' => true,
				//'on' => 'create', // or: 'update'
				'message' => 'La dirección de e-mail no es válida.'
			)
		),
		'vice_nrodoc' => array(
   			'number' => array(
				'rule' => VALID_NUMBER,
				'required' => false,
				'allowEmpty' => true,
				'message' => 'Debe ingresar un valor numérico.'
			),
		),
		'ciclo_alta' => array(
			'notEmpty'=> array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'Debe ingresar el ciclo de alta.'	
			),
			'year'=> array(
				'rule' => VALID_YEAR,
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'Debe ingresar formato de año, con 4 dígitos. Ej: 2008.'	
			)
		),
		'orientacion_id' => array(
			/**
			*controla que la oferta secundaria tenga orientacion
			 */
			'secundaria_con_orientacion' => array(
				'rule' => array('controlar_secundaria_con_orientacion'),
				'message'=> 'El tipo de Institución secundaria debe tener orientación asignada.'
			),
			/**
			*controla que la oferta != secundaria no tenga orientacion
			 */
			'otros_sin_orientacion' => array(
				'rule' => array('controlar_otros_sin_orientacion'),
				'message'=> 'Solo el tipo de Institución secundaria puede tener orientación asignada.'
			),
		),
		'jurisdiccion_id' => array(
			'notEmpty' => array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Seleccione una Jurisdicción.'
			),
			'jurisdiccion' => array(
				'rule' => '/^(2|6|10|14|18|22|26|30|34|38|42|46|50|54|58|62|66|70|74|78|82|86|90|94)$/',
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Seleccione una Jurisdicción.'
			
			)
		),
		'tipoinstit_id' => array(
			'notEmpty' => array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Seleccione un Tipo de Establecimiento.'
			),
		),
		
		'gestion_id' => array(
			'notEmpty' => array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Seleccione un Ámbito de Gestión.'
			)
		),
		
		'etp_estado_id' => array(
			'notEmpty' => array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Seleccione una Relación con ETP.'
			)
		),
                'claseinstit_id' => array(
			'notEmpty' => array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Seleccione un Tipo de Institución de ETP.'
			),
			'claseinstits_con_programa_etp' => array(
				'rule' => 'claseinstits_con_programa_etp',
				'required' => true,
				'allowEmpty' => true,
				'message' => 'Si se trata de "Institución con programa de ETP" debe ser de tipo "Secundario No Técnico", "Superior No Técnico", "con Itinerario Formativo" o "Formación Profesional".'
			), 
                        'claseinstits_de_etp' => array(
				'rule' => 'claseinstits_de_etp',
				'required' => true,
				'allowEmpty' => true,
				'message' => 'Si se trata de "Institución de ETP" debe ser de tipo "Secundario Técnico", "Superior Técnico" o "Formación Profesional".'
			), 
		),
		'modalidad_id' => array(
			'modalidad_con_programa_etp' => array(
				'rule' => 'modalidad_con_programa_etp',
				'required' => true,
				'allowEmpty' => true,
				'message' => 'Si se trata de "Institución con programa de ETP" no puede tener Modalidad "Educación Técnico Profesional".'
			),
		),
            
                'dependencia_id' => array(
		    'notEmpty' => array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Seleccione un Tipo de Dependencia.'
			),
                    'tipo_dependencia_provincial_y_nombre_dep_vacio' => array(
                        'rule' => array('tipo_dependencia_provincial_y_nombre_dep_vacio'),
                        'message' => 'Si la dependencia es Provincial, el nombre de la dependencia debe estar vacio',
                    ),
                    'tipo_dependencia_nacional_y_nombre_dep_no_vacio' => array(
                        'rule' => array('tipo_dependencia_nacional_y_nombre_dep_no_vacio'),
                        'message' => 'Si la dependencia es Nacional, el nombre de la dependencia no debe estar vacio',
                    )
                ),
            
                'modalidad_id' => array(
                    'modalidad_estado_de_etp' => array(
                            'rule' => 'modalidad_estado_de_etp',
                            'required' => true,
                            'allowEmpty' => true,
                            'message' => 'Si se trata de una "Institución de ETP" debe tener la modalidad "Educación Técnico Profesional".'
                    ), 
                    'modalidad_estado_programa_de_etp' => array(
                            'rule' => 'modalidad_estado_programa_de_etp',
                            'required' => true,
                            'allowEmpty' => true,
                            'message' => 'Si se trata de una "Institución con Programa de ETP" no puede tener la modalidad "Educación Técnico Profesional".'
                    ), 
                ),
	);
	
  	/**
  	 * Validacion de CUE por jurisdiccion
  	 *
  	 * @return unknown
  	 */
  	function controlar_coincidencia_cue_jurisdiccion() {
  		$jur_id = $this->data[$this->name]['jurisdiccion_id'];
  		
  		if($jur_id < 10){
  			$jur_id = "0$jur_id";
  		}
  		
  		$tam = strlen($this->data[$this->name]['cue']);
  		if($tam == 7){
  			$jur = substr($this->data[$this->name]['cue'],0,2);
  		} elseif($tam == 6){
  			$jur = substr($this->data[$this->name]['cue'],0,1);
  			$jur = "0$jur";
  		}
  		else return false;
  		
  		return ($jur_id == $jur)?true:false;
        }

    function controlar_secundaria_con_orientacion(){
    	$oferta = $this->data[$this->name]['claseinstit_id'];
    	$clase = $this->data[$this->name]['orientacion_id'];

    	if($oferta == CLASE_SECUNDARIO_ID && empty($clase)){
			return false;
    	}

    	return true;
    }

    function controlar_otros_sin_orientacion(){
    	$oferta = $this->data[$this->name]['claseinstit_id'];
    	$clase = $this->data[$this->name]['orientacion_id'];

    	if($oferta != CLASE_SECUNDARIO_ID && !empty($clase)){
			return false;
    	}
    	return true;
    }


        /**
  	 * Callback que se ejecuta luego de cada find() del model Instit
         * Añade el nombre completo de la institución como un campo más.
         * Esta adaptada a los distintos niveles de key del array $results.
  	 *
  	 * @param array $results
  	 * @return array $results
  	 */
        function afterFind($results) {
            return $this->__agregarDataExtra($results);
        }


        function __agregarDataExtra($results){

            if (empty($results)) {
                return null;
            }

            list($key, $idata) = each($results);
            $aux = "$key";
            if (is_array($idata)) {
                if ($aux == "Instit") {
                    $profundidad = 1;
                }
                else {  // data[0]['Instit']
                    $profundidad = 2;
                }
            }
            else {  // data['id']; data['nombre']; etc
                $profundidad = 0;
            }

            if ($profundidad > 0) {
                foreach ($results as &$item) {
                    if (isset($item['Instit']['tipoinstit_id']) || isset($item['Instit']['nombre']) || isset($item['Instit']['nroinstit'])) {
                        $item_aux = &$item['Instit'];
                    }
                    elseif (isset($item['tipoinstit_id']) || isset($item['nombre']) || isset($item['nroinstit'])) {
                        $item_aux = &$item;
                    }

                    if (isset($item['Tipoinstit'])) {
                        $item_aux['Tipoinstit'] = &$item['Tipoinstit'];
                    }

                    $nombre_tipoinstit = '';
                    if (!empty($item_aux)) {
                        if (!empty($item_aux['Tipoinstit'])) {
                            $nombre_tipoinstit = isset($item_aux['Tipoinstit']['name']) ? $item_aux['Tipoinstit']['name'] : '';
                        }
                        /*elseif (!empty($item_aux['tipoinstit_id'])) {
                            // si no tiene, tipo instit para armar nombre
                            $this->Tipoinstit->recursive = -1;
                            $tipoinstit = $this->Tipoinstit->find('first', array('conditions' => array('Tipoinstit.id' => $item_aux['tipoinstit_id'])));
                            if (!empty($tipoinstit)) {
                                $nombre_tipoinstit = isset($tipoinstit['Tipoinstit']['name']) ? $tipoinstit['Tipoinstit']['name'] : '';
                            }
                        }*/

                        $item_aux['nombre_completo'] = $this->getNombreCompleto($item_aux['nombre'], $item_aux['nroinstit'], $nombre_tipoinstit, $item_aux['dependencia_id'], $item_aux['nombre_dep']);
                        //$item_aux['ultimo_ciclo'] = $this->getUltimoCiclo($item_aux['id']);
                    }
                    unset($item_aux);
                }
            }
            else {
                $nombre_tipoinstit = isset($results['Tipoinstit']['name']) ? $results['Tipoinstit']['name'] : '';

                $results['nombre_completo'] = $this->getNombreCompleto($results['nombre'], $results['nroinstit'], $nombre_tipoinstit, $item_aux['dependencia_id'], $item_aux['nombre_dep']);
                //$results['ultimo_ciclo'] = $this->getUltimoCiclo($item_aux['id']);
            }

            return $results;
        }


        /**
         * Arma el nombre completo con el Tipo instit + N° + nombre propio
         * se le pueden pasar los parametros para concatenar el nombre, o bien
         * pasarle un array al final, si no se le pasa nuingun array, toma el
         * $this->data para extraer la info
         * 
         * @param string $nombre
         * @param string $nroinstit
         * @param string $tipoinstit
         * @param array $arrayParaCompletar si se lo pasa con el puntero de referencia lo modifica directamente ahi mismo
         * @return string el nombre completo
         */
        function getNombreCompleto($nombre='', $nroinstit='', $tipoinstit='', $dependencia_id='', $dependencia='') {
            $nombreCompleto = "";

            if (!empty($tipoinstit) && $tipoinstit == 'SIN DATOS') {
                $tipoinstit = '';
            }
            
            if (!empty($tipoinstit)) {
                $nombreCompleto = $tipoinstit.' ';
                $nombreCompleto .= ($nroinstit > 0 || $nroinstit != '')?"N° $nroinstit ":"";
                if (($tipoinstit != 'SIN DATOS' ||  $nroinstit > 0) && $nombre){
                    $nombreCompleto .= " ";
                }
                $nombreCompleto .= ($nombre != '')?'"'.$nombre.'"':"";
            }
            else {
                $nombreCompleto .= ($nroinstit > 0 || $nroinstit != '')?"N° $nroinstit ":"";
                $nombreCompleto .= ($nombre != '')?'"'.$nombre.'"':"";
            }
            
            if ($dependencia_id > 1 && !empty($dependencia)) {
                $nombreCompleto .= "(".$dependencia.")";
            }

            return $nombreCompleto;
        }

        
  	
  
  	/**
  	 * function dameSumatoriaDeMatriculasPorOferta
  	 * 
  	 * me suma la matricula por oferta para la institucion a mano.
  	 * o sea, recorre el array de planes de la instit y va sumando
  	 * 
  	 * @param $id de la institucion
  	 * @return me devuelve algo como esto:
  	 
  	Array
(
    [totales] => Array        (
            [2007] => Array                (
                    [FP] => Array                        (
                            [total_matricula] => 24                        )

                    [SEC] => Array                        (
                            [total_matricula] => 0                        )
                )

    [array_de_ciclos] => Array        (
            [0] => Array                (
                    [0] => Array                        (
                            [ciclo_id] => 2007
                        )
                )

            [1] => Array                (
                    [0] => Array                        (
                            [ciclo_id] => 2008
                        )
                )

            [2] => Array                (
                    [0] => Array                        (
                            [ciclo_id] => 2009
                        )
                )
        )

    [array_de_ofertas] => Array        (
            [0] => Array                (
                    [0] => Array                        (
                            [id] => 1
                            [abrev] => FP
                        )
                )

            [1] => Array                (
                    [0] => Array                        (
                            [id] => 3
                            [abrev] => SEC
                        )
                )
        )
)
        
                    
                    la matriz que formo teiene que ser para armar una tabla de la siguiente forma:
                    
                    - OFERTA   -    Ciclo 2006    -   Ciclo 2007
                    -   FP     -        12        -      100
                    -   MT     -        154       -      44



  	 */
  	function dameSumatoriaDeMatriculasPorOferta($id = null){
            if ( empty($id) ){
                $id = $this->id;

            }
            $matriz_rtado = array();

            $data_cliclos_involucrados = "SELECT a.ciclo_id
                                            FROM anios as a
                                            LEFT JOIN planes as p on (p.id = a.plan_id)
                                            LEFT JOIN instits as i on (i.id = p.instit_id)
                                            WHERE
                                            i.id = $id
                                            GROUP BY a.ciclo_id
                                            ORDER BY a.ciclo_id DESC
                                            LIMIT 5";


            $data_ofertas_involucradas = "SELECT o.id, o.abrev
                                            FROM ofertas as o
                                            LEFT JOIN planes as p on (p.oferta_id = o.id)
                                            LEFT JOIN anios as a on (a.plan_id = p.id)
                                            LEFT JOIN instits as i on (i.id = p.instit_id)
                                            WHERE
                                            i.id = $id
                                            GROUP BY o.order, o.id, o.abrev
                                            ORDER BY o.order, o.id, o.abrev";


            $ciclos  = $this->query($data_cliclos_involucrados);
            $ofertas = $this->query($data_ofertas_involucradas);

            foreach ($ofertas as $o):
                    $matriz_rtado['array_de_ofertas'][] = $o[0];
            endforeach;


            foreach($ciclos as $c):
                    $ciclo = $c[0]['ciclo_id'];
                    $matriz_rtado['array_de_ciclos'][] = $ciclo;
                    foreach($ofertas as $o):
                            $oferta = $o[0]['id'];
                            $oferta_abrev = $o[0]['abrev'];

                            $sql_suma_matriculas = "SELECT sum(a.matricula)
                                                    FROM anios as a
                                                    LEFT JOIN planes as p ON (p.id = a.plan_id)
                                                    LEFT JOIN ofertas as o ON (o.id = p.oferta_id)
                                                    LEFT JOIN instits as i ON (i.id = p.instit_id)
                                                    WHERE i.id = $id
                                                    AND a.ciclo_id = $ciclo
                                                    AND o.id = $oferta";
                             $aux = $this->query($sql_suma_matriculas);
                             if(isset($aux[0][0]['sum'])):
                                    $matriz_rtado['totales'][$ciclo][$oferta_abrev]['total_matricula'] = (int)$aux[0][0]['sum'];
                             else:
                                    $matriz_rtado['totales'][$ciclo][$oferta_abrev]['total_matricula'] = "<cite>Sin Datos</cite>";
                             endif;
                    endforeach;
            endforeach;

            return $matriz_rtado;
  	}
  	
  	
  	
  	/**
  	 * funcion de validacion departamento que corresponda 
  	 * a la jurisdiccion adecuada
  	 * 
  	 * @return boolean
  	 */
  	function controlar_coincidencia_jurisdiccion_departamento(){
  		if (isset($this->data[$this->name]['departamento_id'])){
  			if ($this->data[$this->name]['departamento_id'] == '') return false;
  			
  			if ($this->data[$this->name]['departamento_id'] != ''){
		  		$jur_id = $this->data[$this->name]['jurisdiccion_id'];
		  		$depto_id = $this->data[$this->name]['departamento_id'];
		  		$this->Departamento->recursive = -1;
		  		$tot = $this->Departamento->find('count',array('conditions'=> array('Departamento.id'=>$depto_id, 'Departamento.jurisdiccion_id'=>$jur_id)));
		  		return ($tot > 0);
  			}
  		}
  		return false;
  	}
  	
  	
  	
  	
  	function controlar_coincidencia_departamento_localidad(){
  		if (isset($this->data[$this->name]['jurisdiccion_id'])){
  			if ($this->data[$this->name]['jurisdiccion_id'] == 2){
  				return true	;		
  			}
  		}
  		
  		if (isset($this->data[$this->name]['localidad_id'])){
  			if ($this->data[$this->name]['localidad_id'] == '') return false;
  			
  			if ($this->data[$this->name]['localidad_id'] != ''){
		  		$loc = $this->data[$this->name]['localidad_id'];
		  		$depto_id = $this->data[$this->name]['departamento_id'];
		  		$this->Departamento->recursive = -1;
		  		$tot = $this->Localidad->find('count',array('conditions'=> array('Localidad.id'=>$loc, 'Localidad.departamento_id'=>$depto_id)));
		  		return ($tot > 0);
  			}
  		}  		
  		
  		return false;
  	}
  	
  	
  	
  	/**
  	 *  
  	 *  me dice si una institucion cambio de cue
  	 *  si el cue fue modificado, entonces me devuelve un array con lso datos viejos
  	 *  caso contrario me devuelve null 
  	 * 
  	 * @param $institData es el $this->data del formulario
  	 * @return array son los datos de la Institucion
  	 */
  	function cambioCue($institData) {
            $this->id = $institData['Instit']['id'];
            $instit = $this->read(array('id','cue','anexo'));

            if(isset($institData['Instit']['cue']) && isset($institData['Instit']['anexo']) && isset($institData['Instit']['id'])){
                    if (($this->data['Instit']['cue']*100+$this->data['Instit']['anexo']) != ($institData['Instit']['cue']*100+$institData['Instit']['anexo'])){
                            return $instit;
                    }
                    return null;
            }
            //else debug('vino vacio el cue, anexo o id de institucion y no se puede comprobar si hubo cambio de cue');
  	}
  	
  	 
  	
  	/**
  	 * Verifica si el CUE ingresado es válido 
  	 * por ahora es utilizado para poder realizar búsqedas
  	 * @param string $cue
  	 * @return 	0 si vino vacio el cue
  	 * 			-1 si no es digito o vinieron < de 3 digitos
  	 * 			-6 si tiene 6 digitos pero no es de ciudad ni buenos aires
  	 * 			-7 si tienen 7 digitos pero no son de
  	 */
	function isCUEValid($cue = '') {
		if($cue=='') return 0;
		
		//este valida que no se hayan ingresado letras, ni puntos ni nada raro
		if(!preg_match('/^[0-9]{3,9}$/', $cue)) return -1;
		
		switch(strlen($cue)){
			case 6:
				// si son de buenos aires o ciudad
				if(!preg_match('/^(2|6|02|06)[0-9]*$/', $cue)) return -6;
				break;
			case 7:
				// para el resto de las provincias
				if(!preg_match('/^(02|06|0|14|18|22|26|30|34|38|42|46|50|54|58|62|66|70|74|78|82|86|90|94)[0-9]*$/', $cue)) return -7;
				break;	
			case 8:
				// si son de buenos aires o ciudad con anexo
				if(!preg_match('/^(2|6)[0-9]*$/', $cue)) return -8;
				break;		
			case 9:
				// para el resto de las provincias con anexo
				if(!preg_match('/^(02|06|10|14|18|22|26|30|34|38|42|46|50|54|58|62|66|70|74|78|82|86|90|94)[0-9]*$/', $cue)) return -9;
				break;
			default: 
				return 2;
				break;
		}		
		return 1;
	}


        public function find($conditions = null, $fields = null, $order = null, $recursive = null) {
            if ($this->asociarPlan == true) {
                $parametersAux = compact('order');
                $parametersAux = array_merge($fields, $parametersAux);
                if ($recursive != $this->recursive) {
                        $parametersAux['recursive'] = $recursive;
                }
                if ($conditions == 'count') {
                    return $this->__asociarPlanParamsSetup($parametersAux,'count');
                }
                else {
                    $inst = $this->__asociarPlanParamsSetup($parametersAux);
                    return $inst;
                }
            } else {
                return parent::find($conditions, $fields, $order, $recursive);
            }
        }

        

        
        /**
         * Esta funcion simplemente inicializa los arrays para luego
         * hacer la busqueda cuando seteo asociarPlan en true
         * @param array $parameters
         * @param string $buscaroSoloContar
         *                          admite los strings: 'buscar' o 'count'
         * @return array
         */
        private function __asociarPlanParamsSetup($parameters = array(), $buscaroSoloContar = 'buscar') {
                
                //$parameters['recursive'] = -1;
                $parameters['joins'] = array(
                    array(
                        'table' => 'tipoinstits',
                        'type' => 'LEFT',
                        'alias' => 'Tipoinstit',
                        'conditions' => array('Tipoinstit.id = Instit.tipoinstit_id'),
                    ),
                    array(
                        'table' => 'planes',
                        'type' => 'LEFT',
                        'alias' => 'Plan',
                        'conditions' => array('Plan.instit_id = Instit.id'),
                    ),
                    array(
                        'table' => 'titulos',
                        'type' => 'LEFT',
                        'alias' => 'Titulo',
                        'conditions' => array('Titulo.id = Plan.titulo_id'),
                    ),
                    array(
                        'table' => 'sectores_titulos',
                        'alias' => 'SectoresTitulo',
                        'type' => 'LEFT',
                        'conditions' => array('Titulo.id = SectoresTitulo.titulo_id')
                    ),
                    array(
                        'table' => 'subsectores',
                        'alias' => 'Subsector',
                        'type' => 'LEFT',
                        'conditions' => array('SectoresTitulo.subsector_id = Subsector.id')
                    ),
                    array(
                        'table' => 'sectores',
                        'alias' => 'Sector',
                        'type' => 'LEFT',
                        'conditions' => array('SectoresTitulo.sector_id = Sector.id')
                    ),
                    array(
                        'table' => 'jurisdicciones',
                        'type' => 'LEFT',
                        'alias' => 'Jurisdiccion',
                        'conditions' => array('Jurisdiccion.id = Instit.jurisdiccion_id'),
                    ),
                    array(
                        'table' => 'localidades',
                        'type' => 'LEFT',
                        'alias' => 'Localidad',
                        'conditions' => array('Localidad.id = Instit.localidad_id'),
                    ),
                    array(
                        'table' => 'departamentos',
                        'type' => 'LEFT',
                        'alias' => 'Departamento',
                        'conditions' => array('Departamento.id = Instit.departamento_id'),
                    ),
                );                

                
                // le pongo en el Group lo que quiero ordenar, porque
                /// sino me tira error
                $groupsVars = array();
                if (!empty($parameters['order'])) {
                    if (is_string($parameters['order'])) {
                        $parameters['order'] = explode(',', $parameters['order']);
                    }
                    $parameters['order'] = array_merge($parameters['order'], $this->order);
                    
                    foreach ( $parameters['order'] as $k=>$or) {
                        if (is_string($k) ) {
                            $groupsVars[] = $k;
                        } else {
                            $letrasBorrar = array(' ASC', ' asc', ' DESC', ' desc');
                            $campo = str_replace($letrasBorrar, '', $or);
                            if ( !empty($campo)) $groupsVars[] = $campo;
                        }                        
                    }

                } else {
                    $groupsVars = $this->order;
                }
                $parameters['group'] = array_merge(array('Instit.id'),$groupsVars);
                
                if ($buscaroSoloContar == 'count') {
                    // si solo es para obtener el total no necesito seguir...
                    return count(parent::find('list', $parameters));
                }

                $parameters['fields']= 'Instit.id';
                

                // recojo todas las instituciones que cumplan con los criterios de busqueda
                $institsIds = parent::find('list', $parameters);
                if (empty($institsIds) ) {
                    // no hay instituciones que cumplan con esos criterios de busqueda
                    return array();
                }
                $parameters['conditions'] = array('Instit.id' => $institsIds);
                

                unset($parameters['limit']);
                unset($parameters['page']);
                unset($parameters['joins']);
                unset($parameters['group']);
                unset($parameters['fields']);

                $instits = parent::find('all', $parameters);
                
                return $instits;
        }
  	

   /**
    * si me encuentra algo me tira FALSO, asi evitamos duplicados
    * @return boolean
    */
	function cue_y_anexo_unico()
  	{
  		return (count($this->__getInstitByCUEandAnexo())==0)?true:false;
  	}

  	
  	
  	/**
  	 * me inserta 1 array pero se fija antes que la institucion no exista
  	 * si existe, no me lo inserta. hace que siempre sean unicas las instits
  	 * 
  	 * @param array $vector1[key_index][Instit][campo]
  	 * @param array $vector2[key_index][Instit][campo]
  	 * @return array 
  	 */
  	private function __armarVectorSinInstitsRepetidas($vector1, $vector2)
  	{
  		$v_final = array();
  		if(empty($vector2)){
  			return $vector1;
  		}
  		if(empty($vector1)){
  			return $vector2;
  		}
  		foreach($vector2 as $v2):
  			$encontro = false;
  			foreach($vector1 as $v1):  				
  				if($v2['Instit']['id'] == $v1['Instit']['id']){
  					$encontro = true;
  					break;
  				}
  			endforeach;
  			if(!$encontro){
  				$v_final[] = $v2;
  			}
  		endforeach;
  		
  		$v_final = array_merge($vector1, $v_final);
  		
  		return $v_final;
  	}
   
  	
  	/**
  	 * Me busca instituciones que tengan el mismo CUE y Anexo pasados como parametros. 
  	 * me devuelve un array del tipo find('all') de las instituciones 
  	 * @param integer $cue
  	 * @param integer $anexo
  	 * @return array del tipo find('all') de Intits
  	 */
  	private function __buscarSimilaresPorCueYAnexo($cue, $anexo) 
  	{
  		$similars = array(); 
  		// busco por cue y anexo
		if( $this->data['Instit']['cue'] != "" && $this->data['Instit']['anexo'] != "")
		{
			$similars = $this->__getInstitByCUEandAnexo();
			if(count($similars)>0) 
			{
				$this->validationErrors += array( 'cue' => 'Hay una institución con éste mismo CUE y Anexo');
				$this->validationErrors += array( 'anexo' => '');
			}
		}
		return $similars;
  	}
  	
  	
  	/**
  	 * Me busca las instituciones similares teniendo en cuenta la Localidad, el Domicilio
  	 * y la Jurisdiccion. Me lee los datos de $this->data['Instit']
  	 * @return array del tipo find('all') 
  	 */
  	private function __buscarSimilaresPorSuUbicacion() 
  	{
  		$similars = array();
  		
  		if (!empty($this->data['Instit']['localidad_id']) &&
  			!empty($this->data['Instit']['direccion'])
  		) { 
			
			$conditions = array("localidad_id" => $this->data['Instit']['localidad_id'], 
								"lower(direccion)  SIMILAR TO ?" => convertir_para_busqueda_avanzada($this->data['Instit']['direccion']));
			
			$txtError = 'Hay una institución con la misma dirección en ésta localidad';
			if ( !empty($this->data['Instit']['jurisdiccion_id'])) {
				$conditions['Instit.jurisdiccion_id'] = $this->data['Instit']['jurisdiccion_id'];
				$txtError .= " y/o jurisdiccion"; 
			}
			
			if (!empty($this->data['Instit']['id'])) {
				$conditions['Instit.id <>'] = $this->data['Instit']['id']; 
			}
						
			$similars = $this->find('all',array('conditions'=> $conditions));
			if(count($similars)>0)
			{
				$this->validationErrors += array( 'direccion' => $txtError);
				$this->validationErrors += array( 'localidad_id' => '');
			}
  		}
  		return $similars;
  	}
  	
  	
  	/**
  	 * busca las instituiciones similares por su Nombre y Localidad
  	 * utiliza el $this->data
  	 * @return array del tipo find('all')
  	 */
  	private function __buscarSimilaresPorNombreYLocalidad()
  	{
  		$similars = array();
  		if( !empty($this->data['Instit']['nombre']) && 
  			!empty($this->data['Instit']['localidad_id']))
		{

			$nombre = convertir_para_busqueda_avanzada($this->data['Instit']['nombre']);
		
			$conditions = array("lower(nombre)  SIMILAR TO ?" => $nombre,
								"localidad_id" => $this->data['Instit']['localidad_id']);
			
			if (!empty($this->data['Instit']['id'])) {
				$conditions['Instit.id <>'] = $this->data['Instit']['id']; 
			}
						
			$similars = $this->find('all',array('conditions'=> $conditions));
			if(count($similars)>0) 
			{
				$this->validationErrors += array( 'nombre' => 'Hay una institución con éste nombre en la misma localidad');
				$this->validationErrors += array( 'localidad_id' => '');
			}
		}
		return $similars;
  	}
   
  	
  	/**
  	 * busca instituciones similares por:
  	 * Nombre + Nro Instit + Tipo de Instit. Utiliza $this->data
  	 * @return array del tipo find('all')
  	 */
  	private function __buscarSimilaresPorNombreCompleto()
  	{
  		$similars = array();
  		if( !empty($this->data['Instit']['nombre'])    &&
			!empty($this->data['Instit']['nroinstit']) &&
			!empty($this->data['Instit']['tipoinstit_id'])
			){
			$nombre = convertir_para_busqueda_avanzada($this->data['Instit']['nombre']);
			$conditions = array("lower(nombre)  SIMILAR TO ?" => $nombre,
								"lower(nroinstit)  SIMILAR TO ?" => convertir_para_busqueda_avanzada($this->data['Instit']['nroinstit']),
								"tipoinstit_id" => $this->data['Instit']['tipoinstit_id']);
			
			if (!empty($this->data['Instit']['id'])) {
				$conditions['Instit.id <>'] = $this->data['Instit']['id']; 
			}
			
			$similars = $this->find('all',array('conditions'=> $conditions));
			if (count($similars)>0) {
				$this->validationErrors += array( 'nombre' => 'Hay una institución con el mismo nombre, tipo y número');
				$this->validationErrors += array( 'nroinstit' => '');
				$this->validationErrors += array( 'tipoinstit_id' => '');
			}
		}
		return $similars;
  	}
  	
  	
  	/**
  	 * busca similares por Tipo instit + Nro Instit en la misma Jurisdiccion
  	 * utiliza $this->data
  	 * @return array del tipo find('all')
  	 */
  	private function __buscarSimilaresPorTipoYNumeroEnJurisiccion()
  	{
  		$similars = array();
  		if( !empty($this->data['Instit']['localidad_id']) &&
			!empty($this->data['Instit']['nroinstit'])    &&
			!empty($this->data['Instit']['tipoinstit_id']))
		{
			$conditions = array("Instit.localidad_id" => $this->data['Instit']['localidad_id'],
								"lower(nroinstit)  SIMILAR TO ?" => convertir_para_busqueda_avanzada($this->data['Instit']['nroinstit']),
								"tipoinstit_id" => $this->data['Instit']['tipoinstit_id']);
			
			if (!empty($this->data['Instit']['id'])){
				$conditions['Instit.id <>'] = $this->data['Instit']['id']; 
			}
			
			$similars = $this->find('all',array('conditions'=> $conditions));
			if(count($similars)>0) 
			{
				$this->validationErrors += array( 'nroinstit' => 'Hay una institución en la misma localidad, con el mismo tipo y número');
				$this->validationErrors += array( 'localidad_id' => '');
				$this->validationErrors += array( 'tipoinstit_id' => '');
			}
		}
		return $similars;
  	}
  	
  	
  	
	/**
	 * Me devuelve todas la Instituciones similares
	 * @param $this->$data
	 * @return array de Instituciones del tipo find('all')
	 */
	function getSimilars($data) 
	{
		$similars = array();
		$this->data = $data;
		
		// busco por cue y anexo
		$v = $this->__buscarSimilaresPorCueYAnexo( $this->data['Instit']['cue'], $this->data['Instit']['anexo'] );
		$similars = $this->__armarVectorSinInstitsRepetidas($similars, $v);
		
		// busco por ubicacion
		$v = $this->__buscarSimilaresPorSuUbicacion();
		$similars = $this->__armarVectorSinInstitsRepetidas($similars, $v);		
		
		// busco por nombre y localidad
		$v = $this->__buscarSimilaresPorNombreYLocalidad();
		$similars = $this->__armarVectorSinInstitsRepetidas($similars, $v);	
		
		// busco por nombre
		$v = $v = $this->__buscarSimilaresPorNombreCompleto();
		$similars = $this->__armarVectorSinInstitsRepetidas($similars, $v);
		
		// busco por juridiccion, tipo y numero
		$this->__buscarSimilaresPorTipoYNumeroEnJurisiccion();
		$similars = $this->__armarVectorSinInstitsRepetidas($similars, $v);
		
		return $similars;
	}
	
	
	/**
	 * Me devuelve instituciones cuyo cue y anexo coinciden
	 * toma los valores de $this->data
	 * @return array find('all')
	 */
	function __getInstitByCUEandAnexo()
	{
		$condiciones = array();	
			
		// cuando se edita uina institucion
		// tengo que buscar todas las intituciones que no sea ésta misma en cuestión
		if (isset($this->data[$this->name]['id'])){
			if($this->data[$this->name]['id']!= null){
				$condiciones = array_merge($condiciones, array('Instit.id <>'=>$this->data[$this->name]['id']));
			}
		}	
		if (isset($this->data[$this->name]['cue'])){
			if($this->data[$this->name]['cue']!= null){
				$condiciones = array_merge($condiciones, array('cue'=>$this->data[$this->name]['cue']));
			}
		}	
		if (isset($this->data[$this->name]['anexo'])){
			if($this->data[$this->name]['anexo']!= null){
				$condiciones = array_merge($condiciones, array('anexo'=>$this->data[$this->name]['anexo']));
			}
		}
 		$this->recursive = -1;
  		return $this->find('all',array('conditions'=>$condiciones));
	}
	
	
	
	/**
	 *  Cambia el "*" utilizado en la busqueda por un "%"
	 * @param string $texto con *
	 * @return string @return texto con % para el LIKE de SQL
	 */
	function cambioComodin($texto) {
		return str_replace('*', '%', $texto);
	}
	
	
	
        /**
	 * validaciones
	 * 
	 * esta funcion lo que hace es comprobar que si una institucion es de tipo "Con programa ETP"
	 * la Clase puede ser FP, Itinerario, Sec No Tec o Sup No Tec
	 * 
	 * @return boolean
	 */
	function claseinstits_con_programa_etp()
	{
            if (!empty($this->data['Instit']['etp_estado_id']) && !empty($this->data['Instit']['claseinstit_id'])){
                    if($this->data['Instit']['etp_estado_id'] == 1) { // con programa de ETP
                        if($this->data['Instit']['claseinstit_id'] == 1 || // FP
                            $this->data['Instit']['claseinstit_id'] == 2 || // con itinerario formativo
                            $this->data['Instit']['claseinstit_id'] == 5 || // Sec No Tec
                            $this->data['Instit']['claseinstit_id'] == 6) {  // Sup No Tec 
                                    return true;					
                            }
                            else return false;
                    }
            }
            return true;
	}
        
	/**
	 * validaciones
	 * 
	 * esta funcion lo que hace es comprobar que si una institucion es de tipo "ETP"
	 * la Clase puede ser FP, Sec Tec o Sup Tec
	 * 
	 * @return boolean
	 */
        function claseinstits_de_etp()
	{
            if (!empty($this->data['Instit']['etp_estado_id']) && !empty($this->data['Instit']['claseinstit_id'])){
                    if($this->data['Instit']['etp_estado_id'] == 2) {   // de ETP
                        if($this->data['Instit']['claseinstit_id'] == 1 || // FP
                            $this->data['Instit']['claseinstit_id'] == 3 || // Sec Tec
                            $this->data['Instit']['claseinstit_id'] == 4) { // Sup Tec
                            return true;
                        }
                        else 
                            return false;
                    }
            }
            return true;
	}

	/**
	 * validaciones
	 * 
	 * esta funcion lo que hace es comprobar que si la institucion es de tipo "Con programa de ETP"
	 * entonces no puede tener Modalidad "Educación Técnico Profesional"
	 * 
	 * @return boolean
	 */
	function modalidad_con_programa_etp()
	{
            if (!empty($this->data['Instit']['etp_estado_id']) && $this->data['Instit']['etp_estado_id'] == 1){  // con programa de ETP
                if($this->data['Instit']['modalidad_id'] != 1) {  // NO es modalidad ETP
                    return true;					
		}
		else return false;
            }
            return true;
	}
	
        /**
	 * validaciones
	 * 
	 * si la institucion es con programa de ETP, debe tener modalidad Educación Tecnico Profesional
       	 * 
	 * @return boolean
	 */
        function modalidad_estado_de_etp() {
            if (!empty($this->data['Instit']['etp_estado_id']) && !empty($this->data['Instit']['modalidad_id'])){
                    if($this->data['Instit']['etp_estado_id'] == 2) {   // de ETP
                        if($this->data['Instit']['modalidad_id'] == 1) {
                            return true;
                        }
                        else {
                            return false;
                        }
                    }
            }
            return true;
        }
        /**
	 * validaciones
	 * 
         * Si es con Programa de ETP cualquiera de las otras modalidades menos Educación Tecnico Prof.
	 * 
	 * @return boolean
	 */
        function modalidad_estado_programa_de_etp() {
            if (!empty($this->data['Instit']['etp_estado_id']) && !empty($this->data['Instit']['modalidad_id'])){
                    if($this->data['Instit']['etp_estado_id'] == 1) {   // programa de ETP
                        if($this->data['Instit']['modalidad_id'] > 1) {
                            return true;
                        }
                        else {
                            return false;
                        }
                    }
            }
            return true;
        }

	
	/**
	 * 
	 * @param  integer $instit_id
	 * @return integer $orientacion_id
	 */
	function getOrientacionSegunSusPlanes($instit_id=0)
        {
            if(!empty($instit_id)) {
                $this->id = $instit_id;
            }
            $instit_id = $this->id;

            $planes = $this->Plan->find('all', array(
                    'conditions'=>array('Plan.instit_id'=>$instit_id),
                    'contain'=>array(
                        'Titulo' => array(
                            'SectoresTitulo'=>array(
                                'Subsector',
                                'Sector',
                                )
                            )
                        )
                )
                    );
            $cantPlanes = count($planes);
            
            $ant = -1;

            foreach ($planes as $p) {
                if (empty($p['Titulo']['SectoresTitulo'])) continue;
                foreach ( $p['Titulo']['SectoresTitulo'] as $st ) {
                    if( $ant != -1 && $st['Sector']['orientacion_id']!= $ant ) {
                        return 0;
                    }
                    $ant = $st['Sector']['orientacion_id'];
                }
            }

            return $ant;

        }



        /**
         *  Me trae los planes de una determinada institucion, con sus anios dato
         * 
         * @param string $depurado posibilidades: (referido a Plan.estructura_plan_id)
         *                          'depurados': Son los que tienen la FK de la estructura
         *                          'no-depurados': los que no tienen FK hacia la estructura
         * @param integer $id
         * @return false si no encontro nada. o un Array de instit con sus planes
         *
         * @deprecated
         */
        function estructuraPlanes($depurado, $id = null){
            $id = (empty($id)) ? $this->id : $id;

            // inicializo  el flag
            $flagDep = 0;

            switch ($depurado) {
                case 'depurados':
                    $flagDep = ' > 0';
                    break;

                case 'no-depurados':
                default:
                    $flagDep = ' = 0';
                    break;
            }            

            $ins = $this->find('first', array(
                'contain' => array('Plan' => array(
                    'conditions'=> array( "Plan.estructura_plan_id $flagDep"),
                    'EstructuraPlan','Anio.EstructuraPlanesAnio')),
                'conditions' => array(
                    'Instit.id'=>$id,                   
                    ),
            ));

            return empty($ins['Plan'])?false:$ins;
        }



        /***************************
         *
         * LOG DE LAS BUSQUEDAS REALIZADAS
         */
        function searchLog($data, $user, $group, $cantEncontradas){
            if (!empty($data)) {
                $posi  = strrpos($_SERVER['HTTP_REFERER'], "/");
                $nombre_form = substr($_SERVER['HTTP_REFERER'],$posi+1);

                $logTxt = $headTxt = '';
                $logTxt .= '|'. @$nombre_form; $headTxt .= '|'.'Formulario';
                $logTxt .= '|'. $user; $headTxt .= '|'.'Usuario';
                $logTxt .= '|'. $group; $headTxt .= '|'.'Rol';
                $logTxt .= '|'. $cantEncontradas; $headTxt .= '|'.'Cant. Encontradas';
                $logTxt .= '|'. @$data['Instit']['cue']; $headTxt .= '|'.'CUE';
                $logTxt .= '|'. @utf8_decode($data['Instit']['busqueda_libre']); $headTxt .= '|'.'Nombre Libre(solo buscador rapido)';
                $logTxt .= '|'. @utf8_decode($data['Instit']['nombre_completo']); $headTxt .= '|'.'Nombre Completo';
                $logTxt .= '|'. @$data['Instit']['nroinstit']; $headTxt .= '|'.'Nro Instit';
                $logTxt .= '|'. @$data['Instit']['jurisdiccion_id']; $headTxt .= '|'.'Jurisdiccion ID';
                $logTxt .= '|'. @$data['Instit']['tipoinstit_id']; $headTxt .= '|'.'Tipo Instit ID';
                $logTxt .= '|'. @utf8_decode($data['Instit']['nombre']); $headTxt .= '|'.'Nombre Instit';
                $logTxt .= '|'. @utf8_decode($data['Instit']['direccion']); $headTxt .= '|'.'Direccion';
                $logTxt .= '|'. @$data['Departamento']['id']; $headTxt .= '|'.'Departamento ID';
                $logTxt .= '|'. @$data['Localidad']['id']; $headTxt .= '|'.'Localidad ID';
                $logTxt .= '|'. @$data['Instit']['gestion_id']; $headTxt .= '|'.'Gestion ID';
                $logTxt .= '|'. @$data['Instit']['dependencia_id']; $headTxt .= '|'.'Dependencia ID';
                $logTxt .= '|'. @$data['Instit']['activo']; $headTxt .= '|'.'Activo';
                $logTxt .= '|'. @$data['Plan']['oferta_id']; $headTxt .= '|'.'Plan Oferta ID';
                $logTxt .= '|'. @$data['Plan']['sector_id']; $headTxt .= '|'.'Plan Sector ID';
                $logTxt .= '|'. @$data['Plan']['subsector_id']; $headTxt .= '|'.'Plan Sub-Sector ID';
                $logTxt .= '|'. @$data['Plan']['titulo_id']; $headTxt .= '|'.'Plan Titulo ID';
                $logTxt .= '|'. @$data['Instit']['orientacion_id']; $headTxt .= '|'.'Orientacion ID';
                $logTxt .= '|'. @utf8_decode($data['Plan']['norma']); $headTxt .= '|'.'Plan Norma';
                $logTxt .= '|'. @$data['Instit']['claseinstit_id']; $headTxt .= '|'.'Clase Instit ID';
                $logTxt .= '|'. @$data['Instit']['etp_estado_id']; $headTxt .= '|'.'ETP Estado ID';

                $log_file_name = 'search_'.date('m_Y',strtotime('now'));
                $archivo = APP . 'tmp' . DS . 'logs' . DS . $log_file_name.'.log';
                if (!file_exists($archivo)){
                     // armo el encabezado del CSV
                     $this->log($headTxt,$log_file_name);
                }
                //meto la data en el log
                $this->log($logTxt,$log_file_name);
            }
        }

       

        /**
  	 * Devuelve los sectores que abarca la institucion
  	 * @param integer $instit_id ID de la institucion
  	 * @param integer $ciclo_id (ciclo del año 2006, 2007, etc)
  	 * @return array $sectores[id][abrev]
  	 */
        function getSectores($instit_id = null, $ciclo_id = 0)
        {
            if (empty ($instit_id)) {
                $instit_id = $this->id;
            }
            $vec = array();

            $sql = "
                    SELECT s.id   AS id  , s.name AS name
                    FROM   planes   p
                    LEFT JOIN titulos t ON (t.id = p.titulo_id)
                    LEFT JOIN sectores_titulos st ON (st.titulo_id = t.id)
                    LEFT JOIN sectores s ON (st.sector_id = s.id)
                    LEFT JOIN anios a ON (a.plan_id = p.id)
                    WHERE
                    p.instit_id = $instit_id
            ";

            if ((int)$ciclo_id > 0){
                    $sql .= " 	AND a.ciclo_id = $ciclo_id";
            }

            $sql .= "
                    GROUP BY s.id, s.name
                    ORDER BY s.name ASC
            ";

            $data = $this->query($sql);

            foreach ($data as $line){
                    if (strlen($line[0]['name']) > 20){
                            $vec[$line[0]['id']] = substr($line[0]['name'],0,20) . "...";
                    } else {
                            $vec[$line[0]['id']] = $line[0]['name'];
                    }
            }

            return $vec;
        }


        /**
         * Lista todos los sectores de una determinada institucion para una
         * determinada oferta.
         * @param integer $instit_id
         * @param integer $oferta_id
         * @return array del find('list') con 'id' => 'nombre del sector'
         */
        function listSectoresConOferta($instit_id, $oferta_id = 0){
            $conditions = array('Plan.instit_id'=>$instit_id);
            
            if (!empty($oferta_id)) {
                $conditions['Titulo.oferta_id'] = $oferta_id;
            }
            
            $sectores = $this->Plan->find("all",array(
                'fields'=>array(
                        'DISTINCT Sector.id', 'Sector.name'
                ),
                'joins'=>array(
                   array(
                          'table' => 'sectores_titulos',
                          'alias' => 'SectoresTitulo',
                          'type' => 'INNER',
                          'conditions' => array('SectoresTitulo.titulo_id = Plan.titulo_id')
                    ),
                    array(
                          'table' => 'sectores',
                          'alias' => 'Sector',
                          'type' => 'INNER',
                          'conditions' => array('Sector.id = SectoresTitulo.sector_id')
                    )
                ),
                'conditions'=> $conditions,
                'contain'=>array(
                        'Titulo' => array(
                            'Sector',
                            'order' => array('Sector.name'),
                            ),
                ),
                )
            );
            $sectores_aux = array();

            foreach($sectores as $s){
                $sectores_aux[$s['Sector']['id']] = $s['Sector']['name'];
            }
            return $sectores_aux;
        }


        /**
         *  Retorna todos los ciclos lectivos en los cuales esta institucion
         *  brindó algún Plan
         * @param integer $instit_id
         * @return array
         */
        function getCiclosLectivos($instit_id = null){
            if (empty($instit_id)){
                $instit_id = $this->id;
            }
            $vec = array();

            $sql  = " SELECT ciclo_id ";
            $sql .= " FROM   planes p ";
            $sql .= "       ,anios  a ";
            $sql .= " WHERE  p.instit_id = " . $instit_id;
            $sql .= " AND    a.plan_id   = p.id ";
            $sql .= " GROUP  BY ciclo_id ";
            $sql .= " ORDER  BY ciclo_id ASC";

            $data = $this->query($sql);

            foreach ($data as $line){
                    $vec[$line[0]['ciclo_id']] = $line[0]['ciclo_id'];
            }

            return $vec;
        }


        /**
         *
         * Retorna un array con todas las ofertas distintas que brinda
         * la institucion, agrupandole los años lectivos que contiene cada una.
         *
         * @param integer $instit_id
         * @param boolean $agregar_anio_actual
         * @return array
         *  Devuelve algo asi
         *          Array(
                        [0] => Array
                            (
                                [ciclo] => Array
                                    (
                                        [0] => 2010
                                        [1] => 2009
                                    )

                                [name] => FP  // Nombre de la Oferta
                            )

                    )
         *
         */
        function getCiclosLectivosXOferta($instit_id, $agregar_anio_actual = true) {

                $ofertaRet = array();

                $oferta = $this->getOfertas($instit_id, $ciclo = 0 , $fields = 'abrev');

                foreach ($oferta as $o=>$d) {
                    $ofertaRet[$o] = array(
                        'ciclo' => array(),
                        'name' => $d,
                        );
                }

		$sql   = " SELECT distinct oferta_id,o.abrev, ciclo_id";
                $sql  .= " FROM planes p";
                $sql  .= " INNER JOIN anios a ON a.plan_id = p.id";
                $sql  .= " INNER JOIN ofertas o ON o.id = p.oferta_id";
                $sql  .= " WHERE p.instit_id = " . $instit_id ;
                $sql  .= " GROUP by oferta_id, o.abrev, ciclo_id";
                $sql  .= " ORDER by oferta_id, o.abrev,ciclo_id DESC";

		$data = $this->query($sql);

                foreach ($data as $line) {
			$ofertaRet[$line[0]['oferta_id']]['ciclo'][] = $line[0]['ciclo_id'];
                }

                $ciclos_disponibles = $this->Plan->Anio->Ciclo->find('list');

                $ciclos = $ofertaRet;
                if ($agregar_anio_actual) {
                    // agregarle el año actual si no existe
                    $existe = false;
                    foreach ($ciclos as &$c) {
                        // le agrego solo si no existe
                        foreach ($c['ciclo'] as $cc) {
                            if (max(array_keys($ciclos_disponibles)) == $cc )  {
                                $existe = true;
                                break;
                            }
                        }
                        if (!$existe) {
                             array_unshift(&$c['ciclo'], max(array_keys($ciclos_disponibles)));
                        }
                        $existe = false;
                    }
                }

		return $ciclos;
  	}


  	/**
  	 * Me devuelve las ofertas que tiene la institucion pasada como parametro agrupada por oferta.
  	 * O sea, me indica la variedad de niveles que tiene una escuela.
  	 * Ej: SEC, SUP, IT .... o .... SEC, SUP
  	 *
  	 * @param integer $instit_id ide de la institucion en cuestion
  	 * @param integer $ciclo_id id del ciclo que estoy buscando(2006, 2007. 2008, ¿2009?)
         * @param string $fields campos que quiero que me traiga la query, ero en formato string. No tipo Cake.
  	 * @return array $oferta[id][abrev]
  	 */
  	function getOfertas($instit_id = null, $ciclo_id = 0, $nameOrAbrev = 'name'){
                if ( empty($instit_id) ) {
                    $instit_id = $this->id;
                }

                if ($nameOrAbrev == 'name'){
                    $field = 'o.name AS abrev';
                    $group = 'o.name';
                } else {
                    $field = 'o.abrev AS abrev';
                    $group = 'o.abrev';
                }

  		$sql = "
                        SELECT o.id AS id , $field
                        FROM   planes   p
                        LEFT JOIN ofertas o ON (o.id = p.oferta_id)
                        LEFT JOIN anios    a ON (a.plan_id = p.id)
                        WHERE
                        p.instit_id = $instit_id
                        ";

		if ((int)$ciclo_id > 0){
			$sql .= " AND a.ciclo_id = " . $ciclo_id;
		}

		$sql .= "
                        GROUP BY o.id, o.order, $group
                        ORDER BY o.order, $group ASC
                        ";


  		$data = $this->query($sql);
		$vec = array();
		foreach ($data as $line){
			$vec[$line[0]['id']] = $line[0]['abrev'];
		}

		return $vec;
  	}


        /**
         * devuelve el ultimo ciclo lectivo de la institución
         */
        function getUltimoCiclo($instit_id){
            $sql = ' SELECT max("Anio"."ciclo_id") AS "Anio__ciclo_id"
                       FROM instits i
                        INNER JOIN planes AS "Plan" ON "Plan".instit_id = i.id
                        INNER JOIN anios AS "Anio" ON "Anio".plan_id = "Plan".id
                      WHERE i.id = ' . $instit_id;

            $data = $this->query($sql);

            $max_ciclo = 0;
            if (!empty($data)) {
                foreach ($data as $line){
                        $max_ciclo = $line['Anio']['ciclo_id'];
                }
            }
            return $max_ciclo;
        }
        
        
        
        function instit_con_anexo_marcado(){
            if ( $this->data['Instit']['esanexo']){
                if (!$this->data['Instit']['anexo']){
                    return false;
                }
            }
            return true;
        }
        
        
        function instit_con_anexo_desmarcado(){
            if ( !$this->data['Instit']['esanexo']){
                if ($this->data['Instit']['anexo']){
                    return false;
                }
            }
            return true;
        }
        
        
        /**
         * Si el tipo de dependencia es provincial 
         * entonces el nombre de la dependencia debe estar vacio
         * @return boolean 
         * 
         */
        function tipo_dependencia_provincial_y_nombre_dep_vacio(){
            if ( $this->data['Instit']['dependencia_id'] == DEPENDENCIA_PROVINCIAL ){
                if ( $this->data['Instit']['nombre_dep']) {
                    return false;
                }
            }
            return true;
        }

        /**
         * Si el tipo de dependencia es nacional
         * entonces el nombre de la dependencia no debe estar vacio
         * @return boolean 
         * 
         */
        function tipo_dependencia_nacional_y_nombre_dep_no_vacio(){
            if ( $this->data['Instit']['dependencia_id'] == DEPENDENCIA_NACIONAL ){
                if (!$this->data['Instit']['nombre_dep']){
                    return false;
                }
            }
            return true;
        }
        
}
?>
