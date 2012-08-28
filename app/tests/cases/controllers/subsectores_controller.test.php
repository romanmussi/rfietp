<?php 
/* SVN FILE: $Id$ */
/* SubsectoresController Test cases generated on: 2009-10-21 11:10:05 : 1256131445*/
App::import('Controller', 'Subsectores');

class TestSubsectores extends SubsectoresController {
	var $autoRender = false;
}

class SubsectoresControllerTest extends CakeTestCase {
	var $Subsectores = null;

	function setUp() {
		$this->Subsectores = new TestSubsectores();
		$this->Subsectores->constructClasses();
	}

	function testSubsectoresControllerInstance() {
		$this->assertTrue(is_a($this->Subsectores, 'SubsectoresController'));
	}

	function tearDown() {
		unset($this->Subsectores);
	}
}
?>