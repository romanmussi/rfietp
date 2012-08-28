<?php
/* SVN FILE: $Id$ */
/**
 * DispatcherTest file
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
 * @subpackage    cake.tests.cases
 * @since         CakePHP(tm) v 1.2.0.4206
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
require_once CAKE . 'dispatcher.php';

if (!class_exists('AppController')) {
	require_once LIBS . 'controller' . DS . 'app_controller.php';
} elseif (!defined('APP_CONTROLLER_EXISTS')){
	define('APP_CONTROLLER_EXISTS', true);
}
/**
 * TestDispatcher class
 *
 * @package       cake
 * @subpackage    cake.tests.cases
 */
class TestDispatcher extends Dispatcher {
/**
 * invoke method
 *
 * @param mixed $controller
 * @param mixed $params
 * @param mixed $missingAction
 * @access protected
 * @return void
 */
	function _invoke(&$controller, $params) {
		restore_error_handler();
		if ($result = parent::_invoke($controller, $params)) {
			if ($result[0] === 'missingAction') {
				return $result;
			}
		}
		set_error_handler('simpleTestErrorHandler');

		return $controller;
	}
/**
 * cakeError method
 *
 * @param mixed $filename
 * @access public
 * @return void
 */
	function cakeError($filename, $params) {
		return array($filename, $params);
	}
/**
 * _stop method
 *
 * @access protected
 * @return void
 */
	function _stop() {
		return true;
	}
}
/**
 * MyPluginAppController class
 *
 * @package       cake
 * @subpackage    cake.tests.cases
 */
class MyPluginAppController extends AppController {
}
/**
 * MyPluginController class
 *
 * @package       cake
 * @subpackage    cake.tests.cases
 */
class MyPluginController extends MyPluginAppController {
/**
 * name property
 *
 * @var string 'MyPlugin'
 * @access public
 */
	var $name = 'MyPlugin';
/**
 * uses property
 *
 * @var array
 * @access public
 */
	var $uses = array();
/**
 * index method
 *
 * @access public
 * @return void
 */
	function index() {
		return true;
	}
/**
 * add method
 *
 * @access public
 * @return void
 */
	function add() {
		return true;
	}
/**
 * admin_add method
 *
 * @param mixed $id
 * @access public
 * @return void
 */
	function admin_add($id = null) {
		return $id;
	}
}
/**
 * SomePagesController class
 *
 * @package       cake
 * @subpackage    cake.tests.cases
 */
class SomePagesController extends AppController {
/**
 * name property
 *
 * @var string 'SomePages'
 * @access public
 */
	var $name = 'SomePages';
/**
 * uses property
 *
 * @var array
 * @access public
 */
	var $uses = array();
/**
 * display method
 *
 * @param mixed $page
 * @access public
 * @return void
 */
	function display($page = null) {
		return $page;
	}
/**
 * index method
 *
 * @access public
 * @return void
 */
	function index() {
		return true;
	}
/**
 * protected method
 *
 * @access protected
 * @return void
 */
	function _protected() {
		return true;
	}
/**
 * redirect method overriding
 *
 * @access public
 * @return void
 */
	function redirect() {
		echo 'this should not be accessible';
	}
}
/**
 * OtherPagesController class
 *
 * @package       cake
 * @subpackage    cake.tests.cases
 */
class OtherPagesController extends MyPluginAppController {
/**
 * name property
 *
 * @var string 'OtherPages'
 * @access public
 */
	var $name = 'OtherPages';
/**
 * uses property
 *
 * @var array
 * @access public
 */
	var $uses = array();
/**
 * display method
 *
 * @param mixed $page
 * @access public
 * @return void
 */
	function display($page = null) {
		return $page;
	}
/**
 * index method
 *
 * @access public
 * @return void
 */
	function index() {
		return true;
	}
}
/**
 * TestDispatchPagesController class
 *
 * @package       cake
 * @subpackage    cake.tests.cases
 */
class TestDispatchPagesController extends AppController {
/**
 * name property
 *
 * @var string 'TestDispatchPages'
 * @access public
 */
	var $name = 'TestDispatchPages';
/**
 * uses property
 *
 * @var array
 * @access public
 */
	var $uses = array();
/**
 * admin_index method
 *
 * @access public
 * @return void
 */
	function admin_index() {
		return true;
	}
/**
 * camelCased method
 *
 * @access public
 * @return void
 */
	function camelCased() {
		return true;
	}
}
/**
 * ArticlesTestAppController class
 *
 * @package       cake
 * @subpackage    cake.tests.cases
 */
