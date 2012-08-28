<?php 
/* SVN FILE: $Id$ */
/* Fondo Fixture generated on: 2010-04-22 10:25:00 : 1271942700*/

class FondoFixture extends CakeTestFixture {
	var $name = 'Fondo';
	//var $table = 'fondos';
        var $table = null;
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'instit_id' => array('type'=>'integer', 'null' => false),
		'jurisdiccion_id' => array('type'=>'integer', 'null' => false),
		'total' => array('type'=>'float', 'null' => false, 'default' => '0'),
		'anio' => array('type'=>'integer', 'null' => false),
		'trimestre' => array('type'=>'integer', 'null' => false),
		'memo' => array('type'=>'string', 'null' => false, 'length' => 20),
		'resolucion' => array('type'=>'string', 'null' => false, 'length' => 20),
		'description' => array('type'=>'text', 'null' => false, 'length' => 1073741824),
		'created' => array('type'=>'datetime', 'null' => true),
		'modified' => array('type'=>'datetime', 'null' => true),
		//'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	var $records = array(
            array(
		'id' => 1,
		'instit_id' => 1,
		'jurisdiccion_id' => 1,
		'total' => 1,
		'anio' => 1,
		'trimestre' => 1,
		'memo' => 'Lorem ipsum dolo',
		'resolucion' => 'Lorem ipsum dolo',
		'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created' => '2010-04-22 10:25:00',
		'modified' => '2010-04-22 10:25:00'
	),
             array(
		'id' => 2,
		'instit_id' => 2,
		'jurisdiccion_id' => 1,
		'total' => 1,
		'anio' => 1,
		'trimestre' => 1,
		'memo' => 'Lorem ipsum dolo',
		'resolucion' => 'Lorem ipsum dolo',
		'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created' => '2010-04-22 10:25:00',
		'modified' => '2010-04-22 10:25:00'
	),  
            );
}
?>