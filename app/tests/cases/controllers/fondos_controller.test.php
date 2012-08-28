<?php 
/* SVN FILE: $Id$ */
/* FondosController Test cases generated on: 2010-04-22 10:28:40 : 1271942920*/
App::import('Controller', 'Fondos');

class TestFondos extends FondosController {
	var $autoRender = false;
}

class FondosControllerTest extends CakeTestCase {
	var $Fondos = null;

	function startTest() {
		$this->Fondos = new TestFondos();
		$this->Fondos->constructClasses();
	}

	function testFondosControllerInstance() {
		$this->assertTrue(is_a($this->Fondos, 'FondosController'));
	}

	function endTest() {
		unset($this->Fondos);
	}
}
?>