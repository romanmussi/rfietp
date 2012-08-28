<?php 
/* SVN FILE: $Id$ */
/* TitulosController Test cases generated on: 2010-03-16 11:03:27 : 1268749467*/
App::import('Controller', 'Titulos');

class TestTitulos extends TitulosController {
	var $autoRender = false;
}

class TitulosControllerTest extends CakeTestCase {
	var $Titulos = null;

	function setUp() {
		$this->Titulos = new TestTitulos();
		$this->Titulos->constructClasses();
	}

	function testTitulosControllerInstance() {
		$this->assertTrue(is_a($this->Titulos, 'TitulosController'));
	}

	function tearDown() {
		unset($this->Titulos);
	}
}
?>