<?php
class LineasDeAccion extends AppModel {

	var $name = 'LineasDeAccion';
        
	var $validate = array(
		'name' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasAndBelongsToMany = array(
		'Fondo' => array(
			'className' => 'Fondo',
			'joinTable' => 'fondos_lineas_de_acciones',
			'foreignKey' => 'lineas_de_accion_id',
			'associationForeignKey' => 'fondo_id',
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