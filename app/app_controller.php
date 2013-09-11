<?php
/* SVN FILE: $Id: app_controller.php 7945 2008-12-19 02:16:01Z gwoo $ */
/** 
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
	var $helpers = array('Html', 'Form', 'Ajax',  'Javascript');
	var $components = array('Acl', 'Session', 'Auth', 'RequestHandler');
	
	//esta es una variable que sera mostrada en el layout
	// se crea mediante un elemento que le inserta un listado de urls
	// indicando claramente en que lugar del sitio estoy navegando
	// es una serie de links PEj:
	// institucion -> ofertas -> plan -> año
	// Sencillamente, es un menu de navegacion
	var $rutaUrl_for_layout = array();	
	
	
	/**
	 * Before Render
	 * Antes de mostrar la vista
	 *
	 */
	function beforeRender(){
		$this->set('rutaUrl_for_layout', $this->rutaUrl_for_layout);

                if ($this->RequestHandler->isAjax()){
                    $this->layout = 'ajax';
                }                
	}


	function beforeFilter(){
		/**
		 * 
		 *  REGETP VERSION
		 * 
		 */
		Configure::write('regetpVersion', '1.7.16');
                /*
		$this->Auth->autoRedirect = false;
		$this->Auth->loginError ='Usuario o Contraseña Incorrectos';
		$this->Auth->authError = 'Debe registrarse para acceder a esta página';
		$this->Auth->logoutRedirect='/pages/home';
		$this->Auth->allow('display','login','logout');
		$this->Auth->authorize = 'controller';
                */
                
                //Configure AuthComponent
                //$this->Auth->allow('display','login','logout');
                //$this->Auth->allow('*');return true;
                $this->Auth->allowedActions = array('display','login','logout', 'password_reset');
                $this->Auth->loginError ='Usuario o Contraseña Incorrectos';
		$this->Auth->authError = 'Usted no tiene permisos para acceder a esta página.';
                $this->Auth->planesMejoraError = 'Usted no tiene acceso a los planes de mejora de otra jurisdicción';
                $this->Auth->authorize = 'actions';
                //$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
                $this->Auth->logoutRedirect='/pages/home';
                $this->Auth->autoRedirect = false;


                // si es Ajax y no tengo permisos que me tire un error HTTP
                // asi lo puedo capturar desde jQuery
                if($this->RequestHandler->isAjax()){
                    Configure::write ( 'debug', 1);
                    if (!$this->Acl->check($this->Auth->user(), $this->action)){
                        header('HTTP/1.1 401 Unauthorized');
                    }
                }           
	}

	
}
?>