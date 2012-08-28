<?php 
/* SVN FILE: $Id$ */
/* PqueryCategoryesController Test cases generated on: 2011-03-30 11:55:13 : 1301496913*/
App::import('Controller', 'PqueryCategoryes');

class TestPqueryCategoryes extends PqueryCategoryesController {
	var $autoRender = false;
}

class PqueryCategoryesControllerTest extends CakeTestCase {
	var $PqueryCategoryes = null;

	function startTest() {
		$this->PqueryCategoryes = new TestPqueryCategoryes();
		$this->PqueryCategoryes->constructClasses();
	}

	function testPqueryCategoryesControllerInstance() {
		$this->assertTrue(is_a($this->PqueryCategoryes, 'PqueryCategoryesController'));
	}

	function endTest() {
		unset($this->PqueryCategoryes);
	}
}
?>