<?php
/* SVN FILE: $Id$ */
/**
 * DboSourceTest file
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <https://trac.cakephp.org/wiki/Developement/TestSuite>
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 *	Licensed under The Open Group Test Suite License
 *	Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          https://trac.cakephp.org/wiki/Developement/TestSuite CakePHP(tm) Tests
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 * @since         CakePHP(tm) v 1.2.0.4206
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
if (!defined('CAKEPHP_UNIT_TEST_EXECUTION')) {
	define('CAKEPHP_UNIT_TEST_EXECUTION', 1);
}
App::import('Core', array('Model', 'DataSource', 'DboSource', 'DboMysql'));
App::import('Model', 'App');
require_once dirname(dirname(__FILE__)) . DS . 'models.php';
/**
 * TestModel class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class TestModel extends CakeTestModel {
/**
 * name property
 *
 * @var string 'TestModel'
 * @access public
 */
	var $name = 'TestModel';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * schema property
 *
 * @var array
 * @access protected
 */
	var $_schema = array(
		'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
		'client_id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '11'),
		'name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'login' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'passwd' => array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '255'),
		'addr_1' => array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '255'),
		'addr_2' => array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '25'),
		'zip_code' => array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
		'city' => array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
		'country' => array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
		'phone' => array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
		'fax' => array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
		'url' => array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '255'),
		'email' => array('type' => 'string', 'null' => '1', 'default' => '', 'length' => '155'),
		'comments' => array('type' => 'text', 'null' => '1', 'default' => '', 'length' => '155'),
		'last_login' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => ''),
		'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
		'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
	);
/**
 * find method
 *
 * @param mixed $conditions
 * @param mixed $fields
 * @param mixed $order
 * @param mixed $recursive
 * @access public
 * @return void
 */
	function find($conditions = null, $fields = null, $order = null, $recursive = null) {
		return array($conditions, $fields);
	}
/**
 * findAll method
 *
 * @param mixed $conditions
 * @param mixed $fields
 * @param mixed $order
 * @param mixed $recursive
 * @access public
 * @return void
 */
	function findAll($conditions = null, $fields = null, $order = null, $recursive = null) {
		return $conditions;
	}
}
/**
 * TestModel2 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class TestModel2 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'TestModel2'
 * @access public
 */
	var $name = 'TestModel2';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
}
/**
 * TestModel4 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class TestModel3 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'TestModel3'
 * @access public
 */
	var $name = 'TestModel3';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
}
/**
 * TestModel4 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class TestModel4 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'TestModel4'
 * @access public
 */
	var $name = 'TestModel4';
/**
 * table property
 *
 * @var string 'test_model4'
 * @access public
 */
	var $table = 'test_model4';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array(
		'TestModel4Parent' => array(
			'className' => 'TestModel4',
			'foreignKey' => 'parent_id'
		)
	);
/**
 * hasOne property
 *
 * @var array
 * @access public
 */
	var $hasOne = array(
		'TestModel5' => array(
			'className' => 'TestModel5',
			'foreignKey' => 'test_model4_id'
		)
	);
/**
 * hasAndBelongsToMany property
 *
 * @var array
 * @access public
 */
	var $hasAndBelongsToMany = array('TestModel7' => array(
		'className' => 'TestModel7',
		'joinTable' => 'test_model4_test_model7',
		'foreignKey' => 'test_model4_id',
		'associationForeignKey' => 'test_model7_id',
		'with' => 'TestModel4TestModel7'
	));
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
				'name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
				'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
				'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
			);
		}
		return $this->_schema;
	}
}
/**
 * TestModel4TestModel7 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class TestModel4TestModel7 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'TestModel4TestModel7'
 * @access public
 */
	var $name = 'TestModel4TestModel7';
/**
 * table property
 *
 * @var string 'test_model4_test_model7'
 * @access public
 */
	var $table = 'test_model4_test_model7';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'test_model4_id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
				'test_model7_id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8')
			);
		}
		return $this->_schema;
	}
}
/**
 * TestModel5 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class TestModel5 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'TestModel5'
 * @access public
 */
	var $name = 'TestModel5';
