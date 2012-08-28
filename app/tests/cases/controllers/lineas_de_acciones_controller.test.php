<?php 
/* SVN FILE: $Id$ */
/* LineasDeAccionesController Test cases generated on: 2010-04-22 10:38:32 : 1271943512*/
App::import('Controller', 'LineasDeAcciones');

class TestLineasDeAcciones extends LineasDeAccionesController {
	var $autoRender = false;
}

class LineasDeAccionesControllerTest extends CakeTestCase {
	var $LineasDeAcciones = null;

	function startTest() {
		$this->LineasDeAcciones = new TestLineasDeAcciones();
		$this->LineasDeAcciones->constructClasses();
	}

	function testLineasDeAccionesControllerInstance() {
		$this->assertTrue(is_a($this->LineasDeAcciones, 'LineasDeAccionesController'));
	}

	function endTest() {
		unset($this->LineasDeAcciones);
	}
}
?>