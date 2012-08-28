<?php
/* Query Fixture generated on: 2010-04-29 09:04:06 : 1272544026 */
class QueryFixture extends CakeTestFixture {
	var $name = 'Query';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => '(NOT NULL', 'length' => 70),
		'description' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'query' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'created' => array('type' => 'datetime', 'null' => true),
		'modified' => array('type' => 'datetime', 'null' => true),
		'categoria' => array('type' => 'string', 'null' => true, 'default' => '(NOT NULL', 'length' => 64),
		'ver_online' => array('type' => 'boolean', 'null' => true, 'default' => '(NOT NULL'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id')),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'query' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2010-04-29 09:27:06',
			'modified' => '2010-04-29 09:27:06',
			'categoria' => 'Lorem ipsum dolor sit amet',
			'ver_online' => 1
		),
	);
}
?>