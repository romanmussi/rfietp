<?php

class AutoridadesCargoFixture extends CakeTestFixture {
	var $name = 'AutoridadesCargo';

        var $fields = array(
            'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
            'autoridad_id' => array('type'=>'integer', 'null' => true),
            'cargo_id' => array('type'=>'integer', 'null' => true),
            'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);

        var $records = array(
            array(
                'id' => 1,
                'autoridad_id' => 1,
                'cargo_id' => 1,
            )
        );

        
}

?>