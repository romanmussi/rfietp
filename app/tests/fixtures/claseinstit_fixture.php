<?php 
/* SVN FILE: $Id$ */
/* Claseinstit Fixture generated on: 2009-10-29 10:11:10 : 1256821870*/

class ClaseinstitFixture extends CakeTestFixture {
	var $name = 'Claseinstit';
	var $table = 'claseinstits';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'length' => 40),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet'
	));
}
?>