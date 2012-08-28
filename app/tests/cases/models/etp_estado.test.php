<?php 
/* SVN FILE: $Id$ */
/* EtpEstado Test cases generated on: 2009-10-29 10:10:26 : 1256821826*/
App::import('Model', 'EtpEstado');

class EtpEstadoTestCase extends CakeTestCase {
	var $EtpEstado = null;
	var $fixtures = array('app.etp_estado', 'app.instit');

	function startTest() {
		$this->EtpEstado =& ClassRegistry::init('EtpEstado');
	}

	function testEtpEstadoInstance() {
		$this->assertTrue(is_a($this->EtpEstado, 'EtpEstado'));
	}

	function testEtpEstadoFind() {
		$this->EtpEstado->recursive = -1;
		$results = $this->EtpEstado->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('EtpEstado' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>