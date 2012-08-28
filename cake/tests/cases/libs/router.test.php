<?php
/* SVN FILE: $Id$ */
/**
 * RouterTest file
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
 * @subpackage    cake.tests.cases.libs
 * @since         CakePHP(tm) v 1.2.0.4206
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
App::import('Core', array('Router', 'Debugger'));

if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', 'http://cakephp.org');
}
/**
 * RouterTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs
 */
class RouterTest extends CakeTestCase {
/**
 * setUp method
 *
 * @access public
 * @return void
 */
	function setUp() {
		Configure::write('Routing.admin', null);
		Router::reload();
		$this->router =& Router::getInstance();
	}
/**
 * testReturnedInstanceReference method
 *
 * @access public
 * @return void
 */
	function testReturnedInstanceReference() {
		$this->router->testVar = 'test';
		$this->assertIdentical($this->router, Router::getInstance());
		unset($this->router->testVar);
	}
/**
 * testFullBaseURL method
 *
 * @access public
 * @return void
 */
	function testFullBaseURL() {
		$this->assertPattern('/^http(s)?:\/\//', Router::url('/', true));
		$this->assertPattern('/^http(s)?:\/\//', Router::url(null, true));
	}
/**
 * testRouteWriting method
 *
 * @access public
 * @return void
 */
	function testRouteWriting() {
		Router::connect('/');
		Router::parse('/');
		$this->assertEqual($this->router->routes[0][0], '/');
		$this->assertEqual($this->router->routes[0][1], '/^[\/]*$/');
		$this->assertEqual($this->router->routes[0][2], array());

		Router::reload();
		Router::connect('/', array('controller' => 'testing'));
		Router::parse('/');
		$this->assertTrue(is_array($this->router->routes[0][3]) && !empty($this->router->routes[0][3]));
		$this->assertEqual($this->router->routes[0][3]['controller'], 'testing');
		$this->assertEqual($this->router->routes[0][3]['action'], 'index');
		$this->assertEqual(count($this->router->routes[0][3]), 3);

		$this->router->routes = array();
		Router::connect('/:controller', array('controller' => 'testing2'));
		Router::parse('/testing2');
		$this->assertTrue(is_array($this->router->routes[0][3]) && !empty($this->router->routes[0][3]), '/');
		$this->assertEqual($this->router->routes[0][3]['controller'], 'testing2');
		$this->assertEqual($this->router->routes[0][3]['action'], 'index');
		$this->assertEqual(count($this->router->routes[0][3]), 3);

		$this->router->routes = array();
		Router::connect('/:controller/:action', array('controller' => 'testing3'));
		Router::parse('/testing3/index');
		$this->assertEqual($this->router->routes[0][0], '/:controller/:action');
		$this->assertEqual($this->router->routes[0][1], '#^(?:/([^\/]+))?(?:/([^\/]+))?[\/]*$#');
		$this->assertEqual($this->router->routes[0][2], array('controller', 'action'));
		$this->assertEqual($this->router->routes[0][3], array('controller' => 'testing3', 'action' => 'index', 'plugin' => null));

		$this->router->routes = array();
		Router::connect('/:controller/:action/:id', array('controller' => 'testing4', 'id' => null), array('id' => $this->router->__named['ID']));
		Router::parse('/testing4/view/5');
		$this->assertEqual($this->router->routes[0][0], '/:controller/:action/:id');
		$this->assertEqual($this->router->routes[0][1], '#^(?:/([^\/]+))?(?:/([^\/]+))?(?:/([0-9]+)?)?[\/]*$#');
		$this->assertEqual($this->router->routes[0][2], array('controller', 'action', 'id'));

		$this->router->routes = array();
		Router::connect('/:controller/:action/:id', array('controller' => 'testing4'), array('id' => $this->router->__named['ID']));
		Router::parse('/testing4/view/5');
		$this->assertEqual($this->router->routes[0][1], '#^(?:/([^\/]+))?(?:/([^\/]+))?(?:/([0-9]+))[\/]*$#');

		$this->router->routes = array();
		Router::connect('/posts/foo:id');
		Router::parse('/posts/foo5');
		$this->assertEqual($this->router->routes[0][2], array('id'));
		$this->assertEqual($this->router->routes[0][1], '#^/posts(?:/foo([^\/]+))?[\/]*$#');

		foreach (array(':', '@', ';', '$', '-') as $delim) {
			$this->router->routes = array();
			Router::connect('/posts/:id'.$delim.':title');
			Router::parse('/posts/5' . $delim . 'foo');
			$this->assertEqual($this->router->routes[0][2], array('id', 'title'));
			$this->assertEqual($this->router->routes[0][1], '#^/posts(?:/([^\/]+))?(?:'.preg_quote($delim, '#').'([^\/]+))?[\/]*$#');
		}

		$this->router->routes = array();
		Router::connect('/posts/:id::title/:year');
		Router::parse('/posts/5:foo:2007');
		$this->assertEqual($this->router->routes[0][2], array('id', 'title', 'year'));
		$this->assertEqual($this->router->routes[0][1], '#^/posts(?:/([^\/]+))?(?:\\:([^\/]+))?(?:/([^\/]+))?[\/]*$#');
	}
/**
 * testRouteDefaultParams method
 *
 * @access public
 * @return void
 */
	function testRouteDefaultParams() {
		Router::connect('/:controller', array('controller' => 'posts'));
		$this->assertEqual(Router::url(array('action' => 'index')), '/');
	}
/**
 * testRouterIdentity method
 *
 * @access public
 * @return void
 */
	function testRouterIdentity() {
		$router2 = new Router();
		$this->assertEqual(get_object_vars($this->router), get_object_vars($router2));
	}
/**
 * testResourceRoutes method
 *
 * @access public
 * @return void
 */
	function testResourceRoutes() {
		Router::mapResources('Posts');

		$_SERVER['REQUEST_METHOD'] = 'GET';
		$result = Router::parse('/posts');
		$this->assertEqual($result, array('pass' => array(), 'named' => array(), 'plugin' => '', 'controller' => 'posts', 'action' => 'index', '[method]' => 'GET'));
		$this->assertEqual($this->router->__resourceMapped, array('posts'));

		$_SERVER['REQUEST_METHOD'] = 'GET';
		$result = Router::parse('/posts/13');
		$this->assertEqual($result, array('pass' => array('13'), 'named' => array(), 'plugin' => '', 'controller' => 'posts', 'action' => 'view', 'id' => '13', '[method]' => 'GET'));
		$this->assertEqual($this->router->__resourceMapped, array('posts'));

		$_SERVER['REQUEST_METHOD'] = 'POST';
		$result = Router::parse('/posts');
		$this->assertEqual($result, array('pass' => array(), 'named' => array(), 'plugin' => '', 'controller' => 'posts', 'action' => 'add', '[method]' => 'POST'));
		$this->assertEqual($this->router->__resourceMapped, array('posts'));

		$_SERVER['REQUEST_METHOD'] = 'PUT';
		$result = Router::parse('/posts/13');
		$this->assertEqual($result, array('pass' => array('13'), 'named' => array(), 'plugin' => '', 'controller' => 'posts', 'action' => 'edit', 'id' => '13', '[method]' => 'PUT'));
		$this->assertEqual($this->router->__resourceMapped, array('posts'));

		$result = Router::parse('/posts/475acc39-a328-44d3-95fb-015000000000');
		$this->assertEqual($result, array('pass' => array('475acc39-a328-44d3-95fb-015000000000'), 'named' => array(), 'plugin' => '', 'controller' => 'posts', 'action' => 'edit', 'id' => '475acc39-a328-44d3-95fb-015000000000', '[method]' => 'PUT'));
		$this->assertEqual($this->router->__resourceMapped, array('posts'));

		$_SERVER['REQUEST_METHOD'] = 'DELETE';
		$result = Router::parse('/posts/13');
		$this->assertEqual($result, array('pass' => array('13'), 'named' => array(), 'plugin' => '', 'controller' => 'posts', 'action' => 'delete', 'id' => '13', '[method]' => 'DELETE'));
		$this->assertEqual($this->router->__resourceMapped, array('posts'));

		$_SERVER['REQUEST_METHOD'] = 'GET';
		$result = Router::parse('/posts/add');
		$this->assertEqual($result, array('pass' => array(), 'named' => array(), 'plugin' => '', 'controller' => 'posts', 'action' => 'add'));
		$this->assertEqual($this->router->__resourceMapped, array('posts'));

		Router::reload();
		Router::mapResources('Posts', array('id' => '[a-z0-9_]+'));

		$_SERVER['REQUEST_METHOD'] = 'GET';
		$result = Router::parse('/posts/add');
		$this->assertEqual($result, array('pass' => array('add'), 'named' => array(), 'plugin' => '', 'controller' => 'posts', 'action' => 'view', 'id' => 'add', '[method]' => 'GET'));
		$this->assertEqual($this->router->__resourceMapped, array('posts'));

		$_SERVER['REQUEST_METHOD'] = 'PUT';
		$result = Router::parse('/posts/name');
		$this->assertEqual($result, array('pass' => array('name'), 'named' => array(), 'plugin' => '', 'controller' => 'posts', 'action' => 'edit', 'id' => 'name', '[method]' => 'PUT'));
		$this->assertEqual($this->router->__resourceMapped, array('posts'));
	}
/**
 * testMultipleResourceRoute method
 *
 * @access public
 * @return void
 */
	function testMultipleResourceRoute() {
		Router::connect('/:controller', array('action' => 'index', '[method]' => array('GET', 'POST')));

		$_SERVER['REQUEST_METHOD'] = 'GET';
		$result = Router::parse('/posts');
		$this->assertEqual($result, array('pass' => array(), 'named' => array(), 'plugin' => '', 'controller' => 'posts', 'action' => 'index', '[method]' => array('GET', 'POST')));

		$_SERVER['REQUEST_METHOD'] = 'POST';
		$result = Router::parse('/posts');
		$this->assertEqual($result, array('pass' => array(), 'named' => array(), 'plugin' => '', 'controller' => 'posts', 'action' => 'index', '[method]' => array('GET', 'POST')));
	}
/**
 * testGenerateUrlResourceRoute method
 *
 * @access public
 * @return void
 */
	function testGenerateUrlResourceRoute() {
		Router::mapResources('Posts');

		$result = Router::url(array('controller' => 'posts', 'action' => 'index', '[method]' => 'GET'));
		$expected = '/posts';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('controller' => 'posts', 'action' => 'view', '[method]' => 'GET', 'id' => 10));
		$expected = '/posts/10';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('controller' => 'posts', 'action' => 'add', '[method]' => 'POST'));
		$expected = '/posts';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('controller' => 'posts', 'action' => 'edit', '[method]' => 'PUT', 'id' => 10));
		$expected = '/posts/10';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('controller' => 'posts', 'action' => 'delete', '[method]' => 'DELETE', 'id' => 10));
		$expected = '/posts/10';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('controller' => 'posts', 'action' => 'edit', '[method]' => 'POST', 'id' => 10));
		$expected = '/posts/10';
		$this->assertEqual($result, $expected);
	}