class ArticlesTestAppController extends AppController {
}
/**
 * ArticlesTestController class
 *
 * @package       cake
 * @subpackage    cake.tests.cases
 */
class ArticlesTestController extends ArticlesTestAppController {
/**
 * name property
 *
 * @var string 'ArticlesTest'
 * @access public
 */
	var $name = 'ArticlesTest';
/**
 * uses property
 *
 * @var array
 * @access public
 */
	var $uses = array();
/**
 * admin_index method
 *
 * @access public
 * @return void
 */
	function admin_index() {
		return true;
	}
}
/**
 * SomePostsController class
 *
 * @package       cake
 * @subpackage    cake.tests.cases
 */
class SomePostsController extends AppController {
/**
 * name property
 *
 * @var string 'SomePosts'
 * @access public
 */
	var $name = 'SomePosts';
/**
 * uses property
 *
 * @var array
 * @access public
 */
	var $uses = array();
/**
 * autoRender property
 *
 * @var bool false
 * @access public
 */
	var $autoRender = false;
/**
 * beforeFilter method
 *
 * @access public
 * @return void
 */
	function beforeFilter() {
		if ($this->params['action'] == 'index') {
			$this->params['action'] = 'view';
		} else {
			$this->params['action'] = 'change';
		}
		$this->params['pass'] = array('changed');
	}
/**
 * index method
 *
 * @access public
 * @return void
 */
	function index() {
		return true;
	}
/**
 * change method
 *
 * @access public
 * @return void
 */
	function change() {
		return true;
	}
}
/**
 * TestCachedPagesController class
 *
 * @package       cake
 * @subpackage    cake.tests.cases
 */
class TestCachedPagesController extends AppController {
/**
 * name property
 *
 * @var string 'TestCachedPages'
 * @access public
 */
	var $name = 'TestCachedPages';
/**
 * uses property
 *
 * @var array
 * @access public
 */
	var $uses = array();
/**
 * helpers property
 *
 * @var array
 * @access public
 */
	var $helpers = array('Cache');
/**
 * cacheAction property
 *
 * @var array
 * @access public
 */
	var $cacheAction = array(
		'index'=> '+2 sec', 'test_nocache_tags'=>'+2 sec',
		'view/' => '+2 sec'
	);
/**
 * viewPath property
 *
 * @var string 'posts'
 * @access public
 */
	var $viewPath = 'posts';
/**
 * index method
 *
 * @access public
 * @return void
 */
	function index() {
		$this->render();
	}
/**
 * test_nocache_tags method
 *
 * @access public
 * @return void
 */
	function test_nocache_tags() {
		$this->render();
	}
/**
 * view method
 *
 * @access public
 * @return void
 */
	function view($id = null) {
		$this->render('index');
	}
/**
 * test cached forms / tests view object being registered
 *
 * @return void
 */
	function cache_form() {
		$this->cacheAction = 10;
		$this->helpers[] = 'Form';
	}
}
/**
 * TimesheetsController class
 *
 * @package       cake
 * @subpackage    cake.tests.cases
 */
class TimesheetsController extends AppController {
/**
 * name property
 *
 * @var string 'Timesheets'
 * @access public
 */
	var $name = 'Timesheets';
/**
 * uses property
 *
 * @var array
 * @access public
 */
	var $uses = array();
/**
 * index method
 *
 * @access public
 * @return void
 */
	function index() {
		return true;
	}
}
/**
 * DispatcherTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases
 */
