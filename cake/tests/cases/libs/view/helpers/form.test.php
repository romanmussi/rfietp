<?php
/* SVN FILE: $Id$ */
/**
 * FormHelperTest file
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) Tests <https://trac.cakephp.org/wiki/Developement/TestSuite>
 * Copyright 2006-2010, Cake Software Foundation, Inc.
 *
 *  Licensed under The Open Group Test Suite License
 *  Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2006-2010, Cake Software Foundation, Inc.
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
App::import('Core', array('ClassRegistry', 'Controller', 'View', 'Model', 'Security'));
App::import('Helper', 'Html');
App::import('Helper', 'Form');
/**
 * ContactTestController class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class ContactTestController extends Controller {
/**
 * name property
 *
 * @var string 'ContactTest'
 * @access public
 */
	var $name = 'ContactTest';
/**
 * uses property
 *
 * @var mixed null
 * @access public
 */
	var $uses = null;
}
/**
 * Contact class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class Contact extends CakeTestModel {
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
 * name property
 *
 * @var string 'Contact'
 * @access public
 */
	var $name = 'Contact';
/**
 * Default schema
 *
 * @var array
 * @access public
 */
	var $_schema = array(
		'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
		'name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'email' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'phone' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'password' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'published' => array('type' => 'date', 'null' => true, 'default' => null, 'length' => null),
		'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
		'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
	);
/**
 * validate property
 *
 * @var array
 * @access public
 */
	var $validate = array(
		'non_existing' => array(),
		'idontexist' => array(),
		'imrequired' => array('rule' => array('between', 5, 30), 'required' => true),
		'imalsorequired' => array('rule' => 'alphaNumeric', 'required' => true),
		'imnotrequired' => array('required' => false, 'rule' => 'alphaNumeric'),
		'imalsonotrequired' => array('alpha' => array('rule' => 'alphaNumeric','required' => false),
		'between' => array('rule' => array('between', 5, 30))));
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function setSchema($schema) {
		$this->_schema = $schema;
	}
/**
 * hasAndBelongsToMany property
 *
 * @var array
 * @access public
 */
	var $hasAndBelongsToMany = array('ContactTag' => array('with' => 'ContactTagsContact'));
}
/**
 * ContactTagsContact class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class ContactTagsContact extends CakeTestModel {
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * name property
 *
 * @var string 'Contact'
 * @access public
 */
	var $name = 'ContactTagsContact';
/**
 * Default schema
 *
 * @var array
 * @access public
 */
	var $_schema = array(
		'contact_id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
		'contact_tag_id' => array(
			'type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'
		)
	);
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function setSchema($schema) {
		$this->_schema = $schema;
	}
}
/**
 * ContactNonStandardPk class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class ContactNonStandardPk extends Contact {
/**
 * primaryKey property
 *
 * @var string 'pk'
 * @access public
 */
	var $primaryKey = 'pk';
/**
 * name property
 *
 * @var string 'ContactNonStandardPk'
 * @access public
 */
	var $name = 'ContactNonStandardPk';
/**
 * schema method
 *
 * @access public
 * @return void
 */
	function schema() {
		$this->_schema = parent::schema();
		$this->_schema['pk'] = $this->_schema['id'];
		unset($this->_schema['id']);
		return $this->_schema;
	}
}
/**
 * ContactTag class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class ContactTag extends Model {
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * schema definition
 *
 * @var array
 * @access protected
 */
	var $_schema = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => '', 'length' => '8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => '255'),
		'created' => array('type' => 'date', 'null' => true, 'default' => '', 'length' => ''),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => '', 'length' => null)
	);
}
/**
 * UserForm class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class UserForm extends CakeTestModel {
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * primaryKey property
 *
 * @var string 'id'
 * @access public
 */
	var $primaryKey = 'id';
/**
 * name property
 *
 * @var string 'UserForm'
 * @access public
 */
	var $name = 'UserForm';
/**
 * hasMany property
 *
 * @var array
 * @access public
 */
	var $hasMany = array(
		'OpenidUrl' => array('className' => 'OpenidUrl', 'foreignKey' => 'user_form_id'
	));