/**
 * testUrlNormalization method
 *
 * @access public
 * @return void
 */
	function testUrlNormalization() {
		$expected = '/users/logout';

		$result = Router::normalize('/users/logout/');
		$this->assertEqual($result, $expected);

		$result = Router::normalize('//users//logout//');
		$this->assertEqual($result, $expected);

		$result = Router::normalize('users/logout');
		$this->assertEqual($result, $expected);

		$result = Router::normalize(array('controller' => 'users', 'action' => 'logout'));
		$this->assertEqual($result, $expected);

		$result = Router::normalize('/');
		$this->assertEqual($result, '/');

		$result = Router::normalize('http://google.com/');
		$this->assertEqual($result, 'http://google.com/');

		$result = Router::normalize('http://google.com//');
		$this->assertEqual($result, 'http://google.com//');

		$result = Router::normalize('/users/login/scope://foo');
		$this->assertEqual($result, '/users/login/scope:/foo');

		$result = Router::normalize('/recipe/recipes/add');
		$this->assertEqual($result, '/recipe/recipes/add');

		Router::setRequestInfo(array(array(), array('base' => '/us')));
		$result = Router::normalize('/us/users/logout/');
		$this->assertEqual($result, '/users/logout');

		Router::reload();

		Router::setRequestInfo(array(array(), array('base' => '/cake_12')));
		$result = Router::normalize('/cake_12/users/logout/');
		$this->assertEqual($result, '/users/logout');

		Router::reload();
		$_back = Configure::read('App.baseUrl');
		Configure::write('App.baseUrl', '/');
		
		Router::setRequestInfo(array(array(), array('base' => '/')));
		$result = Router::normalize('users/login');
		$this->assertEqual($result, '/users/login');
		Configure::write('App.baseUrl', $_back);
		
		Router::reload();
		Router::setRequestInfo(array(array(), array('base' => 'beer')));
		$result = Router::normalize('beer/admin/beers_tags/add');
		$this->assertEqual($result, '/admin/beers_tags/add');

		$result = Router::normalize('/admin/beers_tags/add');
		$this->assertEqual($result, '/admin/beers_tags/add');
	}
