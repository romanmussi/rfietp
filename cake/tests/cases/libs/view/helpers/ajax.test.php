<?php
/* SVN FILE: $Id$ */
/**
 * AjaxHelperTest file
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
 * @subpackage    cake.tests.cases.libs.view.helpers
 * @since         CakePHP(tm) v 1.2.0.4206
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
if (!defined('CAKEPHP_UNIT_TEST_EXECUTION')) {
	define('CAKEPHP_UNIT_TEST_EXECUTION', 1);
}
uses(
	'view' . DS . 'helpers' . DS . 'app_helper',
	'controller' . DS . 'controller',
	'model' . DS . 'model',
	'view' . DS . 'helper',
	'view' . DS . 'helpers'.DS.'ajax',
	'view' . DS . 'helpers' . DS . 'html',
	'view' . DS . 'helpers' . DS . 'form',
	'view' . DS . 'helpers' . DS . 'javascript'
	);
/**
 * AjaxTestController class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class AjaxTestController extends Controller {
/**
 * name property
 *
 * @var string 'AjaxTest'
 * @access public
 */
	var $name = 'AjaxTest';
/**
 * uses property
 *
 * @var mixed null
 * @access public
 */
	var $uses = null;
}
/**
 * PostAjaxTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class PostAjaxTest extends Model {
/**
 * primaryKey property
 *
 * @var string 'id'
 * @access public
 */
	var $primaryKey = 'id';
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
		return array(
			'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
			'name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
			'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
			'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
		);
	}
}
/**
 * TestAjaxHelper class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class TestAjaxHelper extends AjaxHelper {
/**
 * stop method
 *
 * @access public
 * @return void
 */
	function _stop() {
	}
}
/**
 * TestJavascriptHelper class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class TestJavascriptHelper extends JavascriptHelper {
/**
 * codeBlocks property
 *
 * @var mixed
 * @access public
 */
	var $codeBlocks;
/**
 * codeBlock method
 *
 * @param mixed $parameter
 * @access public
 * @return void
 */
	function codeBlock($parameter) {
		if (empty($this->codeBlocks)) {
			$this->codeBlocks = array();
		}
		$this->codeBlocks[] = $parameter;
	}
}
/**
 * AjaxTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class AjaxHelperTest extends CakeTestCase {
/**
 * Regexp for CDATA start block
 *
 * @var string
 */
	var $cDataStart = 'preg:/^\/\/<!\[CDATA\[[\n\r]*/';
/**
 * Regexp for CDATA end block
 *
 * @var string
 */
	var $cDataEnd = 'preg:/[^\]]*\]\]\>[\s\r\n]*/';
/**
 * setUp method
 *
 * @access public
 * @return void
 */
	function setUp() {
		Router::reload();
		$this->Ajax =& new TestAjaxHelper();
		$this->Ajax->Html =& new HtmlHelper();
		$this->Ajax->Form =& new FormHelper();
		$this->Ajax->Javascript =& new JavascriptHelper();
		$this->Ajax->Form->Html =& $this->Ajax->Html;
		$view =& new View(new AjaxTestController());
		ClassRegistry::addObject('view', $view);
		ClassRegistry::addObject('PostAjaxTest', new PostAjaxTest());
	}
/**
 * tearDown method
 *
 * @access public
 * @return void
 */
	function tearDown() {
		unset($this->Ajax);
		ClassRegistry::flush();
	}
/**
 * testEvalScripts method
 *
 * @access public
 * @return void
 */
	function testEvalScripts() {
		$result = $this->Ajax->link('Test Link', 'http://www.cakephp.org', array('id' => 'link1', 'update' => 'content', 'evalScripts' => false));
		$expected = array(
			'a' => array('id' => 'link1', 'onclick' => ' event.returnValue = false; return false;', 'href' => 'http://www.cakephp.org'),
			'Test Link',
			'/a',
			array('script' => array('type' => 'text/javascript')),
			$this->cDataStart,
			"Event.observe('link1', 'click', function(event) { new Ajax.Updater('content','http://www.cakephp.org', {asynchronous:true, evalScripts:false, requestHeaders:['X-Update', 'content']}) }, false);",
			$this->cDataEnd,
			'/script'
		);
		$this->assertTags($result, $expected);

		$result = $this->Ajax->link('Test Link', 'http://www.cakephp.org', array('id' => 'link1', 'update' => 'content'));
		$expected = array(
			'a' => array('id' => 'link1', 'onclick' => ' event.returnValue = false; return false;', 'href' => 'http://www.cakephp.org'),
			'Test Link',
			'/a',
			array('script' => array('type' => 'text/javascript')),
			$this->cDataStart,
			"Event.observe('link1', 'click', function(event) { new Ajax.Updater('content','http://www.cakephp.org', {asynchronous:true, evalScripts:true, requestHeaders:['X-Update', 'content']}) }, false);",
			$this->cDataEnd,
			'/script'
		);
		$this->assertTags($result, $expected);
	}
