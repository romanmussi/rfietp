<?php 
App::import('Controller', 'Instits');
App::import('Model', 'Instit');

class TestInstits extends InstitsController {
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


class InstitsControllerTest extends CakeTestCase { 
    var $Instit = null;
    var $fixtures = array('app.ticket', 'app.instit', 'app.user', 'app.jurisdiccion');
     
	/***************************************************/

	function startTest(){
		$this->Instit = new TestInstits();
		
		$this->Instit->Instit->cacheSources = false;
		$this->Instit->Instit->useDbConfig 	= 'test_suite';
		
		$this->Instit->constructClasses();
		$this->Instit->Component->initialize($this->Instit);
	}
   
    function testIndex() { 
   		//$this->Instit->params['url'] = '';
     	$result = $this->testAction('/instits/search');

  		//debug($result);
    } 
} 
?>