class DispatcherTest extends CakeTestCase {
/**
 * setUp method
 *
 * @access public
 * @return void
 */
	function startTest() {
		$this->_get = $_GET;
		$_GET = array();
		$this->_post = $_POST;
		$this->_files = $_FILES;
		$this->_server = $_SERVER;

		$this->_app = Configure::read('App');
		Configure::write('App.base', false);
		Configure::write('App.baseUrl', false);
		Configure::write('App.dir', 'app');
		Configure::write('App.webroot', 'webroot');

		$this->_cache = Configure::read('Cache');
		Configure::write('Cache.disable', true);

		$this->_vendorPaths = Configure::read('vendorPaths');
		$this->_pluginPaths = Configure::read('pluginPaths');
		$this->_viewPaths = Configure::read('viewPaths');
		$this->_controllerPaths = Configure::read('controllerPaths');
		$this->_debug = Configure::read('debug');

		Configure::write('controllerPaths',  Configure::corePaths('controller'));
		Configure::write('viewPaths',  Configure::corePaths('view'));
	}
/**
 * tearDown method
 *
 * @access public
 * @return void
 */
	function endTest() {
		$_GET = $this->_get;
		$_POST = $this->_post;
		$_FILES = $this->_files;
		$_SERVER = $this->_server;
		Configure::write('App', $this->_app);
		Configure::write('Cache', $this->_cache);
		Configure::write('vendorPaths', $this->_vendorPaths);
		Configure::write('pluginPaths', $this->_pluginPaths);
		Configure::write('viewPaths', $this->_viewPaths);
		Configure::write('controllerPaths', $this->_controllerPaths);
		Configure::write('debug', $this->_debug);
	}
/**
 * testParseParamsWithoutZerosAndEmptyPost method
 *
 * @access public
 * @return void
 */
	function testParseParamsWithoutZerosAndEmptyPost() {
		$Dispatcher =& new Dispatcher();
		$test = $Dispatcher->parseParams("/testcontroller/testaction/params1/params2/params3");
		$this->assertIdentical($test['controller'], 'testcontroller');
		$this->assertIdentical($test['action'], 'testaction');
		$this->assertIdentical($test['pass'][0], 'params1');
		$this->assertIdentical($test['pass'][1], 'params2');
		$this->assertIdentical($test['pass'][2], 'params3');
		$this->assertFalse(!empty($test['form']));
	}
/**
 * testParseParamsReturnsPostedData method
 *
 * @access public
 * @return void
 */
	function testParseParamsReturnsPostedData() {
		$_POST['testdata'] = "My Posted Content";
		$Dispatcher =& new Dispatcher();
		$test = $Dispatcher->parseParams("/");
		$this->assertTrue($test['form'], "Parsed URL not returning post data");
		$this->assertIdentical($test['form']['testdata'], "My Posted Content");
	}
/**
 * testParseParamsWithSingleZero method
 *
 * @access public
 * @return void
 */
	function testParseParamsWithSingleZero() {
		$Dispatcher =& new Dispatcher();
		$test = $Dispatcher->parseParams("/testcontroller/testaction/1/0/23");
		$this->assertIdentical($test['controller'], 'testcontroller');
		$this->assertIdentical($test['action'], 'testaction');
		$this->assertIdentical($test['pass'][0], '1');
		$this->assertPattern('/\\A(?:0)\\z/', $test['pass'][1]);
		$this->assertIdentical($test['pass'][2], '23');
	}
/**
 * testParseParamsWithManySingleZeros method
 *
 * @access public
 * @return void
 */
	function testParseParamsWithManySingleZeros() {
		$Dispatcher =& new Dispatcher();
		$test = $Dispatcher->parseParams("/testcontroller/testaction/0/0/0/0/0/0");
		$this->assertPattern('/\\A(?:0)\\z/', $test['pass'][0]);
		$this->assertPattern('/\\A(?:0)\\z/', $test['pass'][1]);
		$this->assertPattern('/\\A(?:0)\\z/', $test['pass'][2]);
		$this->assertPattern('/\\A(?:0)\\z/', $test['pass'][3]);
		$this->assertPattern('/\\A(?:0)\\z/', $test['pass'][4]);
		$this->assertPattern('/\\A(?:0)\\z/', $test['pass'][5]);
	}
/**
 * testParseParamsWithManyZerosInEachSectionOfUrl method
 *
 * @access public
 * @return void
 */
	function testParseParamsWithManyZerosInEachSectionOfUrl() {
		$Dispatcher =& new Dispatcher();
		$test = $Dispatcher->parseParams("/testcontroller/testaction/000/0000/00000/000000/000000/0000000");
		$this->assertPattern('/\\A(?:000)\\z/', $test['pass'][0]);
		$this->assertPattern('/\\A(?:0000)\\z/', $test['pass'][1]);
		$this->assertPattern('/\\A(?:00000)\\z/', $test['pass'][2]);
		$this->assertPattern('/\\A(?:000000)\\z/', $test['pass'][3]);
		$this->assertPattern('/\\A(?:000000)\\z/', $test['pass'][4]);
		$this->assertPattern('/\\A(?:0000000)\\z/', $test['pass'][5]);
	}
/**
 * testParseParamsWithMixedOneToManyZerosInEachSectionOfUrl method
 *
 * @access public
 * @return void
 */
	function testParseParamsWithMixedOneToManyZerosInEachSectionOfUrl() {
		$Dispatcher =& new Dispatcher();
		$test = $Dispatcher->parseParams("/testcontroller/testaction/01/0403/04010/000002/000030/0000400");
		$this->assertPattern('/\\A(?:01)\\z/', $test['pass'][0]);
		$this->assertPattern('/\\A(?:0403)\\z/', $test['pass'][1]);
		$this->assertPattern('/\\A(?:04010)\\z/', $test['pass'][2]);
		$this->assertPattern('/\\A(?:000002)\\z/', $test['pass'][3]);
		$this->assertPattern('/\\A(?:000030)\\z/', $test['pass'][4]);
		$this->assertPattern('/\\A(?:0000400)\\z/', $test['pass'][5]);
	}
/**
 * testQueryStringOnRoot method
 *
 * @access public
 * @return void
 */
	function testQueryStringOnRoot() {
		Router::reload();
		Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
		Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

		$_GET = array('coffee' => 'life', 'sleep' => 'sissies');
		$Dispatcher =& new Dispatcher();
		$uri = 'posts/home/?coffee=life&sleep=sissies';
		$result = $Dispatcher->parseParams($uri);
		$this->assertPattern('/posts/', $result['controller']);
		$this->assertPattern('/home/', $result['action']);
		$this->assertTrue(isset($result['url']['sleep']));
		$this->assertTrue(isset($result['url']['coffee']));

		$Dispatcher =& new Dispatcher();
		$uri = '/?coffee=life&sleep=sissy';
		$result = $Dispatcher->parseParams($uri);
		$this->assertPattern('/pages/', $result['controller']);
		$this->assertPattern('/display/', $result['action']);
		$this->assertTrue(isset($result['url']['sleep']));
		$this->assertTrue(isset($result['url']['coffee']));
		$this->assertEqual($result['url']['coffee'], 'life');
	}
/**
 * testFileUploadArrayStructure method
 *
 * @access public
 * @return void
 */
	function testFileUploadArrayStructure() {
		$_FILES = array('data' => array('name' => array(
			'File' => array(
				array('data' => 'cake_mssql_patch.patch'),
					array('data' => 'controller.diff'),
					array('data' => ''),
					array('data' => ''),
				),
				'Post' => array('attachment' => 'jquery-1.2.1.js'),
			),
			'type' => array(
				'File' => array(
					array('data' => ''),
					array('data' => ''),
					array('data' => ''),
					array('data' => ''),
				),
				'Post' => array('attachment' => 'application/x-javascript'),
			),
			'tmp_name' => array(
				'File' => array(
					array('data' => '/private/var/tmp/phpy05Ywj'),
					array('data' => '/private/var/tmp/php7MBztY'),
					array('data' => ''),
					array('data' => ''),
				),
				'Post' => array('attachment' => '/private/var/tmp/phpEwlrIo'),
			),
			'error' => array(
				'File' => array(
					array('data' => 0),
					array('data' => 0),
					array('data' => 4),
					array('data' => 4)
				),
				'Post' => array('attachment' => 0)
			),
			'size' => array(
				'File' => array(
					array('data' => 6271),
					array('data' => 350),
					array('data' => 0),
					array('data' => 0),
				),
				'Post' => array('attachment' => 80469)
			),
		));

		$Dispatcher =& new Dispatcher();
		$result = $Dispatcher->parseParams('/');

		$expected = array(
			'File' => array(
				array('data' => array(
					'name' => 'cake_mssql_patch.patch',
					'type' => '',
					'tmp_name' => '/private/var/tmp/phpy05Ywj',
					'error' => 0,
					'size' => 6271,
				),
			),
			array('data' => array(
				'name' => 'controller.diff',
				'type' => '',
				'tmp_name' => '/private/var/tmp/php7MBztY',
				'error' => 0,
				'size' => 350,
			)),
			array('data' => array(
				'name' => '',
				'type' => '',
				'tmp_name' => '',
				'error' => 4,
				'size' => 0,
			)),
			array('data' => array(
				'name' => '',
				'type' => '',
				'tmp_name' => '',
				'error' => 4,
				'size' => 0,
			)),
		),
		'Post' => array('attachment' => array(
			'name' => 'jquery-1.2.1.js',
			'type' => 'application/x-javascript',
			'tmp_name' => '/private/var/tmp/phpEwlrIo',
			'error' => 0,
			'size' => 80469,
		)));
		$this->assertEqual($result['data'], $expected);

		$_FILES = array(
			'data' => array(
				'name' => array(
					'Document' => array(
						1 => array(
							'birth_cert' => 'born on.txt',
							'passport' => 'passport.txt',
							'drivers_license' => 'ugly pic.jpg'
						),
						2 => array(
							'birth_cert' => 'aunt betty.txt',
							'passport' => 'betty-passport.txt',
							'drivers_license' => 'betty-photo.jpg'
						),
					),
				),
				'type' => array(
					'Document' => array(
						1 => array(
							'birth_cert' => 'application/octet-stream',
							'passport' => 'application/octet-stream',
							'drivers_license' => 'application/octet-stream',
						),
						2 => array(
							'birth_cert' => 'application/octet-stream',
							'passport' => 'application/octet-stream',
							'drivers_license' => 'application/octet-stream',
						)
					)
				),
				'tmp_name' => array(
					'Document' => array(
						1 => array(
							'birth_cert' => '/private/var/tmp/phpbsUWfH',
							'passport' => '/private/var/tmp/php7f5zLt',
 							'drivers_license' => '/private/var/tmp/phpMXpZgT',
						),
						2 => array(
							'birth_cert' => '/private/var/tmp/php5kHZt0',
 							'passport' => '/private/var/tmp/phpnYkOuM',
 							'drivers_license' => '/private/var/tmp/php9Rq0P3',
						)
					)
				),
				'error' => array(
					'Document' => array(
						1 => array(
							'birth_cert' => 0,
							'passport' => 0,
 							'drivers_license' => 0,
						),
						2 => array(
							'birth_cert' => 0,
 							'passport' => 0,
 							'drivers_license' => 0,
						)
					)
				),
				'size' => array(
					'Document' => array(
						1 => array(
							'birth_cert' => 123,
							'passport' => 458,
 							'drivers_license' => 875,
						),
						2 => array(
							'birth_cert' => 876,
 							'passport' => 976,
 							'drivers_license' => 9783,
						)
					)
				)
			)
		);
		$Dispatcher =& new Dispatcher();
		$result = $Dispatcher->parseParams('/');
		$expected = array(
			'Document' => array(
				1 => array(
					'birth_cert' => array(
						'name' => 'born on.txt',
						'tmp_name' => '/private/var/tmp/phpbsUWfH',
						'error' => 0,
						'size' => 123,
						'type' => 'application/octet-stream',
					),
					'passport' => array(
						'name' => 'passport.txt',
						'tmp_name' => '/private/var/tmp/php7f5zLt',
						'error' => 0,
						'size' => 458,
						'type' => 'application/octet-stream',
					),
					'drivers_license' => array(
						'name' => 'ugly pic.jpg',
						'tmp_name' => '/private/var/tmp/phpMXpZgT',
						'error' => 0,
						'size' => 875,
						'type' => 'application/octet-stream',
					),
				),
				2 => array(
					'birth_cert' => array(
						'name' => 'aunt betty.txt',
						'tmp_name' => '/private/var/tmp/php5kHZt0',
						'error' => 0,
						'size' => 876,
						'type' => 'application/octet-stream',
					),
					'passport' => array(
						'name' => 'betty-passport.txt',
						'tmp_name' => '/private/var/tmp/phpnYkOuM',
						'error' => 0,
						'size' => 976,
						'type' => 'application/octet-stream',
					),
					'drivers_license' => array(
						'name' => 'betty-photo.jpg',
						'tmp_name' => '/private/var/tmp/php9Rq0P3',
						'error' => 0,
						'size' => 9783,
						'type' => 'application/octet-stream',
					),
				),
			)
		);
		$this->assertEqual($result['data'], $expected);


		$_FILES = array(
			'data' => array(
				'name' => array('birth_cert' => 'born on.txt'),
				'type' => array('birth_cert' => 'application/octet-stream'),
				'tmp_name' => array('birth_cert' => '/private/var/tmp/phpbsUWfH'),
				'error' => array('birth_cert' => 0),
				'size' => array('birth_cert' => 123)
			)
		);

		$Dispatcher =& new Dispatcher();
		$result = $Dispatcher->parseParams('/');

		$expected = array(
			'birth_cert' => array(
				'name' => 'born on.txt',
				'type' => 'application/octet-stream',
				'tmp_name' => '/private/var/tmp/phpbsUWfH',
				'error' => 0,
				'size' => 123
			)
		);

		$this->assertEqual($result['data'], $expected);
	}
/**
 * testGetUrl method
 *
 * @access public
 * @return void
 */
	function testGetUrl() {
		$Dispatcher =& new Dispatcher();
		$Dispatcher->base = '/app/webroot/index.php';
		$uri = '/app/webroot/index.php/posts/add';
		$result = $Dispatcher->getUrl($uri);
		$expected = 'posts/add';
		$this->assertEqual($expected, $result);

		Configure::write('App.baseUrl', '/app/webroot/index.php');

		$uri = '/posts/add';
		$result = $Dispatcher->getUrl($uri);
		$expected = 'posts/add';
		$this->assertEqual($expected, $result);

		$_GET['url'] = array();
		Configure::write('App.base', '/control');
		$Dispatcher =& new Dispatcher();
		$Dispatcher->baseUrl();
		$uri = '/control/students/browse';
		$result = $Dispatcher->getUrl($uri);
		$expected = 'students/browse';
		$this->assertEqual($expected, $result);

		$_GET['url'] = array();
		$Dispatcher =& new Dispatcher();
		$Dispatcher->base = '';
		$uri = '/?/home';
		$result = $Dispatcher->getUrl($uri);
		$expected = '?/home';
		$this->assertEqual($expected, $result);

		$_GET['url'] = array();
		$Dispatcher =& new Dispatcher();
		$Dispatcher->base = '/shop';
		$uri = '/shop/fr/pages/shop';
		$result = $Dispatcher->getUrl($uri);
		$expected = 'fr/pages/shop';
		$this->assertEqual($expected, $result);
	}
/**
 * testBaseUrlAndWebrootWithModRewrite method
 *
 * @access public
 * @return void
 */
	function testBaseUrlAndWebrootWithModRewrite() {
		$Dispatcher =& new Dispatcher();

		$Dispatcher->base = false;
		$_SERVER['DOCUMENT_ROOT'] = '/cake/repo/branches';
		$_SERVER['SCRIPT_FILENAME'] = '/cake/repo/branches/1.2.x.x/app/webroot/index.php';
		$_SERVER['PHP_SELF'] = '/1.2.x.x/app/webroot/index.php';
		$result = $Dispatcher->baseUrl();
		$expected = '/1.2.x.x';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/1.2.x.x/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		$Dispatcher->base = false;
		$_SERVER['DOCUMENT_ROOT'] = '/cake/repo/branches/1.2.x.x/app/webroot';
		$_SERVER['SCRIPT_FILENAME'] = '/cake/repo/branches/1.2.x.x/app/webroot/index.php';
		$_SERVER['PHP_SELF'] = '/index.php';
		$result = $Dispatcher->baseUrl();
		$expected = '';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		$Dispatcher->base = false;
		$_SERVER['DOCUMENT_ROOT'] = '/cake/repo/branches/1.2.x.x/test/';
		$_SERVER['SCRIPT_FILENAME'] = '/cake/repo/branches/1.2.x.x/test/webroot/index.php';
		$_SERVER['PHP_SELF'] = '/webroot/index.php';
		$result = $Dispatcher->baseUrl();
		$expected = '';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		$Dispatcher->base = false;;
		$_SERVER['DOCUMENT_ROOT'] = '/some/apps/where';
		$_SERVER['SCRIPT_FILENAME'] = '/some/apps/where/app/webroot/index.php';
		$_SERVER['PHP_SELF'] = '/some/apps/where/app/webroot/index.php';
		$result = $Dispatcher->baseUrl();
		$expected = '/some/apps/where';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/some/apps/where/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);


