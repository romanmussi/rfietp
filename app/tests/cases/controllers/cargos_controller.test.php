<?php 
/* SVN FILE: $Id$ */
/* CargosController Test cases generated on: 2011-03-03 12:42:52 : 1299166972*/
App::import('Controller', 'Cargos');

class TestCargos extends CargosController {
	var $autoRender = false;
}

class CargosControllerTest extends CakeTestCase {
	var $Cargos = null;

	function startTest() {
		$this->Cargos = new TestCargos();
		$this->Cargos->constructClasses();
	}

	function testCargosControllerInstance() {
		$this->assertTrue(is_a($this->Cargos, 'CargosController'));
	}

	function endTest() {
		unset($this->Cargos);
	}
}
?>