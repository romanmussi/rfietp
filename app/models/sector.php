<?php
class Sector extends AppModel {

	var $name = 'Sector';
	
	var $actsAs = array('Containable');

        var $order = 'Sector.name';

	var $hasMany = array(
                        'SectoresTitulo' => array('dependent'=>true),
			'Plan',
                        'Subsector'
	);

        
	
	var $belongsTo = array('Orientacion');


        var $hasAndBelongsToMany = array(
            'Titulo' => array('joinTable' => 'sectores_titulos'),
        );

}
?>