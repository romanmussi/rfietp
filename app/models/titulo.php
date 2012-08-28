<?php
class Titulo extends AppModel {

	var $name = 'Titulo';
	var $order = 'Titulo.name';
	
	var $validate = array(
		'name' => array('notempty'),
		'marco_ref' => array('boolean'),
		'oferta_id' => array('numeric'),
		/*'sector_id' => array(
			'notEmpty'=> array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				'message' => 'Debe ingresar un sector.',
			)
		),
		'subsector_id' => array(
			'correcto_subsector' => array(
				'rule' => array('controlar_coincidencia_sector_subsector'),
				'message'=> 'El subsector no corresponde al sector.'
			)
		)*/
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Oferta',
	);
	
	
	var $hasMany = array(
            'Plan',
            'SectoresTitulo' => array('dependent'=> true) // borra en cascada // esta es la tabla HABTM, pero la necesito aca para hacer consultas mas especificas
            );

        var $hasAndBelongsToMany = array(
            'Sector' => array('joinTable' => 'sectores_titulos'),
            'Subsector' => array('joinTable' => 'sectores_titulos')
        );


        function beforeDelete($casca) {
            parent::beforeDelete($casca);
            // chequea si contiene planes asociados, no permite
            $count = $this->Plan->find('count', array(
                            'conditions'=>array('Plan.titulo_id'=>$this->id)
                        ));
            if ($count == 0) {
                return true;
            }
            else {
                $this->validationErrors[] = 'Existen Planes que tienen este tìtulo';
                return false;
            }
        }

        /*
         * Trae los titulos con nombre igual o similar al dado por parametro
         */
        function getSimilars($name=null, $titulo_id=null) {
            $similars = array();

            if (!empty($name)) {
                $nombre = $name;
            }
            elseif (!empty($this->data['Titulo']['name'])) {
                $nombre = $this->data['Titulo']['name'];
            }

            if (!empty($titulo_id)) {
                $id = $titulo_id;
            }
            elseif (!empty($this->data['Titulo']['id'])) {
                $id = $this->data['Titulo']['id'];
            }

            if(!empty($nombre)) {
                $conditions = array("lower(Titulo.name)  SIMILAR TO ?" => convertir_texto_plano($nombre));

                if (!empty($id)) {
                    // si esta editando, que no sea el mismo
                    $conditions['Titulo.id <>'] = $id;
                }

                $similars = $this->find('all', array(
                                'conditions' => $conditions));
            }

            return $similars;
        }


        /**
     * Redefinición de find() del parent. Si trae recursive en 3 realiza
     * una "búsqueda completa", utilizando campos de tablas a 2 niveles de
     * relación de distancia
     */
    public function find($conditions = null, $fields = null, $order = null, $recursive = null) {
        if (!empty($fields['recursive']) && $fields['recursive'] == 3) {
            if ($conditions == 'count') {
                $ret = $this->__findCompleto('count', $fields, $order, $recursive);
            } else {
                $ret = $this->__findCompleto('buscar',$fields, $order, $recursive);
            }
        } else {
           $ret = parent::find($conditions, $fields, $order, $recursive);
        }
        return $ret;
    }