/**
 * testAutoComplete method
 *
 * @access public
 * @return void
 */
	function testAutoComplete() {
		$result = $this->Ajax->autoComplete('PostAjaxTest.title' , '/posts', array('minChars' => 2));
		$this->assertPattern('/^<input[^<>]+name="data\[PostAjaxTest\]\[title\]"[^<>]+autocomplete="off"[^<>]+\/>/', $result);
		$this->assertPattern('/<div[^<>]+id="PostAjaxTestTitle_autoComplete"[^<>]*><\/div>/', $result);
		$this->assertPattern('/<div[^<>]+class="auto_complete"[^<>]*><\/div>/', $result);
		$this->assertPattern('/<\/div>\s+<script type="text\/javascript">\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*' . str_replace('/', '\\/', preg_quote('new Ajax.Autocompleter(\'PostAjaxTestTitle\', \'PostAjaxTestTitle_autoComplete\', \'/posts\',')) . '/', $result);
		$this->assertPattern('/' . str_replace('/', '\\/', preg_quote('new Ajax.Autocompleter(\'PostAjaxTestTitle\', \'PostAjaxTestTitle_autoComplete\', \'/posts\', {minChars:2});')) . '/', $result);
		$this->assertPattern('/<\/script>$/', $result);

		$result = $this->Ajax->autoComplete('PostAjaxTest.title' , '/posts', array('paramName' => 'parameter'));
		$this->assertPattern('/^<input[^<>]+name="data\[PostAjaxTest\]\[title\]"[^<>]+autocomplete="off"[^<>]+\/>/', $result);
		$this->assertPattern('/<div[^<>]+id="PostAjaxTestTitle_autoComplete"[^<>]*><\/div>/', $result);
		$this->assertPattern('/<div[^<>]+class="auto_complete"[^<>]*><\/div>/', $result);
		$this->assertPattern('/<\/div>\s+<script type="text\/javascript">\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*' . str_replace('/', '\\/', preg_quote('new Ajax.Autocompleter(\'PostAjaxTestTitle\', \'PostAjaxTestTitle_autoComplete\', \'/posts\',')) . '/', $result);
		$this->assertPattern('/' . str_replace('/', '\\/', preg_quote('new Ajax.Autocompleter(\'PostAjaxTestTitle\', \'PostAjaxTestTitle_autoComplete\', \'/posts\', {paramName:\'parameter\'});')) . '/', $result);
		$this->assertPattern('/<\/script>$/', $result);

		$result = $this->Ajax->autoComplete('PostAjaxTest.title' , '/posts', array('paramName' => 'parameter', 'updateElement' => 'elementUpdated', 'afterUpdateElement' => 'function (input, element) { alert("updated"); }'));
		$this->assertPattern('/^<input[^<>]+name="data\[PostAjaxTest\]\[title\]"[^<>]+autocomplete="off"[^<>]+\/>/', $result);
		$this->assertPattern('/<div[^<>]+id="PostAjaxTestTitle_autoComplete"[^<>]*><\/div>/', $result);
		$this->assertPattern('/<div[^<>]+class="auto_complete"[^<>]*><\/div>/', $result);
		$this->assertPattern('/<\/div>\s+<script type="text\/javascript">\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*' . str_replace('/', '\\/', preg_quote('new Ajax.Autocompleter(\'PostAjaxTestTitle\', \'PostAjaxTestTitle_autoComplete\', \'/posts\',')) . '/', $result);
		$this->assertPattern('/' . str_replace('/', '\\/', preg_quote('new Ajax.Autocompleter(\'PostAjaxTestTitle\', \'PostAjaxTestTitle_autoComplete\', \'/posts\', {paramName:\'parameter\', updateElement:elementUpdated, afterUpdateElement:function (input, element) { alert("updated"); }});')) . '/', $result);
		$this->assertPattern('/<\/script>$/', $result);

		$result = $this->Ajax->autoComplete('PostAjaxTest.title' , '/posts', array('callback' => 'function (input, queryString) { alert("requesting"); }'));
		$this->assertPattern('/^<input[^<>]+name="data\[PostAjaxTest\]\[title\]"[^<>]+autocomplete="off"[^<>]+\/>/', $result);
		$this->assertPattern('/<div[^<>]+id="PostAjaxTestTitle_autoComplete"[^<>]*><\/div>/', $result);
		$this->assertPattern('/<div[^<>]+class="auto_complete"[^<>]*><\/div>/', $result);
		$this->assertPattern('/<\/div>\s+<script type="text\/javascript">\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*' . str_replace('/', '\\/', preg_quote('new Ajax.Autocompleter(\'PostAjaxTestTitle\', \'PostAjaxTestTitle_autoComplete\', \'/posts\',')) . '/', $result);
		$this->assertPattern('/' . str_replace('/', '\\/', preg_quote('new Ajax.Autocompleter(\'PostAjaxTestTitle\', \'PostAjaxTestTitle_autoComplete\', \'/posts\', {callback:function (input, queryString) { alert("requesting"); }});')) . '/', $result);
		$this->assertPattern('/<\/script>$/', $result);

		$result = $this->Ajax->autoComplete("PostAjaxText.title", "/post", array("parameters" => "'key=value&key2=value2'"));
		$this->assertPattern('/{parameters:\'key=value&key2=value2\'}/', $result);

		$result = $this->Ajax->autoComplete("PostAjaxText.title", "/post", array("with" => "'key=value&key2=value2'"));
		$this->assertPattern('/{parameters:\'key=value&key2=value2\'}/', $result);

	}
