<?php 
/* SVN FILE: $Id$ */
/* TicketsController Test cases generated on: 2009-09-23 12:09:13 : 1253719573*/
App::import('Controller', 'Tickets');

class TestTickets extends TicketsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true){
		$this->redirectUrl = $url;
	}
	
	function render($action){
		$this->renderedAction = $action;
	}
	
	function _stop($status = 0){
		$this->stooped = $status;
	}
}

class TicketsControllerTest extends CakeTestCase {
	var $Tickets = null;
	//var $fixtures = array( 'app.ticket' ); 
	
	function startCase() { 
		echo '<h1>Starting Test Case</h1>'; 
	} 
	function endCase() { 
		echo '<br /><br /><h1>Ending Test Case</h1>'; 
	} 
	function startTest($method) { 
		echo '<h3>Starting method ' . $method . '</h3>'; 
	} 
	function endTest($method) { 
		echo '<hr />'; 
	} 
	
	/***************************************************/

	function setUp() {
		$this->Tickets = new TestTickets();
		$this->Tickets->constructClasses();
	}
	
	function testTicketsControllerInstance() {
		$this->assertTrue(is_a($this->Tickets, 'TicketsController'));
	}
	
	function testIndex() {
		$prov_pend = $this->Tickets->provincias_pendientes();
		
		foreach($prov_pend as $key=>$value)
		{
			$result = $this->testAction('/tickets/index/'.$key); 
			
			foreach($result as $res)
			{
				$this->assertTrue($key, $res['Instit']['jurisdiccion_id']);
			}
		}
	}
		
	function tearDown() {
		unset($this->Tickets);
	}
}
?>