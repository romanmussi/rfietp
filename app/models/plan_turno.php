<?php
class PlanTurno extends AppModel {

	var $name = 'PlanTurno';
	var $displayField = 'nombre';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Plan' => array(
			'className' => 'Plan',
			'foreignKey' => 'plan_turno_id',
			'dependent' => false,
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

}
?>