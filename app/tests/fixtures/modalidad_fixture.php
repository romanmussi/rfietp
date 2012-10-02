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
			'name' => 'Educaci�n T�cnico Profesional',
		),
		array(
			'id' => 2,
			'name' => 'Educaci�n Art�stica',
		),
		array(
			'id' => 3,
			'name' => 'Educaci�n Especial',
		),
                array(
			'id' => 4,
			'name' => 'Educaci�n Permanente de J�venes y Adultos',
		),
                array(
			'id' => 5,
			'name' => 'Educaci�n Rural',
		),
                array(
			'id' => 6,
			'name' => 'Educaci�n Intercultural Biling�e',
		),
                array(
			'id' => 7,
			'name' => 'Educaci�n en Contextos de Privaci�n de Libertad',
		),
                array(
			'id' => 8,
			'name' => 'Educaci�n Domiciliaria y Hospitalaria',
		),
                array(
			'id' => 9,
			'name' => 'No Corresponde',
		),
	);
        
}
?>