<?php 
/* SVN FILE: $Id$ */
/* Cargo Fixture generated on: 2011-03-03 12:42:09 : 1299166929*/

class CargoFixture extends CakeTestFixture {
	var $name = 'Cargo';
	var $table = 'cargos';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'nombre' => array('type'=>'string', 'null' => false, 'length' => 100),
		'rango' => array('type'=>'integer', 'null' => true),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	var $records = array(array(
		'id' => 1,
		'nombre' => 'Ministro de Educacion',
		'rango' => 1
	));
}
?>