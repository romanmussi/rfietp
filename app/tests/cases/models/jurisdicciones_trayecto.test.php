<?php 
/* SVN FILE: $Id$ */
/* JurisdiccionesTrayecto Test cases generated on: 2010-08-05 12:08:53 : 1281020753*/
App::import('Model', 'JurisdiccionesTrayecto');

class TestJurisdiccionesTrayecto extends JurisdiccionesTrayecto {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class JurisdiccionesTrayectoTestCase extends CakeTestCase {
	var $JurisdiccionesTrayecto = null;
	var $fixtures = array('app.jurisdicciones_trayecto', 'app.jurisdiccion', 'app.trayecto');

	function start() {
		parent::start();
		$this->JurisdiccionesTrayecto = new TestJurisdiccionesTrayecto();
	}

	function testJurisdiccionesTrayectoInstance() {
		$this->assertTrue(is_a($this->JurisdiccionesTrayecto, 'JurisdiccionesTrayecto'));
	}

	function testJurisdiccionesTrayectoFind() {
		$this->JurisdiccionesTrayecto->recursive = -1;
		$results = $this->JurisdiccionesTrayecto->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('JurisdiccionesTrayecto' => array(
			'id'  => 1,
			'jurisdiccion_id'  => 1,
			'trayecto_id'  => 1,
			'created'  => '2010-08-05 12:05:53',
			'modified'  => '2010-08-05 12:05:53'
			));
		$this->assertEqual($results, $expected);
	}
}
?>