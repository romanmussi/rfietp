<?php

class SubsectorFixture extends CakeTestFixture {
	var $name = 'Subsector';

        var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
                'name' => array('type' => 'string', 'null' => true, 'length' => 255),
                'sector_id' => array('type' => 'integer', 'null' => true, 'default' => 0),
	);

	var $records = array(
		array(
			'id' => 168,
			'name' => 'Idioma',
			'sector_id' => 2,
		),
		array(
			'id' => 171,
			'name' => 'Carrocería',
			'sector_id' => 8,
		),
		array(
			'id' => 174,
			'name' => 'Gastronomía',
			'sector_id' => 24,
		),
	);
}

?>