		Configure::write('App.dir', 'auth');

		$Dispatcher->base = false;;
		$_SERVER['DOCUMENT_ROOT'] = '/cake/repo/branches';
		$_SERVER['SCRIPT_FILENAME'] = '/cake/repo/branches/demos/auth/webroot/index.php';
		$_SERVER['PHP_SELF'] = '/demos/auth/webroot/index.php';

		$result = $Dispatcher->baseUrl();
		$expected = '/demos/auth';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/demos/auth/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		Configure::write('App.dir', 'code');

		$Dispatcher->base = false;;
		$_SERVER['DOCUMENT_ROOT'] = '/Library/WebServer/Documents';
		$_SERVER['SCRIPT_FILENAME'] = '/Library/WebServer/Documents/clients/PewterReport/code/webroot/index.php';
		$_SERVER['PHP_SELF'] = '/clients/PewterReport/code/webroot/index.php';
		$result = $Dispatcher->baseUrl();
		$expected = '/clients/PewterReport/code';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/clients/PewterReport/code/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);
	}
/**
 * testBaseUrlwithModRewriteAlias method
 *
 * @access public
 * @return void
 */
	function testBaseUrlwithModRewriteAlias() {
		$_SERVER['DOCUMENT_ROOT'] = '/home/aplusnur/public_html';
		$_SERVER['SCRIPT_FILENAME'] = '/home/aplusnur/cake2/app/webroot/index.php';
		$_SERVER['PHP_SELF'] = '/control/index.php';

		Configure::write('App.base', '/control');

		$Dispatcher =& new Dispatcher();
		$result = $Dispatcher->baseUrl();
		$expected = '/control';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/control/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		Configure::write('App.base', false);
		Configure::write('App.dir', 'affiliate');
		Configure::write('App.webroot', 'newaffiliate');

		$_SERVER['DOCUMENT_ROOT'] = '/var/www/abtravaff/html';
		$_SERVER['SCRIPT_FILENAME'] = '/var/www/abtravaff/html/newaffiliate/index.php';
		$_SERVER['PHP_SELF'] = '/newaffiliate/index.php';
		$Dispatcher =& new Dispatcher();
		$result = $Dispatcher->baseUrl();
		$expected = '/newaffiliate';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/newaffiliate/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);
	}
