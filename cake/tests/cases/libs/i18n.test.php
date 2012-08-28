<?php
/* SVN FILE: $Id$ */
/**
 * I18nTest file
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
 * @since         CakePHP(tm) v 1.2.0.5432
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/opengroup.php The Open Group Test Suite License
 */
App::import('Core', 'i18n');
/**
 * I18nTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs
 */
class I18nTest extends CakeTestCase {
/**
 * setUp method
 *
 * @access public
 * @return void
 */
	function setUp() {
		$this->_objects = Configure::read('__objects');
		Configure::write('__objects', array());

		$this->_localePaths = Configure::read('localePaths');
		Configure::write('localePaths', array(TEST_CAKE_CORE_INCLUDE_PATH . 'tests' . DS . 'test_app' . DS . 'locale' . DS));

		$this->_pluginPaths = Configure::read('pluginPaths');
		Configure::write('pluginPaths', array(TEST_CAKE_CORE_INCLUDE_PATH . 'tests' . DS . 'test_app' . DS . 'plugins' . DS));

	}
/**
 * tearDown method
 *
 * @access public
 * @return void
 */
	function tearDown() {
		Configure::write('localePaths', $this->_localePaths);
		Configure::write('pluginPaths', $this->_pluginPaths);
		Configure::write('__objects', $this->_objects);
	}

