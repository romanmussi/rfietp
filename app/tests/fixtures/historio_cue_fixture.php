<?php
/* HistorioCue Fixture generated on: 2010-04-29 09:04:56 : 1272544016 */
class HistorioCueFixture extends CakeTestFixture {
	var $name = 'HistorioCue';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'instit_id' => array('type' => 'integer', 'null' => false),
		'cue' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'anexo' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true),
		'observaciones' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id')),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'instit_id' => 1,
			'cue' => 1,
			'anexo' => 1,
			'created' => '2010-04-29 09:26:56',
			'observaciones' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);
}
?>