/**
 * testBaseUrlAndWebrootWithBaseUrl method
 *
 * @access public
 * @return void
 */
	function testBaseUrlAndWebrootWithBaseUrl() {
		$Dispatcher =& new Dispatcher();

		Configure::write('App.dir', 'app');

		Configure::write('App.baseUrl', '/app/webroot/index.php');
		$result = $Dispatcher->baseUrl();
		$expected = '/app/webroot/index.php';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/app/webroot/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		Configure::write('App.baseUrl', '/app/webroot/test.php');
		$result = $Dispatcher->baseUrl();
		$expected = '/app/webroot/test.php';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/app/webroot/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		Configure::write('App.baseUrl', '/app/index.php');
		$result = $Dispatcher->baseUrl();
		$expected = '/app/index.php';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/app/webroot/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		Configure::write('App.baseUrl', '/index.php');
		$result = $Dispatcher->baseUrl();
		$expected = '/index.php';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/app/webroot/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		Configure::write('App.baseUrl', '/CakeBB/app/webroot/index.php');
		$result = $Dispatcher->baseUrl();
		$expected = '/CakeBB/app/webroot/index.php';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/CakeBB/app/webroot/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		Configure::write('App.baseUrl', '/CakeBB/app/index.php');
		$result = $Dispatcher->baseUrl();
		$expected = '/CakeBB/app/index.php';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/CakeBB/app/webroot/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		Configure::write('App.baseUrl', '/CakeBB/index.php');
		$result = $Dispatcher->baseUrl();
		$expected = '/CakeBB/index.php';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/CakeBB/app/webroot/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		Configure::write('App.baseUrl', '/dbhauser/index.php');
		$_SERVER['DOCUMENT_ROOT'] = '/kunden/homepages/4/d181710652/htdocs/joomla';
		$_SERVER['SCRIPT_FILENAME'] = '/kunden/homepages/4/d181710652/htdocs/joomla/dbhauser/index.php';
		$result = $Dispatcher->baseUrl();
		$expected = '/dbhauser/index.php';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/dbhauser/app/webroot/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);
	}
