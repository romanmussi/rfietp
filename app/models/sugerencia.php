<?php
class Sugerencia extends AppModel {

	var $name = 'Sugerencia';


        var $validate = array(
		'mensaje' => array('notempty'=>array(
                    'rule'=>'notempty',
                    'message' => 'Introduzca alg�n mensaje'
                )),
	);

        var $belongsTo = array(
			'User',
	);
}
?>