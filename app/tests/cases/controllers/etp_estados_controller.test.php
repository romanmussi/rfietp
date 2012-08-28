<?php 
/* SVN FILE: $Id$ */
/* EtpEstadosController Test cases generated on: 2009-10-29 10:10:47 : 1256821847*/
App::import('Controller', 'EtpEstados');

class TestEtpEstados extends EtpEstadosController {
	var $autoRender = false;
}

class EtpEstadosControllerTest extends CakeTestCase {
	var $EtpEstados = null;

	function startTest() {
		$this->EtpEstados = new TestEtpEstados();
		$this->EtpEstados->constructClasses();
	}

	function testEtpEstadosControllerInstance() {
		$this->assertTrue(is_a($this->EtpEstados, 'EtpEstadosController'));
	}

	function endTest() {
		unset($this->EtpEstados);
	}
}
?>