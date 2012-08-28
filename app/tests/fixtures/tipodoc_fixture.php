<?php
/* Tipodoc Fixture generated on: 2010-04-29 09:04:12 : 1272544032 */
class TipodocFixture extends CakeTestFixture {
	var $name = 'Tipodoc';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'abrev' => array('type' => 'string', 'null' => false, 'length' => 5),
		'name' => array('type' => 'string', 'null' => false, 'length' => 40),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id')),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'abrev' => 'Lor',
			'name' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>