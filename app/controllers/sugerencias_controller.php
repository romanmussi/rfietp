<?php
class SugerenciasController extends AppController {

    var $name = 'Sugerencias';
    var $helpers = array('Html', 'Form', 'Text', 'Time');
	var $components = array('Email');

    function index() {
        $this->Sugerencia->recursive = 0;
        $this->paginate['order'] = array('Sugerencia.created DESC');
        $this->set('sugerencias', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Sugerencia', true));
            $this->redirect(array('action' => 'index'));
        }

        $this->data = $old = $this->Sugerencia->find('first', array(
                'conditions' => array('Sugerencia.id'=>$id),
                'contain' => array('User' => array('Jurisdiccion'))
        ));
        $this->data['Sugerencia']['leido'] = 1;
        $this->Sugerencia->save($this->data);

        $this->set('sugerencia', $old);
    }

    function add() {
        if (!empty($this->data)) {
            $this->Sugerencia->create();
            if ($this->Sugerencia->save($this->data)) {
                $this->Session->setFlash(__('Gracias por enviarnos una sugerencia', true));

                $this->Sugerencia->User->recursive = 0;
                $user = $this->Sugerencia->User->find('first', array(
                    'conditions' => array('User.id' => $this->data['Sugerencia']['user_id'])
                ));

                // si el usuario tiene email en su perfil, se envia mail
                if (!empty($user['User']['mail'])) {
                    
                    $mensaje  = "Agradecemos que se haya tomado la molestia de enviarnos una sugerencia."."\n\nAtte.\nEquipo de Desarrollo";
                    //$mensaje .= "E-mail: ".$this->data['Correo']['mail']."\n";

                    /* SMTP Options */
                    $this->Email->smtpOptions = array(
                            'port'    => Configure::read('Email.port'),
                            'timeout' => Configure::read('Email.timeout'),
                            'host'    => Configure::read('Email.host'),
                            'username'=> Configure::read('Email.username'),
                            'password'=> Configure::read('Email.password'),
                    );

                    $this->Email->delivery = 'smtp';
                    $this->Email->from     = NOMBRE_CONTACTO.' <'.EMAIL_CONTACTO.'>';
                    $this->Email->to       = $user['User']['mail'];
                    $this->Email->subject  = 'Sugerencia recibida';
                    $this->Email->template = 'simple';
                    $this->set("message", $mensaje);
                    
                    $this->Email->send();

                    $this->log('smtp_errors: ' . $this->Email->smtpError, LOG_DEBUG);
                }
                $this->redirect('/');
            } else {
                $this->Session->setFlash(__('Errores al enviar sugerencia', true));
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Sugerencia', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Sugerencia->save($this->data)) {
                $this->Session->setFlash(__('The Sugerencia has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Sugerencia could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Sugerencia->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Sugerencia', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Sugerencia->del($id)) {
            $this->Session->setFlash(__('Sugerencia deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('The Sugerencia could not be deleted. Please, try again.', true));
        $this->redirect(array('action' => 'index'));
    }

}
?>