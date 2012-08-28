<?php 
/* SVN FILE: $Id$ */
/* Sugerencia Fixture generated on: 2007-04-13 12:05:38 : 1176476738*/

class SugerenciaFixture extends CakeTestFixture {
	var $name = 'Sugerencia';
	var $table = 'sugerencias';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'asunto' => array('type'=>'string', 'null' => true, 'length' => 100),
		'mensaje' => array('type'=>'text', 'null' => true, 'length' => 1073741824),
		'remitente' => array('type'=>'string', 'null' => true, 'length' => 100),
		'email' => array('type'=>'string', 'null' => true, 'length' => 100),
		'IP' => array('type'=>'string', 'null' => true, 'length' => 15),
		'created' => array('type'=>'datetime', 'null' => true),
		'leido' => array('type'=>'integer', 'null' => true, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	var $records = array(array(
		'id' => 1,
		'asunto' => 'Lorem ipsum dolor sit amet',
		'mensaje' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'remitente' => 'Lorem ipsum dolor sit amet',
		'email' => 'Lorem ipsum dolor sit amet',
		'IP' => 'Lorem ipsum d',
		'created' => '2007-04-13 12:05:38',
		'leido' => 1
	));
}
?>