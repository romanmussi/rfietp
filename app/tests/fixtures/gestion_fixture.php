<?php
/* Gestion Fixture generated on: 2010-04-29 09:04:55 : 1272544015 */
class GestionFixture extends CakeTestFixture {
	var $name = 'Gestion';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 20),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id')),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor '
		),
	);
}
?>