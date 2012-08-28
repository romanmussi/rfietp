<?php 
/* SVN FILE: $Id$ */
/* Sugerencia Test cases generated on: 2007-04-13 12:05:38 : 1176476738*/
App::import('Model', 'Sugerencia');

class SugerenciaTestCase extends CakeTestCase {
	var $Sugerencia = null;
	var $fixtures = array('app.sugerencia');

	function startTest() {
		$this->Sugerencia =& ClassRegistry::init('Sugerencia');
	}

	function testSugerenciaInstance() {
		$this->assertTrue(is_a($this->Sugerencia, 'Sugerencia'));
	}

	function testSugerenciaFind() {
		$this->Sugerencia->recursive = -1;
		$results = $this->Sugerencia->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Sugerencia' => array(
			'id' => 1,
			'asunto' => 'Lorem ipsum dolor sit amet',
			'mensaje' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'remitente' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'IP' => 'Lorem ipsum d',
			'created' => '2007-04-13 12:05:38',
			'leido' => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>