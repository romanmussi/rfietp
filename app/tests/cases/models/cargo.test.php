<?php 
/* SVN FILE: $Id$ */
/* Cargo Test cases generated on: 2011-03-03 12:42:09 : 1299166929*/
App::import('Model', 'Cargo');

class CargoTestCase extends CakeTestCase {
	var $Cargo = null;
	var $fixtures = array('app.cargo');

	function startTest() {
		$this->Cargo =& ClassRegistry::init('Cargo');
	}

	function testCargoInstance() {
		$this->assertTrue(is_a($this->Cargo, 'Cargo'));
	}

	function testCargoFind() {
		$this->Cargo->recursive = -1;
		$results = $this->Cargo->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Cargo' => array(
			'id' => 1,
			'nombre' => 'Lorem ipsum dolor sit amet',
			'rango' => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>