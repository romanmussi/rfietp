<?php

class PlanTurnoFixture  extends CakeTestFixture {
    var $name = 'PlanTurno';
    
    var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
                'nombre' => array('type' => 'string', 'null' => true, 'length' => 255),
	);

	var $records = array(
		array(
			'id' => 1,
			'nombre' => 'Diurno',
		),
		array(
			'id' => 2,
			'nombre' => 'Vespertino',
		),
		array(
			'id' => 3,
			'nombre' => 'Nocturno',
		),
	);
}
?>