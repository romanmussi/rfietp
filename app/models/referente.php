<?php
class Referente extends AppModel {

	var $name = 'Referente';

	var $belongsTo = array(
			'Tipodoc',
			'Jurisdiccion',
	);

	var $validate = array(
      	'name' => array(
			'rule' => 'notEmpty', // or: array('ruleName', 'param1', 'param2' ...)
			'required' => true,
			'allowEmpty' => false,
			//'on' => 'create', // or: 'update'
			'message' => 'Se debe ingresar un nombre para la Jurisdicción. No puede quedar vacío.')
   );
	
}
?>