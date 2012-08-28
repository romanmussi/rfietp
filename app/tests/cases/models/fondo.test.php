<?php 
/* SVN FILE: $Id$ */
/* Fondo Test cases generated on: 2010-04-22 10:25:00 : 1271942700*/
App::import('Model', 'Fondo');

class FondoTestCase extends CakeTestCase {
	var $Fondo = null;
	var $fixtures = array('app.fondo', 'app.instit', 'app.jurisdiccion');

	function startTest() {
		$this->Fondo =& ClassRegistry::init('Fondo');
	}

	function testFondoInstance() {
		$this->assertTrue(is_a($this->Fondo, 'Fondo'));
	}

	function testFondoFind() {
		$this->Fondo->recursive = -1;
		$results = $this->Fondo->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Fondo' => array(
			'id' => 1,
			'instit_id' => 1,
			'jurisdiccion_id' => 1,
			'total' => 1,
			'anio' => 1,
			'trimestre' => 1,
			'memo' => 'Lorem ipsum dolor ',
			'resolucion' => 'Lorem ipsum dolor ',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2010-04-22 10:25:00',
			'modified' => '2010-04-22 10:25:00'
		));
		$this->assertEqual($results, $expected);
	}
}
?>