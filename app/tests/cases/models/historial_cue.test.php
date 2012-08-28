<?php 
/* SVN FILE: $Id$ */
/* HistorialCue Test cases generated on: 2009-09-23 10:15:16 : 1253711716*/
App::import('Model', 'HistorialCue');

class HistorialCueTestCase extends CakeTestCase {
	var $HistorialCue = null;
	var $fixtures = array('app.historial_cue', 'app.instit');

	function startTest() {
		$this->HistorialCue =& ClassRegistry::init('HistorialCue');
	}

	function testHistorialCueInstance() {
		$this->assertTrue(is_a($this->HistorialCue, 'HistorialCue'));
	}

	function testHistorialCueFind() {
		$this->HistorialCue->recursive = -1;
		$results = $this->HistorialCue->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('HistorialCue' => array(
			'id'  => 1,
			'instit_id'  => 1,
			'cue'  => 1,
			'anexo'  => 1,
			'created'  => '2009-09-23 10:15:16'
		));
		$this->assertEqual($results, $expected);
	}
}
?>