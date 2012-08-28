<?php
class Ciclo extends AppModel {

	var $name = 'Ciclo';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Anio' => array(
                            'className' => 'Anio',
                            'foreignKey' => 'ciclo_id',
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