/**
 * testUrlGeneration method
 *
 * @access public
 * @return void
 */
	function testUrlGeneration() {
		extract(Router::getNamedExpressions());

		Router::setRequestInfo(array(
			array(
				'pass' => array(), 'action' => 'index', 'plugin' => null, 'controller' => 'subscribe',
				'admin' => true, 'url' => array('url' => '')
			),
			array(
				'base' => '/magazine', 'here' => '/magazine',
				'webroot' => '/magazine/', 'passedArgs' => array('page' => 2), 'namedArgs' => array('page' => 2),
			)
		));
		$result = Router::url();
		$this->assertEqual('/magazine', $result);

		Router::reload();

		Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
		$out = Router::url(array('controller' => 'pages', 'action' => 'display', 'home'));
		$this->assertEqual($out, '/');

		Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
		$result = Router::url(array('controller' => 'pages', 'action' => 'display', 'about'));
		$expected = '/pages/about';
		$this->assertEqual($result, $expected);

		Router::reload();
		Router::parse('/');

		Router::connect('/:plugin/:id/*', array('controller' => 'posts', 'action' => 'view'), array('id' => $ID));
		$result = Router::url(array('plugin' => 'cake_plugin', 'controller' => 'posts', 'action' => 'view', 'id' => '1'));
		$expected = '/cake_plugin/1';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('plugin' => 'cake_plugin', 'controller' => 'posts', 'action' => 'view', 'id' => '1', '0'));
		$expected = '/cake_plugin/1/0';
		$this->assertEqual($result, $expected);

		Router::reload();
		Router::parse('/');

		Router::connect('/:controller/:action/:id', array(), array('id' => $ID));
		$result = Router::url(array('controller' => 'posts', 'action' => 'view', 'id' => '1'));
		$expected = '/posts/view/1';
		$this->assertEqual($result, $expected);

		Router::reload();
		Router::parse('/');

		Router::connect('/:controller/:id', array('action' => 'view', 'id' => '1'));
		$result = Router::url(array('controller' => 'posts', 'action' => 'view', 'id' => '1'));
		$expected = '/posts/1';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('controller' => 'posts', 'action' => 'index', '0'));
		$expected = '/posts/index/0';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('controller' => 'posts', 'action'=>'index', '0', '?' => 'var=test&var2=test2'));
		$expected = '/posts/index/0?var=test&var2=test2';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('controller' => 'posts', '0', '?' => 'var=test&var2=test2'));
		$this->assertEqual($result, $expected);

		$result = Router::url(array('controller' => 'posts', '0', '?' => array('var' => 'test', 'var2' => 'test2')));
		$this->assertEqual($result, $expected);

		$result = Router::url(array('controller' => 'posts', '0', '?' => array('var' => null)));
		$this->assertEqual($result, '/posts/index/0');

		$result = Router::url(array('controller' => 'posts', '0', '?' => 'var=test&var2=test2', '#' => 'unencoded string %'));
		$expected = '/posts/index/0?var=test&var2=test2#unencoded+string+%25';
		$this->assertEqual($result, $expected);

		Router::connect('/view/*',	array('controller' => 'posts', 'action' => 'view'));
		Router::promote();
		$result = Router::url(array('controller' => 'posts', 'action' => 'view', '1'));
		$expected = '/view/1';
		$this->assertEqual($result, $expected);

		Configure::write('Routing.admin', 'admin');
		Router::reload();
		Router::setRequestInfo(array(
			array(
				'pass' => array(), 'action' => 'admin_index', 'plugin' => null, 'controller' => 'subscriptions',
				'admin' => true, 'url' => array('url' => 'admin/subscriptions/index/page:2'),
			),
			array(
				'base' => '/magazine', 'here' => '/magazine/admin/subscriptions/index/page:2',
				'webroot' => '/magazine/', 'passedArgs' => array('page' => 2),
			)
		));
		Router::parse('/');

		$result = Router::url(array('page' => 3));
		$expected = '/magazine/admin/subscriptions/index/page:3';
		$this->assertEqual($result, $expected);

		Configure::write('Routing.admin', 'admin');
		Router::reload();
		Router::connect('/admin/subscriptions/:action/*', array('controller' => 'subscribe', 'admin' => true, 'prefix' => 'admin'));
		Router::setRequestInfo(array(
			array(
				'pass' => array(), 'action' => 'admin_index', 'plugin' => null, 'controller' => 'subscribe',
				'admin' => true, 'url' => array('url' => 'admin/subscriptions/edit/1')
			),
			array(
				'base' => '/magazine', 'here' => '/magazine/admin/subscriptions/edit/1',
				'webroot' => '/magazine/', 'passedArgs' => array('page' => 2), 'namedArgs' => array('page' => 2),
			)
		));
		Router::parse('/');

		$result = Router::url(array('action' => 'edit', 1));
		$expected = '/magazine/admin/subscriptions/edit/1';
		$this->assertEqual($result, $expected);

		Router::reload();
		Router::setRequestInfo(array(
			array('pass' => array(), 'action' => 'index', 'plugin' => null, 'controller' => 'real_controller_name', 'url' => array('url' => '')),
			array(
				'base' => '/', 'here' => '/',
				'webroot' => '/', 'passedArgs' => array('page' => 2), 'namedArgs' => array('page' => 2),
			)
		));
		Router::connect('short_controller_name/:action/*', array('controller' => 'real_controller_name'));
		Router::parse('/');

		$result = Router::url(array('controller' => 'real_controller_name', 'page' => '1'));
		$expected = '/short_controller_name/index/page:1';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('action' => 'add'));
		$expected = '/short_controller_name/add';
		$this->assertEqual($result, $expected);

		Router::reload();

		Router::connect(
			':language/galleries',
			array('controller' => 'galleries', 'action' => 'index'),
			array('language' => '[a-z]{3}')
		);

		Router::connect(
			'/:language/:admin/:controller/:action/*',
			array('admin' => 'admin'),
			array('language' => '[a-z]{3}', 'admin' => 'admin')
		);

		Router::connect('/:language/:controller/:action/*',
			array(),
			array('language' => '[a-z]{3}')
		);

		$result = Router::url(array('admin' => false, 'language' => 'dan', 'action' => 'index', 'controller' => 'galleries'));
		$expected = '/dan/galleries';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('admin' => false, 'language' => 'eng', 'action' => 'index', 'controller' => 'galleries'));
		$expected = '/eng/galleries';
		$this->assertEqual($result, $expected);

		Router::reload();
		Router::connect('/:language/pages',
			array('controller' => 'pages', 'action' => 'index'),
			array('language' => '[a-z]{3}')
		);

		Router::connect('/:language/:controller/:action/*', array(), array('language' => '[a-z]{3}'));

		$result = Router::url(array('language' => 'eng', 'action' => 'index', 'controller' => 'pages'));
		$expected = '/eng/pages';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('language' => 'eng', 'controller' => 'pages'));
		$this->assertEqual($result, $expected);

		$result = Router::url(array('language' => 'eng', 'controller' => 'pages', 'action' => 'add'));
		$expected = '/eng/pages/add';
		$this->assertEqual($result, $expected);

		Router::reload();
		Router::parse('/');
		Router::setRequestInfo(array(
			array('pass' => array(), 'action' => 'index', 'plugin' => null, 'controller' => 'users', 'url' => array('url' => 'users')),
			array(
				'base' => '/', 'here' => '/',
				'webroot' => '/', 'passedArgs' => array(), 'argSeparator' => ':', 'namedArgs' => array(),
			)
		));

		$result = Router::url(array('action' => 'login'));
		$expected = '/users/login';
		$this->assertEqual($result, $expected);

		Router::reload();
		Router::parse('/');
		Router::connect('/page/*', array('plugin' => null, 'controller' => 'pages', 'action' => 'view'));

		$result = Router::url(array('plugin' => 'my_plugin', 'controller' => 'pages', 'action' => 'view', 'my-page'));
		$expected = '/my_plugin/pages/view/my-page';
		$this->assertEqual($result, $expected);

		Router::reload();
		Router::parse('/');
		Router::connect('/forestillinger/:month/:year/*',
			array('plugin' => 'shows', 'controller' => 'shows', 'action' => 'calendar'),
			array('month' => '0[1-9]|1[012]', 'year' => '[12][0-9]{3}')
		);

		$result = Router::url(array('plugin' => 'shows', 'controller' => 'shows', 'action' => 'calendar', 'month' => 10, 'year' => 2007, 'min-forestilling'));
		$expected = '/forestillinger/10/2007/min-forestilling';
		$this->assertEqual($result, $expected);

		Router::reload();
		Router::parse('/');

		Router::connect('/contact/:action', array('plugin' => 'contact', 'controller' => 'contact'));
		$result = Router::url(array('plugin' => 'contact', 'controller' => 'contact', 'action' => 'me'));

		$expected = '/contact/me';
		$this->assertEqual($result, $expected);

		Configure::write('Routing.admin', 'admin');
		Router::reload();
		Router::parse('/');

		$result = Router::url(array('admin' => true, 'controller' => 'users', 'action' => 'login'));
		$expected = '/admin/users/login';
		$this->assertEqual($result, $expected);

		Router::reload();
		Router::parse('/');

		Router::connect('/kalender/:month/:year/*',
			array('plugin' => 'shows', 'controller' => 'shows', 'action' => 'calendar'),
			array('month' => '0[1-9]|1[012]', 'year' => '[12][0-9]{3}')
		);

		Router::connect('/kalender/*', array('plugin' => 'shows', 'controller' => 'shows', 'action' => 'calendar'));

		$result = Router::url(array('plugin' => 'shows', 'controller' => 'shows', 'action' => 'calendar', 'min-forestilling'));
		$expected = '/kalender/min-forestilling';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('plugin' => 'shows', 'controller' => 'shows', 'action' => 'calendar', 'year' => 2007, 'month' => 10, 'min-forestilling'));
		$expected = '/kalender/10/2007/min-forestilling';
		$this->assertEqual($result, $expected);

		Configure::write('Routing.admin', 'admin');
		Router::reload();

		Router::setRequestInfo(array(
			array('pass' => array(), 'admin' => true, 'action' => 'index', 'plugin' => null, 'controller' => 'users', 'url' => array('url' => 'users')),
			array(
				'base' => '/', 'here' => '/',
				'webroot' => '/', 'passedArgs' => array(), 'argSeparator' => ':', 'namedArgs' => array(),
			)
		));

		Router::connect('/page/*', array('controller' => 'pages', 'action' => 'view', 'admin' => true, 'prefix' => 'admin'));
		Router::parse('/');

		$result = Router::url(array('admin' => true, 'controller' => 'pages', 'action' => 'view', 'my-page'));
		$expected = '/page/my-page';
		$this->assertEqual($result, $expected);

		Router::reload();

		Router::setRequestInfo(array(
			array(
				'pass' => array(), 'action' => 'index', 'plugin' => 'myplugin', 'controller' => 'mycontroller',
				'admin' => false, 'url' => array('url' => array())
			),
			array(
				'base' => '/', 'here' => '/',
				'webroot' => '/', 'passedArgs' => array(), 'namedArgs' => array(),
			)
		));

		$result = Router::url(array('plugin' => null, 'controller' => 'myothercontroller'));
		$expected = '/myothercontroller/';
		$this->assertEqual($result, $expected);

		Configure::write('Routing.admin', 'admin');
		Router::reload();

		Router::setRequestInfo(array(
			array('plugin' => null, 'controller' => 'pages', 'action' => 'admin_add', 'pass' => array(), 'prefix' => 'admin', 'admin' => true, 'form' => array(), 'url' => array('url' => 'admin/pages/add')),
			array('plugin' => null, 'controller' => null, 'action' => null, 'base' => '', 'here' => '/admin/pages/add', 'webroot' => '/')
		));
		Router::parse('/');

		$result = Router::url(array('plugin' => null, 'controller' => 'pages', 'action' => 'add', 'id' => false));
		$expected = '/admin/pages/add';
		$this->assertEqual($result, $expected);

		Router::reload();

		Router::setRequestInfo(array(
			array ('plugin' => null, 'controller' => 'pages', 'action' => 'admin_edit', 'pass' => array('284'), 'prefix' => 'admin', 'admin' => true, 'form' => array(), 'url' => array('url' => 'admin/pages/edit/284')),
			array ('plugin' => null, 'controller' => null, 'action' => null, 'base' => '', 'here' => '/admin/pages/edit/284', 'webroot' => '/')
		));

		Router::connect('/admin/:controller/:action/:id', array('admin' => true), array('id' => '[0-9]+'));
		Router::parse('/');

		$result = Router::url(array('plugin' => null, 'controller' => 'pages', 'action' => 'edit', 'id' => '284'));
		$expected = '/admin/pages/edit/284';
		$this->assertEqual($result, $expected);

		Configure::write('Routing.admin', 'admin');
		Router::reload();
		Router::setRequestInfo(array(
			array ('plugin' => null, 'controller' => 'pages', 'action' => 'admin_add', 'pass' => array(), 'prefix' => 'admin', 'admin' => true, 'form' => array(), 'url' => array('url' => 'admin/pages/add')),
			array ('plugin' => null, 'controller' => null, 'action' => null, 'base' => '', 'here' => '/admin/pages/add', 'webroot' => '/')
		));

		Router::parse('/');

		$result = Router::url(array('plugin' => null, 'controller' => 'pages', 'action' => 'add', 'id' => false));
		$expected = '/admin/pages/add';
		$this->assertEqual($result, $expected);


		Router::reload();
		Router::setRequestInfo(array(
			array('plugin' => null, 'controller' => 'pages', 'action' => 'admin_edit', 'pass' => array('284'), 'prefix' => 'admin', 'admin' => true, 'form' => array(), 'url' => array('url' => 'admin/pages/edit/284')),
			array('plugin' => null, 'controller' => null, 'action' => null, 'base' => '', 'here' => '/admin/pages/edit/284', 'webroot' => '/')
		));

		Router::parse('/');

		$result = Router::url(array('plugin' => null, 'controller' => 'pages', 'action' => 'edit', 'id' => '284'));
		$expected = '/admin/pages/edit/284';
		$this->assertEqual($result, $expected);

		Router::reload();
		Router::setRequestInfo(array(
			array(
				'plugin' => 'shows', 'controller' => 'show_tickets', 'action' => 'admin_edit',
				'pass' => array('6'), 'prefix' => 'admin', 'admin' => true, 'form' => array(),
				'url' => array('url' => 'admin/shows/show_tickets/edit/6')
			),
			array(
				'plugin' => null, 'controller' => null, 'action' => null, 'base' => '',
				'here' => '/admin/shows/show_tickets/edit/6', 'webroot' => '/'
			)
		));

		Router::parse('/');

		$result = Router::url(array(
			'plugin' => 'shows', 'controller' => 'show_tickets', 'action' => 'edit', 'id' => '6',
			'admin' => true, 'prefix' => 'admin'
		));
		$expected = '/admin/shows/show_tickets/edit/6';
		$this->assertEqual($result, $expected);

		Router::reload();

		Router::setRequestInfo(array(
			array('pass' => array(), 'action' => 'admin_index', 'plugin' => null, 'controller' => 'posts', 'prefix' => 'admin', 'admin' => true, 'url' => array('url' => 'admin/posts')),
			array('base' => '', 'here' => '/admin/posts', 'webroot' => '/')
		));

		Router::connect('/admin/posts/*', array('controller' => 'posts', 'action' => 'index', 'admin' => true));
		Router::parse('/');

		$result = Router::url(array('all'));
		$expected = '/admin/posts/all';
		$this->assertEqual($result, $expected);
	}
