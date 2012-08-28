<?php 
/* SVN FILE: $Id$ */
/* Autoridad Test cases generated on: 2011-03-03 12:41:45 : 1299166905*/
App::import('Model', 'Autoridad');

class AutoridadTestCase extends CakeTestCase {
	var $Autoridad = null;
	var $fixtures = array('app.autoridad', 'app.jurisdiccion', 'app.localidad', 'app.departamento');

	function startTest() {
		$this->Autoridad =& ClassRegistry::init('Autoridad');
	}

	function testAutoridadInstance() {
		$this->assertTrue(is_a($this->Autoridad, 'Autoridad'));
	}

	function testAutoridadFind() {
		$this->Autoridad->recursive = -1;
		$results = $this->Autoridad->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Autoridad' => array(
			'id' => 1,
			'jurisdiccion_id' => 1,
			'nombre' => 'Lorem ipsum dolor sit amet',
			'apellido' => 'Lorem ipsum dolor sit amet',
			'fecha_asuncion' => '2011-03-03',
			'titulo' => 'Lorem ipsum dolor sit amet',
			'telefono_personal' => 'Lorem ipsum dolor sit amet',
			'telefono_institucional' => 'Lorem ipsum dolor sit amet',
			'email_personal' => 'Lorem ipsum dolor sit amet',
			'email_institucional' => 'Lorem ipsum dolor sit amet',
			'direccion' => 'Lorem ipsum dolor sit amet',
			'localidad_id' => 1,
			'departamento_id' => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>