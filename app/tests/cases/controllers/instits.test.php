<?php 

require_once dirname(__FILE__) . DS . '..' . DS . 'extra_functions.php';

class InstitsControllerTest extends CakeTestCase {

    var $fixtures = array();

    function __construct(){
        $this->fixtures = getAllFixtures();
    }
    
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
    
    function testIndex() {
        $result = $this->testAction('/instits/view/1', array('fixturize' => true,));
        debug($result);
    }
} 
?>