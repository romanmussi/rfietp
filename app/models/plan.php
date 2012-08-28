<?php
class Plan extends AppModel {

  var $name = 'Plan';


  /*
         * $asociarAnio lo que hace es agregar la Estructura y la Etapa a
         * la cual pertenece el año.
         * Esto es agregado en el vector de Anios que devuelve el Plan
         *
         * O sea, sólo sirve para que el array de Planes me traiga más info
         * sobre los Anios
         *
         * Para poder utilizar esta variable es necesario pasar como parametro
         * en la busqueda al mismo estilo que se pasa un 'conditions', o 'contain'
         * seria algo asi $params['asociarAnio'] = true
         *
         * Esta variable es inicializada en "false" luego de cada find
         *
         * @var $this->asociarAnio boolean
         */
  private $__asociarAnio = false; // Se utiliza en el paginador (asocia ultimo anio y todos los models relacionados por joins)

  /*
         * $__asociarCompleto sirve para realizar busquedas avanzadas
         *
         * Si asociarCompleto esta setteado en true, entonces el SELECT
         * se realizará con infinidad de JOINS para que pueda buscar
         * Los modelos Joineados son:
                'Instit'
                'EstructuraPlan'
                'Etapa'
                'Anio'
                'Titulo'
                'SectoresTitulo',
         *
         * Para poder utilizar esta variable es necesario pasar como parametro
         * en la busqueda al mismo estilo que se pasa un 'conditions', o 'contain'
         * seria algo asi $params['asociarCompleto'] = true
         *
         *
         * Esta variable es inicializada en "false" luego de cada find
         */
  private $__asociarCompleto = false;


  var $maxCiclo = "";
  var $traerUltimaAct = false; // se utiliza en el paginador.

  var $actsAs = array( 'Containable' );

  var $order = array();

  //The Associations below have been created with all possible keys, those that are not needed can be removed
  var $belongsTo = array(
    'Instit' ,
    'Oferta',
    'Titulo',
    'EstructuraPlan',
    'PlanEstado',
    'PlanTurno'
  );

  var $hasMany = array(
    'Anio' => array(
      'order'=> array( 'Anio.plan_id', 'Anio.ciclo_id DESC', 'Anio.anio ASC' ),
      'dependent'=> true, // borra en cascada
    )
  );

  var $validate = array(
    'instit_id' => array(
      'number' => array(
        'rule' => VALID_NUMBER,
        'required' => true,
        'allowEmpty' => false,
        'message' => 'Debe asociar el plan a una institución.'

      ),
    ),
    'oferta_id' => array(
      'number' => array(
        'rule' => VALID_NUMBER,
        'required' => true,
        'allowEmpty' => false,
        'message' => 'Debe especificar la oferta del plan.'

      ),
    ),
    'nombre' => array(
      'notEmpty'=> array(
        'rule' => VALID_NOT_EMPTY,
        'required' => true,
        'allowEmpty' => false,
        //'on' => 'create', // or: 'update'
        'message' => 'Debe ingresar el nombre.'
      )
    ),
    'norma' => array(
      'notEmpty'=> array(
        'rule' => VALID_NOT_EMPTY,
        'required' => true,
        'allowEmpty' => false,
        //'on' => 'create', // or: 'update'
        'message' => 'Debe ingresar la normativa.'
      )
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
        'message' => 'Debe ingresar formato de año, con 4 dígitos.'
      )
    ),
    'duracion_semanas' => array(
      'number' => array(
        'rule' => VALID_NUMBER,
        'required' => false,
        'allowEmpty' => true,
        'message' => 'Debe ingresar un valor numérico para las semanas.'
      ),
      'between' => array(
        'rule' => array( 'between', '0', '9' ),
        'required' => false,
        'allowEmpty' => true,
        'message' => 'La duración no puede ser un valor tan alto'

      )
    ),
    'duracion_hs' => array(
      'hs_para_fp_it' => array(
        'rule'   => 'hs_para_fp_it',
        'message'=>'Debe cargar una duracion en horas para las ofertas Formación Profesional e Itinerario Formativo' 
        ),
      'number' => array(
        'rule' => VALID_NUMBER,
        'allowEmpty' => true,
        'message' => 'Debe ingresar un valor numérico para las horas.'
      ),
      'between' => array(
        'rule' => array( 'between', '0', '9' ),
        'allowEmpty' => true,
        'message' => 'La duración no puede ser un valor tan alto'
      )
    ),
    'duracion_anios' => array(
      'anio_para_sec_sup' => array(
        'rule'   => 'anio_para_sec_sup',
        'message'=> 'Debe cargar una duracion en años para las ofertas Secundario y Superior'
      ),
      'number' => array(
        'rule' => VALID_NUMBER,
        'required' => true,
        'allowEmpty' => true,
        'message' => 'Debe ingresar un valor numérico para los años.'

      ),
      'between' => array(
        'rule' => array( 'between', '0', '9' ),
        'message' => 'La duración no puede ser un valor tan alto'
      )
    ),

