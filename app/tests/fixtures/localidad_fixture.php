<?php
/* Localidad Fixture generated on: 2010-04-29 09:04:00 : 1272544020 */
class LocalidadFixture extends CakeTestFixture {
	var $name = 'Localidad';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'departamento_id' => array('type' => 'integer', 'null' => true),
		'name' => array('type' => 'string', 'null' => true, 'length' => 64),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id')),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'departamento_id' => 1,
			'name' => 'TANDIL'
		),
                array(
                    'id' => 2,
                    'departamento_id' => 1,
                    'name' => 'DISTRITO ESCOLAR Nº 4'
                )
	);
}
?>