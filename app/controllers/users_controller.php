<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'Text', 'Time');
	var $components = array('Email');


        function verificar(){
        debug($this->User->Aro->verify());
        //debug($this->User->Aro->recover());
            //debug($this->User->Aro->ArosAcos->verify());
            die("termino");
        }

        function arreglar(){
        debug($this->User->Aro->verify());
        debug($this->User->Aro->recover());
        debug($this->User->Aro->verify());
            die("termino");
        }

        
	function listadoUsuarios() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->data['User']['password']='';
			$this->data['User']["password_reset_token"] = uniqid();

			$this->User->create();
			if ($this->User->save($this->data)) {

				$url = Router::url(array('controller'=>'Users', 
                                                         'action'=>'password_reset', 
                                                         $this->data['User']["password_reset_token"]), true);

                                // si el usuario tiene email en su perfil, se envia mail
                                if (!empty($this->data['User']['mail'])) {
                                    $this->Email->smtpOptions = array(
                                            'port'    => Configure::read('Email.port'),
                                            'timeout' => Configure::read('Email.timeout'),
                                            'host'    => Configure::read('Email.host'),
                                            'username'=> Configure::read('Email.username'),
                                            'password'=> Configure::read('Email.password'),
                                    );

                                    $this->Email->delivery = 'smtp';
                                    $this->Email->from     = NOMBRE_CONTACTO.' <'.EMAIL_CONTACTO.'>';
                                    $this->Email->bcc 	   = array(EMAIL_CONTACTO); 
                                    $this->Email->to       = $this->data['User']['mail'];
                                    $this->Email->subject  = 'Usuario creado';
                                    $this->Email->template = 'user_add';
                                    $this->Email->sendAs   = 'both';
                                    $this->set("url", $url);
                                    $this->set("user", $this->data['User']);

                                    $this->Email->send();

                                    $this->log('smtp_errors: ' . $this->Email->smtpError, LOG_DEBUG);
                                }
                                
				$this->Session->setFlash(__('Se ha agregado un nuevo usuario ('.$url.')', true));
				$this->redirect('/users/add');
			} else {
				$this->Session->setFlash(__('No se ha podio registrar. Por favor intente nuevamente.', true));
			}

		}
        $jurisdicciones = $this->User->Jurisdiccion->find('list',array('order'=>'name'));
        // AROS para combo
        $this->Acl->Aro->recursive = 0;
        $aros = $this->Acl->Aro->find('list', array('fields' => array('alias'), 'conditions'=>array('parent_id'=>1), 'order'=>'alias'));
        $this->set(compact('aros','jurisdicciones'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true));
			$this->redirect(array('controller'=>'Users','action'=>'listadoUsuarios'));
		}
                
		if (!empty($this->data)) {
                    
                    $validated = true;
                    if (!empty($this->data['User']['password'])) { 
                        if ($this->Auth->password($this->data['User']['password_check'])!=$this->data['User']['password'])
                        {
                            $validated = false;
                            $this->Session->setFlash('Los passwords no coinciden');
                            $this->data['User']['password']='';
                            $this->data['User']['password_check']='';
                        }
                    }

                    if ($validated) {
                        if ($this->User->save($this->data)) {
                                $this->Session->setFlash(__('El usuario fue guardado correctamente', true));
                                $this->redirect(array('controller'=>'Users','action'=>'listadoUsuarios'));
                        } else {
                                $this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
                        }
                    }
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}


                $jurisdicciones = $this->User->Jurisdiccion->find('list',array('order'=>'name'));
                // AROS para combo
                $this->Acl->Aro->recursive = 0;
                $aros = $this->Acl->Aro->find('list', array('fields' => array('alias'), 'conditions'=>array('parent_id'=>1), 'order'=>'alias'));
                $this->set(compact('aros','jurisdicciones'));
                $this->set('parent_aro_seleced', $this->User->parentNodeId());
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for User', true));
			$this->redirect(array('controller'=>'Users','action'=>'listadoUsuarios'));
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash(__('User deleted', true));
			$this->redirect(array('controller'=>'Users','action'=>'listadoUsuarios'));;
		}
	}
	
	
	
	/**
	 * 
	 *   Cosas de Authentication
	 * 
	 */
	function login()
	{
		if($this->Auth->loginAction == '/Anio/view' || $this->Auth->loginAction == '/Anio/edit' || $this->Auth->loginAction == '/Anio/add' ){
			$this->layout = 'popup';
		}
		
		if ($this->Auth->login()){
			//guardo al usuario actual en la tabla de log 'user_logins'
                        $current_user = $this->Auth->user();
                        $this->User->UserLogin->save(array('user_id'=>$current_user['User']['id']));
                        // grupo (rol)
                        $parent = $this->User->getParentNode($this->Auth->user('id'));
                        // guarda datos en Session
                        $this->Session->write('User.jurisdiccion_id', $current_user['User']['jurisdiccion_id']);
                        $this->Session->write('User.group_alias', strtolower($parent['Aro']['alias']));
                        
			$this->redirect($this->Auth->redirect());	
		}
	}	
	
	
	function logout()
	{
		$this->Session->setFlash('Ha salido de su cuenta');
                $this->Session->destroy();
		$this->redirect($this->Auth->logout());
	}

	
	/**
	 *  Este es para que un usuario se edite el perfil
	 *  
	 * @param id del usuario
	 */
	function self_user_edit($id){
		if (!$id && empty($this->data) || $id != $this->Auth->user('id')) {
			$this->Session->setFlash(__('Usuario Incorrecto', true));
			$this->redirect('/pages/home');
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash(__('Se ha guardado la información correctamente', true));
				$this->data = $this->User->read(null, $id);
			} else {
				$this->Session->setFlash(__('El usuario no pudo ser guardado. Por favor, intente nuevamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
                        $this->data['User']['grupo'] =$this->User->parentNodeId();
		}
	}
	
	
/**
	 *  Este es para que un usuario se edite el perfil
	 *  
	 * @param id del usuario
	 */
	function cambiar_password($id){
		if (!$id && empty($this->data) || $id != $this->Auth->user('id')) {
			$this->Session->setFlash(__('Usuario Incorrecto', true));
			$this->redirect('/pages/home');
		}
		if (!empty($this->data)) {
			if($this->comparePasswords()){ //me fijo que los passwords coincidan
				if ($this->User->save($this->data, $validate = false)) {
					$this->Session->setFlash(__('Se ha guardado el nuevo password correctamente', true));
					$this->redirect('/pages/home');
				} else {
                                    debug($this->User->validationErrors);
					$this->Session->setFlash(__('La contraseña no pudo ser guardada. Por favor, intente nuevamente.', true));
				}
			}
			else $this->Session->setFlash('La contraseña no coincide, por favor reintente.');
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	/**
	 *  Este es para que un usuario resetee el password olvidado o la primera vez
	 *  
	 * @param password_reset_token
	 */
	function password_reset($token){
		if (empty($this->data)) {
			$this->data = $this->User->findByPasswordResetToken($token);
			if (empty($this->data)) {
				$this->Session->setFlash(__('Link incorrecto o expirado. Comuniquese con la unidad de información para que le proporcionen un nuevo link.', true));
				$this->redirect('/pages/home');
			}
		}else if (!empty($this->data)) {
			if($this->comparePasswords()){ //me fijo que los passwords coincidan
				$this->data["User"]["password_reset_token"] = "";
				if ($this->User->save($this->data, $validate = false)) {
					$this->Session->setFlash(__('Se ha guardado el nuevo password correctamente', true));
					$this->redirect('/pages/home');
				} else {
                                    debug($this->User->validationErrors);
					$this->Session->setFlash(__('La contraseña no pudo ser guardada. Por favor, intente nuevamente.', true));
				}
			}
			else $this->Session->setFlash('La contraseña no coincide, por favor reintente.');
		}
	}

	function password_clear($id){
		$user = $this->data = $this->User->read(null, $id);
		$user["User"]["password"] = "";
		$user["User"]["password_reset_token"] = uniqid();
		if($this->User->save($user, $validate = false)) {
			$url = Router::url(array('controller'=>'Users', 
									 'action'=>'password_reset', 
									 $user["User"]["password_reset_token"]), true);

            // si el usuario tiene email en su perfil, se envia mail
            if (!empty($this->data['User']['mail'])) {
                $this->Email->smtpOptions = array(
                        'port'    => Configure::read('Email.port'),
                        'timeout' => Configure::read('Email.timeout'),
                        'host'    => Configure::read('Email.host'),
                        'username'=> Configure::read('Email.username'),
                        'password'=> Configure::read('Email.password'),
                );

                $this->Email->delivery = 'smtp';
                $this->Email->from     = NOMBRE_CONTACTO.' <'.EMAIL_CONTACTO.'>';
                $this->Email->bcc 	   = array(EMAIL_CONTACTO); 
                $this->Email->to       = $this->data['User']['mail'];
                $this->Email->subject  = 'Contraseña reseteada';
                $this->Email->template = 'user_password_reset';
                $this->Email->sendAs   = 'both';
                $this->set("url", $url);
                $this->set("user", $user['User']);
                
                $this->Email->send();

                $this->log('smtp_errors: ' . $this->Email->smtpError, LOG_DEBUG);
            }
			$this->Session->setFlash(__('Se ha reseteado la contraseña del usuario ('.$url.')', true));
			$this->redirect(array('controller'=>'Users','action'=>'listadoUsuarios'));
		}
	}
	
	
	/**
	 *  Esta funcion me convierte los passwors para luego ser comparados
	 *  sirve cuando quiero generar un nuevio opassword y tengo 2 imputs por comparar
	 * @return unknown_type
	 */
	private function comparePasswords(){
		if(!empty( $this->data['User']['password'] ) ){
			$this->data['User']['password'] = $this->Auth->password($this->data['User']['password'] );
		}
		if(!empty( $this->data['User']['password_check'] ) ){
			$this->data['User']['password_check'] = $this->Auth->password( $this->data['User']['password_check'] );
		}
		
		if ($this->data['User']['password'] == $this->data['User']['password_check']){
			return true;
		} else return false;
	}
	
	
}
?>