<?php
class Tipodoc extends AppModel {

	var $name = 'Tipodoc';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Referente',
	);

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
		'abrev' => array(
			'notEmpty'=> array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'Debe ingresar la abreviatura.'	
			)
		)
	);
}
?>