/**
 * test baseUrl with no rewrite and using the top level index.php.
 *
 * @return void
 */
	function testBaseUrlNoRewriteTopLevelIndex() {
		$Dispatcher =& new Dispatcher();

		Configure::write('App.baseUrl', '/index.php');
		$_SERVER['DOCUMENT_ROOT'] = '/Users/markstory/Sites/cake_dev';
		$_SERVER['SCRIPT_FILENAME'] = '/Users/markstory/Sites/cake_dev/index.php';

		$result = $Dispatcher->baseUrl();
		$this->assertEqual('/index.php', $result);
		$this->assertEqual('/app/webroot/', $Dispatcher->webroot);
		$this->assertEqual('', $Dispatcher->base);
	}

/**
 * test baseUrl with no rewrite, and using the app/webroot/index.php file as is normal with virtual hosts.
 *
 * @return void
 */
	function testBaseUrlNoRewriteWebrootIndex() {
		$Dispatcher =& new Dispatcher();

		Configure::write('App.baseUrl', '/index.php');
		$_SERVER['DOCUMENT_ROOT'] = '/Users/markstory/Sites/cake_dev/app/webroot';
		$_SERVER['SCRIPT_FILENAME'] = '/Users/markstory/Sites/cake_dev/app/webroot/index.php';

		$result = $Dispatcher->baseUrl();
		$this->assertEqual('/index.php', $result);
		$this->assertEqual('/', $Dispatcher->webroot);
		$this->assertEqual('', $Dispatcher->base);
	}

