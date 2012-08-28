<?php
/* Oferta Fixture generated on: 2010-04-29 09:04:02 : 1272544022 */
class OfertaFixture extends CakeTestFixture {
	var $name = 'Oferta';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'abrev' => array('type' => 'string', 'null' => false, 'length' => 10),
		'name' => array('type' => 'string', 'null' => false, 'length' => 30),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id')),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'abrev' => 'FP',
			'name' => 'Formacion Profesional'
		),
                array(
			'id' => 2,
			'abrev' => 'IT',
			'name' => 'Itinerario'
		),
                array(
			'id' => 3,
			'abrev' => 'SEC TEC',
			'name' => 'Secundario Tecnico'
		),
	);
}
?>