<?php
class EtpEstado extends AppModel {

	var $name = 'EtpEstado';
	var $validate = array(
		'name' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Instit',
        );

}
?>