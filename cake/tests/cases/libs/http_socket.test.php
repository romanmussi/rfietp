<?php
/* SVN FILE: $Id$ */
/**
 * HttpSocketTest file
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
App::import('Core', 'HttpSocket');
/**
 * HttpSocketTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs
 */
class HttpSocketTest extends CakeTestCase {
/**
 * Socket property
 *
 * @var mixed null
 * @access public
 */
	var $Socket = null;
/**
 * RequestSocket property
 *
 * @var mixed null
 * @access public
 */
	var $RequestSocket = null;
/**
 * This function sets up a TestHttpSocket instance we are going to use for testing
 *
 * @access public
 * @return void
 */
	function setUp() {
		if (!class_exists('TestHttpSocket')) {
			Mock::generatePartial('HttpSocket', 'TestHttpSocket', array('read', 'write', 'connect'));
			Mock::generatePartial('HttpSocket', 'TestHttpSocketRequests', array('read', 'write', 'connect', 'request'));
		}

		$this->Socket =& new TestHttpSocket();
		$this->RequestSocket =& new TestHttpSocketRequests();
	}
/**
 * We use this function to clean up after the test case was executed
 *
 * @access public
 * @return void
 */
	function tearDown() {
		unset($this->Socket, $this->RequestSocket);
	}
/**
 * Test that HttpSocket::__construct does what one would expect it to do
 *
 * @access public
 * @return void
 */
	function testConstruct() {
		$this->Socket->reset();
		$baseConfig = $this->Socket->config;
		$this->Socket->expectNever('connect');
		$this->Socket->__construct(array('host' => 'foo-bar'));
		$baseConfig['host']	 = 'foo-bar';
		$baseConfig['protocol'] = getprotobyname($baseConfig['protocol']);
		$this->assertIdentical($this->Socket->config, $baseConfig);
		$this->Socket->reset();
		$baseConfig = $this->Socket->config;
		$this->Socket->__construct('http://www.cakephp.org:23/');
		$baseConfig['host']	 = 'www.cakephp.org';
		$baseConfig['request']['uri']['host'] = 'www.cakephp.org';
		$baseConfig['port']	 = 23;
		$baseConfig['request']['uri']['port'] = 23;
		$baseConfig['protocol'] = getprotobyname($baseConfig['protocol']);
		$this->assertIdentical($this->Socket->config, $baseConfig);

		$this->Socket->reset();
		$this->Socket->__construct(array('request' => array('uri' => 'http://www.cakephp.org:23/')));
		$this->assertIdentical($this->Socket->config, $baseConfig);
	}
/**
 * Test that HttpSocket::configUri works properly with different types of arguments
 *
 * @access public
 * @return void
 */
	function testConfigUri() {
		$this->Socket->reset();
		$r = $this->Socket->configUri('https://bob:secret@www.cakephp.org:23/?query=foo');
		$expected = array(
			'persistent' => false,
			'host' 		 => 'www.cakephp.org',
			'protocol'   => 'tcp',
			'port' 		 => 23,
			'timeout' 	 =>	30,
			'request' => array(
				'uri' => array(
					'scheme' => 'https'
					, 'host' => 'www.cakephp.org'
					, 'port' => 23
				),
				'auth' => array(
					'method' => 'Basic'
					, 'user' => 'bob'
					, 'pass' => 'secret'
				),
				'cookies' => array(),
			)
		);
		$this->assertIdentical($this->Socket->config, $expected);
		$this->assertIdentical($r, $expected);
		$r = $this->Socket->configUri(array('host' => 'www.foo-bar.org'));
		$expected['host'] = 'www.foo-bar.org';
		$expected['request']['uri']['host'] = 'www.foo-bar.org';
		$this->assertIdentical($this->Socket->config, $expected);
		$this->assertIdentical($r, $expected);

		$r = $this->Socket->configUri('http://www.foo.com');
		$expected = array(
			'persistent' => false,
			'host' 		 => 'www.foo.com',
			'protocol'   => 'tcp',
			'port' 		 => 80,
			'timeout' 	 =>	30,
			'request' => array(
				'uri' => array(
					'scheme' => 'http'
					, 'host' => 'www.foo.com'
					, 'port' => 80
				),
				'auth' => array(
					'method' => 'Basic'
					, 'user' => null
					, 'pass' => null
				),
				'cookies' => array()
			)
		);
		$this->assertIdentical($this->Socket->config, $expected);
		$this->assertIdentical($r, $expected);
		$r = $this->Socket->configUri('/this-is-broken');
		$this->assertIdentical($this->Socket->config, $expected);
		$this->assertIdentical($r, false);
		$r = $this->Socket->configUri(false);
		$this->assertIdentical($this->Socket->config, $expected);
		$this->assertIdentical($r, false);
	}
/**
 * Tests that HttpSocket::request (the heart of the HttpSocket) is working properly.
 *
 * @access public
 * @return void
 */
	function testRequest() {
		$this->Socket->reset();

		$this->Socket->reset();
		$response = $this->Socket->request(true);
		$this->assertFalse($response);

		$tests = array(
			0 => array(
				'request' => 'http://www.cakephp.org/?foo=bar'
				, 'expectation' => array(
					'config' => array(
						'persistent' => false
						, 'host' => 'www.cakephp.org'
						, 'protocol' => 'tcp'
						, 'port' => 80
						, 'timeout' => 30
						, 'request' => array(
							'uri' => array (
								'scheme' => 'http'
								, 'host' => 'www.cakephp.org'
								, 'port' => 80,
							)
							, 'auth' => array(
								'method' => 'Basic'
								,'user' => null
								,'pass' => null
							),
							'cookies' => array(),
						),
					)
					, 'request' => array(
						'method' => 'GET'
						, 'uri' => array(
							'scheme' => 'http'
							, 'host' => 'www.cakephp.org'
							, 'port' => 80
							, 'user' => null
							, 'pass' => null
							, 'path' => '/'
							, 'query' => array('foo' => 'bar')
							, 'fragment' => null
						)
						, 'auth' => array(
							'method' => 'Basic'
							, 'user' => null
							, 'pass' => null
						)
						, 'version' => '1.1'
						, 'body' => ''
						, 'line' => "GET /?foo=bar HTTP/1.1\r\n"
						, 'header' => "Host: www.cakephp.org\r\nConnection: close\r\nUser-Agent: CakePHP\r\n"
						, 'raw' => ""
						, 'cookies' => array(),
					)
				)
			)
			, 1 => array(
				'request' => array(
					'uri' => array(
						'host' => 'www.cakephp.org'
						, 'query' => '?foo=bar'
					)
				)
			)
			, 2 => array(
				'request' => 'www.cakephp.org/?foo=bar'
			)
			, 3 => array(
				'request' => array('host' => '192.168.0.1', 'uri' => 'http://www.cakephp.org/?foo=bar')
				, 'expectation' => array(
					'request' => array(
						'uri' => array('host' => 'www.cakephp.org')
					)
					, 'config' => array(
						'request' => array(
							'uri' => array('host' => 'www.cakephp.org')
						)
						, 'host' => '192.168.0.1'
					)
				)
			)
			, 'reset4' => array(
				'request.uri.query' => array()
			)
			, 4 => array(
				'request' => array('header' => array('Foo@woo' => 'bar-value'))
				, 'expectation' => array(
					'request' => array(
						'header' => "Host: www.cakephp.org\r\nConnection: close\r\nUser-Agent: CakePHP\r\nFoo\"@\"woo: bar-value\r\n"
						, 'line' => "GET / HTTP/1.1\r\n"
					)
				)
			)
			, 5 => array(
				'request' => array('header' => array('Foo@woo' => 'bar-value', 'host' => 'foo.com'), 'uri' => 'http://www.cakephp.org/')
				, 'expectation' => array(
					'request' => array(
						'header' => "Host: foo.com\r\nConnection: close\r\nUser-Agent: CakePHP\r\nFoo\"@\"woo: bar-value\r\n"
					)
					, 'config' => array(
						'host' => 'www.cakephp.org'
					)
				)
			)
			, 6 => array(
				'request' => array('header' => "Foo: bar\r\n")
				, 'expectation' => array(
					'request' => array(
						'header' => "Foo: bar\r\n"
					)
				)
			)
			, 7 => array(
				'request' => array('header' => "Foo: bar\r\n", 'uri' => 'http://www.cakephp.org/search?q=http_socket#ignore-me')
				, 'expectation' => array(
					'request' => array(
						'uri' => array(
							'path' => '/search'
							, 'query' => array('q' => 'http_socket')
							, 'fragment' => 'ignore-me'
						)
						, 'line' => "GET /search?q=http_socket HTTP/1.1\r\n"
					)
				)
			)
			, 'reset8' => array(
				'request.uri.query' => array()
			)
			, 8 => array(
				'request' => array('method' => 'POST', 'uri' => 'http://www.cakephp.org/posts/add', 'body' => array('name' => 'HttpSocket-is-released', 'date' => 'today'))
				, 'expectation' => array(
					'request' => array(
						'method' => 'POST'
						, 'uri' => array(
							'path' => '/posts/add'
							, 'fragment' => null
						)
						, 'body' => "name=HttpSocket-is-released&date=today"
						, 'line' => "POST /posts/add HTTP/1.1\r\n"
						, 'header' => "Host: www.cakephp.org\r\nConnection: close\r\nUser-Agent: CakePHP\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: 38\r\n"
						, 'raw' => "name=HttpSocket-is-released&date=today"
					)
				)
			)
			, 9 => array(
				'request' => array('method' => 'POST', 'uri' => 'http://www.cakephp.org:8080/posts/add', 'body' => array('name' => 'HttpSocket-is-released', 'date' => 'today'))
				, 'expectation' => array(
					'config' => array(
						'port' => 8080
						, 'request' => array(
							'uri' => array(
								'port' => 8080
							)
						)
					)
					, 'request' => array(
						'uri' => array(
							'port' => 8080
						)
						, 'header' => "Host: www.cakephp.org:8080\r\nConnection: close\r\nUser-Agent: CakePHP\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: 38\r\n"
					)
				)
			)
			, 10 => array(
				'request' => array('method' => 'POST', 'uri' => 'https://www.cakephp.org/posts/add', 'body' => array('name' => 'HttpSocket-is-released', 'date' => 'today'))
				, 'expectation' => array(
					'config' => array(
						'port' => 443
						, 'request' => array(
							'uri' => array(
								'scheme' => 'https'
								, 'port' => 443
							)
						)
					)
					, 'request' => array(
						'uri' => array(
							'scheme' => 'https'
							, 'port' => 443
						)
						, 'header' => "Host: www.cakephp.org\r\nConnection: close\r\nUser-Agent: CakePHP\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: 38\r\n"
					)
				)
			)
			, 11 => array(
				'request' => array(
						'method' => 'POST',
						'uri' => 'https://www.cakephp.org/posts/add',
						'body' => array('name' => 'HttpSocket-is-released', 'date' => 'today'),
						'cookies' => array('foo' => array('value' => 'bar'))
				)
				, 'expectation' => array(
					'request' => array(
						'header' => "Host: www.cakephp.org\r\nConnection: close\r\nUser-Agent: CakePHP\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: 38\r\nCookie: foo=bar\r\n",
						'cookies' => array(
							'foo' => array('value' => 'bar'),
						)
					)
				)
			)
		);

		$expectation = array();
		foreach ($tests as $i => $test) {
			if (strpos($i, 'reset') === 0) {
				foreach ($test as $path => $val) {
					$expectation = Set::insert($expectation, $path, $val);
				}
				continue;
			}

			if (isset($test['expectation'])) {
				$expectation = Set::merge($expectation, $test['expectation']);
			}
			$this->Socket->request($test['request']);

			$raw = $expectation['request']['raw'];
			$expectation['request']['raw'] = $expectation['request']['line'].$expectation['request']['header']."\r\n".$raw;

			$r = array('config' => $this->Socket->config, 'request' => $this->Socket->request);
			$v = $this->assertIdentical($r, $expectation, '%s in test #'.$i.' ');
			if (!$v) {
				debug('Result:');
				debug($r);
				debug('Expected:');
				debug($expectation);
			}
			$expectation['request']['raw'] = $raw;
		}

		$this->Socket->reset();
		$request = array('method' => 'POST', 'uri' => 'http://www.cakephp.org/posts/add', 'body' => array('name' => 'HttpSocket-is-released', 'date' => 'today'));
		$response = $this->Socket->request($request);
		$this->assertIdentical($this->Socket->request['body'], "name=HttpSocket-is-released&date=today");

		$request = array('uri' => '*', 'method' => 'GET');
		$this->expectError(new PatternExpectation('/activate quirks mode/i'));
		$response = $this->Socket->request($request);
		$this->assertFalse($response);
		$this->assertFalse($this->Socket->response);

		$this->Socket->reset();
		$request = array('uri' => 'htpp://www.cakephp.org/');
		$this->Socket->setReturnValue('connect', true);
		$this->Socket->setReturnValue('read', false);
		$this->Socket->_mock->_call_counts['read'] = 0;
		$number = mt_rand(0, 9999999);
		$serverResponse = "HTTP/1.x 200 OK\r\nDate: Mon, 16 Apr 2007 04:14:16 GMT\r\nServer: CakeHttp Server\r\nContent-Type: text/html\r\n\r\n<h1>Hello, your lucky number is " . $number . "</h1>";
		$this->Socket->setReturnValueAt(0, 'read', $serverResponse);
		$this->Socket->expect('write', array("GET / HTTP/1.1\r\nHost: www.cakephp.org\r\nConnection: close\r\nUser-Agent: CakePHP\r\n\r\n"));
		$this->Socket->expectCallCount('read', 2);
		$response = $this->Socket->request($request);
		$this->assertIdentical($response, "<h1>Hello, your lucky number is " . $number . "</h1>");

		$this->Socket->reset();
		$serverResponse = "HTTP/1.x 200 OK\r\nSet-Cookie: foo=bar\r\nDate: Mon, 16 Apr 2007 04:14:16 GMT\r\nServer: CakeHttp Server\r\nContent-Type: text/html\r\n\r\n<h1>This is a cookie test!</h1>";
		unset($this->Socket->_mock->_actions->_at['read']);
		unset($this->Socket->_mock->_return_sequence['read']);
		$this->Socket->_mock->_call_counts['read'] = 0;
		$this->Socket->setReturnValueAt(0, 'read', $serverResponse);

		$this->Socket->connected = true;
		$this->Socket->request($request);
		$result = $this->Socket->response['cookies'];
		$expect = array(
			'foo' => array(
				'value' => 'bar'
			)
		);
		$this->assertEqual($result, $expect);
		$this->assertEqual($this->Socket->config['request']['cookies'], $expect);
		$this->assertFalse($this->Socket->connected);
	}
/**
 * testUrl method
 *
 * @access public
 * @return void
 */
	function testUrl() {
		$this->Socket->reset(true);

		$this->assertIdentical($this->Socket->url(true), false);

		$url = $this->Socket->url('www.cakephp.org');
		$this->assertIdentical($url, 'http://www.cakephp.org/');

		$url = $this->Socket->url('https://www.cakephp.org/posts/add');
		$this->assertIdentical($url, 'https://www.cakephp.org/posts/add');
		$url = $this->Socket->url('http://www.cakephp/search?q=socket', '/%path?%query');
		$this->assertIdentical($url, '/search?q=socket');

		$this->Socket->config['request']['uri']['host'] = 'bakery.cakephp.org';
		$url = $this->Socket->url();
		$this->assertIdentical($url, 'http://bakery.cakephp.org/');

		$this->Socket->configUri('http://www.cakephp.org');
		$url = $this->Socket->url('/search?q=bar');
		$this->assertIdentical($url, 'http://www.cakephp.org/search?q=bar');

		$url = $this->Socket->url(array('host' => 'www.foobar.org', 'query' => array('q' => 'bar')));
		$this->assertIdentical($url, 'http://www.foobar.org/?q=bar');

		$url = $this->Socket->url(array('path' => '/supersearch', 'query' => array('q' => 'bar')));
		$this->assertIdentical($url, 'http://www.cakephp.org/supersearch?q=bar');

		$this->Socket->configUri('http://www.google.com');
		$url = $this->Socket->url('/search?q=socket');
		$this->assertIdentical($url, 'http://www.google.com/search?q=socket');

		$url = $this->Socket->url();
		$this->assertIdentical($url, 'http://www.google.com/');

		$this->Socket->configUri('https://www.google.com');
		$url = $this->Socket->url('/search?q=socket');
		$this->assertIdentical($url, 'https://www.google.com/search?q=socket');

		$this->Socket->reset();
		$this->Socket->configUri('www.google.com:443');
		$url = $this->Socket->url('/search?q=socket');
		$this->assertIdentical($url, 'https://www.google.com/search?q=socket');

		$this->Socket->reset();
		$this->Socket->configUri('www.google.com:8080');
		$url = $this->Socket->url('/search?q=socket');
		$this->assertIdentical($url, 'http://www.google.com:8080/search?q=socket');
	}
/**
 * testGet method
 *
 * @access public
 * @return void
 */
	function testGet() {
		$this->RequestSocket->reset();

		$this->RequestSocket->expect('request', a(array('method' => 'GET', 'uri' => 'http://www.google.com/')));
		$this->RequestSocket->get('http://www.google.com/');

		$this->RequestSocket->expect('request', a(array('method' => 'GET', 'uri' => 'http://www.google.com/?foo=bar')));
		$this->RequestSocket->get('http://www.google.com/', array('foo' => 'bar'));

		$this->RequestSocket->expect('request', a(array('method' => 'GET', 'uri' => 'http://www.google.com/?foo=bar')));
		$this->RequestSocket->get('http://www.google.com/', 'foo=bar');

		$this->RequestSocket->expect('request', a(array('method' => 'GET', 'uri' => 'http://www.google.com/?foo=23&foobar=42')));
		$this->RequestSocket->get('http://www.google.com/?foo=bar', array('foobar' => '42', 'foo' => '23'));

		$this->RequestSocket->expect('request', a(array('method' => 'GET', 'uri' => 'http://www.google.com/', 'auth' => array('user' => 'foo', 'pass' => 'bar'))));
		$this->RequestSocket->get('http://www.google.com/', null, array('auth' => array('user' => 'foo', 'pass' => 'bar')));
	}
/**
 * test that two consecutive get() calls reset the authentication credentials.
 *
 * @return void
 */
	function testConsecutiveGetResetsAuthCredentials() {
		$socket = new TestHttpSocket();
		$socket->config['request']['auth'] = array(
			'method' => 'Basic',
			'user' => 'mark',
			'pass' => 'secret'
		);
		$socket->get('http://mark:secret@example.com/test');
		$this->assertEqual($socket->request['uri']['user'], 'mark');
		$this->assertEqual($socket->request['uri']['pass'], 'secret');

		$socket->get('/test2');
		$this->assertEqual($socket->request['auth']['user'], 'mark');
		$this->assertEqual($socket->request['auth']['pass'], 'secret');

		$socket->get('/test3');
		$this->assertEqual($socket->request['auth']['user'], 'mark');
		$this->assertEqual($socket->request['auth']['pass'], 'secret');
	}

/**
 * testPostPutDelete method
 *
 * @access public
 * @return void
 */
	function testPostPutDelete() {
		$this->RequestSocket->reset();

		foreach (array('POST', 'PUT', 'DELETE') as $method) {
			$this->RequestSocket->expect('request', a(array('method' => $method, 'uri' => 'http://www.google.com/', 'body' => array())));
			$this->RequestSocket->{low($method)}('http://www.google.com/');

			$this->RequestSocket->expect('request', a(array('method' => $method, 'uri' => 'http://www.google.com/', 'body' => array('Foo' => 'bar'))));
			$this->RequestSocket->{low($method)}('http://www.google.com/', array('Foo' => 'bar'));

			$this->RequestSocket->expect('request', a(array('method' => $method, 'uri' => 'http://www.google.com/', 'body' => null, 'line' => 'Hey Server')));
			$this->RequestSocket->{low($method)}('http://www.google.com/', null, array('line' => 'Hey Server'));
		}
	}
/**
 * testParseResponse method
 *
 * @access public
 * @return void
 */
	function testParseResponse() {
		$this->Socket->reset();

		$r = $this->Socket->parseResponse(array('foo' => 'bar'));
		$this->assertIdentical($r, array('foo' => 'bar'));

		$r = $this->Socket->parseResponse(true);
		$this->assertIdentical($r, false);

		$r = $this->Socket->parseResponse("HTTP Foo\r\nBar: La");
		$this->assertIdentical($r, false);

		$tests = array(
			'simple-request' => array(
				'response' => array(
					'status-line' => "HTTP/1.x 200 OK\r\n",
					'header' => "Date: Mon, 16 Apr 2007 04:14:16 GMT\r\nServer: CakeHttp Server\r\n",
					'body' => "<h1>Hello World</h1>\r\n<p>It's good to be html</p>"
				)
				, 'expectations' => array(
					'status.http-version' => 'HTTP/1.x',
					'status.code' => 200,
					'status.reason-phrase' => 'OK',
					'header' => $this->Socket->parseHeader("Date: Mon, 16 Apr 2007 04:14:16 GMT\r\nServer: CakeHttp Server\r\n"),
					'body' => "<h1>Hello World</h1>\r\n<p>It's good to be html</p>"
				)
			),
			'no-header' => array(
				'response' => array(
					'status-line' => "HTTP/1.x 404 OK\r\n",
					'header' => null,
				)
				, 'expectations' => array(
					'status.code' => 404,
					'header' => array()
				)
			),
			'chunked' => array(
				'response' => array(
					'header' => "Transfer-Encoding: chunked\r\n",
					'body' => "19\r\nThis is a chunked message\r\n0\r\n"
				),
				'expectations' => array(
					'body' => "This is a chunked message",
					'header' => $this->Socket->parseHeader("Transfer-Encoding: chunked\r\n")
				)
			),
			'enitity-header' => array(
				'response' => array(
					'body' => "19\r\nThis is a chunked message\r\n0\r\nFoo: Bar\r\n"
				),
				'expectations' => array(
					'header' => $this->Socket->parseHeader("Transfer-Encoding: chunked\r\nFoo: Bar\r\n")
				)
			),
			'enitity-header-combine' => array(
				'response' => array(
					'header' => "Transfer-Encoding: chunked\r\nFoo: Foobar\r\n"
				),
				'expectations' => array(
					'header' => $this->Socket->parseHeader("Transfer-Encoding: chunked\r\nFoo: Foobar\r\nFoo: Bar\r\n")
				)
			)
		);

		$testResponse = array();
		$expectations = array();

		foreach ($tests as $name => $test) {

			$testResponse = array_merge($testResponse, $test['response']);
			$testResponse['response'] = $testResponse['status-line'].$testResponse['header']."\r\n".$testResponse['body'];
			$r = $this->Socket->parseResponse($testResponse['response']);
			$expectations = array_merge($expectations, $test['expectations']);

			foreach ($expectations as $property => $expectedVal) {
				$val = Set::extract($r, $property);
				$this->assertIdentical($val, $expectedVal, 'Test "'.$name.'": response.'.$property.' - %s');
			}

			foreach (array('status-line', 'header', 'body', 'response') as $field) {
				$this->assertIdentical($r['raw'][$field], $testResponse[$field], 'Test response.raw.'.$field.': %s');
			}
		}
	}
/**
 * testDecodeBody method
 *
 * @access public
 * @return void
 */
	function testDecodeBody() {
		$this->Socket->reset();

		$r = $this->Socket->decodeBody(true);
		$this->assertIdentical($r, false);

		$r = $this->Socket->decodeBody('Foobar', false);
		$this->assertIdentical($r, array('body' => 'Foobar', 'header' => false));

		$encodings = array(
			'chunked' => array(
				'encoded' => "19\r\nThis is a chunked message\r\n0\r\n",
				'decoded' => array('body' => "This is a chunked message", 'header' => false)
			),
			'foo-coded' => array(
				'encoded' => '!Foobar!',
				'decoded' => array('body' => '!Foobar!', 'header' => false),
				'error' => new PatternExpectation('/unknown encoding: foo-coded/i')
			)
		);

		foreach ($encodings as $encoding => $sample) {
			if (isset($sample['error'])) {
				$this->expectError($sample['error']);
			}

			$r = $this->Socket->decodeBody($sample['encoded'], $encoding);
			$this->assertIdentical($r, $sample['decoded']);

			if (isset($sample['error'])) {
				$this->Socket->quirksMode = true;
				$r = $this->Socket->decodeBody($sample['encoded'], $encoding);
				$this->assertIdentical($r, $sample['decoded']);
				$this->Socket->quirksMode = false;
			}
		}
	}
/**
 * testDecodeChunkedBody method
 *
 * @access public
 * @return void
 */
	function testDecodeChunkedBody() {
		$this->Socket->reset();

		$r = $this->Socket->decodeChunkedBody(true);
		$this->assertIdentical($r, false);

		$encoded = "19\r\nThis is a chunked message\r\n0\r\n";
		$decoded = "This is a chunked message";
		$r = $this->Socket->decodeChunkedBody($encoded);
		$this->assertIdentical($r['body'], $decoded);
		$this->assertIdentical($r['header'], false);

		$encoded = "19 \r\nThis is a chunked message\r\n0\r\n";
		$r = $this->Socket->decodeChunkedBody($encoded);
		$this->assertIdentical($r['body'], $decoded);

		$encoded = "19\r\nThis is a chunked message\r\nE\r\n\nThat is cool\n\r\n0\r\n";
		$decoded = "This is a chunked message\nThat is cool\n";
		$r = $this->Socket->decodeChunkedBody($encoded);
		$this->assertIdentical($r['body'], $decoded);
		$this->assertIdentical($r['header'], false);

		$encoded = "19\r\nThis is a chunked message\r\nE;foo-chunk=5\r\n\nThat is cool\n\r\n0\r\n";
		$r = $this->Socket->decodeChunkedBody($encoded);
		$this->assertIdentical($r['body'], $decoded);
		$this->assertIdentical($r['header'], false);

		$encoded = "19\r\nThis is a chunked message\r\nE\r\n\nThat is cool\n\r\n0\r\nfoo-header: bar\r\ncake: PHP\r\n\r\n";
		$r = $this->Socket->decodeChunkedBody($encoded);
		$this->assertIdentical($r['body'], $decoded);
		$this->assertIdentical($r['header'], array('Foo-Header' => 'bar', 'Cake' => 'PHP'));

		$encoded = "19\r\nThis is a chunked message\r\nE\r\n\nThat is cool\n\r\n";
		$this->expectError(new PatternExpectation('/activate quirks mode/i'));
		$r = $this->Socket->decodeChunkedBody($encoded);
		$this->assertIdentical($r, false);

		$this->Socket->quirksMode = true;
		$r = $this->Socket->decodeChunkedBody($encoded);
		$this->assertIdentical($r['body'], $decoded);
		$this->assertIdentical($r['header'], false);

		$encoded = "19\r\nThis is a chunked message\r\nE\r\n\nThat is cool\n\r\nfoo-header: bar\r\ncake: PHP\r\n\r\n";
		$r = $this->Socket->decodeChunkedBody($encoded);
		$this->assertIdentical($r['body'], $decoded);
		$this->assertIdentical($r['header'], array('Foo-Header' => 'bar', 'Cake' => 'PHP'));
	}
/**
 * testBuildRequestLine method
 *
 * @access public
 * @return void
 */
	function testBuildRequestLine() {
		$this->Socket->reset();

		$this->expectError(new PatternExpectation('/activate quirks mode/i'));
		$r = $this->Socket->buildRequestLine('Foo');
		$this->assertIdentical($r, false);

		$this->Socket->quirksMode = true;
		$r = $this->Socket->buildRequestLine('Foo');
		$this->assertIdentical($r, 'Foo');
		$this->Socket->quirksMode = false;

		$r = $this->Socket->buildRequestLine(true);
		$this->assertIdentical($r, false);

		$r = $this->Socket->buildRequestLine(array('foo' => 'bar', 'method' => 'foo'));
		$this->assertIdentical($r, false);

		$r = $this->Socket->buildRequestLine(array('method' => 'GET', 'uri' => 'http://www.cakephp.org/search?q=socket'));
		$this->assertIdentical($r, "GET /search?q=socket HTTP/1.1\r\n");

		$request = array(
			'method' => 'GET',
			'uri' => array(
				'path' => '/search',
				'query' => array('q' => 'socket')
			)
		);
		$r = $this->Socket->buildRequestLine($request);
		$this->assertIdentical($r, "GET /search?q=socket HTTP/1.1\r\n");

		unset($request['method']);
		$r = $this->Socket->buildRequestLine($request);
		$this->assertIdentical($r, "GET /search?q=socket HTTP/1.1\r\n");

		$r = $this->Socket->buildRequestLine($request, 'CAKE-HTTP/0.1');
		$this->assertIdentical($r, "GET /search?q=socket CAKE-HTTP/0.1\r\n");

		$request = array('method' => 'OPTIONS', 'uri' => '*');
		$r = $this->Socket->buildRequestLine($request);
		$this->assertIdentical($r, "OPTIONS * HTTP/1.1\r\n");

		$request['method'] = 'GET';
		$this->expectError(new PatternExpectation('/activate quirks mode/i'));
		$r = $this->Socket->buildRequestLine($request);
		$this->assertIdentical($r, false);

		$this->expectError(new PatternExpectation('/activate quirks mode/i'));
		$r = $this->Socket->buildRequestLine("GET * HTTP/1.1\r\n");
		$this->assertIdentical($r, false);

		$this->Socket->quirksMode = true;
		$r = $this->Socket->buildRequestLine($request);
		$this->assertIdentical($r,  "GET * HTTP/1.1\r\n");

		$r = $this->Socket->buildRequestLine("GET * HTTP/1.1\r\n");
		$this->assertIdentical($r, "GET * HTTP/1.1\r\n");
	}
/**
 * Asserts that HttpSocket::parseUri is working properly
 *
 * @access public
 * @return void
 */
	function testParseUri() {
		$this->Socket->reset();

		$uri = $this->Socket->parseUri(array('invalid' => 'uri-string'));
		$this->assertIdentical($uri, false);

		$uri = $this->Socket->parseUri(array('invalid' => 'uri-string'), array('host' => 'somehost'));
		$this->assertIdentical($uri, array('host' => 'somehost', 'invalid' => 'uri-string'));

		$uri = $this->Socket->parseUri(false);
		$this->assertIdentical($uri, false);

		$uri = $this->Socket->parseUri('/my-cool-path');
		$this->assertIdentical($uri, array('path' => '/my-cool-path'));

		$uri = $this->Socket->parseUri('http://bob:foo123@www.cakephp.org:40/search?q=dessert#results');
		$this->assertIdentical($uri, array(
			'scheme' => 'http',
			'host' => 'www.cakephp.org',
			'port' => 40,
			'user' => 'bob',
			'pass' => 'foo123',
			'path' => '/search',
			'query' => array('q' => 'dessert'),
			'fragment' => 'results'
		));

		$uri = $this->Socket->parseUri('http://www.cakephp.org/');
		$this->assertIdentical($uri, array(
			'scheme' => 'http',
			'host' => 'www.cakephp.org',
			'path' => '/',
		));

		$uri = $this->Socket->parseUri('http://www.cakephp.org', true);
		$this->assertIdentical($uri, array(
			'scheme' => 'http',
			'host' => 'www.cakephp.org',
			'port' => 80,
			'user' => null,
			'pass' => null,
			'path' => '/',
			'query' => array(),
			'fragment' => null
		));

		$uri = $this->Socket->parseUri('https://www.cakephp.org', true);
		$this->assertIdentical($uri, array(
			'scheme' => 'https',
			'host' => 'www.cakephp.org',
			'port' => 443,
			'user' => null,
			'pass' => null,
			'path' => '/',
			'query' => array(),
			'fragment' => null
		));

		$uri = $this->Socket->parseUri('www.cakephp.org:443/query?foo', true);
		$this->assertIdentical($uri, array(
			'scheme' => 'https',
			'host' => 'www.cakephp.org',
			'port' => 443,
			'user' => null,
			'pass' => null,
			'path' => '/query',
			'query' => array('foo' => ""),
			'fragment' => null
		));

		$uri = $this->Socket->parseUri('http://www.cakephp.org', array('host' => 'piephp.org', 'user' => 'bob', 'fragment' => 'results'));
		$this->assertIdentical($uri, array(
			'host' => 'www.cakephp.org',
			'user' => 'bob',
			'fragment' => 'results',
			'scheme' => 'http'
		));

		$uri = $this->Socket->parseUri('https://www.cakephp.org', array('scheme' => 'http', 'port' => 23));
		$this->assertIdentical($uri, array(
			'scheme' => 'https',
			'port' => 23,
			'host' => 'www.cakephp.org'
		));

		$uri = $this->Socket->parseUri('www.cakephp.org:59', array('scheme' => array('http', 'https'), 'port' => 80));
		$this->assertIdentical($uri, array(
			'scheme' => 'http',
			'port' => 59,
			'host' => 'www.cakephp.org'
		));

		$uri = $this->Socket->parseUri(array('scheme' => 'http', 'host' => 'www.google.com', 'port' => 8080), array('scheme' => array('http', 'https'), 'host' => 'www.google.com', 'port' => array(80, 443)));
		$this->assertIdentical($uri, array(
			'scheme' => 'http',
			'host' => 'www.google.com',
			'port' => 8080,
		));

		$uri = $this->Socket->parseUri('http://www.cakephp.org/?param1=value1&param2=value2%3Dvalue3');
		$this->assertIdentical($uri, array(
			'scheme' => 'http',
			'host' => 'www.cakephp.org',
			'path' => '/',
			'query' => array(
				'param1' => 'value1',
				'param2' => 'value2=value3'
			)
		));

		$uri = $this->Socket->parseUri('http://www.cakephp.org/?param1=value1&param2=value2=value3');
		$this->assertIdentical($uri, array(
			'scheme' => 'http',
			'host' => 'www.cakephp.org',
			'path' => '/',
			'query' => array(
				'param1' => 'value1',
				'param2' => 'value2=value3'
			)
		));
	}
/**
 * Tests that HttpSocket::buildUri can turn all kinds of uri arrays (and strings) into fully or partially qualified URI's
 *
 * @access public
 * @return void
 */
	function testBuildUri() {
		$this->Socket->reset();

		$r = $this->Socket->buildUri(true);
		$this->assertIdentical($r, false);

		$r = $this->Socket->buildUri('foo.com');
		$this->assertIdentical($r, 'http://foo.com/');

		$r = $this->Socket->buildUri(array('host' => 'www.cakephp.org'));
		$this->assertIdentical($r, 'http://www.cakephp.org/');

		$r = $this->Socket->buildUri(array('host' => 'www.cakephp.org', 'scheme' => 'https'));
		$this->assertIdentical($r, 'https://www.cakephp.org/');

		$r = $this->Socket->buildUri(array('host' => 'www.cakephp.org', 'port' => 23));
		$this->assertIdentical($r, 'http://www.cakephp.org:23/');

		$r = $this->Socket->buildUri(array('path' => 'www.google.com/search', 'query' => 'q=cakephp'));
		$this->assertIdentical($r, 'http://www.google.com/search?q=cakephp');

		$r = $this->Socket->buildUri(array('host' => 'www.cakephp.org', 'scheme' => 'https', 'port' => 79));
		$this->assertIdentical($r, 'https://www.cakephp.org:79/');

		$r = $this->Socket->buildUri(array('host' => 'www.cakephp.org', 'path' => 'foo'));
		$this->assertIdentical($r, 'http://www.cakephp.org/foo');

		$r = $this->Socket->buildUri(array('host' => 'www.cakephp.org', 'path' => '/foo'));
		$this->assertIdentical($r, 'http://www.cakephp.org/foo');

		$r = $this->S