/**
 * testUrlGenerationWithPrefix method
 *
 * @access public
 * @return void
 */
	function testUrlGenerationWithPrefix() {
		Configure::write('Routing.admin', 'admin');
		Router::reload();

		Router::connectNamed(array('event', 'lang'));
		Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
		Router::connect('/pages/contact_us', array('controller' => 'pages', 'action' => 'contact_us'));
		Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
		Router::connect('/reset/*', array('admin' => true, 'controller' => 'users', 'action' => 'reset'));
		Router::connect('/tests', array('controller' => 'tests', 'action' => 'index'));
		Router::parseExtensions('rss');

		Router::setRequestInfo(array(
			array('pass' => array(), 'named' => array(), 'controller' => 'registrations', 'action' => 'admin_index', 'plugin' => '', 'prefix' => 'admin', 'admin' => true, 'url' => array('ext' => 'html', 'url' => 'admin/registrations/index'), 'form' => array()),
			array('base' => '', 'here' => '/admin/registrations/index', 'webroot' => '/')
		));

		$result = Router::url(array('page' => 2));
		$expected = '/admin/registrations/index/page:2';
		$this->assertEqual($result, $expected);
	}
/**
 * testUrlGenerationWithExtensions method
 *
 * @access public
 * @return void
 */
	function testUrlGenerationWithExtensions() {
		Router::parse('/');
		$result = Router::url(array('plugin' => null, 'controller' => 'articles', 'action' => 'add', 'id' => null, 'ext' => 'json'));
		$expected = '/articles/add.json';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('plugin' => null, 'controller' => 'articles', 'action' => 'add', 'ext' => 'json'));
		$expected = '/articles/add.json';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('plugin' => null, 'controller' => 'articles', 'action' => 'index', 'id' => null, 'ext' => 'json'));
		$expected = '/articles.json';
		$this->assertEqual($result, $expected);

		$result = Router::url(array('plugin' => null, 'controller' => 'articles', 'action' => 'index', 'ext' => 'json'));
		$expected = '/articles.json';
		$this->assertEqual($result, $expected);
	}
