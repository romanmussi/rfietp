<?php
class Oferta extends AppModel {

	var $name = 'Oferta';
        
        var $order = 'Oferta.order';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Plan' => array('dependent' => false),
	);

	var $validate = array(
		'abrev' => array(
			'notEmpty'=> array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'Debe ingresar una abreviatura.'	
			)
		),
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