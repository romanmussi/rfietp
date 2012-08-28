<?php
/* SVN FILE: $Id: model.test.php 8225 2009-07-08 03:25:30Z mark_story $ */
/**
 * ModelIntegrationTest file
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <https://trac.cakephp.org/wiki/Developement/TestSuite>
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 *  Licensed under The Open Group Test Suite License
 *  Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          https://trac.cakephp.org/wiki/Developement/TestSuite CakePHP(tm) Tests
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model
 * @since         CakePHP(tm) v 1.2.0.4206
 * @version       $Revision: 8225 $
 * @modifiedby    $LastChangedBy: mark_story $
 * @lastmodified  $Date: 2009-07-07 23:25:30 -0400 (Tue, 07 Jul 2009) $
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
require_once dirname(__FILE__) . DS . 'model.test.php';
App::import('Core', 'DboSource');

/**
 * DboMock class
 * A Dbo Source driver to mock a connection and a identity name() method
 */
class DboMock extends DboSource {

/**
* Returns the $field without modifications
*/
	function name($field) {
		return $field;
	}
/**
* Returns true to fake a database connection
*/
	function connect() {
		return true;
	}
}

/**
 * ModelIntegrationTest
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.operations
 */
class ModelIntegrationTest extends BaseModelTest {
/**
 * testPkInHAbtmLinkModelArticleB
 *
 * @access public
 * @return void
 */
	function testPkInHabtmLinkModelArticleB() {
		$this->loadFixtures('Article', 'Tag');
		$TestModel2 =& new ArticleB();
		$this->assertEqual($TestModel2->ArticlesTag->primaryKey, 'article_id');
	}
/**
 * Tests that $cacheSources can only be disabled in the db using model settings, not enabled
 *
 * @access public
 * @return void
 */
	function testCacheSourcesDisabling() {
		$this->db->cacheSources = true;
		$TestModel = new JoinA();
		$TestModel->cacheSources = false;
		$TestModel->setSource('join_as');
		$this->assertFalse($this->db->cacheSources);

		$this->db->cacheSources = false;
		$TestModel = new JoinA();
		$TestModel->cacheSources = true;
		$TestModel->setSource('join_as');
		$this->assertFalse($this->db->cacheSources);
	}
/**
 * testPkInHabtmLinkModel method
 *
 * @access public
	 * @return void
 */
	function testPkInHabtmLinkModel() {
		//Test Nonconformant Models
		$this->loadFixtures('Content', 'ContentAccount', 'Account');
		$TestModel =& new Content();
		$this->assertEqual($TestModel->ContentAccount->primaryKey, 'iContentAccountsId');

		//test conformant models with no PK in the join table
		$this->loadFixtures('Article', 'Tag');
		$TestModel2 =& new Article();
		$this->assertEqual($TestModel2->ArticlesTag->primaryKey, 'article_id');

		//test conformant models with PK in join table
		$this->loadFixtures('Item', 'Portfolio', 'ItemsPortfolio');
		$TestModel3 =& new Portfolio();
		$this->assertEqual($TestModel3->ItemsPortfolio->primaryKey, 'id');

		//test conformant models with PK in join table - join table contains extra field
		$this->loadFixtures('JoinA', 'JoinB', 'JoinAB');
		$TestModel4 =& new JoinA();
		$this->assertEqual($TestModel4->JoinAsJoinB->primaryKey, 'id');

	}
/**
 * testDynamicBehaviorAttachment method
 *
 * @access public
 * @return void
 */
	function testDynamicBehaviorAttachment() {
		$this->loadFixtures('Apple');
		$TestModel =& new Apple();
		$this->assertEqual($TestModel->Behaviors->attached(), array());

		$TestModel->Behaviors->attach('Tree', array('left' => 'left_field', 'right' => 'right_field'));
		$this->assertTrue(is_object($TestModel->Behaviors->Tree));
		$this->assertEqual($TestModel->Behaviors->attached(), array('Tree'));

		$expected = array(
			'parent' => 'parent_id',
			'left' => 'left_field',
			'right' => 'right_field',
			'scope' => '1 = 1',
			'type' => 'nested',
			'__parentChange' => false,
			'recursive' => -1
		);

		$this->assertEqual($TestModel->Behaviors->Tree->settings['Apple'], $expected);

		$expected['enabled'] = false;
		$TestModel->Behaviors->attach('Tree', array('enabled' => false));
		$this->assertEqual($TestModel->Behaviors->Tree->settings['Apple'], $expected);
		$this->assertEqual($TestModel->Behaviors->attached(), array('Tree'));

		$TestModel->Behaviors->detach('Tree');
		$this->assertEqual($TestModel->Behaviors->attached(), array());
		$this->assertFalse(isset($TestModel->Behaviors->Tree));
	}
/**
 * Tests cross database joins.  Requires $test and $test2 to both be set in DATABASE_CONFIG
 * NOTE: When testing on MySQL, you must set 'persistent' => false on *both* database connections,
 * or one connection will step on the other.
 */
	function testCrossDatabaseJoins() {
		$config = new DATABASE_CONFIG();

		$skip = $this->skipIf(
			!isset($config->test) || !isset($config->test2),
			 '%s Primary and secondary test databases not configured, skipping cross-database '
			.'join tests.'
			.' To run these tests, you must define $test and $test2 in your database configuration.'
		);

		if ($skip) {
			return;
		}

		$this->loadFixtures('Article', 'Tag', 'ArticlesTag', 'User', 'Comment');
		$TestModel =& new Article();

		$expected = array(
			array(
				'Article' => array(
					'id' => '1',
					'user_id' => '1',
					'title' => 'First Article',
					'body' => 'First Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31'
				),
				'User' => array(
					'id' => '1',
					'user' => 'mariano',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:16:23',
					'updated' => '2007-03-17 01:18:31'
				),
				'Comment' => array(
					array(
						'id' => '1',
						'article_id' => '1',
						'user_id' => '2',
						'comment' => 'First Comment for First Article',
						'published' => 'Y',
						'created' => '2007-03-18 10:45:23',
						'updated' => '2007-03-18 10:47:31'
					),
					array(
						'id' => '2',
						'article_id' => '1',
						'user_id' => '4',
						'comment' => 'Second Comment for First Article',
						'published' => 'Y',
						'created' => '2007-03-18 10:47:23',
						'updated' => '2007-03-18 10:49:31'
					),
					array(
						'id' => '3',
						'article_id' => '1',
						'user_id' => '1',
						'comment' => 'Third Comment for First Article',
						'published' => 'Y',
						'created' => '2007-03-18 10:49:23',
						'updated' => '2007-03-18 10:51:31'
					),
					array(
						'id' => '4',
						'article_id' => '1',
						'user_id' => '1',
						'comment' => 'Fourth Comment for First Article',
						'published' => 'N',
						'created' => '2007-03-18 10:51:23',
						'updated' => '2007-03-18 10:53:31'
				)),
				'Tag' => array(
					array(
						'id' => '1',
						'tag' => 'tag1',
						'created' => '2007-03-18 12:22:23',
						'updated' => '2007-03-18 12:24:31'
					),
					array(
						'id' => '2',
						'tag' => 'tag2',
						'created' => '2007-03-18 12:24:23',
						'updated' => '2007-03-18 12:26:31'
			))),
			array(
				'Article' => array(
					'id' => '2',
					'user_id' => '3',
					'title' => 'Second Article',
					'body' => 'Second Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:41:23',
					'updated' => '2007-03-18 10:43:31'
				),
				'User' => array(
					'id' => '3',
					'user' => 'larry',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:20:23',
					'updated' => '2007-03-17 01:22:31'
				),
				'Comment' => array(
					array(
						'id' => '5',
						'article_id' => '2',
						'user_id' => '1',
						'comment' => 'First Comment for Second Article',
						'published' => 'Y',
						'created' => '2007-03-18 10:53:23',
						'updated' => '2007-03-18 10:55:31'
					),
					array(
						'id' => '6',
						'article_id' => '2',
						'user_id' => '2',
						'comment' => 'Second Comment for Second Article',
						'published' => 'Y',
						'created' => '2007-03-18 10:55:23',
						'updated' => '2007-03-18 10:57:31'
				)),
				'Tag' => array(
					array(
						'id' => '1',
						'tag' => 'tag1',
						'created' => '2007-03-18 12:22:23',
						'updated' => '2007-03-18 12:24:31'
					),
					array(
						'id' => '3',
						'tag' => 'tag3',
						'created' => '2007-03-18 12:26:23',
						'updated' => '2007-03-18 12:28:31'
			))),
			array(
				'Article' => array(
					'id' => '3',
					'user_id' => '1',
					'title' => 'Third Article',
					'body' => 'Third Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:43:23',
					'updated' => '2007-03-18 10:45:31'
				),
				'User' => array(
					'id' => '1',
					'user' => 'mariano',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:16:23',
					'updated' => '2007-03-17 01:18:31'
				),
				'Comment' => array(),
				'Tag' => array()
		));
		$this->assertEqual($TestModel->find('all'), $expected);

		$db2 =& ConnectionManager::getDataSource('test2');

		foreach (array('User', 'Comment') as $class) {
			$this->_fixtures[$this->_fixtureClassMap[$class]]->create($db2);
			$this->_fixtures[$this->_fixtureClassMap[$class]]->insert($db2);
			$this->db->truncate(Inflector::pluralize(Inflector::underscore($class)));
		}

		$this->assertEqual($TestModel->User->find('all'), array());
		$this->assertEqual($TestModel->Comment->find('all'), array());
		$this->assertEqual($TestModel->find('count'), 3);

		$TestModel->User->setDataSource('test2');
		$TestModel->Comment->setDataSource('test2');

		foreach ($expected as $key => $value) {
			unset($value['Comment'], $value['Tag']);
			$expected[$key] = $value;
		}

		$TestModel->recursive = 0;
		$result = $TestModel->find('all');
		$this->assertEqual($result, $expected);

		foreach ($expected as $key => $value) {
			unset($value['Comment'], $value['Tag']);
			$expected[$key] = $value;
		}

		$TestModel->recursive = 0;
		$result = $TestModel->find('all');
		$this->assertEqual($result, $expected);

		$result = Set::extract($TestModel->User->find('all'), '{n}.User.id');
		$this->assertEqual($result, array('1', '2', '3', '4'));
		$this->assertEqual($TestModel->find('all'), $expected);

		$TestModel->Comment->unbindModel(array('hasOne' => array('Attachment')));
		$expected = array(
			array(
				'Comment' => array(
					'id' => '1',
					'article_id' => '1',
					'user_id' => '2',
					'comment' => 'First Comment for First Article',
					'published' => 'Y',
					'created' => '2007-03-18 10:45:23',
					'updated' => '2007-03-18 10:47:31'
				),
				'User' => array(
					'id' => '2',
					'user' => 'nate',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:18:23',
					'updated' => '2007-03-17 01:20:31'
				),
				'Article' => array(
					'id' => '1',
					'user_id' => '1',
					'title' => 'First Article',
					'body' => 'First Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31'
			)),
			array(
				'Comment' => array(
					'id' => '2',
					'article_id' => '1',
					'user_id' => '4',
					'comment' => 'Second Comment for First Article',
					'published' => 'Y',
					'created' => '2007-03-18 10:47:23',
					'updated' => '2007-03-18 10:49:31'
				),
				'User' => array(
					'id' => '4',
					'user' => 'garrett',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:22:23',
					'updated' => '2007-03-17 01:24:31'
				),
				'Article' => array(
					'id' => '1',
					'user_id' => '1',
					'title' => 'First Article',
					'body' => 'First Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31'
			)),
			array(
				'Comment' => array(
					'id' => '3',
					'article_id' => '1',
					'user_id' => '1',
					'comment' => 'Third Comment for First Article',
					'published' => 'Y',
					'created' => '2007-03-18 10:49:23',
					'updated' => '2007-03-18 10:51:31'
				),
				'User' => array(
					'id' => '1',
					'user' => 'mariano',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:16:23',
					'updated' => '2007-03-17 01:18:31'
				),
				'Article' => array(
					'id' => '1',
					'user_id' => '1',
					'title' => 'First Article',
					'body' => 'First Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31'
			)),
			array(
				'Comment' => array(
					'id' => '4',
					'article_id' => '1',
					'user_id' => '1',
					'comment' => 'Fourth Comment for First Article',
					'published' => 'N',
					'created' => '2007-03-18 10:51:23',
					'updated' => '2007-03-18 10:53:31'
				),
				'User' => array(
					'id' => '1',
					'user' => 'mariano',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:16:23',
					'updated' => '2007-03-17 01:18:31'
				),
				'Article' => array(
					'id' => '1',
					'user_id' => '1',
					'title' => 'First Article',
					'body' => 'First Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31'
			)),
			array(
				'Comment' => array(
					'id' => '5',
					'article_id' => '2',
					'user_id' => '1',
					'comment' => 'First Comment for Second Article',
					'published' => 'Y',
					'created' => '2007-03-18 10:53:23',
					'updated' => '2007-03-18 10:55:31'
				),
				'User' => array(
					'id' => '1',
					'user' => 'mariano',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:16:23',
					'updated' => '2007-03-17 01:18:31'
				),
				'Article' => array(
					'id' => '2',
					'user_id' => '3',
					'title' => 'Second Article',
					'body' => 'Second Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:41:23',
					'updated' => '2007-03-18 10:43:31'
			)),
			array(
				'Comment' => array(
					'id' => '6',
					'article_id' => '2',
					'user_id' => '2',
					'comment' => 'Second Comment for Second Article',
					'published' => 'Y',
					'created' => '2007-03-18 10:55:23',
					'updated' => '2007-03-18 10:57:31'
				),
				'User' => array(
					'id' => '2',
					'user' => 'nate',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:18:23',
					'updated' => '2007-03-17 01:20:31'
				),
				'Article' => array(
					'id' => '2',
					'user_id' => '3',
					'title' => 'Second Article',
					'body' => 'Second Article Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:41:23',
					'updated' => '2007-03-18 10:43:31'
		)));
		$this->assertEqual($TestModel->Comment->find('all'), $expected);

		foreach (array('User', 'Comment') as $class) {
			$this->_fixtures[$this->_fixtureClassMap[$class]]->drop($db2);
		}
	}
/**
 * testDisplayField method
 *
 * @access public
 * @return void
 */
	function testDisplayField() {
		$this->loadFixtures('Post', 'Comment', 'Person');
		$Post = new Post();
		$Comment = new Comment();
		$Person = new Person();

		$this->assertEqual($Post->displayField, 'title');
		$this->assertEqual($Person->displayField, 'name');
		$this->assertEqual($Comment->displayField, 'id');
	}
/**
 * testSchema method
 *
 * @access public
 * @return void
 */
	function testSchema() {
		$Post = new Post();

		$result = $Post->schema();
		$columns = array('id', 'author_id', 'title', 'body', 'published', 'created', 'updated');
		$this->assertEqual(array_keys($result), $columns);

		$types = array('integer', 'integer', 'string', 'text', 'string', 'datetime', 'datetime');
		$this->assertEqual(Set::extract(array_values($result), '{n}.type'), $types);

		$result = $Post->schema('body');
		$this->assertEqual($result['type'], 'text');
		$this->assertNull($Post->schema('foo'));

		$this->assertEqual($Post->getColumnTypes(), array_combine($columns, $types));
	}
/**
 * test deconstruct() with time fields.
 *
 * @return void
 **/
	function testDeconstructFieldsTime() {
		$this->loadFixtures('Apple');
		$TestModel =& new Apple();

		$data = array();
		$data['Apple']['mytime']['hour'] = '';
		$data['Apple']['mytime']['min'] = '';
		$data['Apple']['mytime']['sec'] = '';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('mytime'=> ''));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['mytime']['hour'] = '';
		$data['Apple']['mytime']['min'] = '';
		$data['Apple']['mytime']['meridan'] = '';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('mytime'=> ''));
		$this->assertEqual($TestModel->data, $expected, 'Empty values are not returning properly. %s');

		$data = array();
		$data['Apple']['mytime']['hour'] = '12';
		$data['Apple']['mytime']['min'] = '0';
		$data['Apple']['mytime']['meridian'] = 'am';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('mytime'=> '00:00:00'));
		$this->assertEqual($TestModel->data, $expected, 'Midnight is not returning proper values. %s');

		$data = array();
		$data['Apple']['mytime']['hour'] = '00';
		$data['Apple']['mytime']['min'] = '00';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('mytime'=> '00:00:00'));
		$this->assertEqual($TestModel->data, $expected, 'Midnight is not returning proper values. %s');

		$data = array();
		$data['Apple']['mytime']['hour'] = '03';
		$data['Apple']['mytime']['min'] = '04';
		$data['Apple']['mytime']['sec'] = '04';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('mytime'=> '03:04:04'));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['mytime']['hour'] = '3';
		$data['Apple']['mytime']['min'] = '4';
		$data['Apple']['mytime']['sec'] = '4';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple' => array('mytime'=> '03:04:04'));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['mytime']['hour'] = '03';
		$data['Apple']['mytime']['min'] = '4';
		$data['Apple']['mytime']['sec'] = '4';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('mytime'=> '03:04:04'));
		$this->assertEqual($TestModel->data, $expected);

		$db = ConnectionManager::getDataSource('test_suite');
		$data = array();
		$data['Apple']['mytime'] = $db->expression('NOW()');
		$TestModel->data = null;
		$TestModel->set($data);
		$this->assertEqual($TestModel->data, $data);
	}