	function testTranslationCaching() {
		Configure::write('Config.language', 'cache_test_po');
		$i18n =& i18n::getInstance();
		
		// reset cache & i18n
		$i18n->__destruct();
		Cache::clear(false, '_cake_core_');
		$lang = $i18n->l10n->locale;

		Cache::config('_cake_core_', Cache::config('default'));

		// make some calls to translate using different domains
		$this->assertEqual(i18n::translate('dom1.foo', false, 'dom1'), 'Dom 1 Foo');
		$this->assertEqual(i18n::translate('dom1.bar', false, 'dom1'), 'Dom 1 Bar');

		$this->assertEqual($i18n->__cache[0]['key'], 'dom1_' . $lang);
		$this->assertEqual($i18n->__cache[0]['domain'], 'dom1');
		$this->assertEqual($i18n->__domains['LC_MESSAGES']['cache_test_po']['dom1']['dom1.foo'], 'Dom 1 Foo');

		// destruct -> writes to cache
		$i18n->__destruct();

		// now only dom1 should be in cache
		$cachedDom1 = Cache::read('dom1_' . $lang, '_cake_core_');
		$this->assertEqual($cachedDom1['dom1.foo'], 'Dom 1 Foo');
		$this->assertEqual($cachedDom1['dom1.bar'], 'Dom 1 Bar');
		// dom2 not in cache
		$this->assertFalse(Cache::read('dom2_' . $lang, '_cake_core_'));

		// translate a item of dom2 (adds dom2 to cache)
		$this->assertEqual(i18n::translate('dom2.foo', false, 'dom2'), 'Dom 2 Foo');

		// modify cache entry to verify that dom1 entry is now read from cache 
		$cachedDom1['dom1.foo'] = 'FOO';
		Cache::write('dom1_' . $lang, $cachedDom1, '_cake_core_');
		$this->assertEqual(i18n::translate('dom1.foo', false, 'dom1'), 'FOO');

		// verify that only dom2 will be cached now
		$this->assertEqual($i18n->__cache[0]['key'], 'dom2_' . $lang);
		$this->assertEqual(count($i18n->__cache), 1);

		// write to cache
		$i18n->__destruct();

		// verify caching through manual read from cache
		$cachedDom2 = Cache::read('dom2_' . $lang, '_cake_core_');
		$this->assertEqual($cachedDom2['dom2.foo'], 'Dom 2 Foo');
		$this->assertEqual($cachedDom2['dom2.bar'], 'Dom 2 Bar');
	}
/**
 * testDefaultStrings method
 *
 * @access public
 * @return void
 */
	function testDefaultStrings() {
		$singular = $this->__singular();
		$this->assertEqual('Plural Rule 1', $singular);

		$plurals = $this->__plural();
		$this->assertTrue(in_array('0 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('1 = 1', $plurals));
		$this->assertTrue(in_array('2 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('3 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('4 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('5 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('6 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('7 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('8 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('9 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('10 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('11 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('12 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('13 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('14 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('15 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('16 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('17 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('18 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('19 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('20 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('21 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('22 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('23 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('24 = 0 or > 1', $plurals));
		$this->assertTrue(in_array('25 = 0 or > 1', $plurals));

		$coreSingular = $this->__singularFromCore();
		$this->assertEqual('Plural Rule 1 (from core)', $coreSingular);

		$corePlurals = $this->__pluralFromCore();
		$this->assertTrue(in_array('0 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('1 = 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('2 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('3 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('4 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('5 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('6 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('7 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('8 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('9 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('10 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('11 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('12 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('13 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('14 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('15 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('16 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('17 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('18 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('19 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('20 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('21 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('22 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('23 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('24 = 0 or > 1 (from core)', $corePlurals));
		$this->assertTrue(in_array('25 = 0 or > 1 (from core)', $corePlurals));
	}
/**
 * testPoRulesZero method
 *
 * @access public
 * @return void
 */
	function testPoRulesZero() {
		Configure::write('Config.language', 'rule_0_po');

		$singular = $this->__singular();
		$this->assertEqual('Plural Rule 0 (translated)', $singular);

		$plurals = $this->__plural();
		$this->assertTrue(in_array('0 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('1 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('2 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('3 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('4 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('5 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('6 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('7 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('8 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('9 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('10 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('11 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('12 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('13 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('14 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('15 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('16 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('17 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('18 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('19 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('20 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('21 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('22 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('23 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('24 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('25 ends with any # (translated)', $plurals));

		$coreSingular = $this->__singularFromCore();
		$this->assertEqual('Plural Rule 0 (from core translated)', $coreSingular);

		$corePlurals = $this->__pluralFromCore();
		$this->assertTrue(in_array('0 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('1 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('2 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('3 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('4 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('5 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('6 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('7 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('8 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('9 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('10 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('11 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('12 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('13 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('14 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('15 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('16 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('17 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('18 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('19 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('20 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('21 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('22 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('23 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('24 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('25 ends with any # (from core translated)', $corePlurals));
	}
/**
 * testMoRulesZero method
 *
 * @access public
 * @return void
 */
	function testMoRulesZero() {
		Configure::write('Config.language', 'rule_0_mo');

		$singular = $this->__singular();
		$this->assertEqual('Plural Rule 0 (translated)', $singular);

		$plurals = $this->__plural();
		$this->assertTrue(in_array('0 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('1 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('2 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('3 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('4 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('5 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('6 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('7 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('8 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('9 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('10 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('11 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('12 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('13 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('14 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('15 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('16 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('17 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('18 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('19 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('20 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('21 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('22 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('23 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('24 ends with any # (translated)', $plurals));
		$this->assertTrue(in_array('25 ends with any # (translated)', $plurals));

		$coreSingular = $this->__singularFromCore();
		$this->assertEqual('Plural Rule 0 (from core translated)', $coreSingular);

		$corePlurals = $this->__pluralFromCore();
		$this->assertTrue(in_array('0 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('1 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('2 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('3 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('4 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('5 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('6 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('7 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('8 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('9 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('10 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('11 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('12 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('13 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('14 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('15 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('16 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('17 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('18 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('19 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('20 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('21 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('22 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('23 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('24 ends with any # (from core translated)', $corePlurals));
		$this->assertTrue(in_array('25 ends with any # (from core translated)', $corePlurals));
	}
/**
 * testPoRulesOne method
 *
 * @access public
 * @return void
 */
	function testPoRulesOne() {
		Configure::write('Config.language', 'rule_1_po');

		$singular = $this->__singular();
		$this->assertEqual('Plural Rule 1 (translated)', $singular);

		$plurals = $this->__plural();
		$this->assertTrue(in_array('0 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('1 = 1 (translated)', $plurals));
		$this->assertTrue(in_array('2 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('3 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('4 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('5 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('6 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('7 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('8 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('9 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('10 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('11 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('12 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('13 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('14 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('15 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('16 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('17 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('18 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('19 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('20 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('21 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('22 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('23 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('24 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('25 = 0 or > 1 (translated)', $plurals));

		$coreSingular = $this->__singularFromCore();
		$this->assertEqual('Plural Rule 1 (from core translated)', $coreSingular);

		$corePlurals = $this->__pluralFromCore();
		$this->assertTrue(in_array('0 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('1 = 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('2 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('3 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('4 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('5 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('6 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('7 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('8 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('9 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('10 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('11 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('12 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('13 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('14 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('15 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('16 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('17 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('18 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('19 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('20 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('21 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('22 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('23 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('24 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('25 = 0 or > 1 (from core translated)', $corePlurals));
	}
/**
 * testMoRulesOne method
 *
 * @access public
 * @return void
 */
	function testMoRulesOne() {
		Configure::write('Config.language', 'rule_1_mo');

		$singular = $this->__singular();
		$this->assertEqual('Plural Rule 1 (translated)', $singular);

		$plurals = $this->__plural();
		$this->assertTrue(in_array('0 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('1 = 1 (translated)', $plurals));
		$this->assertTrue(in_array('2 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('3 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('4 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('5 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('6 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('7 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('8 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('9 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('10 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('11 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('12 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('13 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('14 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('15 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('16 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('17 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('18 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('19 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('20 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('21 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('22 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('23 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('24 = 0 or > 1 (translated)', $plurals));
		$this->assertTrue(in_array('25 = 0 or > 1 (translated)', $plurals));

		$coreSingular = $this->__singularFromCore();
		$this->assertEqual('Plural Rule 1 (from core translated)', $coreSingular);

		$corePlurals = $this->__pluralFromCore();
		$this->assertTrue(in_array('0 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('1 = 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('2 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('3 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('4 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('5 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('6 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('7 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('8 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('9 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('10 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('11 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('12 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('13 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('14 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('15 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('16 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('17 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('18 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('19 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('20 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('21 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('22 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('23 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('24 = 0 or > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('25 = 0 or > 1 (from core translated)', $corePlurals));
	}
/**
 * testPoRulesTwo method
 *
 * @access public
 * @return void
 */
	function testPoRulesTwo() {
		Configure::write('Config.language', 'rule_2_po');

		$singular = $this->__singular();
		$this->assertEqual('Plural Rule 2 (translated)', $singular);

		$plurals = $this->__plural();
		$this->assertTrue(in_array('0 = 0 or 1 (translated)', $plurals));
		$this->assertTrue(in_array('1 = 0 or 1 (translated)', $plurals));
		$this->assertTrue(in_array('2 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('3 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('4 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('5 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('6 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('7 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('8 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('9 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('10 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('11 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('12 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('13 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('14 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('15 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('16 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('17 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('18 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('19 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('20 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('21 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('22 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('23 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('24 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('25 > 1 (translated)', $plurals));

		$coreSingular = $this->__singularFromCore();
		$this->assertEqual('Plural Rule 2 (from core translated)', $coreSingular);

		$corePlurals = $this->__pluralFromCore();
		$this->assertTrue(in_array('0 = 0 or 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('1 = 0 or 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('2 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('3 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('4 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('5 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('6 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('7 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('8 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('9 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('10 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('11 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('12 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('13 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('14 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('15 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('16 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('17 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('18 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('19 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('20 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('21 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('22 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('23 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('24 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('25 > 1 (from core translated)', $corePlurals));
	}
/**
 * testMoRulesTwo method
 *
 * @access public
 * @return void
 */
	function testMoRulesTwo() {
		Configure::write('Config.language', 'rule_2_mo');

		$singular = $this->__singular();
		$this->assertEqual('Plural Rule 2 (translated)', $singular);

		$plurals = $this->__plural();
		$this->assertTrue(in_array('0 = 0 or 1 (translated)', $plurals));
		$this->assertTrue(in_array('1 = 0 or 1 (translated)', $plurals));
		$this->assertTrue(in_array('2 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('3 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('4 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('5 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('6 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('7 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('8 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('9 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('10 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('11 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('12 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('13 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('14 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('15 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('16 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('17 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('18 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('19 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('20 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('21 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('22 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('23 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('24 > 1 (translated)', $plurals));
		$this->assertTrue(in_array('25 > 1 (translated)', $plurals));

		$coreSingular = $this->__singularFromCore();
		$this->assertEqual('Plural Rule 2 (from core translated)', $coreSingular);

		$corePlurals = $this->__pluralFromCore();
		$this->assertTrue(in_array('0 = 0 or 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('1 = 0 or 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('2 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('3 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('4 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_array('5 > 1 (from core translated)', $corePlurals));
		$this->assertTrue(in_