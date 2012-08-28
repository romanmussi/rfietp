<?php
class User extends AppModel {

	var $name = 'User';
        var $actsAs = array('Acl' => array('type' => 'requester'));
	
	
	var $hasMany = array(
            'UserLogin',
            'Ticket',
            );

        //The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Jurisdiccion',
            );

        var $validate = array(
            'username' => array(
                'notEmpty' => array( // or: array('ruleName', 'param1', 'param2' ...)
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'El Usuario no puede quedar vacío.',
			),
                'unique' => array('rule' => array('unique','username'),
                                                  'message' => 'El username ya existe'),
                ),
            /*'password' => array(
                'notEmpty' => array( // or: array('ruleName', 'param1', 'param2' ...)
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'Debe ingresar una Password.'
			)
                )*/
         );

        function parentNode() {
            return null;
        }

        function parentNodeId() {
           if (!$this->id && empty($this->data)) {
               return null;
           }

           $aro = $this->Aro->find('all', array('fields' => array('parent_id'),
                                'conditions'=>array('foreign_key'=>$this->id)));

           return $aro[0]['Aro']['parent_id'];
           //return array('Group' => array('id' => $data['User']['group_id']));
        }

        function getParentNode($id) {
            if (!$id) {
               return null;
           }

           $aro = $this->Aro->find('all', array('fields' => array('id'),
                                    'conditions'=>array('foreign_key'=>$id)));
           $aro_parent = $this->Aro->getparentnode($aro[0]['Aro']['id']);
           
           return $aro_parent;
        }

	/**
         * After save callback
         *
         * Update the aro for the user.
         *
         * @access public
         * @return void
         */
        function afterSave($created) {
                if (!$created) {
                    $node = $this->node();
                    $aro = $node[0];
                    if (!empty($this->data['User']['grupo'])) {
                        $aro['Aro']['parent_id'] = $this->data['User']['grupo'];
                    }
                    $this->Aro->save($aro);
                }
                else {
                    $node = $this->node();
                    $aro = $node[0];
                    if (!empty($this->data['User']['username'])) {
                        $aro['Aro']['alias'] = $this->data['User']['username'];
                    }
                    if (!empty($this->data['User']['grupo'])) {
                        $aro['Aro']['parent_id'] = $this->data['User']['grupo'];
                    }
                    $this->Aro->save($aro);
                }
        }
        
        function unique($data, $name){
            $this->recursive = 0;
            $found = $this->find($this->name.".$name='".$this->data['User']['username']."'");
            
            $same = isset($this->id) && $found[$this->name]['id'] == $this->id;
            return !$found || $found && $same;
        }
}
?>