<?php
class Gestion extends AppModel {

	var $name = 'Gestion';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Instit',
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
		)
	);
}
?>