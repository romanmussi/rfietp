<?php 
/* SVN FILE: $Id$ */
/* FondosLineasDeAccion Fixture generated on: 2010-04-22 10:39:45 : 1271943585*/

class FondosLineasDeAccionFixture extends CakeTestFixture {
	var $name = 'FondosLineasDeAccion';
	var $table = 'fondos_lineas_de_acciones';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'fondo_id' => array('type'=>'integer', 'null' => false),
		'lineas_de_accion_id' => array('type'=>'integer', 'null' => false),
		'monto' => array('type'=>'float', 'null' => false, 'default' => '0'),
		'created' => array('type'=>'datetime', 'null' => true),
		'modified' => array('type'=>'datetime', 'null' => true),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	var $records = array(array(
		'id' => 1,
		'fondo_id' => 1,
		'lineas_de_accion_id' => 1,
		'monto' => 1,
		'created' => '2010-04-22 10:39:45',
		'modified' => '2010-04-22 10:39:45'
	));
}
?>