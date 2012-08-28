<?php
class PlanEstado extends AppModel {

	var $name = 'PlanEstado';
	var $displayField = 'nombre';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Plan' => array(
			'className' => 'Plan',
			'foreignKey' => 'plan_estado_id',
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