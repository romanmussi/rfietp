<?php
class JurisdiccionesEstructuraPlan extends AppModel {

	var $name = 'JurisdiccionesEstructuraPlan';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Jurisdiccion',
			'EstructuraPlan',
	);


        /**
         *
         *  Me devuelve todas las EstructuraPlan disponibles para una determinada
         *  jurisdiccion.
         *
         * 
         * @param integer $jurisdiccion_id ID de la jurisdiccion donde quiero buscar las estructuras
         * @param string $find_type las posibilidades son:
         *                                                  'all'
         *                                                  'list'
         * @return array del model 'EstructuraPlan' encontradas
         */
        function getEstructurasDeJurisdiccion($jurisdiccion_id, $find_type = 'all', $order='Etapa.orden') {
             /*$trayecto_anios = $this->find('all', array(
                'fields' => array('EstructuraPlan.name'),
                'contain' => array(
                    'EstructuraPlan.EstructuraPlanesAnio',
                    'EstructuraPlan.Etapa'
                ),
                'conditions'=> array(
                    'JurisdiccionesEstructuraPlan.jurisdiccion_id' => $jurisdiccion_id,
                ),
                ));*/
             $this->recursive = -1;
             $trayecto_anios = $this->find('all', array(
                'fields' => array('EstructuraPlan.id','EstructuraPlan.name'),
                'joins' => array(
                    array('table' => 'estructura_planes',
                          'alias' => 'EstructuraPlan',
                          'type' => 'inner',
                          'conditions' => array(
                            'EstructuraPlan.id = JurisdiccionesEstructuraPlan.estructura_plan_id'
                          )
                    ),
                    array('table' => 'etapas',
                          'alias' => 'Etapa',
                          'type' => 'inner',
                          'conditions' => array(
                            'EstructuraPlan.etapa_id = Etapa.id'
                          )
                    ),
                ),
                'conditions' => array(
                    'jurisdiccion_id' => $jurisdiccion_id
                ),
                'order' => array($order),
                ));

             // si es del tipo list convierto el resultado a ese formato
             if ($find_type == 'list') {
                 $nuevoTA = array();
                 foreach ($trayecto_anios as $ta) {
                    $estrucID = $ta['EstructuraPlan']['id'];
                    $estrucNAME = $ta['EstructuraPlan']['name'];
                    $nuevoTA[ $estrucID ] = $estrucNAME;
                 }
                 $trayecto_anios = $nuevoTA;

             }

            return $trayecto_anios;
        }

}
?>