/**
 * schema definition
 *
 * @var array
 * @access protected
 */
	var $_schema = array(
		'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
		'published' => array('type' => 'date', 'null' => true, 'default' => null, 'length' => null),
		'other' => array('type' => 'text', 'null' => true, 'default' => null, 'length' => null),
		'stuff' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 255),
		'something' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 255),
		'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
		'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
	);
}
/**
 * OpenidUrl class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class OpenidUrl extends CakeTestModel {
/**
 * useTable property
 *
 * @var bool false
 * @access public
 */
	var $useTable = false;
/**
 * primaryKey property
 *
 * @var string 'id'
 * @access public
 */
	var $primaryKey = 'id';
/**
 * name property
 *
 * @var string 'OpenidUrl'
 * @access public
 */
	var $name = 'OpenidUrl';
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array('UserForm' => array(
		'className' => 'UserForm', 'foreignKey' => 'user_form_id'
	));
/**
 * validate property
 *
 * @var array
 * @access public
 */
	var $validate = array('openid_not_registered' => array());
/**
 * schema method
 *
 * @var array
 * @access protected
 */
	var $_schema = array(
		'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
		'user_form_id' => array(
			'type' => 'user_form_id', 'null' => '', 'default' => '', 'length' => '8'
		),
		'url' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
	);
/**
 * beforeValidate method
 *
 * @access public
 * @return void
 */
	function beforeValidate() {
		$this->invalidate('openid_not_registered');
		return true;
	}
}
/**
 * ValidateUser class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class ValidateUser extends CakeTestModel {
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
 * name property
 *
 * @var string 'ValidateUser'
 * @access public
 */
	var $name = 'ValidateUser';
/**
 * hasOne property
 *
 * @var array
 * @access public
 */
	var $hasOne = array('ValidateProfile' => array(
		'className' => 'ValidateProfile', 'foreignKey' => 'user_id'
	));
/**
 * schema method
 *
 * @var array
 * @access protected
 */
	var $_schema = array(
		'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
		'name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'email' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'balance' => array('type' => 'float', 'null' => false, 'length' => '5,2'),
		'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
		'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
	);
/**
 * beforeValidate method
 *
 * @access public
 * @return void
 */
	function beforeValidate() {
		$this->invalidate('email');
		return false;
	}
}
/**
 * ValidateProfile class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class ValidateProfile extends CakeTestModel {
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
 * schema property
 *
 * @var array
 * @access protected
 */
	var $_schema = array(
		'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
		'user_id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
		'full_name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'city' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
		'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
	);
/**
 * name property
 *
 * @var string 'ValidateProfile'
 * @access public
 */
	var $name = 'ValidateProfile';
/**
 * hasOne property
 *
 * @var array
 * @access public
 */
	var $hasOne = array('ValidateItem' => array(
		'className' => 'ValidateItem', 'foreignKey' => 'profile_id'
	));
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array('ValidateUser' => array(
		'className' => 'ValidateUser', 'foreignKey' => 'user_id'
	));
/**
 * beforeValidate method
 *
 * @access public
 * @return void
 */
	function beforeValidate() {
		$this->invalidate('full_name');
		$this->invalidate('city');
		return false;
	}
}
/**
 * ValidateItem class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class ValidateItem extends CakeTestModel {
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
 * name property
 *
 * @var string 'ValidateItem'
 * @access public
 */
	var $name = 'ValidateItem';
/**
 * schema property
 *
 * @var array
 * @access protected
 */
	var $_schema = array(
		'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
		'profile_id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
		'name' => array('type' => 'text', 'null' => '', 'default' => '', 'length' => '255'),
		'description' => array(
			'type' => 'string', 'null' => '', 'default' => '', 'length' => '255'
		),
		'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
		'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null)
	);
/**
 * belongsTo property
 *
 * @var array
 * @access public
 */
	var $belongsTo = array('ValidateProfile' => array('foreignKey' => 'profile_id'));
/**
 * beforeValidate method
 *
 * @access public
 * @return void
 */
	function beforeValidate() {
		$this->invalidate('description');
		return false;
	}
}
/**
 * TestMail class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class TestMail extends CakeTestModel {
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
 * name property
 *
 * @var string 'TestMail'
 * @access public
 */
	var $name = 'TestMail';
}
/**
 * FormHelperTest class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.view.helpers
 */
