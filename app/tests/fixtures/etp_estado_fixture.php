<?php 
/* SVN FILE: $Id$ */
/* EtpEstado Fixture generated on: 2009-10-29 10:10:26 : 1256821826*/

class EtpEstadoFixture extends CakeTestFixture {
	var $name = 'EtpEstado';
	var $table = 'etp_estados';
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