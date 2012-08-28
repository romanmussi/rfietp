<?php
class Fondo extends AppModel {
        var $actsAs = array('Containable');
	var $name = 'Fondo';
	var $validate = array(
		'instit_id' => array('numeric'),
		'jurisdiccion_id' => array('numeric'),
		'anio' => array('numeric'),
		'trimestre' => array('numeric'),
		//'memo' => array('notempty'),
		//'resolucion' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Instit',
		'Jurisdiccion',
	);

        var $hasMany = array('FondosLineasDeAccion' => array('dependent'=> true));

	var $hasAndBelongsToMany = array(
		'LineasDeAccion' => array(
			'className' => 'LineasDeAccion',
			'joinTable' => 'fondos_lineas_de_acciones',
			'foreignKey' => 'fondo_id',
			'associationForeignKey' => 'lineas_de_accion_id',
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