<?php 
/* SVN FILE: $Id$ */
/* ClaseinstitsController Test cases generated on: 2009-10-29 10:11:24 : 1256821884*/
App::import('Controller', 'Claseinstits');

class TestClaseinstits extends ClaseinstitsController {
	var $autoRender = false;
}

class ClaseinstitsControllerTest extends CakeTestCase {
	var $Claseinstits = null;

	function startTest() {
		$this->Claseinstits = new TestClaseinstits();
		$this->Claseinstits->constructClasses();
	}

	function testClaseinstitsControllerInstance() {
		$this->assertTrue(is_a($this->Claseinstits, 'ClaseinstitsController'));
	}

	function endTest() {
		unset($this->Claseinstits);
	}
}
?>