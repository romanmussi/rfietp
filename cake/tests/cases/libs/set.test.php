<?php
/* SVN FILE: $Id$ */
/**
 * SetTest file
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
 * @subpackage    cake.tests.cases.libs
 * @since         CakePHP(tm) v 1.2.0.4206
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
App::import('Core', 'Set');
/**
 * SetTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs
 */
class SetTest extends CakeTestCase {
/**
 * testNumericKeyExtraction method
 *
 * @access public
 * @return void
 */
	function testNumericKeyExtraction() {
		$data = array('plugin' => null, 'controller' => '', 'action' => '', 1, 'whatever');
		$this->assertIdentical(Set::extract($data, '{n}'), array(1, 'whatever'));
		$this->assertIdentical(Set::diff($data, Set::extract($data, '{n}')), array('plugin' => null, 'controller' => '', 'action' => ''));
	}
/**
 * testEnum method
 *
 * @access public
 * @return void
 */
	function testEnum() {
		$result = Set::enum(1, 'one, two');
		$this->assertIdentical($result, 'two');
		$result = Set::enum(2, 'one, two');
		$this->assertNull($result);

		$set = array('one', 'two');
		$result = Set::enum(0, $set);
		$this->assertIdentical($result, 'one');
		$result = Set::enum(1, $set);
		$this->assertIdentical($result, 'two');

		$result = Set::enum(1, array('one', 'two'));
		$this->assertIdentical($result, 'two');
		$result = Set::enum(2, array('one', 'two'));
		$this->assertNull($result);

		$result = Set::enum('first', array('first' => 'one', 'second' => 'two'));
		$this->assertIdentical($result, 'one');
		$result = Set::enum('third', array('first' => 'one', 'second' => 'two'));
		$this->assertNull($result);

		$result = Set::enum('no', array('no' => 0, 'yes' => 1));
		$this->assertIdentical($result, 0);
		$result = Set::enum('not sure', array('no' => 0, 'yes' => 1));
		$this->assertNull($result);

		$result = Set::enum(0);
		$this->assertIdentical($result, 'no');
		$result = Set::enum(1);
		$this->assertIdentical($result, 'yes');
		$result = Set::enum(2);
		$this->assertNull($result);
	}
/**
 * testFilter method
 *
 * @access public
 * @return void
 */
	function testFilter() {
		$result = Set::filter(array('0', false, true, 0, array('one thing', 'I can tell you', 'is you got to be', false)));
		$expected = array('0', 2 => true, 3 => 0, 4 => array('one thing', 'I can tell you', 'is you got to be', false));
		$this->assertIdentical($result, $expected);
	}
/**
 * testNumericArrayCheck method
 *
 * @access public
 * @return void
 */
	function testNumericArrayCheck() {
		$data = array('one');
		$this->assertTrue(Set::numeric(array_keys($data)));

		$data = array(1 => 'one');
		$this->assertFalse(Set::numeric($data));

		$data = array('one');
		$this->assertFalse(Set::numeric($data));

		$data = array('one' => 'two');
		$this->assertFalse(Set::numeric($data));

		$data = array('one' => 1);
		$this->assertTrue(Set::numeric($data));

		$data = array(0);
		$this->assertTrue(Set::numeric($data));

		$data = array('one', 'two', 'three', 'four', 'five');
		$this->assertTrue(Set::numeric(array_keys($data)));

		$data = array(1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five');
		$this->assertTrue(Set::numeric(array_keys($data)));

		$data = array('1' => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five');
		$this->assertTrue(Set::numeric(array_keys($data)));

		$data = array('one', 2 => 'two', 3 => 'three', 4 => 'four', 'a' => 'five');
		$this->assertFalse(Set::numeric(array_keys($data)));
	}
/**
 * testKeyCheck method
 *
 * @access public
 * @return void
 */
	function testKeyCheck() {
		$data = array('Multi' => array('dimensonal' => array('array')));
		$this->assertTrue(Set::check($data, 'Multi.dimensonal'));
		$this->assertFalse(Set::check($data, 'Multi.dimensonal.array'));

		$data = array(
			array(
				'Article' => array('id' => '1', 'user_id' => '1', 'title' => 'First Article', 'body' => 'First Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'),
				'User' => array('id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(
					array('id' => '1', 'article_id' => '1', 'user_id' => '2', 'comment' => 'First Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:45:23', 'updated' => '2007-03-18 10:47:31'),
					array('id' => '2', 'article_id' => '1', 'user_id' => '4', 'comment' => 'Second Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:47:23', 'updated' => '2007-03-18 10:49:31'),
				),
				'Tag' => array(
					array('id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
					array('id' => '2', 'tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31')
				)
			),
			array(
				'Article' => array('id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31'),
				'User' => array('id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(),
				'Tag' => array()
			)
		);
		$this->assertTrue(Set::check($data, '0.Article.user_id'));
		$this->assertTrue(Set::check($data, '0.Comment.0.id'));
		$this->assertFalse(Set::check($data, '0.Comment.0.id.0'));
		$this->assertTrue(Set::check($data, '0.Article.user_id'));
		$this->assertFalse(Set::check($data, '0.Article.user_id.a'));
	}
/**
 * testMerge method
 *
 * @access public
 * @return void
 */
	function testMerge() {
		$r = Set::merge(array('foo'));
		$this->assertIdentical($r, array('foo'));

		$r = Set::merge('foo');
		$this->assertIdentical($r, array('foo'));

		$r = Set::merge('foo', 'bar');
		$this->assertIdentical($r, array('foo', 'bar'));

		if (substr(PHP_VERSION, 0, 1) >= 5) {
			$r = eval('class StaticSetCaller{static function merge($a, $b){return Set::merge($a, $b);}} return StaticSetCaller::merge("foo", "bar");');
			$this->assertIdentical($r, array('foo', 'bar'));
		}

		$r = Set::merge('foo', array('user' => 'bob', 'no-bar'), 'bar');
		$this->assertIdentical($r, array('foo', 'user' => 'bob', 'no-bar', 'bar'));

		$a = array('foo', 'foo2');
		$b = array('bar', 'bar2');
		$this->assertIdentical(Set::merge($a, $b), array('foo', 'foo2', 'bar', 'bar2'));

		$a = array('foo' => 'bar', 'bar' => 'foo');
		$b = array('foo' => 'no-bar', 'bar' => 'no-foo');
		$this->assertIdentical(Set::merge($a, $b), array('foo' => 'no-bar', 'bar' => 'no-foo'));

		$a = array('users' => array('bob', 'jim'));
		$b = array('users' => array('lisa', 'tina'));
		$this->assertIdentical(Set::merge($a, $b), array('users' => array('bob', 'jim', 'lisa', 'tina')));

		$a = array('users' => array('jim', 'bob'));
		$b = array('users' => 'none');
		$this->assertIdentical(Set::merge($a, $b), array('users' => 'none'));

		$a = array('users' => array('lisa' => array('id' => 5, 'pw' => 'secret')), 'cakephp');
		$b = array('users' => array('lisa' => array('pw' => 'new-pass', 'age' => 23)), 'ice-cream');
		$this->assertIdentical(Set::merge($a, $b), array('users' => array('lisa' => array('id' => 5, 'pw' => 'new-pass', 'age' => 23)), 'cakephp', 'ice-cream'));

		$c = array('users' => array('lisa' => array('pw' => 'you-will-never-guess', 'age' => 25, 'pet' => 'dog')), 'chocolate');
		$expected = array('users' => array('lisa' => array('id' => 5, 'pw' => 'you-will-never-guess', 'age' => 25, 'pet' => 'dog')), 'cakephp', 'ice-cream', 'chocolate');
		$this->assertIdentical(Set::merge($a, $b, $c), $expected);

		$this->assertIdentical(Set::merge($a, $b, array(), $c), $expected);

		$r = Set::merge($a, $b, $c);
		$this->assertIdentical($r, $expected);

		$a = array('Tree', 'CounterCache',
				'Upload' => array('folder' => 'products',
					'fields' => array('image_1_id', 'image_2_id', 'image_3_id', 'image_4_id', 'image_5_id')));
		$b =  array('Cacheable' => array('enabled' => false),
				'Limit',
				'Bindable',
				'Validator',
				'Transactional');

		$expected = array('Tree', 'CounterCache',
				'Upload' => array('folder' => 'products',
					'fields' => array('image_1_id', 'image_2_id', 'image_3_id', 'image_4_id', 'image_5_id')),
				'Cacheable' => array('enabled' => false),
				'Limit',
				'Bindable',
				'Validator',
				'Transactional');

		$this->assertIdentical(Set::merge($a, $b), $expected);

		$expected = array('Tree' => null, 'CounterCache' => null,
				'Upload' => array('folder' => 'products',
					'fields' => array('image_1_id', 'image_2_id', 'image_3_id', 'image_4_id', 'image_5_id')),
				'Cacheable' => array('enabled' => false),
				'Limit' => null,
				'Bindable' => null,
				'Validator' => null,
				'Transactional' => null);

		$this->assertIdentical(Set::normalize(Set::merge($a, $b)), $expected);
	}
/**
 * testSort method
 *
 * @access public
 * @return void
 */
	function testSort() {
		$a = array(
			0 => array('Person' => array('name' => 'Jeff'), 'Friend' => array(array('name' => 'Nate'))),
			1 => array('Person' => array('name' => 'Tracy'),'Friend' => array(array('name' => 'Lindsay')))
		);
		$b = array(
			0 => array('Person' => array('name' => 'Tracy'),'Friend' => array(array('name' => 'Lindsay'))),
			1 => array('Person' => array('name' => 'Jeff'), 'Friend' => array(array('name' => 'Nate')))

		);
		$a = Set::sort($a, '{n}.Friend.{n}.name', 'asc');
		$this->assertIdentical($a, $b);

		$b = array(
			0 => array('Person' => array('name' => 'Jeff'), 'Friend' => array(array('name' => 'Nate'))),
			1 => array('Person' => array('name' => 'Tracy'),'Friend' => array(array('name' => 'Lindsay')))
		);
		$a = array(
			0 => array('Person' => array('name' => 'Tracy'),'Friend' => array(array('name' => 'Lindsay'))),
			1 => array('Person' => array('name' => 'Jeff'), 'Friend' => array(array('name' => 'Nate')))

		);
		$a = Set::sort($a, '{n}.Friend.{n}.name', 'desc');
		$this->assertIdentical($a, $b);

		$a = array(
			0 => array('Person' => array('name' => 'Jeff'), 'Friend' => array(array('name' => 'Nate'))),
			1 => array('Person' => array('name' => 'Tracy'),'Friend' => array(array('name' => 'Lindsay'))),
			2 => array('Person' => array('name' => 'Adam'),'Friend' => array(array('name' => 'Bob')))
		);
		$b = array(
			0 => array('Person' => array('name' => 'Adam'),'Friend' => array(array('name' => 'Bob'))),
			1 => array('Person' => array('name' => 'Jeff'), 'Friend' => array(array('name' => 'Nate'))),
			2 => array('Person' => array('name' => 'Tracy'),'Friend' => array(array('name' => 'Lindsay')))
		);
		$a = Set::sort($a, '{n}.Person.name', 'asc');
		$this->assertIdentical($a, $b);

		$a = array(
			array(7,6,4),
			array(3,4,5),
			array(3,2,1),
		);

		$b = array(
			array(3,2,1),
			array(3,4,5),
			array(7,6,4),
		);

		$a = Set::sort($a, '{n}.{n}', 'asc');
		$this->assertIdentical($a, $b);

		$a = array(
			array(7,6,4),
			array(3,4,5),
			array(3,2,array(1,1,1)),
		);

		$b = array(
			array(3,2,array(1,1,1)),
			array(3,4,5),
			array(7,6,4),
		);

		$a = Set::sort($a, '{n}', 'asc');
		$this->assertIdentical($a, $b);

		$a = array(
			0 => array('Person' => array('name' => 'Jeff')),
			1 => array('Shirt' => array('color' => 'black'))
		);
		$b = array(
			0 => array('Shirt' => array('color' => 'black')),
			1 => array('Person' => array('name' => 'Jeff')),
		);
		$a = Set::sort($a, '{n}.Person.name', 'ASC');
		$this->assertIdentical($a, $b);

		$names = array(
			array('employees' => array(array('name' => array('first' => 'John', 'last' => 'Doe')))),
			array('employees' => array(array('name' => array('first' => 'Jane', 'last' => 'Doe')))),
			array('employees' => array(array('name' => array()))),
			array('employees' => array(array('name' => array())))
		);
		$result = Set::sort($names, '{n}.employees.0.name', 'asc', 1);
		$expected = array(
			array('employees' => array(array('name' => array('first' => 'John', 'last' => 'Doe')))),
			array('employees' => array(array('name' => array('first' => 'Jane', 'last' => 'Doe')))),
			array('employees' => array(array('name' => array()))),
			array('employees' => array(array('name' => array())))
		);
		$this->assertEqual($result, $expected);
	}
/**
 * testExtract method
 *
 * @access public
 * @return void
 */
	function testExtract() {
		$a = array(
			array(
				'Article' => array('id' => '1', 'user_id' => '1', 'title' => 'First Article', 'body' => 'First Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:39:23', 'updated' => '2007-03-18 10:41:31'),
				'User' => array('id' => '1', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(
					array('id' => '1', 'article_id' => '1', 'user_id' => '2', 'comment' => 'First Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:45:23', 'updated' => '2007-03-18 10:47:31'),
					array('id' => '2', 'article_id' => '1', 'user_id' => '4', 'comment' => 'Second Comment for First Article', 'published' => 'Y', 'created' => '2007-03-18 10:47:23', 'updated' => '2007-03-18 10:49:31'),
				),
				'Tag' => array(
					array('id' => '1', 'tag' => 'tag1', 'created' => '2007-03-18 12:22:23', 'updated' => '2007-03-18 12:24:31'),
					array('id' => '2', 'tag' => 'tag2', 'created' => '2007-03-18 12:24:23', 'updated' => '2007-03-18 12:26:31')
				),
				'Deep' => array(
					'Nesting' => array(
						'test' => array(
							1 => 'foo',
							2 => array(
								'and' => array('more' => 'stuff')
							)
						)
					)
				)
			),
			array(
				'Article' => array('id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31'),
				'User' => array('id' => '2', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(),
				'Tag' => array()
			),
			array(
				'Article' => array('id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31'),
				'User' => array('id' => '3', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(),
				'Tag' => array()
			),
			array(
				'Article' => array('id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31'),
				'User' => array('id' => '4', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(),
				'Tag' => array()
			),
			array(
				'Article' => array('id' => '3', 'user_id' => '1', 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created' => '2007-03-18 10:43:23', 'updated' => '2007-03-18 10:45:31'),
				'User' => array('id' => '5', 'user' => 'mariano', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'created' => '2007-03-17 01:16:23', 'updated' => '2007-03-17 01:18:31'),
				'Comment' => array(),
				'Tag' => array()
			)
		);
		$b = array('Deep' => $a[0]['Deep']);
		$c = array(
			array('a' => array('I' => array('a' => 1))),
			array(
				'a' => array(
					2
				)
			),
			array('a' => array('II' => array('a' => 3, 'III' => array('a' => array('foo' => 4))))),
		);

		$expected = array(array('a' => $c[2]['a']));
		$r = Set::extract('/a/II[a=3]/..', $c);
		$this->assertEqual($r, $expected);

		$expected = array(1, 2, 3, 4, 5);
		$this->assertEqual(Set::extract('/User/id', $a), $expected);

		$expected = array(1, 2, 3, 4, 5);
		$this->assertEqual(Set::extract('/User/id', $a), $expected);

		$expected = array(
			array('id' => 1), array('id' => 2), array('id' => 3), array('id' => 4), array('id' => 5)
		);

		$r = Set::extract('/User/id', $a, array('flatten' => false));
		$this->assertEqual($r, $expected);

		$expected = array(array('test' => $a[0]['Deep']['Nesting']['test']));
		$this->assertEqual(Set::extract('/Deep/Nesting/test', $a), $expected);
		$this->assertEqual(Set::extract('/Deep/Nesting/test', $b), $expected);

		$expected = array(array('test' => $a[0]['Deep']['Nesting']['test']));
		$r = Set::extract('/Deep/Nesting/test/1/..', $a);
		$this->assertEqual($r, $expected);

		$expected = array(array('test' => $a[0]['Deep']['Nesting']['test']));
		$r = Set::extract('/Deep/Nesting/test/2/and/../..', $a);
		$this->assertEqual($r, $expected);

		$expected = array(array('test' => $a[0]['Deep']['Nesting']['test']));
		$r = Set::extract('/Deep/Nesting/test/2/../../../Nesting/test/2/..', $a);
		$this->assertEqual($r, $expected);

		$expected = array(2);
		$r = Set::extract('/User[2]/id', $a);
		$this->assertEqual($r, $expected);

		$expected = array(4, 5);
		$r = Set::extract('/User[id>3]/id', $a);
		$this->assertEqual($r, $expected);

		$expected = array(2, 3);
		$r = Set::extract('/User[id>1][id<=3]/id', $a);
		$this->assertEqual($r, $expected);

		$expected = array(array('I'), array('II'));
		$r = Set::extract('/a/@*', $c);
		$this->assertEqual($r, $expected);

		$single = array(
			'User' => array(
				'id' => 4,
				'name' => 'Neo',
			)
		);
		$tricky = array(
			0 => array(
				'User' => array(
					'id' => 1,
					'name' => 'John',
				)
			),
			1 => array(
				'User' => array(
					'id' => 2,
					'name' => 'Bob',
				)
			),
			2 => array(
				'User' => array(
					'id' => 3,
					'name' => 'Tony',
				)
			),
			'User' => array(
				'id' => 4,
				'name' => 'Neo',
			)
		);

		$expected = array(1, 2, 3, 4);
		$r = Set::extract('/User/id', $tricky);
		$this->assertEqual($r, $expected);

		$expected = array(4);
		$r = Set::extract('/User/id', $single);
		$this->assertEqual($r, $expected);

		$expected = array(1, 3);
		$r = Set::extract('/User[name=/n/]/id', $tricky);
		$this->assertEqual($r, $expected);

		$expected = array(4);
		$r = Set::extract('/User[name=/N/]/id', $tricky);
		$this->assertEqual($r, $expected);

		$expected = array(1, 3, 4);
		$r = Set::extract('/User[name=/N/i]/id', $tricky);
		$this->assertEqual($r, $expected);

		$expected = array(array('id', 'name'), array('id', 'name'), array('id', 'name'), array('id', 'name'));
		$r = Set::extract('/User/@*', $tricky);
		$this->assertEqual($r, $expected);

		$common = array(
			array(
				'Article' => array(
					'id' => 1,
					'name' => 'Article 1',
				),
				'Comment' => array(
					array(
						'id' => 1,
						'user_id' => 5,
						'article_id' => 1,
						'text' => 'Comment 1',
					),
					array(
						'id' => 2,
						'user_id' => 23,
						'article_id' => 1,
						'text' => 'Comment 2',
					),
					array(
						'id' => 3,
						'user_id' => 17,
						'article_id' => 1,
						'text' => 'Comment 3',
					),
				),
			),
			array(
				'Article' => array(
					'id' => 2,
					'name' => 'Article 2',
				),
				'Comment' => array(
					array(
						'id' => 4,
						'user_id' => 2,
						'article_id' => 2,
						'text' => 'Comment 4',
						'addition' => '',
					),
					array(
						'id' => 5,
						'user_id' => 23,
						'article_id' => 2,
						'text' => 'Comment 5',
						'addition' => 'foo',
					),
				),
			),
			array(
				'Article' => array(
					'id' => 3,
					'name' => 'Article 3',
				),
				'Comment' => array(),
			)
		);

		$r = Set::extract('/Comment/id', $common);
		$expected = array(1, 2, 3, 4, 5);
		$this->assertEqual($r, $expected);

		$expected = array(1, 2, 4, 5);
		$r = Set::extract('/Comment[id!=3]/id', $common);
		$this->assertEqual($r, $expected);

		$r = Set::extract('/', $common);
		$this->assertEqual($r, $common);

		$expected = array(1, 2, 4, 5);
		$r = Set::extract($common, '/Comment[id!=3]/id');
		$this->assertEqual($r, $expected);

		$expected = array($common[0]['Comment'][2]);
		$r = Set::extract($common, '/Comment/2');
		$this->assertEqual($r, $expected);

		$expected = array($common[0]['Comment'][0]);
		$r = Set::extract($common, '/Comment[1]/.[id=1]');
		$this->assertEqual($r, $expected);

		$expected = array($common[1]['Comment'][1]);
		$r = Set::extract($common, '/1/Comment/.[2]');
		$this->assertEqual($r, $expected);

		$expected = array();
		$r = Set::extract('/User/id', array());
		$this->assertEqual($r, $expected);

		$expected = array(5);
		$r = Set::extract('/Comment/id[:last]', $common);
		$this->assertEqual($r, $expected);

		$expected = array(1);
		$r = Set::extract('/Comment/id[:first]', $common);
		$this->assertEqual($r, $expected);

		$expected = array(3);
		$r = Set::extract('/Article[:last]/id', $common);
		$this->assertEqual($r, $expected);

		$expected = array(array('Comment' => $common[1]['Comment'][0]));
		$r = Set::extract('/Comment[addition=]', $common);
		$this->assertEqual($r, $expected);

		$habtm = array(
			array(
				'Post' => array(
					'id' => 1,
					'title' => 'great post',
				),
				'Comment' => array(
					array(
						'id' => 1,
						'text' => 'foo',
						'User' => array(
							'id' => 1,
							'name' => 'bob'
						),
					),
					array(
						'id' => 2,
						'text' => 'bar',
						'User' => array(
							'id' => 2,
							'name' => 'tod'
						),
					),
				),
			),
			array(
				'Post' => array(
					'id' => 2,
					'title' => 'fun post',
				),
				'Comment' => array(
					array(
						'id' => 3,
						'text' => '123',
						'User' => array(
							'id' => 3,
							'name' => 'dan'
						),
					),
					array(
						'id' => 4,
						'text' => '987',
						'User' => array(
							'id' => 4,
							'name' => 'jim'
						),
					),
				),
			),
		);

		$r = Set::extract('/Comment/User[name=/bob|dan/]/..', $habtm);
		$this->assertEqual($r[0]['Comment']['User']['name'], 'bob');
		$this->assertEqual($r[1]['Comment']['User']['name'], 'dan');
		$this->assertEqual(count($r), 2);

		$r = Set::extract('/Comment/User[name=/bob|tod/]/..', $habtm);
		$this->assertEqual($r[0]['Comment']['User']['name'], 'bob');

		$this->assertEqual($r[1]['Comment']['User']['name'], 'tod');
		$this->assertEqual(count($r), 2);

		$tree = array(
			array(
				'Category' => array('name' => 'Category 1'),
				'children' => array(array('Category' => array('name' => 'Category 1.1')))
			),
			array(
				'Category' => array('name' => 'Category 2'),
				'children' => array(
					array('Category' => array('name' => 'Category 2.1')),
					array('Category' => array('name' => 'Category 2.2'))
				)
			),
			array(
				'Category' => array('name' => 'Category 3'),
				'children' => array(array('Category' => array('name' => 'Category 3.1')))
			)
		);

		$expected = array(array('Category' => $tree[1]['Category']));
		$r = Set::extract('/Category[name=Category 2]', $tree);
		$this->assertEqual($r, $expected);

		$expected = array(
			array('Category' => $tree[1]['Category'], 'children' => $tree[1]['children'])
		);
		$r = Set::extract('/Category[name=Category 2]/..', $tree);
		$this->assertEqual($r, $expected);

		$expected = array(
			array('children' => $tree[1]['children'][0]),
			array('children' => $tree[1]['children'][1])
		);
		$r = Set::extract('/Category[name=Category 2]/../children', $tree);
		$this->assertEqual($r, $expected);

		$habtm = array(
			array(
				'Post' => array(
					'id' => 1,
					'title' => 'great post',
				),
				'Comment' => array(
					array(
						'id' => 1,
						'text' => 'foo',
						'User' => array(
							'id' => 1,
							'name' => 'bob'
						),
					),
					array(
						'id' => 2,
						'text' => 'bar',
						'User' => array(
							'id' => 2,
							'name' => 'tod'
						),
					),
				),
			),
			array(
				'Post' => array(
					'id' => 2,
					'title' => 'fun post',
				),
				'Comment' => array(
					array(
						'id' => 3,
						'text' => '123',
						'User' => array(
							'id' => 3,
							'name' => 'dan'
						),
					),
					array(
						'id' => 4,
						'text' => '987',
						'User' => array(
							'id' => 4,
							'name' => 'jim'
						),
					),
				),
			),
		);

		$r = Set::extract('/Comment/User[name=/\w+/]/..', $habtm);
		$this->assertEqual($r[0]['Comment']['User']['name'], 'bob');
		$this->assertEqual($r[1]['Comment']['User']['name'], 'tod');
		$this->assertEqual($r[2]['Comment']['User']['name'], 'dan');
		$this->assertEqual($r[3]['Comment']['User']['name'], 'dan');
		$this->assertEqual(count($r), 4);

		$r = Set::extract('/Comment/User[name=/[a-z]+/]/..', $habtm);
		$this->assertEqual($r[0]['Comment']['User']['name'], 'bob');
		$this->assertEqual($r[1]['Comment']['User']['name'], 'tod');
		$this->assertEqual($r[2]['Comment']['User']['name'], 'dan');
		$this->assertEqual($r[3]['Comment']['User']['name'], 'dan');
		$this->assertEqual(count($r), 4);

		$r = Set::extract('/Comment/User[name=/bob|dan/]/..', $habtm);
		$this->assertEqual($r[0]['Comment']['User']['name'], 'bob');
		$this->assertEqual($r[1]['Comment']['User']['name'], 'dan');
		$this->assertEqual(count($r), 2);

		$r = Set::extract('/Comment/User[name=/bob|tod/]/..', $habtm);
		$this->assertEqual($r[0]['Comment']['User']['name'], 'bob');
		$this->assertEqual($r[1]['Comment']['User']['name'], 'tod');
		$this->assertEqual(count($r), 2);

		$mixedKeys = array(
			'User' => array(
				0 => array(
					'id' => 4,
					'name' => 'Neo'
				),
				1 => array(
					'id' => 5,
					'name' => 'Morpheus'
				),
				'stringKey' => array()
			)
		);
		$expected = array('Neo', 'Morpheus');
		$r = Set::extract('/User/name', $mixedKeys);
		$this->assertEqual($r, $expected);

		$f = array(
			array(
				'file' => array(
					'name' => 'zipfile.zip',
					'type' => 'application/zip',
					'tmp_name' => '/tmp/php178.tmp',
					'error' => 0,
					'size' => '564647'
				)
			),
			array(
				'file' => array(
					'name' => 'zipfile2.zip',
					'type' => 'application/x-zip-compressed',
					'tmp_name' => '/tmp/php179.tmp',
					'error' => 0,
					'size' => '354784'
				)
			),
			array(
				'file' => array(
					'name' => 'picture.jpg',
					'type' => 'image/jpeg',
					'tmp_name' => '/tmp/php180.tmp',
					'error' => 0,
					'size' => '21324'
				)
			)
		);
		$expected = array(array('name' => 'zipfile2.zip','type' => 'application/x-zip-compressed','tmp_name' => '/tmp/php179.tmp','error' => 0,'size' => '354784'));
		$r = Set::extract('/file/.[type=application/x-zip-compressed]', $f);
		$this->assertEqual($r, $expected);

		$expected = array(array('name' => 'zipfile.zip','type' => 'application/zip','tmp_name' => '/tmp/php178.tmp','error' => 0,'size' => '564647'));
		$r = Set::extract('/file/.[type=application/zip]', $f);
		$this->assertEqual($r, $expected);

		$f = array(
			array(
				'file' => array(
					'name' => 'zipfile.zip',
					'type' => 'application/zip',
					'tmp_name' => '/tmp/php178.tmp',
					'error' => 0,
					'size' => '564647'
				)
			),
			array(
				'file' => array(
					'name' => 'zipfile2.zip',
					'type' => 'application/x zip compressed',
					'tmp_name' => '/tmp/php179.tmp',
					'error' => 0,
					'size' => '354784'
				)
			),
			array(
				'file' => array(
					'name' => 'picture.jpg',
					'type' => 'image/jpeg',
					'tmp_name' => '/tmp/php180.tmp',
					'error' => 0,
					'size' => '21324'
				)
			)
		);
		$expected = array(array('name' => 'zipfile2.zip','type' => 'application/x zip compressed','tmp_name' => '/tmp/php179.tmp','error' => 0,'size' => '354784'));
		$r = Set::extract('/file/.[type=application/x zip compressed]', $f);
		$this->assertEqual($r, $expected);

		$hasMany = array(
			'Node' => array(
				'id' => 1,
				'name' => 'First',
				'state' => 50
			),
			'ParentNode' => array(
				0 => array(
					'id' => 2,
					'name' => 'Second',
					'state' => 60,
				)
			)
		);
		$result = Set::extract('/ParentNode/name', $hasMany);
		$expected = array('Second');
		$this->assertEqual($result, $expected);
	}
/**
 * test parent selectors with extract
 *
 * @return void
 */
	function testExtractParentSelector() {
		$tree = array(
			array(
				'Category' => array(
					'name' => 'Category 1'
				),
				'children' => array(
					array(
						'Category' => array(
							'name' => 'Category 1.1'
						)
					)
				)
			),
			array(
				'Category' => array(
					'name' => 'Category 2'
				),
				'children' => array(
					array(
						'Category' => array(
							'name' => 'Category 2.1'
						)
					),
					array(
						'Category' => array(
							'name' => 'Category 2.2'
						)
					),
				)
			),
			array(
				'Category' => array(
					'name' => 'Category 3'
				),
				'children' => array(
					array(
						'Category' => array(
							'name' => 'Category 3.1'
						)
					)
				)
			)
		);
		$expected = array(array('Category' => $tree[1]['Category']));
		$r = Set::extract('/Category[name=Category 2]', $tree);
		$this->assertEqual($r, $expected);

		$expected = array(array('Category' => $tree[1]['Category'], 'children' => $tree[1]['children']));
		$r = Set::extract('/Category[name=Category 2]/..', $tree);
		$this->assertEqual($r, $expected);

		$expected = array(array('children' => $tree[1]['children'][0]), array('children' => $tree[1]['children'][1]));
		$r = Set::extract('/Category[name=Category 2]/../children', $tree);
		$this->assertEqual($r, $expected);

		$single = array(
			array(
				'CallType' => array(
					'name' => 'Internal Voice'
				),
				'x' => array(
					'hour' => 7
				)
			)
		);

		$expected = array(7);
		$r = Set::extract('/CallType[name=Internal Voice]/../x/hour', $single);
		$this->assertEqual($r, $expected);

		$multiple = array(
			array(
				'CallType' => array(
					'name' => 'Internal Voice'
				),
				'x' => array(
					'hour' => 7
				)
			),
			array(
				'CallType' => array(
					'name' => 'Internal Voice'
				),
				'x' => array(
					'hour' => 2
				)
			),
			array(
				'CallType' => array(
					'name' => 'Internal Voice'
				),
				'x' => array(
					'hour' => 1
				)
			)
		);

		$expected = array(7,2,1);
		$r = Set::extract('/CallType[name=Internal Voice]/../x/hour', $multiple);
		$this->assertEqual($r, $expected);

		$a = array(
			'Model' => array(
				'0' => array(
					'id' => 18,
					'SubModelsModel' => array(
						'id' => 1,
						'submodel_id' => 66,
						'model_id' => 18,
						'type' => 1
					),
				),
				'1' => array(
					'id' => 0,
					'SubModelsModel' => array(
						'id' => 2,
						'submodel_id' => 66,
						'model_id' => 0,
						'type' => 1
					),
				),
				'2' => array(
					'id' => 17,
					'SubModelsModel' => array(
						'id' => 3,
						'submodel_id' => 66,
						'model_id' => 17,
						'type' => 2
					),
				),
				'3' => array(
					'id' => 0,
					'SubModelsModel' => array(
						'id' => 4,
						'submodel_id' => 66,
						'model_id' => 0,
						'type' => 2
					)
				)
			)
		);

		$expected = array(
			array(
				'Model' => array(
					'id' => 17,
					'SubModelsModel' => array(
						'id' => 3,
						'submodel_id' => 66,
						'model_id' => 17,
						'type' => 2
					),
				)
			),
			array(
				'Model' => array(
					'id' => 0,
					'SubModelsModel' => array(
						'id' => 4,
						'submodel_id' => 66,
						'model_id' => 0,
						'type' => 2
					)
				)
			)
		);
		$r = Set::extract('/Model/SubModelsModel[type=2]/..', $a);
		$this->assertEqual($r, $expected);
	}
/**
 * test that extract() still works when arrays don't contain a 0 index.
 *
 * @return void
 */
	function testExtractWithNonZeroArrays() {
		$nonZero = array(
			1 => array(
				'User' => array(
					'id' => 1,
					'name' => 'John',
				)
			),
			2 => array(
				'User' => array(
					'id' => 2,
					'name' => 'Bob',
				)
			),
			3 => array(
				'User' => array(
					'id' => 3,
					'name' => 'Tony',
				)
			)
		);
		$expected = array(1, 2, 3);
		$r = Set::extract('/User/id', $nonZero);
		$this->assertEqual($r, $expected);
		
		$expected = array(
			array('User' => array('id' => 1, 'name' => 'John')),
			array('User' => array('id' => 2, 'name' => 'Bob')),
			array('User' => array('id' => 3, 'name' => 'Tony')),