/**
 * testPluginUrlGeneration method
 *
 * @access public
 * @return void
 */
	function testPluginUrlGeneration() {
		Router::setRequestInfo(array(
			array(
				'controller' => 'controller', 'action' => 'index', 'form' => array(),
				'url' => array(), 'plugin' => 'test'
			),
			array(
				'base' => '/base', 'here' => '/clients/sage/portal/donations', 'webroot' => '/base/',
				'passedArgs' => array(), 'argSeparator' => ':', 'namedArgs' => array()
			)
		));

		$this->assertEqual(Router::url('read/1'), '/base/test/controller/read/1');

		Router::reload();

		Router::connect('/:lang/:plugin/:controller/*', array(), array('action' => 'index'));

		Router::setRequestInfo(array(
				array(
					'lang' => 'en',
					'plugin' => 'shows', 'controller' => 'shows', 'action' => 'index', 'pass' =>
						array(), 'form' => array(), 'url' =>
						array('url' => 'en/shows/')),
				array('plugin' => NULL, 'controller' => NULL, 'action' => NULL, 'base' => '',
				'here' => '/en/shows/', 'webroot' => '/')));

		Router::parse('/en/shows/');

		$result = Router::url(array(
			'lang' => 'en',
			'controller' => 'shows', 'action' => 'index', 'page' => '1',
		));
		$expected = '/en/shows/page:1';
		$this->assertEqual($result, $expected);
	}
