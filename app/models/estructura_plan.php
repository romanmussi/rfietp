<?php
class EstructuraPlan extends AppModel {

	var $name = 'EstructuraPlan';

        var $validate = array(
		'name' => array(
			'notEmpty'=> array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'Debe ingresar el nombre.'
			)
		),
        );

        var $belongsTo = array(
                        'Etapa',
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
                        'Plan',
			'EstructuraPlanesAnio' => array('dependent'=> true),
                        'JurisdiccionesEstructuraPlan',
	);


    function comparar_planes_por_orden($a, $b)
    {
        $a_order = $a['EstructuraPlan']['Etapa']['orden'];
        $b_order = $b['EstructuraPlan']['Etapa']['orden'];

        if ($a_order == $b_order) {
            return 0;
        }
        return ($a_order > $b_order) ? +1 : -1;
    }

    function afterFind($results) {
        if (!empty($results[0]['EstructuraPlan']['Etapa'])) {
            usort($results, array( $this, 'comparar_planes_por_orden' ));
        }

        return $results;
    }

}
?>