class FormHelperTest extends CakeTestCase {
/**
 * fixtures property
 *
 * @var array
 * @access public
 */
	var $fixtures = array(null);
/**
 * setUp method
 *
 * @access public
 * @return void
 */
	function setUp() {
		parent::setUp();
		Router::reload();

		$this->Form =& new FormHelper();
		$this->Form->Html =& new HtmlHelper();
		$this->Controller =& new ContactTestController();
		$this->View =& new View($this->Controller);

		ClassRegistry::addObject('view', $view);
		ClassRegistry::addObject('Contact', new Contact());
		ClassRegistry::addObject('ContactNonStandardPk', new ContactNonStandardPk());
		ClassRegistry::addObject('OpenidUrl', new OpenidUrl());
		ClassRegistry::addObject('UserForm', new UserForm());
		ClassRegistry::addObject('ValidateItem', new ValidateItem());
		ClassRegistry::addObject('ValidateUser', new ValidateUser());
		ClassRegistry::addObject('ValidateProfile', new ValidateProfile());

		$this->oldSalt = Configure::read('Security.salt');

		$this->dateRegex = array(
			'daysRegex' => 'preg:/(?:<option value="0?([\d]+)">\\1<\/option>[\r\n]*)*/',
			'monthsRegex' => 'preg:/(?:<option value="[\d]+">[\w]+<\/option>[\r\n]*)*/',
			'yearsRegex' => 'preg:/(?:<option value="([\d]+)">\\1<\/option>[\r\n]*)*/',
			'hoursRegex' => 'preg:/(?:<option value="0?([\d]+)">\\1<\/option>[\r\n]*)*/',
			'minutesRegex' => 'preg:/(?:<option value="([\d]+)">0?\\1<\/option>[\r\n]*)*/',
			'meridianRegex' => 'preg:/(?:<option value="(am|pm)">\\1<\/option>[\r\n]*)*/',
		);

		Configure::write('Security.salt', 'foo!');
	}
/**
 * tearDown method
 *
 * @access public
 * @return void
 */
	function tearDown() {
		ClassRegistry::removeObject('view');
		ClassRegistry::removeObject('Contact');
		ClassRegistry::removeObject('ContactNonStandardPk');
		ClassRegistry::removeObject('ContactTag');
		ClassRegistry::removeObject('OpenidUrl');
		ClassRegistry::removeObject('UserForm');
		ClassRegistry::removeObject('ValidateItem');
		ClassRegistry::removeObject('ValidateUser');
		ClassRegistry::removeObject('ValidateProfile');
		unset($this->Form->Html, $this->Form, $this->Controller, $this->View);
		Configure::write('Security.salt', $this->oldSalt);
	}
/**
 * testFormCreateWithSecurity method
 *
 * Test form->create() with security key.
 *
 * @access public
 * @return void
 */
	function testFormCreateWithSecurity() {
		$this->Form->params['_Token'] = array('key' => 'testKey');

		$result = $this->Form->create('Contact', array('url' => '/contacts/add'));
		$expected = array(
			'form' => array('method' => 'post', 'action' => '/contacts/add'),
			'fieldset' => array('style' => 'display:none;'),
			array('input' => array('type' => 'hidden', 'name' => '_method', 'value' => 'POST')),
			array('input' => array(
				'type' => 'hidden', 'name' => 'data[_Token][key]', 'value' => 'testKey', 'id'
			)),
			'/fieldset'
		);
		$this->assertTags($result, $expected);

		$result = $this->Form->create('Contact', array('url' => '/contacts/add', 'id' => 'MyForm'));
		$expected['form']['id'] = 'MyForm';
		$this->assertTags($result, $expected);
	}
/**
 * Tests form hash generation with model-less data
 *
 * @access public
 * @return void
 */
	function testValidateHashNoModel() {
		$this->Form->params['_Token'] = array('key' => 'foo');
		$result = $this->Form->secure(array('anything'));
		$this->assertPattern('/540ac9c60d323c22bafe997b72c0790f39a8bdef/', $result);
	}
/**
 * Tests that models with identical field names get resolved properly
 *
 * @access public
 * @return void
 */
	function testDuplicateFieldNameResolution() {
		$result = $this->Form->create('ValidateUser');
		$this->assertEqual($this->View->entity(), array('ValidateUser'));

		$result = $this->Form->input('ValidateItem.name');
		$this->assertEqual($this->View->entity(), array('ValidateItem', 'name'));

		$result = $this->Form->input('ValidateUser.name');
		$this->assertEqual($this->View->entity(), array('ValidateUser', 'name'));
		$this->assertPattern('/name="data\[ValidateUser\]\[name\]"/', $result);
		$this->assertPattern('/type="text"/', $result);

		$result = $this->Form->input('ValidateItem.name');
		$this->assertEqual($this->View->entity(), array('ValidateItem', 'name'));
		$this->assertPattern('/name="data\[ValidateItem\]\[name\]"/', $result);
		$this->assertPattern('/<textarea/', $result);

		$result = $this->Form->input('name');
		$this->assertEqual($this->View->entity(), array('ValidateUser', 'name'));
		$this->assertPattern('/name="data\[ValidateUser\]\[name\]"/', $result);
		$this->assertPattern('/type="text"/', $result);
	}
/**
 * Tests that hidden fields generated for checkboxes don't get locked
 *
 * @access public
 * @return void
 */
	function testNoCheckboxLocking() {
		$this->Form->params['_Token'] = array('key' => 'foo');
		$this->assertIdentical($this->Form->fields, array());

		$this->Form->checkbox('check', array('value' => '1'));
		$this->assertIdentical($this->Form->fields, array('check'));
	}
/**
 * testFormSecurityFields method
 *
 * Test generation of secure form hash generation.
 *
 * @access public
 * @return void
 */
	function testFormSecurityFields() {
		$key = 'testKey';
		$fields = array('Model.password', 'Model.username', 'Model.valid' => '0');
		$this->Form->params['_Token']['key'] = $key;
		$result = $this->Form->secure($fields);

		$expected = Security::hash(serialize($fields) . Configure::read('Security.salt'));
		$expected .= ':' . 'Model.valid';

		$expected = array(
			'fieldset' => array('style' => 'display:none;'),
			'input' => array(
				'type' => 'hidden', 'name' => 'data[_Token][fields]',
				'value' => urlencode($expected), 'id' => 'preg:/TokenFields\d+/'
			),
			'/fieldset'
		);
		$this->assertTags($result, $expected);
	}
/**
 * Tests correct generation of text fields for double and float fields
 *
 * @access public
 * @return void
 */
	function testTextFieldGenerationForFloats() {
		$model = ClassRegistry::getObject('Contact');
		$model->setSchema(array('foo' => array(
			'type' => 'float',
			'null' => false,
			'default' => null,
			'length' => null
		)));

		$this->Form->create('Contact');
		$result = $this->Form->input('foo');
		$expected = array(
			'div' => array('class' => 'input text'),
			'label' => array('for' => 'ContactFoo'),
			'Foo',
			'/label',
			array('input' => array(
				'type' => 'text', 'name' => 'data[Contact][foo]',
				'value' => '', 'id' => 'ContactFoo'
			)),
			'/div'
		);
	}
/**
 * testFormSecurityMultipleFields method
 *
 * Test secure() with multiple row form. Ensure hash is correct.
 *
 * @access public
 * @return void
 */
	function testFormSecurityMultipleFields() {
		$key = 'testKey';

		$fields = array(
			'Model.0.password', 'Model.0.username', 'Model.0.hidden' => 'value',
			'Model.0.valid' => '0', 'Model.1.password', 'Model.1.username',
			'Model.1.hidden' => 'value', 'Model.1.valid' => '0'
		);
		$this->Form->params['_Token']['key'] = $key;
		$result = $this->Form->secure($fields);

		$hash  = '51e3b55a6edd82020b3f29c9ae200e14bbeb7ee5%3AModel.0.hidden%7CModel.0.valid';
		$hash .= '%7CModel.1.hidden%7CModel.1.valid';

		$expected = array(
			'fieldset' => array('style' => 'display:none;'),
			'input' => array(
				'type' => 'hidden', 'name' => 'data[_Token][fields]',
				'value' => $hash, 'id' => 'preg:/TokenFields\d+/'
			),
			'/fieldset'
		);
		$this->assertTags($result, $expected);
	}
/**
 * testFormSecurityMultipleSubmitButtons
 *
 * test form submit generation and ensure that _Token is only created on end()
 *
 * @return void
 */
	function testFormSecurityMultipleSubmitButtons() {
		$key = 'testKey';
		$this->Form->params['_Token']['key'] = $key;

		$this->Form->create('Addresses');
		$this->Form->input('Address.title');
		$this->Form->input('Address.first_name');

		$result = $this->Form->submit('Save', array('name' => 'save'));
		$expected = array(
			'div' => array('class' => 'submit'),
			'input' => array('type' => 'submit', 'name' => 'save', 'value' => 'Save'),
			'/div',
		);
		$this->assertTags($result, $expected);
		$result = $this->Form->submit('Cancel', array('name' => 'cancel'));
		$expected = array(
			'div' => array('class' => 'submit'),
			'input' => array('type' => 'submit', 'name' => 'cancel', 'value' => 'Cancel'),
			'/div',
		);
		$this->assertTags($result, $expected);
		$result = $this->Form->end(null);

		$expected = array(
			'fieldset' => array('style' => 'display:none;'),
			'input' => array(
				'type' => 'hidden', 'name' => 'data[_Token][fields]',
				'value' => 'preg:/.+/', 'id' => 'preg:/TokenFields\d+/'
			),
			'/fieldset'
		);
		$this->assertTags($result, $expected);
	}
/**
 * testFormSecurityMultipleInputFields method
 *
 * Test secure form creation with multiple row creation.  Checks hidden, text, checkbox field types
 *
 * @access public
 * @return void
 */
	function testFormSecurityMultipleInputFields() {
		$key = 'testKey';

		$this->Form->params['_Token']['key'] = $key;
		$this->Form->create('Addresses');

		$this->Form->hidden('Addresses.0.id', array('value' => '123456'));
		$this->Form->input('Addresses.0.title');
		$this->Form->input('Addresses.0.first_name');
		$this->Form->input('Addresses.0.last_name');
		$this->Form->input('Addresses.0.address');
		$this->Form->input('Addresses.0.city');
		$this->Form->input('Addresses.0.phone');
		$this->Form->input('Addresses.0.primary', array('type' => 'checkbox'));

		$this->Form->hidden('Addresses.1.id', array('value' => '654321'));
		$this->Form->input('Addresses.1.title');
		$this->Form->input('Addresses.1.first_name');
		$this->Form->input('Addresses.1.last_name');
		$this->Form->input('Addresses.1.address');
		$this->Form->input('Addresses.1.city');
		$this->Form->input('Addresses.1.phone');
		$this->Form->input('Addresses.1.primary', array('type' => 'checkbox'));

		$result = $this->Form->secure($this->Form->fields);

		$hash = 'c9118120e680a7201b543f562e5301006ccfcbe2%3AAddresses.0.id%7CAddresses.1.id';

		$expected = array(
			'fieldset' => array('style' => 'display:none;'),
			'input' => array(
				'type' => 'hidden', 'name' => 'data[_Token][fields]',
				'value' => $hash, 'id' => 'preg:/TokenFields\d+/'
			),
			'/fieldset'
		);
		$this->assertTags($result, $expected);
	}
/**
 * testFormSecurityMultipleInputDisabledFields method
 *
 * test secure form generation with multiple records and disabled fields.
 *
 * @access public
 * @return void
 */
	function testFormSecurityMultipleInputDisabledFields() {
		$key = 'testKey';
		$this->Form->params['_Token']['key'] = $key;
		$this->Form->params['_Token']['disabledFields'] = array('first_name', 'address');
		$this->Form->create();

		$this->Form->hidden('Addresses.0.id', array('value' => '123456'));
		$this->Form->input('Addresses.0.title');
		$this->Form->input('Addresses.0.first_name');
		$this->Form->input('Addresses.0.last_name');
		$this->Form->input('Addresses.0.address');
		$this->Form->input('Addresses.0.city');
		$this->Form->input('Addresses.0.phone');
		$this->Form->hidden('Addresses.1.id', array('value' => '654321'));
		$this->Form->input('Addresses.1.title');
		$this->Form->input('Addresses.1.first_name');
		$this->Form->input('Addresses.1.last_name');
		$this->Form->input('Addresses.1.address');
		$this->Form->input('Addresses.1.city');
		$this->Form->input('Addresses.1.phone');

		$result = $this->Form->secure($this->Form->fields);
		$hash = '774df31936dc850b7d8a5277dc0b890123788b09%3AAddresses.0.id%7CAddresses.1.id';

		$expected = array(
			'fieldset' => array('style' => 'display:none;'),
			'input' => array(
				'type' => 'hidden', 'name' => 'data[_Token][fields]',
				'value' => $hash, 'id' => 'preg:/TokenFields\d+/'
			),
			'/fieldset'
		);
		$this->assertTags($result, $expected);
	}
/**
 * testFormSecurityInputDisabledFields method
 *
 * Test single record form with disabled fields.
 *
 * @access public
 * @return void
 */
	function testFormSecurityInputDisabledFields() {
		$key = 'testKey';
		$this->Form->params['_Token']['key'] = $key;
		$this->Form->params['_Token']['disabledFields'] = array('first_name', 'address');
		$this->Form->create();

		$this->Form->hidden('Addresses.id', array('value' => '123456'));
		$this->Form->input('Addresses.title');
		$this->Form->input('Addresses.first_name');
		$this->Form->input('Addresses.last_name');
		$this->Form->input('Addresses.address');
		$this->Form->input('Addresses.city');
		$this->Form->input('Addresses.phone');

		$result = $this->Form->fields;
		$expected = array(
			'Addresses.id' => '123456', 'Addresses.title', 'Addresses.last_name',
			'Addresses.city', 'Addresses.phone'
		);
		$this->assertEqual($result, $expected);

		$result = $this->Form->secure($expected);

		$hash = '449b7e889128e8e52c5e81d19df68f5346571492%3AAddresses.id';
		$expected = array(
			'fieldset' => array('style' => 'display:none;'),
			'input' => array(
				'type' => 'hidden', 'name' => 'data[_Token][fields]',
				'value' => $hash, 'id' => 'preg:/TokenFields\d+/'
			),
			'/fieldset'
		);
		$this->assertTags($result, $expected);
	}
/**
 * testFormSecuredInput method
 *
 * Test generation of entire secure form, assertions made on input() output.
 *
 * @access public
 * @return void
 */
	function testFormSecuredInput() {
		$this->Form->params['_Token']['key'] = 'testKey';

		$result = $this->Form->create('Contact', array('url' => '/contacts/add'));
		$expected = array(
			'form' => array('method' => 'post', 'action' => '/contacts/add'),
			'fieldset' => array('style' => 'display:none;'),
			array('input' => array('type' => 'hidden', 'name' => '_method', 'value' => 'POST')),
			array('input' => array(
				'type' => 'hidden', 'name' => 'data[_Token][key]',
				'value' => 'testKey', 'id' => 'preg:/Token\d+/'
			)),
			'/fieldset'
		);
		$this->assertTags($result, $expected);

		$result = $this->Form->input('UserForm.published', array('type' => 'text'));
		$expected = array(
			'div' => array('class' => 'input text'),
			'label' => array('for' => 'UserFormPublished'),
			'Published',
			'/label',
			array('input' => array(
				'type' => 'text', 'name' => 'data[UserForm][published]',
				'value' => '', 'id' => 'UserFormPublished'
			)),
			'/div'
		);
		$this->assertTags($result, $expected);

		$result = $this->Form->input('UserForm.other', array('type' => 'text'));
		$expected = array(
			'div' => array('class' => 'input text'),
			'label' => array('for' => 'UserFormOther'),
			'Other',
			'/label',
			array('input' => array(
				'type' => 'text', 'name' => 'data[UserForm][other]',
				'value' => '', 'id' => 'UserFormOther'
			)),
			'/div'
		);
		$this->assertTags($result, $expected);

		$result = $this->Form->hidden('UserForm.stuff');
		$expected = array('input' => array(
				'type' => 'hidden', 'name' => 'data[UserForm][stuff]',
				'value' => '', 'id' => 'UserFormStuff'
		));
		$this->assertTags($result, $expected);

		$result = $this->Form->hidden('UserForm.hidden', array('value' => '0'));
		$expected = array('input' => array(
			'type' => 'hidden', 'name' => 'data[UserForm][hidden]',
			'value' => '0', 'id' => 'UserFormHidden'
		));
		$this->assertTags($result, $expected);

		$result = $this->Form->input('UserForm.something', array('type' => 'checkbox'));
		$expected = array(
			'div' => array('class' => 'input checkbox'),
			array('input' => array(
				'type' => 'hidden', 'name' => 'data[UserForm][something]',
				'value' => '0', 'id' => 'UserFormSomething_'
			)),
			array('input' => array(
				'type' => 'checkbox', 'name' => 'data[UserForm][something]',
				'value' => '1', 'id' => 'UserFormSomething'
			)),
			'label' => array('for' => 'UserFormSomething'),
			'Something',
			'/label',
			'/div'
		);
		$this->assertTags($result, $expected);

		$result = $this->Form->fields;
		$expected = array(
			'UserForm.published', 'UserForm.other', 'UserForm.stuff' => '',
			'UserForm.hidden' => '0', 'UserForm.something'
		);
		$this->assertEqual($result, $expected);

		$hash = 'bd7c4a654e5361f9a433a43f488ff9a1065d0aaf%3AUserForm.hidden%7CUserForm.stuff';

		$result = $this->Form->secure($this->Form->fields);
		$expected = array(
			'fieldset' => array('style' => 'display:none;'),
			array('input' => array(
				'type' => 'hidden', 'name' => 'data[_Token][fields]',
				'value' => $hash, 'id' => 'preg:/TokenFields\d+/'
			)),
			'/fieldset'
		);
		$this->assertTags($result, $expected);
	}
/**
 * Tests that the correct keys are added to the field hash index
 *
 * @access public
 * @return void
 */
	function testFormSecuredFileInput() {
		$this->Form->params['_Token']['key'] = 'testKey';
		$this->assertEqual($this->Form->fields, array());

		$result = $this->Form->file('Attachment.file');
		$expected = array (
			'Attachment.file.name', 'Attachment.file.type', 'Attachment.file.tmp_name',
			'Attachment.file.error', 'Attachment.file.size'
		);
		$this->assertEqual($this->Form->fields, $expected);
	}
/**
 * test that multiple selects keys are added to field hash
 *
 * @access public
 * @return void
 */
	function testFormSecuredMultipleSelect() {
		$this->Form->params['_Token']['key'] = 'testKey';
		$this->assertEqual($this->Form->fields, array());
		$options = array('1' => 'one', '2' => 'two');

		$this->Form->select('Model.select', $options);
		$expected = array('Model.select');
		$this->assertEqual($this->Form->fields, $expected);

		$this->Form->fields = array();
		$this->Form->select('Model.select', $options, null, array('multiple' => true));
		$this->assertEqual($this->Form->fields, $expected);
	}
/**
 * testFormSecuredRadio method
 *
 * @access public
 * @return void
 */
	function testFormSecuredRadio() {
		$this->Form->params['_Token']['key'] = 'testKey';
		$this->assertEqual($this->Form->fields, array());
		$options = array('1' => 'option1', '2' => 'option2');

		$this->Form->radio('Test.test', $options);
		$expected = array('Test.test');
		$this->assertEqual($this->Form->fields, $expected);
	}
/**
 * testPasswordValidation method
 *
 * test validation errors on password input.
 *
 * @access public
 * @return void
 */
	function testPasswordValidation() {
		$this->Form->validationErrors['Contact']['password'] = 'Please provide a password';
		$result = $this->Form->input('Contact.password');
		$expected = array(
			'div' => array('class' => 'input password error'),
			'label' => array('for' => 'ContactPassword'),
			'Password',
			'/label',
			'input' => array(
				'type' => 'password', 'name' => 'data[Contact][password]',
				'value' => '', 'id' => 'ContactPassword', 'class' => 'form-error'
			),
			array('div' => array('class' => 'error-message')),
			'Please provide a password',
			'/div',
			'/div'
		);
		$this->assertTags($result, $expected);
	}
/**
 * testFormValidationAssociated method
 *
 * test display of form errors in conjunction with model::validates.
 *
 * @access public
 * @return void
 */
	function testFormValidationAssociated() {
		$this->UserForm =& ClassRegistry::getObject('UserForm');
		$this->UserForm->OpenidUrl =& ClassRegistry::getObject('OpenidUrl');

		$data = array(
			'UserForm' => array('name' => 'user'),
			'OpenidUrl' => array('url' => 'http://www.cakephp.org')
		);

		$this->assertTrue($this->UserForm->OpenidUrl->create($data));
		$this->assertFalse($this->UserForm->OpenidUrl->validates());

		$result = $this->Form->create('UserForm', array('type' => 'post', 'action' => 'login'));
		$expected = array(
			'form' => array(
				'method' => 'post', 'action' => '/user_forms/login/', 'id' => 'UserFormLoginForm'
			),
			'fieldset' => array('style' => 'display:none;'),
			'input' => array('type' => 'hidden', 'name' => '_method', 'value' => 'POST'),
			'/fieldset'
		);
		$this->assertTags($result, $expected);

		$expected = array('O