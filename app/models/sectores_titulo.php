<?php
class SectoresTitulo extends AppModel {

	var $name = 'SectoresTitulo';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Titulo' => array(
			'className' => 'Titulo',
			'foreignKey' => 'titulo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sector' => array(
			'className' => 'Sector',
			'foreignKey' => 'sector_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Subsector' => array(
			'className' => 'Subsector',
			'foreignKey' => 'subsector_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>