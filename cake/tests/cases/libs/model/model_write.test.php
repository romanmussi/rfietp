<?php
/* SVN FILE: $Id: model.test.php 8225 2009-07-08 03:25:30Z mark_story $ */
/**
 * ModelWriteTest file
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
/**
 * ModelWriteTest
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model.operations
 */
class ModelWriteTest extends BaseModelTest {
/**
 * testInsertAnotherHabtmRecordWithSameForeignKey method
 *
 * @access public
 * @return void
 */
	function testInsertAnotherHabtmRecordWithSameForeignKey() {
		$this->loadFixtures('JoinA', 'JoinB', 'JoinAB');
		$TestModel = new JoinA();

		$result = $TestModel->JoinAsJoinB->findById(1);
		$expected = array(
			'JoinAsJoinB' => array(
				'id' => 1,
				'join_a_id' => 1,
				'join_b_id' => 2,
				'other' => 'Data for Join A 1 Join B 2',
				'created' => '2008-01-03 10:56:33',
				'updated' => '2008-01-03 10:56:33'
		));
		$this->assertEqual($result, $expected);

		$TestModel->JoinAsJoinB->create();
		$result = $TestModel->JoinAsJoinB->save(array(
			'join_a_id' => 1,
			'join_b_id' => 1,
			'other' => 'Data for Join A 1 Join B 1',
			'created' => '2008-01-03 10:56:44',
			'updated' => '2008-01-03 10:56:44'
		));
		$this->assertTrue($result);
		$lastInsertId = $TestModel->JoinAsJoinB->getLastInsertID();
		$this->assertTrue($lastInsertId != null);

		$result = $TestModel->JoinAsJoinB->findById(1);
		$expected = array(
			'JoinAsJoinB' => array(
				'id' => 1,
				'join_a_id' => 1,
				'join_b_id' => 2,
				'other' => 'Data for Join A 1 Join B 2',
				'created' => '2008-01-03 10:56:33',
				'updated' => '2008-01-03 10:56:33'
		));
		$this->assertEqual($result, $expected);

		$updatedValue = 'UPDATED Data for Join A 1 Join B 2';
		$TestModel->JoinAsJoinB->id = 1;
		$result = $TestModel->JoinAsJoinB->saveField('other', $updatedValue, false);
		$this->assertTrue($result);

		$result = $TestModel->JoinAsJoinB->findById(1);
		$this->assertEqual($result['JoinAsJoinB']['other'], $updatedValue);
	}
/**
 * testSaveDateAsFirstEntry method
 *
 * @access public
 * @return void
 */
	function testSaveDateAsFirstEntry() {
		$this->loadFixtures('Article');

		$Article =& new Article();

		$data = array(
			'Article' => array(
				'created' => array(
					'day' => '1',
					'month' => '1',
					'year' => '2008'
				),
				'title' => 'Test Title',
				'user_id' => 1
		));
		$Article->create();
		$this->assertTrue($Article->save($data));

		$testResult = $Article->find(array('Article.title' => 'Test Title'));

		$this->assertEqual($testResult['Article']['title'], $data['Article']['title']);
		$this->assertEqual($testResult['Article']['created'], '2008-01-01 00:00:00');

	}
/**
 * testUnderscoreFieldSave method
 *
 * @access public
 * @return void
 */
	function testUnderscoreFieldSave() {
		$this->loadFixtures('UnderscoreField');
		$UnderscoreField =& new UnderscoreField();

		$currentCount = $UnderscoreField->find('count');
		$this->assertEqual($currentCount, 3);
		$data = array('UnderscoreField' => array(
			'user_id' => '1',
			'my_model_has_a_field' => 'Content here',
			'body' => 'Body',
			'published' => 'Y',
			'another_field' => 4
		));
		$ret = $UnderscoreField->save($data);
		$this->assertTrue($ret);

		$currentCount = $UnderscoreField->find('count');
		$this->assertEqual($currentCount, 4);
	}
/**
 * testAutoSaveUuid method
 *
 * @access public
 * @return void
 */
	function testAutoSaveUuid() {
		// SQLite does not support non-integer primary keys
		$this->skipIf($this->db->config['driver'] == 'sqlite');

		$this->loadFixtures('Uuid');
		$TestModel =& new Uuid();

		$TestModel->save(array('title' => 'Test record'));
		$result = $TestModel->findByTitle('Test record');
		$this->assertEqual(
			array_keys($result['Uuid']),
			array('id', 'title', 'count', 'created', 'updated')
		);
		$this->assertEqual(strlen($result['Uuid']['id']), 36);
	}
/**
 * Ensure that if the id key is null but present the save doesn't fail (with an
 * x sql error: "Column id specified twice")
 *
 * @return void
 * @access public
 */
	function testSaveUuidNull() {
		// SQLite does not support non-integer primary keys
		$this->skipIf($this->db->config['driver'] == 'sqlite');

		$this->loadFixtures('Uuid');
		$TestModel =& new Uuid();

		$TestModel->save(array('title' => 'Test record', 'id' => null));
		$result = $TestModel->findByTitle('Test record');
		$this->assertEqual(
			array_keys($result['Uuid']),
			array('id', 'title', 'count', 'created', 'updated')
		);
		$this->assertEqual(strlen($result['Uuid']['id']), 36);
	}

/**
 * testZeroDefaultFieldValue method
 *
 * @access public
 * @return void
 */
	function testZeroDefaultFieldValue() {
		$this->skipIf(
			$this->db->config['driver'] == 'sqlite',
			'%s SQLite uses loose typing, this operation is unsupported'
		);
		$this->loadFixtures('DataTest');
		$TestModel =& new DataTest();

		$TestModel->create(array());
		$TestModel->save();
		$result = $TestModel->findById($TestModel->id);
		$this->assertIdentical($result['DataTest']['count'], '0');
		$this->assertIdentical($result['DataTest']['float'], '0');
	}
/**
 * testNonNumericHabtmJoinKey method
 *
 * @access public
 * @return void
 */
	function testNonNumericHabtmJoinKey() {
		$this->loadFixtures('Post', 'Tag', 'PostsTag');
		$Post =& new Post();
		$Post->bind('Tag', array('type' => 'hasAndBelongsToMany'));
		$Post->Tag->primaryKey = 'tag';

		$result = $Post->find('all');
		$expected = array(
			array(
				'Post' => array(
					'id' => '1',
					'author_id' => '1',
					'title' => 'First Post',
					'body' => 'First Post Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:39:23',
					'updated' => '2007-03-18 10:41:31'
				),
				'Author' => array(
					'id' => null,
					'user' => null,
					'password' => null,
					'created' => null,
					'updated' => null,
					'test' => 'working'
				),
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
				'Post' => array(
					'id' => '2',
					'author_id' => '3',
					'title' => 'Second Post',
					'body' => 'Second Post Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:41:23',
					'updated' => '2007-03-18 10:43:31'
				),
				'Author' => array(
					'id' => null,
					'user' => null,
					'password' => null,
					'created' => null,
					'updated' => null,
					'test' => 'working'
				),
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
				'Post' => array(
					'id' => '3',
					'author_id' => '1',
					'title' => 'Third Post',
					'body' => 'Third Post Body',
					'published' => 'Y',
					'created' => '2007-03-18 10:43:23',
					'updated' => '2007-03-18 10:45:31'
				),
				'Author' => array(
					'id' => null,
					'user' => null,
					'password' => null,
					'created' => null,
					'updated' => null,
					'test' => 'working'
				),
				'Tag' => array()
		));
		$this->assertEqual($result, $expected);
	}
/**
 * Tests validation parameter order in custom validation methods
 *
 * @access public
 * @return void
 */
	function testAllowSimulatedFields() {
		$TestModel =& new ValidationTest1();

		$TestModel->create(array(
			'title' => 'foo',
			'bar' => 'baz'
		));
		$expected = array(
			'ValidationTest1' => array(
				'title' => 'foo',
				'bar' => 'baz'
		));
		$this->assertEqual($TestModel->data, $expected);
	}
/**
 * test that Caches are getting cleared on save().
 * ensure that both inflections of controller names are getting cleared
 * as url for controller could be either overallFavorites/index or overall_favorites/index
 *
 * @return void
 **/
	function testCacheClearOnSave() {
		$_back = array(
			'check' => Configure::read('Cache.check'),
			'disable' => Configure::read('Cache.disable'),
		);
		Configure::write('Cache.check', true);
		Configure::write('Cache.disable', false);

		$this->loadFixtures('OverallFavorite');
		$OverallFavorite =& new OverallFavorite();

		touch(CACHE . 'views' . DS . 'some_dir_overallfavorites_index.php');
		touch(CACHE . 'views' . DS . 'some_dir_overall_favorites_index.php');

		$data = array(
			'OverallFavorite' => array(
				'id' => 22,
		 		'model_type' => '8-track',
				'model_id' => '3',
				'priority' => '1'
			)
		);
		$OverallFavorite->create($data);
		$OverallFavorite->save();

		$this->assertFalse(file_exists(CACHE . 'views' . DS . 'some_dir_overallfavorites_index.php'));
		$this->assertFalse(file_exists(CACHE . 'views' . DS . 'some_dir_overall_favorites_index.php'));

		Configure::write('Cache.check', $_back['check']);
		Configure::write('Cache.disable', $_back['disable']);
	}
/**
 * testSaveWithCounterCache method
 *
 * @access public
 * @return void
 */
	function testSaveWithCounterCache() {
		$this->loadFixtures('Syfile', 'Item');
		$TestModel =& new Syfile();
		$TestModel2 =& new Item();

		$result = $TestModel->findById(1);
		$this->assertIdentical($result['Syfile']['item_count'], null);

		$TestModel2->save(array(
			'name' => 'Item 7',
			'syfile_id' => 1,
			'published' => false
		));

		$result = $TestModel->findById(1);
		$this->assertIdentical($result['Syfile']['item_count'], '2');

		$TestModel2->delete(1);
		$result = $TestModel->findById(1);
		$this->assertIdentical($result['Syfile']['item_count'], '1');

		$TestModel2->id = 2;
		$TestModel2->saveField('syfile_id', 1);

		$result = $TestModel->findById(1);
		$this->assertIdentical($result['Syfile']['item_count'], '2');

		$result = $TestModel->findById(2);
		$this->assertIdentical($result['Syfile']['item_count'], '0');
	}
/**
 * Tests that counter caches are updated when records are added
 *
 * @access public
 * @return void
 */
	function testCounterCacheIncrease() {
		$this->loadFixtures('CounterCacheUser', 'CounterCachePost');
		$User = new CounterCacheUser();
		$Post = new CounterCachePost();
		$data = array('Post' => array(
			'id' => 22,
			'title' => 'New Post',
			'user_id' => 66
		));

		$Post->save($data);
		$user = $User->find('first', array(
			'conditions' => array('id' => 66),
			'recursive' => -1
		));

		$result = $user[$User->alias]['post_count'];
		$expected = 3;
		$this->assertEqual($result, $expected);
	}
/**
 * Tests that counter caches are updated when records are deleted
 *
 * @access public
 * @return void
 */
	function testCounterCacheDecrease() {
		$this->loadFixtures('CounterCacheUser', 'CounterCachePost');
		$User = new CounterCacheUser();
		$Post = new CounterCachePost();

		$Post->del(2);
		$user = $User->find('first', array(
			'conditions' => array('id' => 66),
			'recursive' => -1
		));

		$result = $user[$User->alias]['post_count'];
		$expected = 1;
		$this->assertEqual($result, $expected);
	}
/**
 * Tests that counter caches are updated when foreign keys of counted records change
 *
 * @access public
 * @return void
 */
	function testCounterCacheUpdated() {
		$this->loadFixtures('CounterCacheUser', 'CounterCachePost');
		$User = new CounterCacheUser();
		$Post = new CounterCachePost();

		$data = $Post->find('first', array(
			'conditions' => array('id' => 1),
			'recursive' => -1
		));
		$data[$Post->alias]['user_id'] = 301;
		$Post->save($data);

		$users = $User->find('all',array('order' => 'User.id'));
		$this->assertEqual($users[0]['User']['post_count'], 1);
		$this->assertEqual($users[1]['User']['post_count'], 2);
	}
/**
 * Test counter cache with models that use a non-standard (i.e. not using 'id')
 * as their primary key.
 *
 * @access public
 * @return void
 */
    function testCounterCacheWithNonstandardPrimaryKey() {
        $this->loadFixtures(
			'CounterCacheUserNonstandardPrimaryKey',
			'CounterCachePostNonstandardPrimaryKey'
		);

        $User = new CounterCacheUserNonstandardPrimaryKey();
        $Post = new CounterCachePostNonstandardPrimaryKey();

		$data = $Post->find('first', array(
			'conditions' => array('pid' => 1),
			'recursive' => -1
		));
		$data[$Post->alias]['uid'] = 301;
		$Post->save($data);

		$users = $User->find('all',array('order' => 'User.uid'));
		$this->assertEqual($users[0]['User']['post_count'], 1);
		$this->assertEqual($users[1]['User']['post_count'], 2);
    }

/**
 * test Counter Cache With Self Joining table
 *
 * @return void
 * @access public
 */
	function testCounterCacheWithSelfJoin() {
		$skip = $this->skipIf(
			($this->db->config['driver'] == 'sqlite'),
			'SQLite 2.x does not support ALTER TABLE ADD COLUMN'
		);
		if ($skip) {
			return;
		}

		$this->loadFixtures('CategoryThread');
		$this->db->query('ALTER TABLE '. $this->db->fullTableName('category_threads') . " ADD COLUMN child_count INTEGER");
		$Category =& new CategoryThread();
		$result = $Category->updateAll(array('CategoryThread.name' => "'updated'"), array('CategoryThread.parent_id' => 5));
		$this->assertTrue($result);

		$Category =& new CategoryThread();
		$Category->belongsTo['ParentCategory']['counterCache'] = 'child_count';
		$Category->updateCounterCache(array('parent_id' => 5));
		$result = Set::extract($Category->find('all', array('conditions' => array('CategoryThread.id' => 5))), '{n}.CategoryThread.child_count');
		$expected = array_fill(0, 1, 1);
		$this->assertEqual($result, $expected);
	}
/**
 * testSaveWithCounterCacheScope method
 *
 * @access public
 * @return void
 */
	function testSaveWithCounterCacheScope() {
		$this->loadFixtures('Syfile', 'Item');
		$TestModel =& new Syfile();
		$TestModel2 =& new Item();
		$TestModel2->belongsTo['Syfile']['counterCache'] = true;
		$TestModel2->belongsTo['Syfile']['counterScope'] = array('published' => true);

		$result = $TestModel->findById(1);
		$this->assertIdentical($result['Syfile']['item_count'], null);

		$TestModel2->save(array(
			'name' => 'Item 7',
			'syfile_id' => 1,
			'published'=> true
		));

		$result = $TestModel->findById(1);
		$this->assertIdentical($result['Syfile']['item_count'], '1');

		$TestModel2->id = 1;
		$TestModel2->saveField('published', true);
		$result = $TestModel->findById(1);
		$this->assertIdentical($result['Syfile']['item_count'], '2');

		$TestModel2->save(array(
			'id' => 1,
			'syfile_id' => 1,
			'published'=> false
		));

		$result = $TestModel->findById(1);
		$this->assertIdentical($result['Syfile']['item_count'], '1');
	}
/**
 * testValidatesBackwards method
 *
 * @access public
 * @return void
 */
	function testValidatesBackwards() {
		$TestModel =& new TestValidate();

		$TestModel->validate = array(
			'user_id' => VALID_NUMBER,
			'title' => VALID_NOT_EMPTY,
			'body' => VALID_NOT_EMPTY
		);

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => '',
			'body' => ''
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => 'title',
			'body' => ''
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array(
			'user_id' => '',
			'title' => 'title',
			'body' => 'body'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array(
			'user_id' => 'not a number',
			'title' => 'title',
			'body' => 'body'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => 'title',
			'body' => 'body'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertTrue($result);
	}
/**
 * test that beforeValidate returning false can abort saves.
 *
 * @return void
 **/
	function testBeforeValidateSaveAbortion() {
		$Model =& new CallbackPostTestModel();
		$Model->beforeValidateReturn = false;

		$data = array(
			'title' => 'new article',
			'body' => 'this is some text.'
		);
		$Model->create();
		$result = $Model->save($data);
		$this->assertFalse($result);
	}
/**
 * test that beforeSave returning false can abort saves.
 *
 * @return void
 **/
	function testBeforeSaveSaveAbortion() {
		$Model =& new CallbackPostTestModel();
		$Model->beforeSaveReturn = false;

		$data = array(
			'title' => 'new article',
			'body' => 'this is some text.'
		);
		$Model->create();
		$result = $Model->save($data);
		$this->assertFalse($result);
	}
/**
 * testValidates method
 *
 * @access public
 * @return void
 */
	function testValidates() {
		$TestModel =& new TestValidate();

		$TestModel->validate = array(
			'user_id' => 'numeric',
			'title' => array('allowEmpty' => false, 'rule' => 'notEmpty'),
			'body' => 'notEmpty'
		);

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => '',
			'body' => 'body'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => 'title',
			'body' => 'body'
		));
		$result = $TestModel->create($data) && $TestModel->validates();
		$this->assertTrue($result);

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => '0',
			'body' => 'body'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertTrue($result);

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => 0,
			'body' => 'body'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertTrue($result);

		$TestModel->validate['modified'] = array('allowEmpty' => true, 'rule' => 'date');

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => 0,
			'body' => 'body',
			'modified' => ''
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertTrue($result);

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => 0,
			'body' => 'body',
			'modified' => '2007-05-01'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertTrue($result);

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => 0,
			'body' => 'body',
			'modified' => 'invalid-date-here'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => 0,
			'body' => 'body',
			'modified' => 0
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => 0,
			'body' => 'body',
			'modified' => '0'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$TestModel->validate['modified'] = array('allowEmpty' => false, 'rule' => 'date');

		$data = array('TestValidate' => array('modified' => null));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('modified' => false));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('modified' => ''));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array(
			'modified' => '2007-05-01'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertTrue($result);

		$TestModel->validate['slug'] = array('allowEmpty' => false, 'rule' => array('maxLength', 45));

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => 0,
			'body' => 'body',
			'slug' => ''
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => 0,
			'body' => 'body',
			'slug' => 'slug-right-here'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertTrue($result);

		$data = array('TestValidate' => array(
			'user_id' => '1',
			'title' => 0,
			'body' => 'body',
			'slug' => 'abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$TestModel->validate = array(
			'number' => array(
				'rule' => 'validateNumber',
				'min' => 3,
				'max' => 5
			),
			'title' => array(
				'allowEmpty' => false,
				'rule' => 'notEmpty'
		));

		$data = array('TestValidate' => array(
			'title' => 'title',
			'number' => '0'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array(
			'title' => 'title',
			'number' => 0
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array(
			'title' => 'title',
			'number' => '3'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertTrue($result);

		$data = array('TestValidate' => array(
			'title' => 'title',
			'number' => 3
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertTrue($result);

		$TestModel->validate = array(
			'number' => array(
				'rule' => 'validateNumber',
				'min' => 5,
				'max' => 10
			),
			'title' => array(
				'allowEmpty' => false,
				'rule' => 'notEmpty'
		));

		$data = array('TestValidate' => array(
			'title' => 'title',
			'number' => '3'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array(
			'title' => 'title',
			'number' => 3
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$TestModel->validate = array(
			'title' => array(
				'allowEmpty' => false,
				'rule' => 'validateTitle'
		));

		$data = array('TestValidate' => array('title' => ''));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('title' => 'new title'));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array('title' => 'title-new'));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertTrue($result);

		$TestModel->validate = array('title' => array(
			'allowEmpty' => true,
			'rule' => 'validateTitle'
		));
		$data = array('TestValidate' => array('title' => ''));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertTrue($result);

		$TestModel->validate = array(
			'title' => array(
				'length' => array(
					'allowEmpty' => true,
					'rule' => array('maxLength', 10)
		)));
		$data = array('TestValidate' => array('title' => ''));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertTrue($result);

		$TestModel->validate = array(
			'title' => array(
				'rule' => array('userDefined', 'Article', 'titleDuplicate')
		));
		$data = array('TestValidate' => array('title' => 'My Article Title'));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertFalse($result);

		$data = array('TestValidate' => array(
			'title' => 'My Article With a Different Title'
		));
		$result = $TestModel->create($data);
		$this->assertTrue($result);
		$result = $TestModel->validates();
		$this->assertTrue($result);

		$TestModel->validate = array(
			'title' => array(
				'tooShort' => array('rule' => array('minLength', 50)),
				'onlyLetters' => array('rule' => '/^[a-z]+$/i')
			),
		);
		$data = array('TestValidate' => array(
			'title' => 'I am a short string'
		));
		$TestModel->create($data);
		$result = $TestModel->validates();
		$this->assertFalse($result);
		$result = $TestModel->validationErrors;
		$expected = array(
			'title' => 'onlyLetters'
		);
		$this->assertEqual($result, $expected);

		$TestModel->validate = array(
			'title' => array(
				'tooShort' => array(
					'rule' => array('minLength', 50),
					'last' => true
				),
				'onlyLetters' => array('rule' => '/^[a-z]+$/i')
			),
		);
		$data = array('TestValidate' => array(
			'title' => 'I am a short string'
		));
		$TestModel->create($data);
		$result = $TestModel->validates();
		$this->assertFalse($result);
		$result = $TestModel->validationErrors;
		$expected = array(
			'title' => 'tooShort'
		);
		$this->assertEqual($result, $expected);
	}
/**
 * testSaveField method
 *
 * @access public
 * @return void
 */
	function testSaveField() {
		$this->loadFixtures('Article');
		$TestModel =& new Article();

		$TestModel->id = 1;
		$result = $TestModel->saveField('title', 'New First Article');
		$this->assertTrue($result);

		$TestModel->recursive = -1;
		$result = $TestModel->read(array('id', 'user_id', 'title', 'body'), 1);
		$expected = array('Article' => array(
			'id' => '1',
			'user_id' => '1',
			'title' => 'New First Article',
			'body' => 'First Article Body'
		));
		$this->assertEqual($result, $expected);

		$TestModel->id = 1;
		$result = $TestModel->saveField('title', '');
		$this->assertTrue($result);

		$TestModel->recursive = -1;
		$result = $TestModel->read(array('id', 'user_id', 'title', 'body'), 1);
		$expected = array('Article' => array(
			'id' => '1',
			'user_id' => '1',
			'title' => '',
			'body' => 'First Article Body'
		));
		$result['Article']['title'] = trim($result['Article']['title']);
		$this->assertEqual($result, $expected);

		$TestModel->id = 1;
		$TestModel->set('body', 'Messed up data');
		$this->assertTrue($TestModel->saveField('title', 'First Article'));
		$result = $TestModel->read(array('id', 'user_id', 'title', 'body'), 1);
		$expected = array('Article' => array(
			'id' => '1',
			'user_id' => '1',
			'title' => 'First Article',
			'body' => 'First Article Body'
		));
		$this->assertEqual($result, $expected);

		$TestModel->recursive = -1;
		$result = $TestModel->read(array('id', 'user_id', 'title', 'body'), 1);

		$TestModel->id = 1;
		$result = $TestModel->saveField('title', '', true);
		$this->assertFalse($result);

		$this->loadFixtures('Node', 'Dependency');
		$Node =& new Node();
		$Node->set('id', 1);
		$result = $Node->read();
		$this->assertEqual(Set::extract('/ParentNode/name', $result), array('Second'));

		$Node->saveField('state', 10);
		$result = $Node->read();
		$this->assertEqual(Set::extract('/ParentNode/name', $result), array('Second'));
	}
/**
 * testSaveWithCreate method
 *
 * @access public
 * @return void
 */
	function testSaveWithCreate() {
		$this->loadFixtures(
			'User',
			'Article',
			'User',
			'Comment',
			'Tag',
			'ArticlesTag',
			'Attachment'
		);
		$TestModel =& new User();

		$data = array('User' => array(
			'user' => 'user',
			'password' => ''
		));
		$result = $TestModel->save($data);
		$this->assertFalse($result);
		$this->assertTrue(!empty($TestModel->validationErrors));

		$TestModel =& new Article();

		$data = array('Article' => array(
			'user_id' => '',
			'title' => '',
			'body' => ''
		));
		$result = $TestModel->create($data) && $TestModel->save();
		$this->assertFalse($result);
		$this->assertTrue(!empty($TestModel->validationErrors));

		$data = array('Article' => array(
			'id' => 1,
			'user_id' => '1',
			'title' => 'New First Article',
			'body' => ''
		));
		$result = $TestModel->create($data) && $TestModel->save();
		$this->assertFalse($result);

		$data = array('Article' => array(
			'id' => 1,
			'title' => 'New First Article'
		));
		$result = $TestModel->create() && $TestModel->save($data, false);
		$this->assertTrue($result);

		$TestModel->recursive = -1;
		$result = $TestModel->read(array('id', 'user_id', 'title', 'body', 'published'), 1);
		$expected = array('Article' => array(
			'id' => '1',
			'user_id' => '1',
			'title' => 'New First Article',
			'body' => 'First Article Body',
			'published' => 'N'
		));
		$this->assertEqual($result, $expected);

		$data = array('Article' => array(
			'id' => 1,
			'user_id' => '2',
			'title' => 'First Article',
			'body' => 'New First Article Body',
			'published' => 'Y'
		));
		$result = $TestModel->create() && $TestModel->save($data, true, array('id', 'title', 'published'));
		$this->assertTrue($result);

		$TestModel->recursive = -1;
		$result = $TestModel->read(array('id', 'user_id', 'title', 'body', 'published'), 1);
		$expected = array('Article' => array(
			'id' => '1',
			'user_id' => '1',
			'title' => 'First Article',
			'body' => 'First Article Body',
			'published' => 'Y'
		));
		$this->assertEqual($result, $expected);

		$data = array(
			'Article' => array(
				'user_id' => '2',
				'title' => 'New Article',
				'body' => 'New Article Body',
				'created' => '2007-03-18 14:55:23',
				'updated' => '2007-03-18 14:57:31'
			),
			'Tag' => array('Tag' => array(1, 3))
		);
		$TestModel->create();
		$result = $TestModel->create() && $TestModel->save($data);
		$this->assertTrue($result);

		$TestModel->recursive = 2;
		$result = $TestModel->read(null, 4);
		$expected = array(
			'Article' => array(
				'id' => '4',
				'user_id' => '2',
				'title' => 'New Article',
				'body' => 'New Article Body',
				'published' => 'N',
				'created' => '2007-03-18 14:55:23',
				'updated' => '2007-03-18 14:57:31'
			),
			'User' => array(
				'id' => '2',
				'user' => 'nate',
				'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
				'created' => '2007-03-17 01:18:23',
				'updated' => '2007-03-17 01:20:31'
			),
			'Comment' => array(),
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
		)));
		$this->assertEqual($result, $expected);

		$data = array('Comment' => array(
			'article_id' => '4',
			'user_id' => '1',
			'comment' => 'Comment New Article',
			'published' => 'Y',
			'created' => '2007-03-18 14:57:23',
			'updated' => '2007-03-18 14:59:31'
		));
		$result = $TestModel->Comment->create() && $TestModel->Comment->save($data);
		$this->assertTrue($result);

		$data = array('Attachment' => array(
			'comment_id' => '7',
			'attachment' => 'newattachment.zip',
			'c