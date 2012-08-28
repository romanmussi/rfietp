<?php
/* Referente Fixture generated on: 2010-04-29 09:04:07 : 1272544027 */
class ReferenteFixture extends CakeTestFixture {
	var $name = 'Referente';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'jurisdiccion_id' => array('type' => 'integer', 'null' => false),
		'name' => array('type' => 'string', 'null' => false, 'length' => 60),
		'tipodoc_id' => array('type' => 'integer', 'null' => false),
		'nrodoc' => array('type' => 'integer', 'null' => false),
		'telefono' => array('type' => 'string', 'null' => false, 'length' => 60),
		'mail' => array('type' => 'string', 'null' => false, 'length' => 60),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id')),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'jurisdiccion_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'tipodoc_id' => 1,
			'nrodoc' => 1,
			'telefono' => 'Lorem ipsum dolor sit amet',
			'mail' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>