/**
 * table property
 *
 * @var string 'test_model5'
 * @access public
 */
	var $table = 'test_model5';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array('TestModel4' => array(
		'className' => 'TestModel4',
		'foreignKey' => 'test_model4_id'
	));
/**
 * hasMany property
 *
 * @var array
 * @access public
 */
	var $hasMany = array('TestModel6' => array(
		'className' => 'TestModel6',
		'foreignKey' => 'test_model5_id'
	));
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
				'test_model4_id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
				'name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
				'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
				'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
			);
		}
		return $this->_schema;
	}
}
/**
 * TestModel6 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class TestModel6 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'TestModel6'
 * @access public
 */
	var $name = 'TestModel6';
/**
 * table property
 *
 * @var string 'test_model6'
 * @access public
 */
	var $table = 'test_model6';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array('TestModel5' => array(
		'className' => 'TestModel5',
		'foreignKey' => 'test_model5_id'
	));
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
				'test_model5_id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
				'name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
				'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
				'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
			);
		}
		return $this->_schema;
	}
}
/**
 * TestModel7 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class TestModel7 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'TestModel7'
 * @access public
 */
	var $name = 'TestModel7';
/**
 * table property
 *
 * @var string 'test_model7'
 * @access public
 */
	var $table = 'test_model7';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
				'name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
				'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
				'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
			);
		}
		return $this->_schema;
	}
}
/**
 * TestModel8 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class TestModel8 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'TestModel8'
 * @access public
 */
	var $name = 'TestModel8';
/**
 * table property
 *
 * @var string 'test_model8'
 * @access public
 */
	var $table = 'test_model8';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * hasOne property
 *
 * @var array
 * @access public
 */
	var $hasOne = array(
		'TestModel9' => array(
			'className' => 'TestModel9',
			'foreignKey' => 'test_model8_id',
			'conditions' => 'TestModel9.name != \'mariano\''
		)
	);
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
				'test_model9_id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
				'name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
				'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
				'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
			);
		}
		return $this->_schema;
	}
}
/**
 * TestModel9 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class TestModel9 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'TestModel9'
 * @access public
 */
	var $name = 'TestModel9';
/**
 * table property
 *
 * @var string 'test_model9'
 * @access public
 */
	var $table = 'test_model9';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array('TestModel8' => array(
		'className' => 'TestModel8',
		'foreignKey' => 'test_model8_id',
		'conditions' => 'TestModel8.name != \'larry\''
	));
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
				'test_model8_id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '11'),
				'name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
				'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
				'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
			);
		}
		return $this->_schema;
	}
}
/**
 * Level class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class Level extends CakeTestModel {
/**
 * name property
 *
 * @var string 'Level'
 * @access public
 */
	var $name = 'Level';
/**
 * table property
 *
 * @var string 'level'
 * @access public
 */
	var $table = 'level';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * hasMany property
 *
 * @var array
 * @access public
 */
	var $hasMany = array(
		'Group'=> array(
			'className' => 'Group'
		),
		'User2' => array(
			'className' => 'User2'
		)
	);
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => '10'),
				'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => '20'),
			);
		}
		return $this->_schema;
	}
}
/**
 * Group class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class Group extends CakeTestModel {
/**
 * name property
 *
 * @var string 'Group'
 * @access public
 */
	var $name = 'Group';
/**
 * table property
 *
 * @var string 'group'
 * @access public
 */
	var $table = 'group';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array('Level');
/**
 * hasMany property
 *
 * @var array
 * @access public
 */
	var $hasMany = array('Category2', 'User2');
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => '10'),
				'level_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => '10'),
				'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => '20'),
			);
		}
		return $this->_schema;
	}

}
/**
 * User2 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class User2 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'User2'
 * @access public
 */
	var $name = 'User2';
/**
 * table property
 *
 * @var string 'user'
 * @access public
 */
	var $table = 'user';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array(
		'Group' => array(
			'className' => 'Group'
		),
		'Level' => array(
			'className' => 'Level'
		)
	);
