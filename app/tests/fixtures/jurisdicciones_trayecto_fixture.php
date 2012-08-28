<?php 
/* SVN FILE: $Id$ */
/* JurisdiccionesTrayecto Fixture generated on: 2010-08-05 12:08:53 : 1281020753*/

class JurisdiccionesTrayectoFixture extends CakeTestFixture {
	var $name = 'JurisdiccionesTrayecto';
	var $table = 'jurisdicciones_trayectos';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
			'jurisdiccion_id' => array('type'=>'integer', 'null' => true, 'default' => '0'),
			'trayecto_id' => array('type'=>'integer', 'null' => true, 'default' => '0'),
			'created' => array('type'=>'datetime', 'null' => true),
			'modified' => array('type'=>'datetime', 'null' => true),
			'indexes' => array('0' => array())
			);
	var $records = array(array(
			'id'  => 1,
			'jurisdiccion_id'  => 1,
			'trayecto_id'  => 1,
			'created'  => '2010-08-05 12:05:53',
			'modified'  => '2010-08-05 12:05:53'
			));
}
?>