/**
 * testAsynchronous method
 *
 * @access public
 * @return void
 */
	function testAsynchronous() {
		$result = $this->Ajax->link('Test Link', '/', array('id' => 'link1', 'update' => 'content', 'type' => 'synchronous'));
		$expected = array(
			'a' => array('id' => 'link1', 'onclick' => ' event.returnValue = false; return false;', 'href' => '/'),
			'Test Link',
			'/a',
			array('script' => array('type' => 'text/javascript')),
			$this->cDataStart,
			"Event.observe('link1', 'click', function(event) { new Ajax.Updater('content','/', {asynchronous:false, evalScripts:true, requestHeaders:['X-Update', 'content']}) }, false);",
			$this->cDataEnd,
			'/script'
		);
		$this->assertTags($result, $expected);
	}
/**
 * testDraggable method
 *
 * @access public
 * @return void
 */
	function testDraggable() {
		$result = $this->Ajax->drag('id', array('handle' => 'other_id'));
		$expected = array(
			array('script' => array('type' => 'text/javascript')),
			$this->cDataStart,
			"new Draggable('id', {handle:'other_id'});",
			$this->cDataEnd,
			'/script'
		);
		$this->assertTags($result, $expected);

		$result = $this->Ajax->drag('id', array('onDrag' => 'doDrag', 'onEnd' => 'doEnd'));
		$this->assertPattern('/onDrag:doDrag/', $result);
		$this->assertPattern('/onEnd:doEnd/', $result);
	}
