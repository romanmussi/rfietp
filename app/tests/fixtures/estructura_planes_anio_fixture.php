<?php

class EstructuraPlanesAnioFixture  extends CakeTestFixture {
    var $name = 'EstructuraPlanesAnio';
    //var $import = 'Plan';
    //var $import = array('model' => 'Plan', 'records' => true);


    var $fields = array(
            'id' 	=> array('type' => 'integer', 'key' => 'primary', 'null' => false),
            'nro_anio'	=> array('type' => 'integer', 'null' => false, 'default' => 0),
            'estructura_plan_id'	=> array('type' => 'integer', 'null' => false, 'default' => 0),
            'edad_teorica'	=> array('type' => 'integer', 'null' => false, 'default' => 0),
            'anio_escolaridad'	=> array('type' => 'integer', 'null' => false, 'default' => 0),
    );


    var $records = array(
            array(
                'id'                    => 1,
                'nro_anio'              => 1,
                'estructura_plan_id'	=> 1,
                'edad_teorica'          => 11,
                'anio_escolaridad'	=> 1,
            ),
            array(
                'id'                    => 2,
                'nro_anio'              => 2,
                'estructura_plan_id'	=> 1,
                'edad_teorica'          => 12,
                'anio_escolaridad'	=> 1,
            ),
            array(
                'id'                    => 3,
                'nro_anio'              => 3,
                'estructura_plan_id'	=> 1,
                'edad_teorica'          => 13,
                'anio_escolaridad'	=> 1,
            ),

        
            array(
                'id'                    => 4,
                'nro_anio'              => 1,
                'estructura_plan_id'	=> 2,
                'edad_teorica'          => 11,
                'anio_escolaridad'	=> 1,
            ),
            array(
                'id'                    => 5,
                'nro_anio'              => 2,
                'estructura_plan_id'	=> 2,
                'edad_teorica'          => 12,
                'anio_escolaridad'	=> 1,
            ),
            array(
                'id'                    => 6,
                'nro_anio'              => 3,
                'estructura_plan_id'	=> 2,
                'edad_teorica'          => 12,
                'anio_escolaridad'	=> 1,
            ),


            array(
                'id'                    => 7,
                'nro_anio'              => 2,
                'estructura_plan_id'	=> 3,
                'edad_teorica'          => 12,
                'anio_escolaridad'	=> 1,
            ),
            array(
                'id'                    => 8,
                'nro_anio'              => 3,
                'estructura_plan_id'	=> 3,
                'edad_teorica'          => 13,
                'anio_escolaridad'	=> 2,
            ),
    );
}
?>