/**
 * hasMany property
 *
 * @var array
 * @access public
 */
	var $hasMany = array(
		'Article2' => array(
			'className' => 'Article2'
		),
	);
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => '10'),
				'group_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => '10'),
				'level_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => '10'),
				'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => '20'),
			);
		}
		return $this->_schema;
	}
}
/**
 * Category2 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class Category2 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'Category2'
 * @access public
 */
	var $name = 'Category2';
/**
 * table property
 *
 * @var string 'category'
 * @access public
 */
	var $table = 'category';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id'
		),
		'ParentCat' => array(
			'className' => 'Category2',
			'foreignKey' => 'parent_id'
		)
	);
/**
 * hasMany property
 *
 * @var array
 * @access public
 */
	var $hasMany = array(
		'ChildCat' => array(
			'className' => 'Category2',
			'foreignKey' => 'parent_id'
		),
		'Article2' => array(
			'className' => 'Article2',
			'order'=>'Article2.published_date DESC',
			'foreignKey' => 'category_id',
			'limit'=>'3')
	);
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => '', 'length' => '10'),
				'group_id' => array('type' => 'integer', 'null' => false, 'default' => '', 'length' => '10'),
				'parent_id' => array('type' => 'integer', 'null' => false, 'default' => '', 'length' => '10'),
				'name' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => '255'),
				'icon' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => '255'),
				'description' => array('type' => 'text', 'null' => false, 'default' => '', 'length' => null),

			);
		}
		return $this->_schema;
	}
}
/**
 * Article2 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class Article2 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'Article2'
 * @access public
 */
	var $name = 'Article2';
/**
 * table property
 *
 * @var string 'article'
 * @access public
 */
	var $table = 'article';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array(
		'Category2' => array('className' => 'Category2'),
		'User2' => array('className' => 'User2')
	);
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => '', 'length' => '10'),
				'category_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => '10'),
				'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => '10'),
				'rate_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => '10'),
				'rate_sum' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => '10'),
				'viewed' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => '10'),
				'version' => array('type' => 'string', 'null' => true, 'default' => '', 'length' => '45'),
				'title' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => '200'),
				'intro' => array('text' => 'string', 'null' => true, 'default' => '', 'length' => null),
				'comments' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => '4'),
				'body' => array('text' => 'string', 'null' => true, 'default' => '', 'length' => null),
				'isdraft' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'length' => '1'),
				'allow_comments' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'length' => '1'),
				'moderate_comments' => array('type' => 'boolean', 'null' => false, 'default' => '1', 'length' => '1'),
				'published' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'length' => '1'),
				'multipage' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'length' => '1'),
				'published_date' => array('type' => 'datetime', 'null' => true, 'default' => '', 'length' => null),
				'created' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00', 'length' => null),
				'modified' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00', 'length' => null)
			);
		}
		return $this->_schema;
	}
}
/**
 * CategoryFeatured2 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class CategoryFeatured2 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'CategoryFeatured2'
 * @access public
 */
	var $name = 'CategoryFeatured2';
/**
 * table property
 *
 * @var string 'category_featured'
 * @access public
 */
	var $table = 'category_featured';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => '', 'length' => '10'),
				'parent_id' => array('type' => 'integer', 'null' => false, 'default' => '', 'length' => '10'),
				'name' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => '255'),
				'icon' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => '255'),
				'description' => array('text' => 'string', 'null' => false, 'default' => '', 'length' => null)
			);
		}
		return $this->_schema;
	}
}
/**
 * Featured2 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class Featured2 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'Featured2'
 * @access public
 */
	var $name = 'Featured2';
/**
 * table property
 *
 * @var string 'featured2'
 * @access public
 */
	var $table = 'featured2';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array(
		'CategoryFeatured2' => array(
			'className' => 'CategoryFeatured2'
		)
	);
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => '10'),
				'article_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => '10'),
				'category_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => '10'),
				'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => '20')
			);
		}
		return $this->_schema;
	}
}
/**
 * Comment2 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class Comment2 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'Comment2'
 * @access public
 */
	var $name = 'Comment2';
