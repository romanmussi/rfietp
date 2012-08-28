<?php 
/* SVN FILE: $Id$ */
/* AutoridadesController Test cases generated on: 2011-03-03 12:42:43 : 1299166963*/
App::import('Controller', 'Autoridades');

class TestAutoridades extends AutoridadesController {
	var $autoRender = false;
}

class AutoridadesControllerTest extends CakeTestCase {
	var $Autoridades = null;

	function startTest() {
		$this->Autoridades = new TestAutoridades();
		$this->Autoridades->constructClasses();
	}

	function testAutoridadesControllerInstance() {
		$this->assertTrue(is_a($this->Autoridades, 'AutoridadesController'));
	}

	function endTest() {
		unset($this->Autoridades);
	}
}
?>