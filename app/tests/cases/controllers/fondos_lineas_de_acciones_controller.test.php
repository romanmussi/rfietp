<?php 
/* SVN FILE: $Id$ */
/* FondosLineasDeAccionesController Test cases generated on: 2010-04-22 10:40:01 : 1271943601*/
App::import('Controller', 'FondosLineasDeAcciones');

class TestFondosLineasDeAcciones extends FondosLineasDeAccionesController {
	var $autoRender = false;
}

class FondosLineasDeAccionesControllerTest extends CakeTestCase {
	var $FondosLineasDeAcciones = null;

	function startTest() {
		$this->FondosLineasDeAcciones = new TestFondosLineasDeAcciones();
		$this->FondosLineasDeAcciones->constructClasses();
	}

	function testFondosLineasDeAccionesControllerInstance() {
		$this->assertTrue(is_a($this->FondosLineasDeAcciones, 'FondosLineasDeAccionesController'));
	}

	function endTest() {
		unset($this->FondosLineasDeAcciones);
	}
}
?>