/**
 * testDroppable method
 *
 * @access public
 * @return void
 */
	function testDroppable() {
		$result = $this->Ajax->drop('droppable', array('accept' => 'crap'));
		$expected = array(
			array('script' => array('type' => 'text/javascript')),
			$this->cDataStart,
			"Droppables.add('droppable', {accept:'crap'});",
			$this->cDataEnd,
			'/script'
		);
		$this->assertTags($result, $expected);

		$result = $this->Ajax->dropRemote('droppable', array('accept' => 'crap'), array('url' => '/posts'));
		$expected = array(
			array('script' => array('type' => 'text/javascript')),
			$this->cDataStart,
			"Droppables.add('droppable', {accept:'crap', onDrop:function(element, droppable, event) {new Ajax.Request('/posts', {asynchronous:true, evalScripts:true})}});",
			$this->cDataEnd,
			'/script'
		);
		$this->assertTags($result, $expected);

		$result = $this->Ajax->dropRemote('droppable', array('accept' => array('crap1', 'crap2')), array('url' => '/posts'));
		$expected = array(
			array('script' => array('type' => 'text/javascript')),
			$this->cDataStart,
			"Droppables.add('droppable', {accept:[\"crap1\",\"crap2\"], onDrop:function(element, droppable, event) {new Ajax.Request('/posts', {asynchronous:true, evalScripts:true})}});",
			$this->cDataEnd,
			'/script'
		);
		$this->assertTags($result, $expected);

		$result = $this->Ajax->dropRemote('droppable', array('accept' => 'crap'), array('url' => '/posts', 'with' => '{drag_id:element.id,drop_id:dropon.id,event:event.whatever_you_want}'));
		$expected = array(
			array('script' => array('type' => 'text/javascript')),
			$this->cDataStart,
			"Droppables.add('droppable', {accept:'crap', onDrop:function(element, droppable, event) {new Ajax.Request('/posts', {asynchronous:true, evalScripts:true, parameters:{drag_id:element.id,drop_id:dropon.id,event:event.whatever_you_want}})}});",
			$this->cDataEnd,
			'/script'
		);
		$this->assertTags($result, $expected);
	}
/**
 * testForm method
 *
 * @access public
 * @return void
 */
	function testForm() {
		$result = $this->Ajax->form('showForm', 'post', array('model' => 'Form', 'url' => array('action' => 'showForm', 'controller' => 'forms'), 'update' => 'form_box'));
		$this->assertNoPattern('/model=/', $result);

		$result = $this->Ajax->form('showForm', 'post', array('name'=> 'SomeFormName', 'id' => 'MyFormID', 'url' => array('action' => 'showForm', 'controller' => 'forms'), 'update' => 'form_box'));
		$this->assertPattern('/id="MyFormID"/', $result);
		$this->assertPattern('/name="SomeFormName"/', $result);
	}
