<?php

class PlanEstadoFixture  extends CakeTestFixture {
    var $name = 'PlanEstado';
    
    var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
                'nombre' => array('type' => 'string', 'null' => true, 'length' => 255),
	);

	var $records = array(
		array(
			'id' => 1,
			'nombre' => 'Activo',
		),
		array(
			'id' => 2,
			'nombre' => 'Residual',
		),
		array(
			'id' => 3,
			'nombre' => 'Inactivo',
		),
	);
}
?>