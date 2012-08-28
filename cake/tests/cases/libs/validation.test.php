<?php
/* SVN FILE: $Id$ */
/**
 * ValidationTest file
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
App::import('Core', 'Validation');
/**
 * CustomValidator class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs
 */
class CustomValidator {
/**
 * Makes sure that a given $email address is valid and unique
 *
 * @param string $email
 * @return boolean
 * @access public
 */
	function customValidate($check) {
		return preg_match('/^[0-9]{3}$/', $check);
	}
}
/**
 * Test Case for Validation Class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs
 */
class ValidationTest extends CakeTestCase {
/**
 * Validation property
 *
 * @var mixed null
 * @access public
 */
	var $Validation = null;
/**
 * setup method
 *
 * @access public
 * @return void
 */
	function setUp() {
		$this->Validation =& Validation::getInstance();
		$this->_appEncoding = Configure::read('App.encoding');
	}
/**
 * tearDown method
 *
 * @access public
 * @return void
 */
	function tearDown() {
		Configure::write('App.encoding', $this->_appEncoding);
	}
/**
 * testNotEmpty method
 *
 * @access public
 * @return void
 */
	function testNotEmpty() {
		$this->assertTrue(Validation::notEmpty('abcdefg'));
		$this->assertTrue(Validation::notEmpty('fasdf '));
		$this->assertTrue(Validation::notEmpty('fooo'.chr(243).'blabla'));
		$this->assertTrue(Validation::notEmpty('abç