<?php 
/* SVN FILE: $Id$ */
/* CuadrosController Test cases generated on: 2009-11-26 11:06:07 : 1259244367*/
App::import('Controller', 'Cuadros');

class TestCuadros extends CuadrosController {
	var $autoRender = false;
}

class CuadrosControllerTest extends CakeTestCase {
	var $Cuadros = null;

	function startTest() {
		$this->Cuadros = new TestCuadros();
		$this->Cuadros->constructClasses();
	}

	function testCuadrosControllerInstance() {
		$this->assertTrue(is_a($this->Cuadros, 'CuadrosController'));
	}

	function endTest() {
		unset($this->Cuadros);
	}
}
?>