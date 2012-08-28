<?php 
/* SVN FILE: $Id$ */
/* LineasDeAccion Test cases generated on: 2010-04-22 10:30:30 : 1271943030*/
App::import('Model', 'LineasDeAccion');

class LineasDeAccionTestCase extends CakeTestCase {
	var $LineasDeAccion = null;
	var $fixtures = array('app.lineas_de_accion');

	function startTest() {
		$this->LineasDeAccion =& ClassRegistry::init('LineasDeAccion');
	}

	function testLineasDeAccionInstance() {
		$this->assertTrue(is_a($this->LineasDeAccion, 'LineasDeAccion'));
	}

	function testLineasDeAccionFind() {
		$this->LineasDeAccion->recursive = -1;
		$results = $this->LineasDeAccion->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('LineasDeAccion' => array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor ',
			'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2010-04-22 10:30:30',
			'modified' => '2010-04-22 10:30:30'
		));
		$this->assertEqual($results, $expected);
	}
}
?>