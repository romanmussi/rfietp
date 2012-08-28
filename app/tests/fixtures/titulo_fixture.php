<?php

class TituloFixture extends CakeTestFixture {
	var $name = 'Titulo';

        var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
                'name' => array('type' => 'string', 'null' => true, 'length' => 255),
                'marco_ref' => array('type' => 'boolean', 'null' => true, 'default' => false),
                'oferta_id' => array('type' => 'integer', 'null' => true, 'default' => 0),
	);

	var $records = array(
                array(
			'id'  		=> 1,
			'name'  	=> 'Lorem ipsum dolor sit amet',
			'marco_ref' => true,
			'oferta_id' => 1
			),
                array(
			'id' => 2,
			'name' => 'Un titulo inventado 1',
			'marco_ref' => false,
			'oferta_id' => 1,
		),
		array(
			'id' => 60,
			'name' => 'Técnico Superior en Comunicación Multimedial',
			'marco_ref' => false,
			'oferta_id' => 4,
		),
		array(
			'id' => 1242,
			'name' => 'Cocina Básica',
			'marco_ref' => false,
			'oferta_id' => 1,
		),
		array(
			'id' => 55,
			'name' => 'Técnico en Producción Agropecuaria con Especialización en Enología',
			'marco_ref' => false,
			'oferta_id' => 3,
		),
                array(
			'id' => 344,
			'name' => 'Plomero',
			'marco_ref' => false,
			'oferta_id' => 1,
		),
	);
}

?>