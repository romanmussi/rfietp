<?php
class Cargo extends AppModel {

	var $name = 'Cargo';
	var $validate = array(
		'nombre' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasAndBelongsToMany = array(
		'Autoridad' => array(
			'className' => 'Autoridad',
			'joinTable' => 'autoridades_cargos',
			'foreignKey' => 'cargo_id',
			'associationForeignKey' => 'autoridad_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

}
?>