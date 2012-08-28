<?php 
/* SVN FILE: $Id$ */
/* UserLogin Fixture generated on: 2010-03-03 10:20:07 : 1267622407*/

class UserLoginFixture extends CakeTestFixture {
	var $name = 'UserLogin';
	var $table = 'user_logins';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'null' => false),
		'created' => array('type'=>'datetime', 'null' => true),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	var $records = array(array(
		'id'  => 1,
		'user_id'  => 1,
		'created'  => '2010-03-03 10:20:07'
	));
}
?>