/**
 * testBaseUrlAndWebrootWithBase method
 *
 * @access public
 * @return void
 */
	function testBaseUrlAndWebrootWithBase() {
		$Dispatcher =& new Dispatcher();
		$Dispatcher->base = '/app';
		$result = $Dispatcher->baseUrl();
		$expected = '/app';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/app/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		$Dispatcher->base = '';
		$result = $Dispatcher->baseUrl();
		$expected = '';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);

		Configure::write('App.dir', 'testbed');
		$Dispatcher->base = '/cake/testbed/webroot';
		$result = $Dispatcher->baseUrl();
		$expected = '/cake/testbed/webroot';
		$this->assertEqual($expected, $result);
		$expectedWebroot = '/cake/testbed/webroot/';
		$this->assertEqual($expectedWebroot, $Dispatcher->webroot);
	}
/**
 * testMissingController method
 *
 * @access public
 * @return void
 */
	function testMissingController() {
		$Dispatcher =& new TestDispatcher();
		Configure::write('App.baseUrl', '/index.php');
		$url = 'some_controller/home/param:value/param2:value2';
		$controller = $Dispatcher->dispatch($url, array('return' => 1));
		$expected = array('missingController', array(array(
			'className' => 'SomeControllerController',
			'webroot' => '/app/webroot/',
			'url' => 'some_controller/home/param:value/param2:value2',
			'base' => '/index.php'
		)));
		$this->assertEqual($expected, $controller);
	}