/**
 * testDeconstructFields with datetime, timestamp, and date fields
 *
 * @access public
 * @return void
 */
	function testDeconstructFieldsDateTime() {
		$this->loadFixtures('Apple');
		$TestModel =& new Apple();

		//test null/empty values first
		$data['Apple']['created']['year'] = '';
		$data['Apple']['created']['month'] = '';
		$data['Apple']['created']['day'] = '';
		$data['Apple']['created']['hour'] = '';
		$data['Apple']['created']['min'] = '';
		$data['Apple']['created']['sec'] = '';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('created'=> ''));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['date']['year'] = '';
		$data['Apple']['date']['month'] = '';
		$data['Apple']['date']['day'] = '';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('date'=> ''));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['created']['year'] = '2007';
		$data['Apple']['created']['month'] = '08';
		$data['Apple']['created']['day'] = '20';
		$data['Apple']['created']['hour'] = '';
		$data['Apple']['created']['min'] = '';
		$data['Apple']['created']['sec'] = '';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('created'=> '2007-08-20 00:00:00'));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['created']['year'] = '2007';
		$data['Apple']['created']['month'] = '08';
		$data['Apple']['created']['day'] = '20';
		$data['Apple']['created']['hour'] = '10';
		$data['Apple']['created']['min'] = '12';
		$data['Apple']['created']['sec'] = '';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('created'=> '2007-08-20 10:12:00'));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['created']['year'] = '2007';
		$data['Apple']['created']['month'] = '';
		$data['Apple']['created']['day'] = '12';
		$data['Apple']['created']['hour'] = '20';
		$data['Apple']['created']['min'] = '';
		$data['Apple']['created']['sec'] = '';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('created'=> ''));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['created']['hour'] = '20';
		$data['Apple']['created']['min'] = '33';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('created'=> ''));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['created']['hour'] = '20';
		$data['Apple']['created']['min'] = '33';
		$data['Apple']['created']['sec'] = '33';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('created'=> ''));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['created']['hour'] = '13';
		$data['Apple']['created']['min'] = '00';
		$data['Apple']['date']['year'] = '2006';
		$data['Apple']['date']['month'] = '12';
		$data['Apple']['date']['day'] = '25';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array(
			'Apple'=> array(
			'created'=> '',
			'date'=> '2006-12-25'
		));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['created']['year'] = '2007';
		$data['Apple']['created']['month'] = '08';
		$data['Apple']['created']['day'] = '20';
		$data['Apple']['created']['hour'] = '10';
		$data['Apple']['created']['min'] = '12';
		$data['Apple']['created']['sec'] = '09';
		$data['Apple']['date']['year'] = '2006';
		$data['Apple']['date']['month'] = '12';
		$data['Apple']['date']['day'] = '25';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array(
			'Apple'=> array(
				'created'=> '2007-08-20 10:12:09',
				'date'=> '2006-12-25'
		));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['created']['year'] = '--';
		$data['Apple']['created']['month'] = '--';
		$data['Apple']['created']['day'] = '--';
		$data['Apple']['created']['hour'] = '--';
		$data['Apple']['created']['min'] = '--';
		$data['Apple']['created']['sec'] = '--';
		$data['Apple']['date']['year'] = '--';
		$data['Apple']['date']['month'] = '--';
		$data['Apple']['date']['day'] = '--';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('created'=> '', 'date'=> ''));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['created']['year'] = '2007';
		$data['Apple']['created']['month'] = '--';
		$data['Apple']['created']['day'] = '20';
		$data['Apple']['created']['hour'] = '10';
		$data['Apple']['created']['min'] = '12';
		$data['Apple']['created']['sec'] = '09';
		$data['Apple']['date']['year'] = '2006';
		$data['Apple']['date']['month'] = '12';
		$data['Apple']['date']['day'] = '25';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('created'=> '', 'date'=> '2006-12-25'));
		$this->assertEqual($TestModel->data, $expected);

		$data = array();
		$data['Apple']['date']['year'] = '2006';
		$data['Apple']['date']['month'] = '12';
		$data['Apple']['date']['day'] = '25';

		$TestModel->data = null;
		$TestModel->set($data);
		$expected = array('Apple'=> array('date'=> '2006-12-25'));
		$this->assertEqual($TestModel->data, $expected);

		$db = ConnectionManager::getDataSource('test_suite');
		$data = array();
		$data['Apple']['modified'] = $db->expression('NOW()');
		$TestModel->data = null;
		$TestModel->set($data);
		$this->assertEqual($TestModel->data, $data);
	}
