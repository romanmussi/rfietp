<?php
/* Ciclo Fixture generated on: 2010-04-29 09:04:47 : 1272544007 */
class CicloFixture extends CakeTestFixture {
	var $name = 'Ciclo';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 10),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id')),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 2006,
			'name' => '2006'
		),
                array(
			'id' => 2007,
			'name' => '2007'
		),
            array(
			'id' => 2008,
			'name' => '2008'
		),
            array(
			'id' => 2009,
			'name' => '2009'
		),
            array(
			'id' => 2010,
			'name' => '2010'
		),
	);
}
?>