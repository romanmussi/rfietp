<?php

class EstructuraPlanFixture  extends CakeTestFixture {
    var $name = 'EstructuraPlan';
    //var $import = 'Plan';
    //var $import = array('model' => 'Plan', 'records' => true);


    var $fields = array(
            'id' 	=> array('type' => 'integer', 'key' => 'primary', 'null' => false),
            'name'	=> array('type'=>'string', 'null' => false, 'length' => 200),
            'etapa_id'	=> array('type' => 'integer', 'null' => false, 'default' => 0),
            'created'   => array('type' => 'timestamp'),
            'modified' 	=> array('type' => 'timestamp'),
    );


    var $records = array(
            array(
                'id' 		=> 1,
                'name'		=> "EGB de 3",
                'etapa_id'	=> 1,
            ),
            array(
                'id' 		=> 2,
                'name'		=> "Polimodal de 3",
                'etapa_id'	=> 2,
            ),
            array(
                'id' 		=> 3,
                'name'		=> "Polimodal de 2",
                'etapa_id'	=> 2,
            ),
    );
}
?>