/**
 * testTablePrefixSwitching method
 *
 * @access public
 * @return void
 */
	function testTablePrefixSwitching() {
		ConnectionManager::create('database1',
				array_merge($this->db->config, array('prefix' => 'aaa_')
		));
		ConnectionManager::create('database2',
			array_merge($this->db->config, array('prefix' => 'bbb_')
		));

		$db1 = ConnectionManager::getDataSource('database1');
		$db2 = ConnectionManager::getDataSource('database2');

		$TestModel = new Apple();
		$TestModel->setDataSource('database1');
		$this->assertEqual($this->db->fullTableName($TestModel, false), 'aaa_apples');
		$this->assertEqual($db1->fullTableName($TestModel, false), 'aaa_apples');
		$this->assertEqual($db2->fullTableName($TestModel, false), 'aaa_apples');

		$TestModel->setDataSource('database2');
		$this->assertEqual($this->db->fullTableName($TestModel, false), 'bbb_apples');
		$this->assertEqual($db1->fullTableName($TestModel, false), 'bbb_apples');
		$this->assertEqual($db2->fullTableName($TestModel, false), 'bbb_apples');

		$TestModel = new Apple();
		$TestModel->tablePrefix = 'custom_';
		$this->assertEqual($this->db->fullTableName($TestModel, false), 'custom_apples');
		$TestModel->setDataSource('database1');
		$this->assertEqual($this->db->fullTableName($TestModel, false), 'custom_apples');
		$this->assertEqual($db1->fullTableName($TestModel, false), 'custom_apples');

		$TestModel = new Apple();
		$TestModel->setDataSource('database1');
		$this->assertEqual($this->db->fullTableName($TestModel, false), 'aaa_apples');
		$TestModel->tablePrefix = '';
		$TestModel->setDataSource('database2');
		$this->assertEqual($db2->fullTableName($TestModel, false), 'apples');
		$this->assertEqual($db1->fullTableName($TestModel, false), 'apples');

		$TestModel->tablePrefix = null;
		$TestModel->setDataSource('database1');
		$this->assertEqual($db2->fullTableName($TestModel, false), 'aaa_apples');
		$this->assertEqual($db1->fullTableName($TestModel, false), 'aaa_apples');

		$TestModel->tablePrefix = false;
		$TestModel->setDataSource('database2');
		$this->assertEqual($db2->fullTableName($TestModel, false), 'apples');
		$this->assertEqual($db1->fullTableName($TestModel, false), 'apples');
	}
