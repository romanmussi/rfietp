<?php

class ModalidadFixture  extends CakeTestFixture {
    var $name = 'Modalidad';
    var $import = array('model' => 'Modalidad', 'records' => true);
    
    var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
                'name' => array('type' => 'string', 'null' => true, 'length' => 255),
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Educación Técnico Profesional',
		),
		array(
			'id' => 2,
			'name' => 'Educación Artística',
		),
		array(
			'id' => 3,
			'name' => 'Educación Especial',
		),
                array(
			'id' => 4,
			'name' => 'Educación Permanente de Jóvenes y Adultos',
		),
                array(
			'id' => 5,
			'name' => 'Educación Rural',
		),
                array(
			'id' => 6,
			'name' => 'Educación Intercultural Bilingüe',
		),
                array(
			'id' => 7,
			'name' => 'Educación en Contextos de Privación de Libertad',
		),
                array(
			'id' => 8,
			'name' => 'Educación Domiciliaria y Hospitalaria',
		),
                array(
			'id' => 9,
			'name' => 'No Corresponde',
		),
	);
        
}
?>