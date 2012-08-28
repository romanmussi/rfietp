<?php 
/* SVN FILE: $Id$ */
/* SugerenciasController Test cases generated on: 2007-04-13 12:56:15 : 1176479775*/
App::import('Controller', 'Sugerencias');

class TestSugerencias extends SugerenciasController {
	var $autoRender = false;
}

class SugerenciasControllerTest extends CakeTestCase {
	var $Sugerencias = null;

	function startTest() {
		$this->Sugerencias = new TestSugerencias();
		$this->Sugerencias->constructClasses();
	}

	function testSugerenciasControllerInstance() {
		$this->assertTrue(is_a($this->Sugerencias, 'SugerenciasController'));
	}

	function endTest() {
		unset($this->Sugerencias);
	}
}
?>