/**
 * testUrlParsing method
 *
 * @access public
 * @return void
 */
	function testUrlParsing() {
		extract(Router::getNamedExpressions());

		Router::connect('/posts/:value/:somevalue/:othervalue/*', array('controller' => 'posts', 'action' => 'view'), array('value','somevalue', 'othervalue'));
		$result = Router::parse('/posts/2007/08/01/title-of-post-here');
		$expected = array('value' => '2007', 'somevalue' => '08', 'othervalue' => '01', 'controller' => 'posts', 'action' => 'view', 'plugin' =>'', 'pass' => array('0' => 'title-of-post-here'), 'named' => array());
		$this->assertEqual($result, $expected);

		$this->router->routes = array();
		Router::connect('/posts/:year/:month/:day/*', array('controller' => 'posts', 'action' => 'view'), array('year' => $Year, 'month' => $Month, 'day' => $Day));
		$result = Router::parse('/posts/2007/08/01/title-of-post-here');
		$expected = array('year' => '2007', 'month' => '08', 'day' => '01', 'controller' => 'posts', 'action' => 'view', 'plugin' =>'', 'pass' => array('0' => 'title-of-post-here'), 'named' => array());
		$this->assertEqual($result, $expected);

		$this->router->routes = array();
		Router::connect('/posts/:day/:year/:month/*', array('controller' => 'posts', 'action' => 'view'), array('year' => $Year, 'month' => $Month, 'day' => $Day));
		$result = 