/**
 * testPrivate method
 *
 * @access public
 * @return void
 */
	function testPrivate() {
		$Dispatcher =& new TestDispatcher();
		Configure::write('App.baseUrl','/index.php');
		$url = 'some_pages/_protected/param:value/param2:value2';

		$controller = $Dispatcher->dispatch($url, array('return' => 1));

		$expected = array('privateAction', array(array(
			'className' => 'SomePagesController',
			'action' => '_protected',
			'webroot' => '/app/webroot/',
			'url' => 'some_pages/_protected/param:value/param2:value2',
			'base' => '/index.php'
		)));
		$this->assertEqual($controller, $expected);
	}
/**
 * testMissingAction method
 *
 * @access public
 * @return void
 */
	function testMissingAction() {
		$Dispatcher =& new TestDispatcher();
		Configure::write('App.baseUrl', '/index.php');
		$url = 'some_pages/home/param:value/param2:value2';

		$controller = $Dispatcher->dispatch($url, array('return'=> 1));

		$expected = array('missingAction', array(array(
			'className' => 'SomePagesController',
			'action' => 'home',
			'webroot' => '/app/webroot/',
			'url' => '/index.php/some_pages/home/param:value/param2:value2',
			'base' => '/index.php'
		)));
		$this->assertEqual($expected, $controller);

		$Dispatcher =& new TestDispatcher();
		Configure::write('App.baseUrl','/index.php');
		$url = 'some_pages/redirect/param:value/param2:value2';

		$controller = $Dispatcher->dispatch($url, array('return'=> 1));

		$expected = array('missingAction', array(array(
			'className' => 'SomePagesController',
			'action' => 'redirect',
			'webroot' => '/app/webroot/',
			'url' => '/index.php/some_pages/redirect/param:value/param2:value2',
			'