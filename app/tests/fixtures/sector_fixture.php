<?php

class SectorFixture extends CakeTestFixture {
	var $name = 'Sector';

        var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
                'name' => array('type' => 'string', 'null' => true, 'length' => 255),
                'orientacion_id' => array('type' => 'integer', 'null' => true, 'default' => 0),
	);

	var $records = array(
		array(
			'id' => 2,
			'name' => 'Aeronáutica',
			'orientacion_id' => 2, // Industrial
		),
		array(
			'id' => 8,
			'name' => 'Construcción',
			'orientacion_id' => 2, // Industrial
		),
		array(
			'id' => 24,
			'name' => 'Seguridad, Ambiente e Higiene',
			'orientacion_id' => 3, // Otros
		),
	);
}

?>