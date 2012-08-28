<?php 
/* SVN FILE: $Id$ */
/* PqueryCategory Fixture generated on: 2011-03-30 11:47:20 : 1301496440*/

class PqueryCategoryFixture extends CakeTestFixture {
	var $name = 'PqueryCategory';
	var $table = 'pquery_categories';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'length' => 64),
		'created' => array('type'=>'datetime', 'null' => true),
		'modified' => array('type'=>'datetime', 'null' => true),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	var $records = array(array(
		'id' => 1,
		'name' => 'Lorem ipsum dolor sit amet',
		'created' => '2011-03-30 11:47:20',
		'modified' => '2011-03-30 11:47:20'
	));
}
?>