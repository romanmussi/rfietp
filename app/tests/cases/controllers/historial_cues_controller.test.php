<?php

class HistorialCuesControllerTest extends CakeTestCase {
	
	/**************
	var $autoFixtures = false;

	function startCase() {
		echo '<h1>Starting Test Case</h1>';
	}

	function endCase() {
		echo '<h1>Ending Test Case</h1>';
	}

	function startTest($method) {
		echo '<h3>Starting method ' . $method . '</h3>';
	}

	function endTest($method) {
		echo '<hr />';
	}

	function testSearchForm() {
		$result = $this->testAction('/historialCues/search_form');
		//debug($result);
	}
	***************/
	function testSearch() {
	//	$data = array('HistorialCues' => array('cue' => '200'),
		//              );
		
        $result = $this->testAction('/historialCues/search',
                 array('method' => 'post','return' =>'vars',
                       'fixturize' => true )); 
		
		debug($result['instits']);
	}

	/*******************
	function testIndexShortGetRenderedHtml() {
		$result = $this->testAction('/articles/index/short',
		array('return' => 'render'));
		debug(htmlentities($result));
	}

	function testIndexShortGetViewVars() {
		$result = $this->testAction('/articles/index/short',
		array('return' => 'vars'));
		debug($result);
	}

	function testIndexFixturized() {
	}
		$result = $this->testAction('/historialCues/search',
		array('fixturize' => true));
		//debug($result);

	function testIndexPostFixturized() {
		$data = array('HistorialCue' => array('id'  => 1,
		                                      'instit_id'  => 1,
		                                      'cue'  => 1,
		                                      'anexo'  => 1,
		                                      'created'  => '2009-09-23 10:15:16'
	                 ));
		//$result = $this->testAction('/historialCues/search',
		//array('fixturize' => true, 'data' => $data, 'method' => 'post'));
		//debug($result);
	}
**/
} 