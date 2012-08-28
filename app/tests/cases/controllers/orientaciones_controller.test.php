<?php 
/* SVN FILE: $Id$ */
/* OrientacionesController Test cases generated on: 2010-03-16 09:03:23 : 1268743583*/
App::import('Controller', 'Orientaciones');

class TestOrientaciones extends OrientacionesController {
	var $autoRender = false;
}

class OrientacionesControllerTest extends CakeTestCase {
	var $Orientaciones = null;

	function setUp() {
		$this->Orientaciones = new TestOrientaciones();
		$this->Orientaciones->constructClasses();
	}

	function testOrientacionesControllerInstance() {
		$this->assertTrue(is_a($this->Orientaciones, 'OrientacionesController'));
	}

	function tearDown() {
		unset($this->Orientaciones);
	}
}
?>