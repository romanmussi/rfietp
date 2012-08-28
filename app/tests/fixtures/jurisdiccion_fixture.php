<?php 
/* SVN FILE: $Id$ */
/* jurisdiccion Fixture generated on: 2009-09-23 10:15:16 : 1253711716*/

class jurisdiccionFixture extends CakeTestFixture {
	var $name = 'jurisdiccion';
	var $table = 'jurisdicciones';
	
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => '')
	);
	
	var $records = array(array(
		'id'  => 2,
		'name'  => 'Nombre Provincia'
	));
}
?>