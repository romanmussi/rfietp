<?php 
/* SVN FILE: $Id$ */
/* Claseinstit Test cases generated on: 2009-10-29 10:11:10 : 1256821870*/
App::import('Model', 'Claseinstit');

class ClaseinstitTestCase extends CakeTestCase {
	var $Claseinstit = null;
	var $fixtures = array('app.claseinstit', 'app.instit', 'app.jurisdiccion');

	function startTest() {
		$this->Claseinstit =& ClassRegistry::init('Claseinstit');
	}

	function testClaseinstitInstance() {
		$this->assertTrue(is_a($this->Claseinstit, 'Claseinstit'));
	}

	function testClaseinstitFind() {
		$this->Claseinstit->recursive = -1;
		$results = $this->Claseinstit->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Claseinstit' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>