/**
 * table property
 *
 * @var string 'comment'
 * @access public
 */
	var $table = 'comment';
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array('ArticleFeatured2', 'User2');
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => '10'),
				'article_featured_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => '10'),
				'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => '10'),
				'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => '20')
			);
		}
		return $this->_schema;
	}
}
/**
 * ArticleFeatured2 class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class ArticleFeatured2 extends CakeTestModel {
/**
 * name property
 *
 * @var string 'ArticleFeatured2'
 * @access public
 */
	var $name = 'ArticleFeatured2';
/**
 * table property
 *
 * @var string 'article_featured'
 * @access public
 */
	var $table = 'article_featured';
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array(
		'CategoryFeatured2' => array('className' => 'CategoryFeatured2'),
		'User2' => array('className' => 'User2')
	);
/**
 * hasOne property
 *
 * @var array
 * @access public
 */
	var $hasOne = array(
		'Featured2' => array('className' => 'Featured2')
	);
/**
 * hasMany property
 *
 * @var array
 * @access public
 */
	var $hasMany = array(
		'Comment2' => array('className'=>'Comment2', 'dependent' => true)
	);
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		if (!isset($this->_schema)) {
			$this->_schema = array(
				'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => '10'),
				'category_featured_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => '10'),
				'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => '10'),
				'title' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => '20'),
				'body' => array('text' => 'string', 'null' => true, 'default' => '', 'length' => null),
				'published' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'length' => '1'),
				'published_date' => array('type' => 'datetime', 'null' => true, 'default' => '', 'length' => null),
				'created' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00', 'length' => null),
				'modified' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00', 'length' => null)
			);
		}
		return $this->_schema;
	}
}
/**
 * DboSourceTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.datasources
 */
