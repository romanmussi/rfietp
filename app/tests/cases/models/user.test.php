<?php 

require_once dirname(__FILE__) . DS . '..' . DS . 'extra_functions.php';


class UserTestCase extends CakeTestCase {
	var $User = null;
	var $fixtures = array();

        function __construct(){
            //parent::__construct();
            $this->fixtures = getAllFixtures();
        }


	function startTest() {
            $this->User =& ClassRegistry::init('User');
            //$this->User->useDbConfig = 'test';
	}

	function testUserInstance() {
		$this->assertTrue(is_a($this->User, 'User'));
	}

	function testUserFind() {
		$this->User->recursive = -1;
		$results = $this->User->find('count');
                debug($this->User->useDbConfig);
                debug($results);

		//$this->assertEqual($results, $expected);
	}
}



?>