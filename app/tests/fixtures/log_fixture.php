<?php
/* Log Fixture generated on: 2010-04-29 09:04:01 : 1272544021 */
class LogFixture extends CakeTestFixture {
	var $name = 'Log';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'length' => 20),
		'fecha_in' => array('type' => 'date', 'null' => false),
		'hora_in' => array('type' => 'integer', 'null' => false),
		'fecha_out' => array('type' => 'date', 'null' => false),
		'hora_out' => array('type' => 'integer', 'null' => false),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id')),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'username' => 'Lorem ipsum dolor ',
			'fecha_in' => '2010-04-29',
			'hora_in' => 1,
			'fecha_out' => '2010-04-29',
			'hora_out' => 1
		),
	);
}
?>