    'titulo_id' => array(
      'coincidir_con_oferta' => array(
        'rule'   =>'coincidir_con_oferta',
        'message'=>'El título seleccionado no corresponde a la oferta indicada.' )
    ),
    'tituloName' => array(
      'tiene_titulo'=> array(
        'rule'   =>'tiene_titulo',
        'message' => 'Debe seleccionar un Título de Referencia.'
      )
    ), 
    "estructura_plan_id" => array(
      'estructura_para_sec'=> array(
        'rule'   =>'estructura_para_sec',
        'message' => 'Debe seleccionar una Estructura Plan.'
      )
    )

  );

  
    function beforeSave() {
        if (!empty($this->data['Plan']['nombre'])) {
            $this->data['Plan']['nombre'] = trim($this->data['Plan']['nombre']);
        }
        
        return true;
    }

  /**
   * Me dice si el titulo de referencia
   * pertenece a la oferta
   *
   * @return boolean
   */
  function coincidir_con_oferta() {
    if ( !empty( $this->data['Plan']['oferta_id'] ) ) {
      if ( !empty( $this->data['Plan']['titulo_id'] ) ) {
        $cond['conditions'] = array(
          'Titulo.oferta_id'=>$this->data['Plan']['oferta_id'],
          'Titulo.id'=>$this->data['Plan']['titulo_id'],
        );
        if ( $this->Titulo->find( 'count', $cond ) == 1 ) {
          return true;
        } else {
          return false;
        }
      }
      return true;
    }
  }

  function hs_para_fp_it() {
    if($this->data['Plan']['oferta_id'] == ITINERARIO_ID || $this->data['Plan']['oferta_id'] == FP_ID){
      if(empty($this->data['Plan']['duracion_hs'])){
        return false;
      }
    }
    return true;
  }

  function anio_para_sec_sup() {
    if($this->data['Plan']['oferta_id'] == SEC_ID 
       || $this->data['Plan']['oferta_id'] == SEC_TEC_ID 
       || $this->data['Plan']['oferta_id'] == SUP_ID
       || $this->data['Plan']['oferta_id'] == SUP_TEC_ID){
      if(empty($this->data['Plan']['duracion_anios'])){
        return false;
      }
    }
    return true;
  }

  function estructura_para_sec(){
    if($this->data['Plan']['oferta_id'] == SEC_TEC_ID){
      if(empty($this->data['Plan']['estructura_plan_id']))
        return false;
    }
    return true;
  }

  function tiene_titulo() {
    if(empty($this->data['Plan']['titulo_id'])){
        return false;
    }
    return true;
  }

  /**
   * Redefinición de find() del parent. Si trae recursive en 3 realiza
   * una "búsqueda completa", utilizando campos de tablas a 2 niveles de
   * relación de distancia
   */
  public function find( $conditions = null, $fields = null, $order = null, $recursive = null ) {
    //if ($conditions == 'completo' || $conditions == 'countCompleto') {
    if ( !empty( $fields['recursive'] ) && $fields['recursive'] == 3 ) {
      if ( $conditions == 'count' ) {
        $ret = $this->__findCompleto( 'count', $fields, $order, $recursive );
      } else {
        $ret = $this->__findCompleto( 'buscar', $fields, $order, $recursive );
      }
    } else {
      $ret = parent::find( $conditions, $fields, $order, $recursive );
    }
    return $ret;
  }


  /**
   * Devuelve un find "all" con un monton de JOINs extra.
   * Los JOINs fueron utilizados porque CakePHP llega al nivel de Belongs To
   * y en el Contain no utiliza Joins sino que realiza un Select por item,
   * por este motivo no se podía ordenar o filtrar por un campo de esos Contain.
   *
   * @param array   $parameters
   * @param string  $buscaroSoloContar
   *                      Los valores posibles son: 'buscar' (por default)  o 'count'
   * @return array
   */
  function __findCompleto( $buscaroSoloContar = 'buscar', $parameters = array(), $order = null, $recursive = null ) {

    $parameters = array_merge( $parameters, compact( 'conditions', 'fields', 'order', 'recursive' ) );
    $ciclo = 0;
    if ( isset( $parameters['conditions']['ciclo_id'] ) ) {
      $ciclo = $parameters['conditions']['ciclo_id'];
    }
    if ( isset( $parameters['conditions']['Anio.ciclo_id'] ) ) {
      $ciclo = $parameters['conditions']['Anio.ciclo_id'];
    }
    if ( isset( $parameters['conditions']['Ciclo.id'] ) ) {
      $ciclo = $parameters['conditions']['Ciclo.id'];
    }

    $parameters['joins'] = array(
      array(
        'table' => 'instits',
        'type' => 'LEFT',
        'alias' => 'Instit',
        'conditions' => array( 'Instit.id = Plan.instit_id' ),
      ),
      array(
        'table' => 'estructura_planes',
        'type' => 'LEFT',
        'alias' => 'EstructuraPlan',
        'conditions' => array( 'EstructuraPlan.id = Plan.estructura_plan_id' ),
      ),
      array(
        'table' => 'anios',
        'type' => 'LEFT',
        'alias' => 'Anio',
        'conditions' => array( 'Plan.id = Anio.plan_id' ),
      ),
      array(
        'table' => 'etapas',
        'type' => 'LEFT',
        'alias' => 'Etapa',
        'conditions' => array( 'Anio.etapa_id = Etapa.id' ),
      ),
      array(
        'table' => 'ciclos',
        'type' => 'LEFT',
        'alias' => 'Ciclo',
        'conditions' => array( 'Ciclo.id = Anio.ciclo_id' ),
      ),
      array(
        'table' => 'titulos',
        'type' => 'LEFT',
        'alias' => 'Titulo',
        'conditions' => array( 'Titulo.id = Plan.titulo_id' ),
      ),
      array(
        'table' => 'sectores_titulos',
        'type' => 'LEFT',
        'alias' => 'SectoresTitulo',
        'conditions' => array( 'SectoresTitulo.titulo_id = Titulo.id' ),
      ),
      array(
        'table' => 'sectores',
        'type' => 'LEFT',
        'alias' => 'Sector',
        'conditions' => array( 'SectoresTitulo.sector_id = Sector.id' ),
      ),
      array(
        'table' => 'orientaciones',
        'type' => 'LEFT',
        'alias' => 'Orientacion',
        'conditions' => array( 'Orientacion.id = Sector.orientacion_id' ),
      ),
    );

    if ( empty( $parameters['order'] ) )
      $parameters['order'] = array( "Plan.nombre" );
    $parametersForList = $parameters;
    $parametersForList['fields']= 'Plan.id';
    $parametersForList['group']= array( 'Plan.id', 'Plan.nombre' );
    unset( $parametersForList['contain'] );
    //unset($parametersForList['order']);

    //debug($parametersForList);
    $planesIds = parent::find( 'list', $parametersForList );
    if ( $buscaroSoloContar == 'count' ) {
      return count( $planesIds );
    }

    // recojo todos los planes que cumplan con los criterios de busqueda
    if ( empty( $planesIds ) ) {
      // no hay planes que cumplan con esos criterios de busqueda
      return array();
    }

    $parameters['conditions'] = array( 'Plan.id' => $planesIds );

    unset( $parameters['limit'] );
    unset( $parameters['page'] );
    unset( $parameters['joins'] );
    unset( $parameters['fields'] );
    unset( $parameters['group'] );

    if ( empty( $parameters['contain'] ) ) {
      $parameters['contain'] = array(
        'Instit' => array(
          'Orientacion'
        ),
        'EstructuraPlan' => array( 'Etapa' ),
        'PlanEstado',
        'PlanTurno',
        'Oferta',
        'Titulo' => array(
          'SectoresTitulo' => array(
            'Sector' => array(
              'Orientacion'
            ),
            'Subsector',
          ),
        ),
        'Anio' => array(
          'EstructuraPlanesAnio',
          'Etapa'
        ),
      );
    }

    $planes = parent::find( 'all', $parameters );

    foreach ( $planes as $key=>&$p ) {
      $ciclo_id = empty( $ciclo ) ?
        $this->getUltimoCiclo( $p['Plan']['id'] ) : $ciclo;
      $p['Anio'] = $this->Anio->getAniosDePlanPorCiclo( $p['Plan']['id'], $ciclo_id );
    }

    return $planes;
  }


  function setMaxCiclo( $ciclo ) {
    $this->maxCiclo = $ciclo;
  }

  function setTraerUltimaAct( $ult ) {
    $this->traerUltimaAct = $ult;
  }

  function getTraerUltimaAct() {
    return $this->traerUltimaAct;
  }

  /**
   * Suma las matriculas para un determinado plan y ciclo.
   *
   *
   * @return matricula de determinado plan, ciclo.
   */

  function dameMatriculaDeCiclo( $plan_id = null, $ciclo = 0 ) {
    if ( !empty( $plan_id ) ) {
      $this->id = $plan_id;
    }
    $conditions = array();

    if ( $ciclo == 0 ) {
      $conditions = array( 'plan_id'=>$plan_id );
    }
    else {
      $conditions = array( 'plan_id'=>$plan_id, 'ciclo_id'=>$ciclo );
    }

    $tot = $this->Anio->find( 'all', array(
        'fields'=>'sum("Anio"."matricula") AS "Anio__matricula"',
        'conditions'=> $conditions,
        'limit'=> 1
      ) );

    return $tot[0]['Anio']['matricula'];
  }

  function controlar_coincidencia_sector_subsector() {
    if ( isset( $this->data[$this->name]['subsector_id'] ) ) {
      if ( $this->data[$this->name]['subsector_id'] == '' ) {
        $this->data[$this->name]['subsector_id'] = 0;
        return true;
      }

      if ( $this->data[$this->name]['subsector_id'] == 0 ) return true;

      if ( $this->data[$this->name]['subsector_id'] != '' ) {
        $sector_id = $this->data[$this->name]['sector_id'];
        $subsector_id = $this->data[$this->name]['subsector_id'];
        $this->Subsector->recursive = -1;
        $tot = $this->Subsector->find( 'count', array( 'conditions'=> array( 'Subsector.id'=>$subsector_id, 'Subsector.sector_id'=>$sector_id ) ) );
        return $tot > 0;
      }
    }
    return false;
  }


  //TODO validar la oferta con la clase de institucion
  function validar_oferta_id_con_claseinstit() {
    return true;
  }






  /**
   * Me devuelve la estructura de un Plan Tecnico (si no es tecnico,
   * o sea oferta_id = SEC_TEC, devuelve -1).
   * En el caso que la estructura no haya sido asignada, busca entre los anios
   * del Plan para identificar la estructura de su oferta
   * Si hay varios ciclos lectivos busca en el ultimo.
   * Devuelve el ID de la estcuctura del plan
   *
   * @param integer $plan_id
   * @param bool    $busqueda_forzada forza la sugerencia por mas que ya tenga estructura asociada
   * @return integer  devuelve el ID de estructura_planes. Si el plan NO es tecnico, devuelve -1
   */
  function getEstructuraSugerida( $plan_id=null, $busqueda_forzada=false ) {
    if ( empty( $plan_id ) ) {
      $plan_id = $this->id;
    }

    $this->recursive = -1;
    $plan = $this->findById( $plan_id );
    // si el plan no es tecnico que devuelva -1
    if ( $plan['Plan']['oferta_id'] != SEC_TEC_ID ) {
      return -1;
    }
    if ( !$busqueda_forzada ) {
      // si ya tiene una estructura asignada
      if ( $plan['Plan']['estructura_plan_id'] != 0 )
        return $plan['Plan']['estructura_plan_id'];
    }

    $anios = $this->Anio->find( 'all', array(
        'fields'=> array( 'ciclo_id', 'etapa_id', 'count(etapa_id) AS "Anio__total"' ),
        'conditions'=> array(
          'plan_id'=>$plan_id ),
        'group'=> array( 'etapa_id', 'ciclo_id' ),
        'order'=>'ciclo_id' ) );
    /*
            [0] => Array
                (
                    [Anio] => Array
                        (
                            [ciclo_id] => 2007
                            [etapa_id] => 4  // (C.B.)
                            [total] => 3
                        )

                )

            [1] => Array
                (
                    [Anio] => Array
                        (
                            [ciclo_id] => 2007
                            [etapa_id] => 5 // (C.S.)
                            [total] => 3
                        )

                )
             */
    // chequea si existen en un mismo ciclo distintas etapas
    $ciclo_anterior = '';
    $totales = '';
    foreach ( $anios as $anio ) {
      if ( $anio['Anio']['ciclo_id'] != $ciclo_anterior ) {
        $ciclo_anterior = $anio['Anio']['ciclo_id'];
        $etapas_en_ciclos[$anio['Anio']['ciclo_id']] = $anio['Anio']['etapa_id'];

        $totales[$anio['Anio']['ciclo_id']][$anio['Anio']['etapa_id']] = $anio['Anio']['total'];
      }
      else {
        // etapa repetida en un mismo ciclo
        if ( !@in_array( $anio['Anio']['ciclo_id'], $ciclos_con_repeticiones ) ) {
          $ciclos_con_repeticiones[] = $anio['Anio']['ciclo_id'];
        }
      }
      $etapas[$anio['Anio']['ciclo_id']][$anio['Anio']['etapa_id']] = $anio['Anio']['total'];
    }

    // si hubo repeticiones pero el ultimo ciclo no tuvo, se sugiere el mismo
    if ( !@in_array( $ciclo_anterior, $ciclos_con_repeticiones ) ) {
      $plan = $this->find( 'all', array(
          'fields'=> array( 'id' ),
          'contain'=>array( 'Instit'=>array( 'fields'=>'jurisdiccion_id' ) ),
          'conditions'=> array( 'Plan.id'=>$plan_id )
        ) );
      if ( $plan && !empty( $etapas_en_ciclos ) ) {
        $etapa_id_de_este_ciclo = $etapas_en_ciclos[$ciclo_anterior];
        $estructuraPlanes = $this->EstructuraPlan->JurisdiccionesEstructuraPlan->find( 'all', array(
            //'fields'=> array('id'),
            'contain'=>array(
              // 'EstructuraPlanesAnio',
              'EstructuraPlan.EstructuraPlanesAnio',
            ),
            'conditions'=> array(
              'EstructuraPlan.etapa_id'=>$etapa_id_de_este_ciclo,
              'JurisdiccionesEstructuraPlan.jurisdiccion_id'=>$plan['0']['Instit']['jurisdiccion_id']
            ),
          ) );


        if ( $estructuraPlanes ) {
          $cant_etapas_de_este_ciclo = $etapas[$ciclo_anterior][$etapa_id_de_este_ciclo];

          if ( count( $estructuraPlanes ) == 1 ) {
            if ( count( $estructuraPlanes[0]['EstructuraPlan']['EstructuraPlanesAnio'] ) >= $cant_etapas_de_este_ciclo ) {
              return $estructuraPlanes[0]['EstructuraPlan']['id'];
            }
          }
          else {
            foreach ( $estructuraPlanes as $estructuraPlan ) {
              // si tengo una estructura mayor a la cant de Anios cargados, duda (0)
              if ( count( $estructuraPlan['EstructuraPlan']['EstructuraPlanesAnio'] ) > $cant_etapas_de_este_ciclo ) {
                return 0;
              }
            }

            foreach ( $estructuraPlanes as $estructuraPlan ) {
              // si tengo una estructura con la misma cant de Anios cargados, la retorna
              if ( count( $estructuraPlan['EstructuraPlan']['EstructuraPlanesAnio'] ) == $cant_etapas_de_este_ciclo ) {
                return $estructuraPlan['EstructuraPlan']['id'];
              }
            }
          }
          // si no coincide la cantidad de años, lo sugiere igual
          //return $estructuraPlanes['0']['EstructuraPlan']['id'];
        }
      }
    }
    return 0;
  }


  /**
   *  Me devuelve la Etapa del Plan obteniendo el valor de EstructuraPlan
   *  las etapas son: Ciclo Basico, Ciclo Superior, Polimodal, EGB3, etc etc
   *
   * @param integer $plan_id
   * @return array del model Etapa, o false en caso de no tener etapa definida
   */
  function getEtapaDeEstructura( $plan_id ) {
    $plan = $this->find( 'first', array(
        'contain' => array( 'EstructuraPlan.Etapa' ),
        'conditions' => array( 'Plan.id'=>$plan_id ),
      ) );
    return  ( !empty( $plan['EstructuraPlan']['Etapa'] ) ) ? $plan['EstructuraPlan']['Etapa']: false;
  }


  function getEstructuraOfertaYDatos() {
    $trayectosData['anios'] = array( 12, 13, 14, 15 );
    $trayectosData['etapa_header'] = array(
      array( 'title'=>'Ciclo Básico', 'anios'=>array( 1, 2, 3 ) ),
      array( 'title'=>'Ciclo Superior', 'anios'=>array( 4 ) ),
    );
    $trayectosData['ciclo_lectivo'] = array(
      array( 'title'=>2009,
        'ciclos_data'=> array(
          array(
            'matricula'=>12,
            'seccion'=>10,
            'hs_taller'=>1,
          ),
          array(
            'matricula'=>12,
            'seccion'=>10,
            'hs_taller'=>2,
          ),
          array(
            'matricula'=>12,
            'seccion'=>10,
            'hs_taller'=>3,
          ),
          array(
            'matricula'=>12,
            'seccion'=>10,
            'hs_taller'=>4,
          ),
        ) ),
      array( 'title'=>2008,
        'ciclos_data'=> array(
          array(
            'matricula'=>12,
            'seccion'=>10,
            'hs_taller'=>1,
          ),
          array(
            'matricula'=>12,
            'seccion'=>10,
            'hs_taller'=>2,
          ),
          array(
            'matricula'=>12,
            'seccion'=>10,
            'hs_taller'=>3,
          ),
          array(
            'matricula'=>12,
            'seccion'=>10,
            'hs_taller'=>4,
          ),
        ) ),
    );
    return $trayectosData;
  }


  /**
   *
   *
   * @param integer $plan_id            id del plan, por defecto en nulo
   * @param integer $estructura_plan_id
   */
  function guardarEstructuraSiNoLaTiene( $estructura_plan_id, $plan_id = null ) {
    $this->recursive = -1;

    if ( !empty( $plan_id ) ) $this->id = $plan_id;

    $plan = $this->read();

    if ( empty( $plan['Plan']['estructura_plan_id'] ) ) {
      if ( !$this->saveField( 'estructura_plan_id', $estructura_plan_id ) ) {
        debug( "error al guardar el ID del plan" );
      }
    }
  }


  function tieneEstructuraDefinida( $plan_id = null ) {
    if ( empty( $plan_id ) ) {
      $plan_id = $this->id;
    }
    $ep = $this->find( 'count', array(
        'conditions' => array(
          'Plan.estructura_plan_id <>' => 0,
          'Plan.id' => $plan_id,
        ),
        'recursive' => -1,
      ) );

    return $ep;

  }



  /**
   * Verifica que todos los años del plan tengan la misma estructura que
   * su Plan padre
   *
   * @param integer $plan_id
   * @return true si teiene estructura valida o un array con los años incorrectos en caso de no tenerla
   */
  function estructuraValida( $plan_id = null ) {
    if ( empty( $plan_id ) ) {
      $plan_id = $this->id;
    }

    if ( !empty( $plan_id ) ) {
      // busca la estructura del plan
      $ep = $this->find( 'first', array(
          'conditions' => array(
            'Plan.id' => $plan_id,
          ),
          'contain' => array( 'EstructuraPlan' ),
        ) );

      // Si el plan no es Secundario Tecnico
      // devolver siempre que la estructura es valida
      if ( $ep['Plan']['oferta_id'] != 3 ) {
        return true;
      }

      // busco si hay anios que tengan otra estructura
      $cant = $this->Anio->find( 'all', array(
          'conditions' => array(
            'Anio.plan_id' => $plan_id,
            'OR' => array (
              'EstructuraPlanesAnio.estructura_plan_id <>' => $ep['EstructuraPlan']['id'],
              'Anio.estructura_planes_anio_id' => 0,
            )
          ),
          'contain' => array(
            'EstructuraPlanesAnio.EstructuraPlan',
          ),
          'order' => array( 'Anio.ciclo_id', 'EstructuraPlanesAnio.edad_teorica' ),
        ) );

      // verifico que tenga estructura el año
      $cant2 = $this->Anio->find( 'all', array(
          'conditions' => array(
            'Anio.plan_id' => $plan_id,
          ),
          'contain' => array( 'EstructuraPlanesAnio' ),
          'order' => array( 'Anio.ciclo_id', 'EstructuraPlanesAnio.edad_teorica' ),
        ) );
      $newVec = array();
      foreach ( $cant2 as $cc ) {
        if ( empty( $cc['EstructuraPlanesAnio']['id'] ) ) {
          $newVec[] = $cc;
        }
      }
      if ( count( $newVec )>0 ) {
        $cant += $newVec;
      }

      return ( count( $cant ) > 0 )  ?    $cant   :    true;
    }
    return true;
  }

  /**
   * devuelve el ultimo ciclo lectivo del plan
   */
  function getUltimoCiclo( $plan_id ) {
    $sql = ' SELECT max("Anio"."ciclo_id") AS "Anio__ciclo_id"
                       FROM planes p
                      INNER JOIN anios AS "Anio" ON "Anio".plan_id = p.id
                      WHERE p.id = ' . $plan_id;

    $data = $this->query( $sql );

    $max_ciclo = 0;
    if ( !empty( $data ) ) {
      foreach ( $data as $line ) {
        $max_ciclo = $line['Anio']['ciclo_id'];
      }
    }
    return $max_ciclo;
  }

  function filtrar_planes( $planes, $filtro_titulo, $filtro_sector, $filtro_ciclo ) {
    return $planes;
  }


  /*
         * Trae los planes de la misma institucion con nombre igual o similar al dado por parametro
         */
  function getSimilars( $name, $instit_id, $plan_id=null ) {
    $similars = array();

    if ( !empty( $name ) ) {
      $nombre = $name;
    }
    elseif ( !empty( $this->data['Plan']['nombre'] ) ) {
      $nombre = $this->data['Plan']['nombre'];
    }

    if ( !empty( $plan_id ) ) {
      $id = $plan_id;
    }
    elseif ( !empty( $this->data['Plan']['id'] ) ) {
      $id = $this->data['Plan']['id'];
    }

    if ( !empty( $nombre ) ) {
      $conditions = array( 'lower(Plan.nombre)  SIMILAR TO ?' => convertir_texto_plano( $nombre ),
        'Plan.instit_id' => $instit_id );

      if ( !empty( $id ) ) {
        // si esta editando, que no sea el mismo
        $conditions['Plan.id <>'] = $id;
      }

      $similars = $this->find( 'all', array(
          'conditions' => $conditions ) );
    }

    return $similars;
  }


}
?>
