<?php 
/* SVN FILE: $Id$ */
/* ZFondoWorksController Test cases generated on: 2010-04-22 13:27:46 : 1271953666*/
App::import('Controller', 'ZFondoWorks');

class TestZFondoWorks extends ZFondoWorksController {
	var $autoRender = false;
}

class ZFondoWorksControllerTest extends CakeTestCase {
	var $ZFondoWorks = null;

	function startTest() {
		$this->ZFondoWorks = new TestZFondoWorks();
		$this->ZFondoWorks->constructClasses();
	}

	function testZFondoWorksControllerInstance() {
		$this->assertTrue(is_a($this->ZFondoWorks, 'ZFondoWorksController'));
	}

	function endTest() {
		unset($this->ZFondoWorks);
	}
}
?>