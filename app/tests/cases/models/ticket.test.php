<?php 
/* SVN FILE: $Id$ */
/* Ticket Test cases generated on: 2009-09-23 12:09:15 : 1253719455*/

App::import('Model', 'Ticket');

class TestTicket extends Ticket {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class TicketTestCase extends CakeTestCase {
	var $Ticket = null;
	var $fixtures = array('app.ticket', 'app.instit', 'app.user', 'app.jurisdiccion');
	
	var $expected = array('Ticket' => array(
			'id'  => 1,
			'instit_id'  => 1,
			'user_id'  => 1,
			'observacion'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,
									phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,
									vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,
									feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
									Orci aliquet, in lorem et velit maecenas luctus, wisi nulla at, mauris nam ut a, lorem et et elit eu.
									Sed dui facilisi, adipiscing mollis lacus congue integer, faucibus consectetuer eros amet sit sit,
									magna dolor posuere. Placeat et, ac occaecat rutrum ante ut fusce. Sit velit sit porttitor non enim purus,
									id semper consectetuer justo enim, nulla etiam quis justo condimentum vel, malesuada ligula arcu. Nisl neque,
									ligula cras suscipit nunc eget, et tellus in varius urna odio est. Fuga urna dis metus euismod laoreet orci,
									litora luctus suspendisse sed id luctus ut. Pede volutpat quam vitae, ut ornare wisi. Velit dis tincidunt,
									pede vel eleifend nec curabitur dui pellentesque, volutpat taciti aliquet vivamus viverra, eget tellus ut
									feugiat lacinia mauris sed, lacinia et felis.',
			'estado'  => 0,
			'created'  => '2009-09-23 12:24:15',
			'modified'  => '2009-09-23 12:24:15'
			));
	
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
	
	function start() {
		parent::start();
		$this->Ticket = new TestTicket();
	}
	
	function testTicketInstance() {
		$this->assertTrue(is_a($this->Ticket, 'Ticket'));
	}
	
	function testTicketFind() {
		$this->Ticket->recursive = -1;
		$results = $this->Ticket->find('first');
		$this->assertTrue(!empty($results));
		
		$this->assertEqual($results, $this->expected);
	}
	
	function testDameTicketPendiente() {
		$results = $this->Ticket->dameTicketPendiente('1');
		
		$this->assertEqual($results, $this->expected);
	}
	
	function testDameProvinciasConPendientes() {
		$results = $this->Ticket->dameProvinciasConPendientes();
		
		$expected = array('2' => 'Nombre Provincia');	
		$this->assertEqual($results, $expected);
	}
}
?>