class DboSourceTest extends CakeTestCase {
/**
 * debug property
 *
 * @var mixed null
 * @access public
 */
	var $debug = null;
/**
 * autoFixtures property
 *
 * @var bool false
 * @access public
 */
	var $autoFixtures = false;
/**
 * fixtures property
 *
 * @var array
 * @access public
 */
	var $fixtures = array(
		'core.apple', 'core.article', 'core.articles_tag', 'core.attachment', 'core.comment',
		'core.sample', 'core.tag', 'core.user', 'core.post', 'core.author'
	);
/**
 * startTest method
 *
 * @access public
 * @return void
 */
	function startTest() {
		$this->__config = $this->db->config;

		if (!class_exists('DboTest')) {
			$db = ConnectionManager::getDataSource('test_suite');
			$class = get_class($db);
			eval("class DboTest extends $class {
				var \$simulated = array();
/**
 * execute method
 *
 * @param \$sql
 * @access protected
 * @return void
 */
				function _execute(\$sql) {
					\$this->simulated[] = \$sql;
					return null;
				}
/**
 * getLastQuery method
 *
 * @access public
 * @return void
 */
				function getLastQuery() {
					return \$this->simulated[count(\$this->simulated) - 1];
				}
			}");
		}

		$this->testDb =& new DboTest($this->__config);
		$this->testDb->cacheSources = false;
		$this->testDb->startQuote = '`';
		$this->testDb->endQuote = '`';
		Configure::write('debug', 1);
		$this->debug = Configure::read('debug');
		$this->Model =& new TestModel();
	}
/**
 * endTest method
 *
 * @access public
 * @return void
 */
	function endTest() {
		unset($this->Model);
		Configure::write('debug', $this->debug);
		ClassRegistry::flush();
		unset($this->debug);
	}
/**
 * testFieldDoubleEscaping method
 *
 * @access public
 * @return void
 */
	function testFieldDoubleEscaping() {
		$config = array_merge($this->__config, array('driver' => 'test'));
		$test =& ConnectionManager::create('quoteTest', $config);
		$test->simulated = array();

		$this->Model =& new Article2(array('alias' => 'Article', 'ds' => 'quoteTest'));
		$this->Model->setDataSource('quoteTest');

		$this->assertEqual($this->Model->escapeField(), '`Article`.`id`');
		$result = $test->fields($this->Model, null, $this->Model->escapeField());
		$this->assertEqual($result, array('`Article`.`id`'));

		$result = $test->read($this->Model, array(
			'fields' => $this->Model->escapeField(),
			'conditions' => null,
			'recursive' => -1
		));
		$this->assertEqual(trim($test->simulated[0]), 'SELECT `Article`.`id` FROM `' . $this->testDb->fullTableName('article', false) . '` AS `Article`   WHERE 1 = 1');

		$test->startQuote = '[';
		$test->endQuote = ']';
		$this->assertEqual($this->Model->escapeField(), '[Article].[id]');

		$result = $test->fields($this->Model, null, $this->Model->escapeField());
		$this->assertEqual($result, array('[Article].[id]'));

		$result = $test->read($this->Model, array(
			'fields' => $this->Model->escapeField(),
			'conditions' => null,
			'recursive' => -1
		));
		$this->assertEqual(trim($test->simulated[1]), 'SELECT [Article].[id] FROM [' . $this->testDb->fullTableName('article', false) . '] AS [Article]   WHERE 1 = 1');

		ClassRegistry::removeObject('Article');
	}
/**
 * testGenerateAssociationQuerySelfJoin method
 *
 * @access public
 * @return void
 */
	function testGenerateAssociationQuerySelfJoin() {
		$this->startTime = microtime(true);
		$this->Model =& new Article2();
		$this->_buildRelatedModels($this->Model);
		$this->_buildRelatedModels($this->Model->Category2);
		$this->Model->Category2->ChildCat =& new Category2();
		$this->Model->Category2->ParentCat =& new Category2();

		$queryData = array();

		foreach ($this->Model->Category2->__associations as $type) {
			foreach ($this->Model->Category2->{$type} as $assoc => $assocData) {
				$linkModel =& $this->Model->Category2->{$assoc};
				$external = isset($assocData['external']);

				if ($this->Model->Category2->alias == $linkModel->alias && $type != 'hasAndBelongsToMany' && $type != 'hasMany') {
					$result = $this->testDb->generateAssociationQuery($this->Model->Category2, $linkModel, $type, $assoc, $assocData, $queryData, $external, $null);
					$this->assertTrue($result);
				} else {
					if ($this->Model->Category2->useDbConfig == $linkModel->useDbConfig) {
						$result = $this->testDb->generateAssociationQuery($this->Model->Category2, $linkModel, $type, $assoc, $assocData, $queryData, $external, $null);
						$this->assertTrue($result);
					}
				}
			}
		}

		$query = $this->testDb->generateAssociationQuery($this->Model->Category2, $null, null, null, null, $queryData, false, $null);
		$this->assertPattern('/^SELECT\s+(.+)FROM(.+)`Category2`\.`group_id`\s+=\s+`Group`\.`id`\)\s+LEFT JOIN(.+)WHERE\s+1 = 1\s*$/', $query);

		$this->Model =& new TestModel4();
		$this->Model->schema();
		$this->_buildRelatedModels($this->Model);

		$binding = array('type' => 'belongsTo', 'model' => 'TestModel4Parent');
		$queryData = array();
		$resultSet = null;
		$null = null;

		$params = &$this->_prepareAssociationQuery($this->Model, $queryData, $binding);

		$_queryData = $queryData;
		$result = $this->testDb->generateAssociationQuery($this->Model, $params['linkModel'], $params['type'], $params['assoc'], $params['assocData'], $queryData, $params['external'], $resultSet);
		$this->assertTrue($result);

		$expected = array(
			'fields' => array(
				'`TestModel4`.`id`',
				'`TestModel4`.`name`',
				'`TestModel4`.`created`',
				'`TestModel4`.`updated`',
				'`TestModel4Parent`.`id`',
				'`TestModel4Parent`.`name`',
				'`TestModel4Parent`.`created`',
				'`TestModel4Parent`.`updated`'
			),
			'joins' => array(
				array(
					'table' => '`test_model4`',
					'alias' => 'TestModel4Pare