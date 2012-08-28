<?php


class OrientacionFixture  extends CakeTestFixture {
	var $name = 'Orientacion';
   	//var $import = 'Orientacion';
 	//var $import = array('model' => 'Orientacion', 'records' => true); 
    
    var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
			'name' => array('type'=>'string', 'null' => true, 'length' => 64),
			);
 	
    var $records = array(
    	array(
    		'id' 	=> 1,
		'name'	=> "Agropecuaria",
    	),
    	array(
    		'id' 	=> 2,
		'name'	=> "Industria",
    	),
    	array(
    		'id' 	=> 3,
		'name'	=> "Otros",
    	),
   );
    
}
?>