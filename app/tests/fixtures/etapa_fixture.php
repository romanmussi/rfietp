<?php

class EtapaFixture extends CakeTestFixture {
	var $name = 'Etapa';

        var $fields = array(
            'id' 	=> array('type' => 'integer', 'key' => 'primary', 'null' => false),
            'name'	=> array('type'=>'string', 'null' => false, 'length' => 100),
            'abrev'	=> array('type'=>'string', 'null' => false, 'length' => 100),
            'orden'	=> array('type' => 'integer', 'null' => false, 'default' => 0),
    );

        
	var $records = array(
		array(
			'id' => 1,
			'name' => 'EGB3',
			'abrev' => '',
			'orden' => 1,
		),
		array(
			'id' => 99,
			'name' => 'No corresponde',
			'abrev' => '',
			'orden' => 99,
		),
		array(
			'id' => 98,
			'name' => 'Sin datos',
			'abrev' => '',
			'orden' => 99,
		),
		array(
			'id' => 2,
			'name' => 'Polimodal',
			'abrev' => '',
			'orden' => 4,
		),
		array(
			'id' => 3,
			'name' => 'Media',
			'abrev' => '',
			'orden' => 9,
		),
		array(
			'id' => 4,
			'name' => 'Ciclo Básico',
			'abrev' => '',
			'orden' => 2,
		),
		array(
			'id' => 5,
			'name' => 'Ciclo Superior',
			'abrev' => '',
			'orden' => 5,
		),
		array(
			'id' => 6,
			'name' => 'Año Superior Polimodal',
			'abrev' => '',
			'orden' => 6,
		),
		array(
			'id' => 100,
			'name' => 'Secundario No Ciclado',
			'abrev' => '',
			'orden' => 8,
		),
		array(
			'id' => 101,
			'name' => 'Ciclo Orientado',
			'abrev' => '',
			'orden' => 9,
		),
		array(
			'id' => 102,
			'name' => 'Primer Ciclo',
			'abrev' => 'PC',
			'orden' => 3,
		),
		array(
			'id' => 103,
			'name' => 'Segundo Ciclo',
			'abrev' => 'SC',
			'orden' => 7,
		),
	);
}

?>