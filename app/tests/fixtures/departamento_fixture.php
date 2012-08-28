<?php
/* Departamento Fixture generated on: 2010-04-29 09:04:50 : 1272544010 */
class DepartamentoFixture extends CakeTestFixture {
	var $name = 'Departamento';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'jurisdiccion_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'length' => 64),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id')),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'jurisdiccion_id' => 2,
			'name' => 'BUENOS AIRES'
		)
	);
}
?>