<?php 
/* SVN FILE: $Id$ */
/* PqueryCategory Test cases generated on: 2011-03-30 11:47:20 : 1301496440*/
App::import('Model', 'PqueryCategory');

class PqueryCategoryTestCase extends CakeTestCase {
	var $PqueryCategory = null;
	var $fixtures = array('app.pquery_category', 'app.query', 'app.query');

	function startTest() {
		$this->PqueryCategory =& ClassRegistry::init('PqueryCategory');
	}

	function testPqueryCategoryInstance() {
		$this->assertTrue(is_a($this->PqueryCategory, 'PqueryCategory'));
	}

	function testPqueryCategoryFind() {
		$this->PqueryCategory->recursive = -1;
		$results = $this->PqueryCategory->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('PqueryCategory' => array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-03-30 11:47:20',
			'modified' => '2011-03-30 11:47:20'
		));
		$this->assertEqual($results, $expected);
	}
}
?>