/**
 * Tests validation parameter order in custom validation methods
 *
 * @access public
 * @return void
 */
	function testInvalidAssociation() {
		$TestModel =& new ValidationTest1();
		$this->assertNull($TestModel->getAssociated('Foo'));
	}
/**
 * testLoadModelSecondIteration method
 *
 * @access public
 * @return void
 */
	function testLoadModelSecondIteration() {
		$model = new ModelA();
		$this->assertIsA($model,'ModelA');

		$this->assertIsA($model->ModelB, 'ModelB');
		$this->assertIsA($model->ModelB->ModelD, 'ModelD');

		$this->assertIsA($model->ModelC, 'ModelC');
		$this->assertIsA($model->ModelC->ModelD, 'ModelD');
	}
/**
 * ensure that __exists is reset on create
 *
 * @return void
 **/
	function testResetOfExistsOnCreate() {
		$this->loadFixtures('Article');
		$Article =& new Article();
		$Article->id = 1;
		$Article->saveField('title', 'Reset me');
		$Article->delete();
		$Article->id = 1;
		$this->assertFalse($Article->exists());

		$Article->create();
		$this->assertFalse($Article->exists());
		$Article->id = 2;
		$Article->saveField('title', 'Staying alive');
		$result = $Article->read(null, 2);
		$this->assertEqual($result['Article']['title'], 'Staying alive');
	}