    /**
     * Devuelve un find "all" con un monton de JOINs extra.
     * Los JOINs fueron utilizados porque CakePHP llega al nivel de Belongs To
     * y en el Contain no utiliza Joins sino que realiza un Select por item,
     * por este motivo no se podía ordenar o filtrar por un campo de esos Contain.
     *
     * @param array $parameters
     * @param string $buscaroSoloContar
     *                      Los valores posibles son: 'buscar' (por default)  o 'count'
     * @return array
     */
    function __findCompleto($buscaroSoloContar = 'buscar', $parameters = array(), $order = null, $recursive = null) {

        $parameters = array_merge($parameters, compact('conditions', 'fields', 'recursive'));

        $parameters['joins'] = array(
            array(
                'table' => 'planes',
                'type' => 'LEFT',
                'alias' => 'Plan',
                'conditions' => array('Titulo.id = Plan.titulo_id'),
            ),
            array(
                'table' => 'instits',
                'type' => 'LEFT',
                'alias' => 'Instit',
                'conditions' => array('Instit.id = Plan.instit_id'),
            ),
            array(
                'table' => 'tipoinstits',
                'type' => 'LEFT',
                'alias' => 'Tipoinstit',
                'conditions' => array('Tipoinstit.id = Instit.tipoinstit_id'),
            ),
            array(
                'table' => 'jurisdicciones',
                'type' => 'LEFT',
                'alias' => 'Jurisdiccion',
                'conditions' => array('Jurisdiccion.id = Instit.jurisdiccion_id'),
            ),
            array(
                'table' => 'departamentos',
                'type' => 'LEFT',
                'alias' => 'Departamento',
                'conditions' => array('Departamento.id = Instit.departamento_id'),
            ),
            array(
                'table' => 'localidades',
                'type' => 'LEFT',
                'alias' => 'Localidad',
                'conditions' => array('Localidad.id = Instit.localidad_id'),
            ),
            array(
                'table' => 'estructura_planes',
                'type' => 'LEFT',
                'alias' => 'EstructuraPlan',
                'conditions' => array('EstructuraPlan.id = Plan.estructura_plan_id'),
            ),
            array(
                'table' => 'anios',
                'type' => 'LEFT',
                'alias' => 'Anio',
                'conditions' => array('Plan.id = Anio.plan_id'),
            ),
            array(
                'table' => 'etapas',
                'type' => 'LEFT',
                'alias' => 'Etapa',
                'conditions' => array('Anio.etapa_id = Etapa.id'),
            ),
            array(
                'table' => 'ciclos',
                'type' => 'LEFT',
                'alias' => 'Ciclo',
                'conditions' => array('Ciclo.id = Anio.ciclo_id'),
            ),
            array(
                'table' => 'sectores_titulos',
                'type' => 'LEFT',
                'alias' => 'SectoresTitulo',
                'conditions' => array('SectoresTitulo.titulo_id = Titulo.id'),
            ),
            array(
                'table' => 'sectores',
                'type' => 'LEFT',
                'alias' => 'Sector',
                'conditions' => array('SectoresTitulo.sector_id = Sector.id'),
            ),
            array(
                'table' => 'subsectores',
                'type' => 'LEFT',
                'alias' => 'Subsector',
                'conditions' => array('SectoresTitulo.subsector_id = Subsector.id'),
            ),
            array(
                'table' => 'ofertas',
                'type' => 'LEFT',
                'alias' => 'Oferta',
                'conditions' => array('Titulo.oferta_id = Oferta.id'),
            ),
            array(
                'table' => 'orientaciones',
                'type' => 'LEFT',
                'alias' => 'Orientacion',
                'conditions' => array('Orientacion.id = Sector.orientacion_id'),
            ),
        );

        $parametersForList = $parameters;
        $parametersForList['fields']= 'Titulo.id';
        //$parametersForList['group']= 'Titulo.id';
        $orderaux = $this->order;
        $this->order = null;
        unset($parametersForList['contain']);
        //unset($parametersForList['order']);

        $titulosIds = parent::find('list', $parametersForList);
        if ($buscaroSoloContar == 'count') {
            return count($titulosIds);
        }
        
        // recojo todos los planes que cumplan con los criterios de busqueda
        if (empty($titulosIds) ) {
            // no hay planes que cumplan con esos criterios de busqueda
            return array();
        }

        $parameters['conditions'] = array('Titulo.id' => $titulosIds);

        unset( $parameters['limit'] );
        unset( $parameters['page'] );
        unset( $parameters['joins'] );
        //unset( $parameters['fields'] );
        unset( $parameters['group'] );

        if (empty($parameters['contain'])) {
            $parameters['contain'] = array(
                'SectoresTitulo' => array(
                    'Sector' => array(
                        'Orientacion'
                        ),
                    'Subsector',
                    ),
                'Oferta'
            );
        }

        $titulos = parent::find('all', $parameters);

        $this->order = $orderaux;

        return $titulos;
    }

}
?>