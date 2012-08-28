<?php
class UserLogin extends AppModel {

	var $name = 'UserLogin';
        
	var $validate = array(
		'user_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'User',
	);

}
?>