/**
 * testPluginAssociations method
 *
 * @access public
 * @return void
 */
	function testPluginAssociations() {
		$this->loadFixtures('TestPluginArticle', 'User', 'TestPluginComment');
		$TestModel =& new TestPluginArticle();

		$result = $TestModel->find('all');
		$expected = array(
			array(
				'TestPluginArticle' => array(
					'id' => 1,
					'user_id' => 1,
					'title' => 'First Plugin Article',
					'body' => 'First Plugin Article Body',
					'published' => 'Y',
					'created' => '2008-09-24 10:39:23',
					'updated' => '2008-09-24 10:41:31'
				),
				'User' => array(
					'id' => 1,
					'user' => 'mariano',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:16:23',
					'updated' => '2007-03-17 01:18:31'
				),
				'TestPluginComment' => array(
					array(
						'id' => 1,
						'article_id' => 1,
						'user_id' => 2,
						'comment' => 'First Comment for First Plugin Article',
						'published' => 'Y',
						'created' => '2008-09-24 10:45:23',
						'updated' => '2008-09-24 10:47:31'
					),
					array(
						'id' => 2,
						'article_id' => 1,
						'user_id' => 4,
						'comment' => 'Second Comment for First Plugin Article',
						'published' => 'Y',
						'created' => '2008-09-24 10:47:23',
						'updated' => '2008-09-24 10:49:31'
					),
					array(
						'id' => 3,
						'article_id' => 1,
						'user_id' => 1,
						'comment' => 'Third Comment for First Plugin Article',
						'published' => 'Y',
						'created' => '2008-09-24 10:49:23',
						'updated' => '2008-09-24 10:51:31'
					),
					array(
						'id' => 4,
						'article_id' => 1,
						'user_id' => 1,
						'comment' => 'Fourth Comment for First Plugin Article',
						'published' => 'N',
						'created' => '2008-09-24 10:51:23',
						'updated' => '2008-09-24 10:53:31'
			))),
			array(
				'TestPluginArticle' => array(
					'id' => 2,
					'user_id' => 3,
					'title' => 'Second Plugin Article',
					'body' => 'Second Plugin Article Body',
					'published' => 'Y',
					'created' => '2008-09-24 10:41:23',
					'updated' => '2008-09-24 10:43:31'
				),
				'User' => array(
					'id' => 3,
					'user' => 'larry',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:20:23',
					'updated' => '2007-03-17 01:22:31'
				),
				'TestPluginComment' => array(
					array(
						'id' => 5,
						'article_id' => 2,
						'user_id' => 1,
						'comment' => 'First Comment for Second Plugin Article',
						'published' => 'Y',
						'created' => '2008-09-24 10:53:23',
						'updated' => '2008-09-24 10:55:31'
					),
					array(
						'id' => 6,
						'article_id' => 2,
						'user_id' => 2,
						'comment' => 'Second Comment for Second Plugin Article',
						'published' => 'Y',
						'created' => '2008-09-24 10:55:23',
						'updated' => '2008-09-24 10:57:31'
			))),
			array(
				'TestPluginArticle' => array(
					'id' => 3,
					'user_id' => 1,
					'title' => 'Third Plugin Article',
					'body' => 'Third Plugin Article Body',
					'published' => 'Y',
					'created' => '2008-09-24 10:43:23',
					'updated' => '2008-09-24 10:45:31'
				),
				'User' => array(
					'id' => 1,
					'user' => 'mariano',
					'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
					'created' => '2007-03-17 01:16:23',
					'updated' => '2007-03-17 01:18:31'
				),
				'TestPluginComment' => array()
		));

		$this->assertEqual($result, $expected);
	}
