<?php 
/* SVN FILE: $Id$ */
/* UserLogin Test cases generated on: 2010-03-03 10:20:07 : 1267622407*/
App::import('Model', 'UserLogin');

class UserLoginTestCase extends CakeTestCase {
	var $UserLogin = null;
	var $fixtures = array('app.user_login', 'app.user');

	function startTest() {
		$this->UserLogin =& ClassRegistry::init('UserLogin');
	}

	function testUserLoginInstance() {
		$this->assertTrue(is_a($this->UserLogin, 'UserLogin'));
	}

	function testUserLoginFind() {
		$this->UserLogin->recursive = -1;
		$results = $this->UserLogin->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('UserLogin' => array(
			'id'  => 1,
			'user_id'  => 1,
			'created'  => '2010-03-03 10:20:07'
		));
		$this->assertEqual($results, $expected);
	}
}
?>