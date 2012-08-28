<?php
/* Tipoinstit Fixture generated on: 2010-04-29 09:04:13 : 1272544033 */
class TipoinstitFixture extends CakeTestFixture {
	var $name = 'Tipoinstit';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'jurisdiccion_id' => array('type' => 'integer', 'null' => false),
		'name' => array('type' => 'string', 'null' => false, 'length' => 100),
	);

	var $records = array(
		array(
			'id' => 33,
                        'jurisdiccion_id' => 2,
                        'name' => 'ESCUELA DE EDUCACION TECNICA (E.E.T.)'
		),
                array(
                        'id' => 9,
                        'jurisdiccion_id' => 2,
                        'name' => 'CENTRO EDUCATIVO DE NIVEL TERCIARIO (C.E.N.T.)'
		),
                array(
			'id' => 3,
                        'jurisdiccion_id' => 2,
                        'name' => 'ESCUELA POLITECNICA'
		),
                array(
			'id' => 8,
                        'jurisdiccion_id' => 2,
                        'name' => 'ESCUELA'
		),
                array(
			'id' => 18,
                        'jurisdiccion_id' => 2,
                        'name' => 'CENTRO DE FORMACION PROFESIONAL (C.F.P.)'
		),
                array(
			'id' => 214,
                        'jurisdiccion_id' => 2,
                        'name' => 'INSTITUTO'
		),
                array(
			'id' => 215,
                        'jurisdiccion_id' => 2,
                        'name' => 'MISIÓN MONOTÉCNICA Y DE EXTENSION CULTURAL'
		),
                array(
			'id' => 216,
                        'jurisdiccion_id' => 2,
                        'name' => 'ESCUELA DE EDUCACIÓN MEDIA (E.E.M.)'
		),
                array(
			'id' => 217,
                        'jurisdiccion_id' => 2,
                        'name' => 'INSTITUTO DE EDUCACIÓN SUPERIOR DE COMERCIO'
		),
                array(
			'id' => 218,
                        'jurisdiccion_id' => 2,
                        'name' => 'ESCUELA POLIMODAL'
		),
                array(
			'id' => 219,
                        'jurisdiccion_id' => 2,
                        'name' => 'INSTITUTO POLITÉCNICO'
		),
                array(
			'id' => 220,
                        'jurisdiccion_id' => 2,
                        'name' => 'ESCUELA PROVINCIAL DE EDUCACIÓN TÉCNICA (E.P.E.T.)'
		),
                array(
			'id' => 221,
                        'jurisdiccion_id' => 2,
                        'name' => 'MISIÓN MONOTÉCNICA Y DE CULTURA RURAL Y DOMÉSTICA'
		)
	);
}
?>