/**
 * Tests getAssociated method
 *
 * @access public
 * @return void
 */
	function testGetAssociated() {
		$this->loadFixtures('Article');
		$Article = ClassRegistry::init('Article');

		$assocTypes = array('hasMany', 'hasOne', 'belongsTo', 'hasAndBelongsToMany');
		foreach ($assocTypes as $type) {
			 $this->assertEqual($Article->getAssociated($type), array_keys($Article->{$type}));
		}

		$Article->bindModel(array('hasMany' => array('Category')));
		$this->assertEqual($Article->getAssociated('hasMany'), array('Comment', 'Category'));

		$results = $Article->getAssociated();
		$this->assertEqual(sort(array_keys($results)), array('Category', 'Comment', 'Tag'));

		$Article->unbindModel(array('hasAndBelongsToMany' => array('Tag')));
		$this->assertEqual($Article->getAssociated('hasAndBelongsToMany'), array());

		$result = $Article->getAssociated('Category');
		$expected = array(
			'className' => 'Category',
			'foreignKey' => 'article_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'dependent' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => '',
			'association' => 'hasMany',
		);
		$this->assertEqual($result, $expected);
	}

/**
 * testAutoConstructAssociations method
 *
 * @access public
 * @return void
 */
	function testAutoConstructAssociations() {
		$this->loadFixtures('User', 'ArticleFeatured');
		$TestModel =& new AssociationTest1();

		$result = $TestModel->hasAndBelongsToMany;
		$expected = array('AssociationTest2' => array(
				'unique' => false,
				'joinTable' => 'join_as_join_bs',
				'foreignKey' => false