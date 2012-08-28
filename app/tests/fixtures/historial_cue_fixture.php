<?php 
/* SVN FILE: $Id$ */
/* HistorialCue Fixture generated on: 2009-09-23 10:15:16 : 1253711716*/

class HistorialCueFixture extends CakeTestFixture {
	var $name = 'HistorialCue';
	var $table = 'historial_cues';
	//var $import = 'HistorialCue'; 
	
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'instit_id' => array('type'=>'integer', 'null' => false),
		'cue' => array('type'=>'integer', 'null' => true, 'default' => '0'),
		'anexo' => array('type'=>'integer', 'null' => true, 'default' => '0'),
		'created' => array('type'=>'datetime', 'null' => true),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	var $records = array(array(
		'id'  => 1,
		'instit_id'  => 1,
		'cue'  => 200000,
		'anexo'  => 0,
		'created'  => '2009-09-23 10:15:16'
	));
}
?>