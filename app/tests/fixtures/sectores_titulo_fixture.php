<?php

class SectoresTituloFixture extends CakeTestFixture {
	var $name = 'SectoresTitulo';

        var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
                'titulo_id' => array('type' => 'integer', 'null' => true, 'default' => 0),
                'sector_id' => array('type' => 'integer', 'null' => true, 'default' => 0),
                'subsector_id' => array('type' => 'integer', 'null' => true, 'default' => 0),
                'prioridad' => array('type' => 'integer', 'null' => true, 'default' => 0),
	);

	var $records = array(
                array(
			'id' => 1,
			'titulo_id' => 1, // Lorem ipsum dolor sit amet
			'sector_id' => 8, // Construcción  orientacion 2
			'subsector_id' => 0,
			'prioridad' => 1,
		),
                array(
			'id' => 2,
			'titulo_id' => 2, // Un titulo inventado 1
			'sector_id' => 2, // aeronautica orientacion 2
			'subsector_id' => 1,
			'prioridad' => 1,
		),
                array(
			'id' => 3,
			'titulo_id' => 2, // Un titulo inventado 1
			'sector_id' => 3, // aeronautica orientacion 2
			'subsector_id' => 0,
			'prioridad' => 0,
		),
		array(
			'id' => 1727,
			'titulo_id' => 60, // Técnico Superior en Comunicación Multimedial
			'sector_id' => 2, // aeronautica orientacion 2
			'subsector_id' => 0,
			'prioridad' => 1,
		),
		array(
			'id' => 1738,
			'titulo_id' => 1242, // 'Cocina Básica'
			'sector_id' => 8, // Construcción  orientacion 2
			'subsector_id' => 0,
			'prioridad' => 1,
		),
		array(
			'id' => 1749,
			'titulo_id' => 55, // Técnico en Producción Agropecuaria con Especialización en Enología
			'sector_id' => 24, // seguridad ambiente e higiene, orientacion 3
			'subsector_id' => 0,
			'prioridad' => 1,
		),
            );
}

?>