/**
 * testSortable method
 *
 * @access public
 * @return void
 */
	function testSortable() {
		$result = $this->Ajax->sortable('ull', array('constraint' => false, 'ghosting' => true));
		$expected = array(
			array('script' => array('type' => 'text/javascript')),
			$this->cDataStart,
			"Sortable.create('ull', {constraint:false, ghosting:true});",
			$this->cDataEnd,
			'/script'
		);
		$this->assertTags($result, $expected);

		$result = $this->Ajax->sortable('ull', array('constraint' => 'false', 'ghosting' => 'true'));
		$expected = array(
			array('script' => array('type' => 'text/javascript')),
			$this->cDataStart,
			"Sortable.create('ull', {constraint:false, ghosting:true});",
			$this->cDataEnd,
			'/script'
		);
		$this->assertTags($result, $expected);

		$result = $this->Ajax->sortable('ull', array('constraint'=>'false', 'ghosting'=>'true', 'update' => 'myId'));
		$expected = array(
			array('script' => array('type' => 'text/javascript')),
			$this->cDataStart,
			"Sortable.create('ull', {constraint:false, ghosting:true, update:'myId'});",
			$this->cDataEnd,
			'/script'
		);
		$this->assertTags($result, $expected);

		$result = $this->Ajax->sortable('faqs', array('url'=>'http://www.cakephp.org',
			'update' => 'faqs',
			'tag' => 'tbody',
			'handle' => 'grip',
			'before' => "Element.hide('message')",
			'complete' => "Element.show('message');"
		));
		$expected = 'Sortable.create(\'faqs\', {update:\'faqs\', tag:\'tbody\', handle:\'grip\', onUpdate:function(sortable) {Element.hide(\'message\'); new Ajax.Updater(\'faqs\',\'http://www.cakephp.org\', {asynchronous:true, evalScripts:true, onComplete:function(request, json) {Element.show(\'message\');}, parameters:Sortable.serialize(\'faqs\'), requestHeaders:[\'X-Update\', \'faqs\']})}});';
		$this->assertPattern('/^<script[^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*' . str_replace('/', '\\/', preg_quote($expected)) . '\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);

		$result = $this->Ajax->sortable('div', array('overlap' => 'foo'));
		$expected = array(
			array('script' => array('type' => 'text/javascript')),
			$this->cDataStart,
			"Sortable.create('div', {overlap:'foo'});",
			$this->cDataEnd,
			'/script'
		);
		$this->assertTags($result, $expected);

		$result = $this->Ajax->sortable('div', array('block' => false));
		$expected = "Sortable.create('div', {});";
		$this->assertEqual($result, $expected);

		$result = $this->Ajax->sortable('div', array('block' => false, 'scroll' => 'someID'));
		$expected = "Sortable.create('div', {scroll:'someID'});";
		$this->assertEqual($result, $expected);

		$result = $this->Ajax->sortable('div', array('block' => false, 'scroll' => 'window'));
		$expected = "Sortable.create('div', {scroll:window});";
		$this->assertEqual($result, $expected);

		$result = $this->Ajax->sortable('div', array('block' => false, 'scroll' => "$('someElement')"));
		$expected = "Sortable.create('div', {scroll:$('someElement')});";
		$this->assertEqual($result, $expected);
	}
/**
 * testSubmitWithIndicator method
 *
 * @access public
 * @return void
 */
	function testSubmitWithIndicator() {
		$result = $this->Ajax->submit('Add', array('div' => false, 'url' => "http://www.cakephp.org", 'indicator' => 'loading', 'loading' => "doSomething()", 'complete' => 'doSomethingElse() '));
		$this->assertPattern('/onLoading:function\(request\) {doSomething\(\);\s+Element.show\(\'loading\'\);}/', $result);
		$this->assertPattern('/onComplete:function\(request, json\) {doSomethingElse\(\) ;\s+Element.hide\(\'loading\'\);}/', $result);
	}
/**
 * testLink method
 *
 * @access public
 * @return void
 */
	function testLink() {
		$result = $this->Ajax->link('Ajax Link', 'http://www.cakephp.org/downloads');
		$this->assertPattern('/^<a[^<>]+>Ajax Link<\/a><script [^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*[^<>]+\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/^<a[^<>]+href="http:\/\/www.cakephp.org\/downloads"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+id="link\d+"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+onclick="\s*event.returnValue = false;\s*return false;"[^<>]*>/', $result);
		$this->assertPattern('/<script[^<>]+type="text\/javascript"[^<>]*>/', $result);
		$this->assertNoPattern('/^<a\s+[^<>]*url="[^"]*"[^<>]*>/', $result);
		$this->assertNoPattern('/<script[^<>]+[^type]=[^<>]*>/', $result);
		$this->assertPattern('/Event.observe\(\'link\d+\',\s*\'click\',\s*function\(event\)\s*{.+},\s*false\);\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/function\(event\)\s*{\s*new Ajax\.Request\(\'http:\/\/www.cakephp.org\/downloads\',\s*{asynchronous:true, evalScripts:true}\)\s*},\s*false\);/', $result);

		$result = $this->Ajax->link('Ajax Link', 'http://www.cakephp.org/downloads', array('confirm' => 'Are you sure & positive?'));
		$this->assertPattern('/^<a[^<>]+>Ajax Link<\/a><script [^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*[^<>]+\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/^<a[^<>]+href="http:\/\/www.cakephp.org\/downloads"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+id="link\d+"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+onclick="\s*event.returnValue = false;\s*return false;"[^<>]*>/', $result);
		$this->assertPattern('/<script[^<>]+type="text\/javascript"[^<>]*>/', $result);
		$this->assertNoPattern('/^<a\s+[^<>]*url="[^"]*"[^<>]*>/', $result);
		$this->assertNoPattern('/<script[^<>]+[^type]=[^<>]*>/', $result);
		$this->assertPattern('/Event.observe\(\'link\d+\',\s*\'click\',\s*function\(event\)\s*{.+},\s*false\);\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/function\(event\)\s*{\s*if \(confirm\(\'Are you sure & positive\?\'\)\) {\s*new Ajax\.Request\(\'http:\/\/www.cakephp.org\/downloads\',\s*{asynchronous:true, evalScripts:true}\);\s*}\s*else\s*{\s*event.returnValue = false;\s*return false;\s*}\s*},\s*false\);/', $result);

		$result = $this->Ajax->link('Ajax Link', 'http://www.cakephp.org/downloads', array('update' => 'myDiv'));
		$this->assertPattern('/^<a[^<>]+>Ajax Link<\/a><script [^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*[^<>]+\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/^<a[^<>]+href="http:\/\/www.cakephp.org\/downloads"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+id="link\d+"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+onclick="\s*event.returnValue = false;\s*return false;"[^<>]*>/', $result);
		$this->assertPattern('/<script[^<>]+type="text\/javascript"[^<>]*>/', $result);
		$this->assertNoPattern('/^<a\s+[^<>]*url="[^"]*"[^<>]*>/', $result);
		$this->assertNoPattern('/<script[^<>]+[^type]=[^<>]*>/', $result);
		$this->assertPattern('/Event.observe\(\'link\d+\',\s*\'click\',\s*function\(event\)\s*{.+},\s*false\);\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/function\(event\)\s*{\s*new Ajax\.Updater\(\'myDiv\',\s*\'http:\/\/www.cakephp.org\/downloads\',\s*{asynchronous:true, evalScripts:true, requestHeaders:\[\'X-Update\', \'myDiv\'\]}\)\s*},\s*false\);/', $result);

		$result = $this->Ajax->link('Ajax Link', 'http://www.cakephp.org/downloads', array('update' => 'myDiv', 'id' => 'myLink'));
		$this->assertPattern('/^<a[^<>]+>Ajax Link<\/a><script [^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*[^<>]+\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/^<a[^<>]+href="http:\/\/www.cakephp.org\/downloads"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+id="myLink"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+onclick="\s*event.returnValue = false;\s*return false;"[^<>]*>/', $result);
		$this->assertPattern('/<script[^<>]+type="text\/javascript"[^<>]*>/', $result);
		$this->assertNoPattern('/^<a\s+[^<>]*url="[^"]*"[^<>]*>/', $result);
		$this->assertNoPattern('/<script[^<>]+[^type]=[^<>]*>/', $result);
		$this->assertPattern('/Event.observe\(\'myLink\',\s*\'click\',\s*function\(event\)\s*{.+},\s*false\);\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/function\(event\)\s*{\s*new Ajax\.Updater\(\'myDiv\',\s*\'http:\/\/www.cakephp.org\/downloads\',\s*{asynchronous:true, evalScripts:true, requestHeaders:\[\'X-Update\', \'myDiv\'\]}\)\s*},\s*false\);/', $result);

		$result = $this->Ajax->link('Ajax Link', 'http://www.cakephp.org/downloads', array('update' => 'myDiv', 'id' => 'myLink', 'complete' => 'myComplete();'));
		$this->assertPattern('/^<a[^<>]+>Ajax Link<\/a><script [^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*[^<>]+\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/^<a[^<>]+href="http:\/\/www.cakephp.org\/downloads"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+id="myLink"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+onclick="\s*event.returnValue = false;\s*return false;"[^<>]*>/', $result);
		$this->assertPattern('/<script[^<>]+type="text\/javascript"[^<>]*>/', $result);
		$this->assertNoPattern('/^<a\s+[^<>]*url="[^"]*"[^<>]*>/', $result);
		$this->assertNoPattern('/<script[^<>]+[^type]=[^<>]*>/', $result);
		$this->assertPattern('/Event.observe\(\'myLink\',\s*\'click\',\s*function\(event\)\s*{.+},\s*false\);\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/function\(event\)\s*{\s*new Ajax\.Updater\(\'myDiv\',\s*\'http:\/\/www.cakephp.org\/downloads\',\s*{asynchronous:true, evalScripts:true, onComplete:function\(request, json\) {myComplete\(\);}, requestHeaders:\[\'X-Update\', \'myDiv\'\]}\)\s*},\s*false\);/', $result);

		$result = $this->Ajax->link('Ajax Link', 'http://www.cakephp.org/downloads', array('update' => 'myDiv', 'id' => 'myLink', 'loading' => 'myLoading();', 'complete' => 'myComplete();'));
		$this->assertPattern('/^<a[^<>]+>Ajax Link<\/a><script [^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*[^<>]+\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/^<a[^<>]+href="http:\/\/www.cakephp.org\/downloads"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+id="myLink"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+onclick="\s*event.returnValue = false;\s*return false;"[^<>]*>/', $result);
		$this->assertPattern('/<script[^<>]+type="text\/javascript"[^<>]*>/', $result);
		$this->assertNoPattern('/^<a\s+[^<>]*url="[^"]*"[^<>]*>/', $result);
		$this->assertNoPattern('/<script[^<>]+[^type]=[^<>]*>/', $result);
		$this->assertPattern('/Event.observe\(\'myLink\',\s*\'click\',\s*function\(event\)\s*{.+},\s*false\);\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/function\(event\)\s*{\s*new Ajax\.Updater\(\'myDiv\',\s*\'http:\/\/www.cakephp.org\/downloads\',\s*{asynchronous:true, evalScripts:true, onComplete:function\(request, json\) {myComplete\(\);}, onLoading:function\(request\) {myLoading\(\);}, requestHeaders:\[\'X-Update\', \'myDiv\'\]}\)\s*},\s*false\);/', $result);

		$result = $this->Ajax->link('Ajax Link', 'http://www.cakephp.org/downloads', array('update' => 'myDiv', 'encoding' => 'utf-8'));
		$this->assertPattern('/^<a[^<>]+>Ajax Link<\/a><script [^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*[^<>]+\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/^<a[^<>]+href="http:\/\/www.cakephp.org\/downloads"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+onclick="\s*event.returnValue = false;\s*return false;"[^<>]*>/', $result);
		$this->assertPattern('/<script[^<>]+type="text\/javascript"[^<>]*>/', $result);
		$this->assertNoPattern('/^<a\s+[^<>]*url="[^"]*"[^<>]*>/', $result);
		$this->assertNoPattern('/<script[^<>]+[^type]=[^<>]*>/', $result);
		$this->assertPattern('/Event.observe\(\'\w+\',\s*\'click\',\s*function\(event\)\s*{.+},\s*false\);\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/function\(event\)\s*{\s*new Ajax\.Updater\(\'myDiv\',\s*\'http:\/\/www.cakephp.org\/downloads\',\s*{asynchronous:true, evalScripts:true, encoding:\'utf-8\', requestHeaders:\[\'X-Update\', \'myDiv\'\]}\)\s*},\s*false\);/', $result);

		$result = $this->Ajax->link('Ajax Link', 'http://www.cakephp.org/downloads', array('update' => 'myDiv', 'success' => 'success();'));
		$this->assertPattern('/^<a[^<>]+>Ajax Link<\/a><script [^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*[^<>]+\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/^<a[^<>]+href="http:\/\/www.cakephp.org\/downloads"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+onclick="\s*event.returnValue = false;\s*return false;"[^<>]*>/', $result);
		$this->assertPattern('/<script[^<>]+type="text\/javascript"[^<>]*>/', $result);
		$this->assertNoPattern('/^<a\s+[^<>]*url="[^"]*"[^<>]*>/', $result);
		$this->assertNoPattern('/<script[^<>]+[^type]=[^<>]*>/', $result);
		$this->assertPattern('/Event.observe\(\'\w+\',\s*\'click\',\s*function\(event\)\s*{.+},\s*false\);\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/function\(event\)\s*{\s*new Ajax\.Updater\(\'myDiv\',\s*\'http:\/\/www.cakephp.org\/downloads\',\s*{asynchronous:true, evalScripts:true, onSuccess:function\(request\) {success\(\);}, requestHeaders:\[\'X-Update\', \'myDiv\'\]}\)\s*},\s*false\);/', $result);

		$result = $this->Ajax->link('Ajax Link', 'http://www.cakephp.org/downloads', array('update' => 'myDiv', 'failure' => 'failure();'));
		$this->assertPattern('/^<a[^<>]+>Ajax Link<\/a><script [^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*[^<>]+\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/^<a[^<>]+href="http:\/\/www.cakephp.org\/downloads"[^<>]*>/', $result);
		$this->assertPattern('/^<a[^<>]+onclick="\s*event.returnValue = false;\s*return false;"[^<>]*>/', $result);
		$this->assertPattern('/<script[^<>]+type="text\/javascript"[^<>]*>/', $result);
		$this->assertNoPattern('/^<a\s+[^<>]*url="[^"]*"[^<>]*>/', $result);
		$this->assertNoPattern('/<script[^<>]+[^type]=[^<>]*>/', $result);
		$this->assertPattern('/Event.observe\(\'\w+\',\s*\'click\',\s*function\(event\)\s*{.+},\s*false\);\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/function\(event\)\s*{\s*new Ajax\.Updater\(\'myDiv\',\s*\'http:\/\/www.cakephp.org\/downloads\',\s*{asynchronous:true, evalScripts:true, onFailure:function\(request\) {failure\(\);}, requestHeaders:\[\'X-Update\', \'myDiv\'\]}\)\s*},\s*false\);/', $result);

		$result = $this->Ajax->link('Ajax Link', '/test', array('complete' => 'test'));
		$this->assertPattern('/^<a[^<>]+>Ajax Link<\/a><script [^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*[^<>]+\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern("/Event.observe\('link[0-9]+', [\w\d,'\(\)\s{}]+Ajax\.Request\([\w\d\s,'\(\){}:\/]+onComplete:function\(request, json\) {test}/", $result);
		$this->assertNoPattern('/^<a[^<>]+complete="test"[^<>]*>Ajax Link<\/a>/', $result);
		$this->assertNoPattern('/^<a\s+[^<>]*url="[^"]*"[^<>]*>/', $result);

		$result = $this->Ajax->link(
			'Ajax Link',
			array('controller' => 'posts', 'action' => 'index', '?' => array('one' => '1', 'two' => '2')),
			array('update' => 'myDiv', 'id' => 'myLink')
		);
		$this->assertPattern('#/posts/\?one\=1\&two\=2#', $result);
	}
/**
 * testRemoteTimer method
 *
 * @access public
 * @return void
 */
	function testRemoteTimer() {
		$result = $this->Ajax->remoteTimer(array('url' => 'http://www.cakephp.org'));
		$this->assertPattern('/^<script[^<>]+type="text\/javascript"[^<>]*>.+<\/script>$/s', $result);
		$this->assertNoPattern('/<script[^<>]+[^type]=[^<>]*>/', $result);
		$this->assertPattern('/^<script[^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*new PeriodicalExecuter\(function\(pe\) {.+}, 10\)\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/' . str_replace('/', '\\/', preg_quote('new Ajax.Request(\'http://www.cakephp.org\', {asynchronous:true, evalScripts:true})')) . '/', $result);

		$result = $this->Ajax->remoteTimer(array('url' => 'http://www.cakephp.org', 'frequency' => 25));
		$this->assertPattern('/^<script[^<>]+type="text\/javascript"[^<>]*>.+<\/script>$/s', $result);
		$this->assertNoPattern('/<script[^<>]+[^type]=[^<>]*>/', $result);
		$this->assertPattern('/^<script[^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*new PeriodicalExecuter\(function\(pe\) {.+}, 25\)\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/' . str_replace('/', '\\/', preg_quote('new Ajax.Request(\'http://www.cakephp.org\', {asynchronous:true, evalScripts:true})')) . '/', $result);

		$result = $this->Ajax->remoteTimer(array('url' => 'http://www.cakephp.org', 'complete' => 'complete();'));
		$this->assertPattern('/^<script[^<>]+type="text\/javascript"[^<>]*>.+<\/script>$/s', $result);
		$this->assertNoPattern('/<script[^<>]+[^type]=[^<>]*>/', $result);
		$this->assertPattern('/^<script[^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*new PeriodicalExecuter\(function\(pe\) {.+}, 10\)\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/script>$/', $result);
		$this->assertPattern('/' . str_replace('/', '\\/', preg_quote('new Ajax.Request(\'http://www.cakephp.org\', {asynchronous:true, evalScripts:true, onComplete:function(request, json) {complete();}})')) . '/', $result);

		$result = $this->Ajax->remoteTimer(array('url' => 'http://www.cakephp.org', 'complete' => 'complete();', 'create' => 'create();'));
		$this->assertPattern('/^<script[^<>]+type="text\/javascript"[^<>]*>.+<\/script>$/s', $result);
		$this->assertNoPattern('/<script[^<>]+[^type]=[^<>]*>/', $result);
		$this->assertPattern('/^<script[^<>]+>\s*' . str_replace('/', '\\/', preg_quote('//<![CDATA[')) . '\s*new PeriodicalExecuter\(function\(pe\) {.+}, 10\)\s*' . str_replace('/', '\\/', preg_quote('//]]>')) . '\s*<\/scrip