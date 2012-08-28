<?php 
/* SVN FILE: $Id$ */
/* Subsector Test cases generated on: 2009-10-21 11:10:27 : 1256131287*/
App::import('Model', 'Subsector');

class TestSubsector extends Subsector {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class SubsectorTestCase extends CakeTestCase {
	var $Subsector = null;
	var $fixtures = array('app.subsector');

	function start() {
		parent::start();
		$this->Subsector = new TestSubsector();
	}

	function testSubsectorInstance() {
		$this->assertTrue(is_a($this->Subsector, 'Subsector'));
	}

	function testSubsectorFind() {
		$this->Subsector->recursive = -1;
		$results = $this->Subsector->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Subsector' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'sector_id'  => 1
			));
		$this->assertEqual($results, $expected);
	}
}
?>