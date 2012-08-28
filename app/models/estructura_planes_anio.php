<?php
class EstructuraPlanesAnio extends AppModel {

	var $name = 'EstructuraPlanesAnio';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'EstructuraPlan',
	);

	var $hasMany = array(
			'Anio',
	);

}
?>