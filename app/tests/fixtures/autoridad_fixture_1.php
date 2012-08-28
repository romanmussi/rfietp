<?php 
/* SVN FILE: $Id$ */
/* Autoridad Fixture generated on: 2011-03-03 12:41:45 : 1299166905*/

class AutoridadesCargoFixture extends CakeTestFixture {
	var $name  = 'AutoridadesCargo';
	var $table = 'autoridades_cargos';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'jurisdiccion_id' => array('type'=>'integer', 'null' => true),
		'nombre' => array('type'=>'string', 'null' => false, 'length' => 100),
		'apellido' => array('type'=>'string', 'null' => false, 'length' => 100),
		'fecha_asuncion' => array('type'=>'date', 'null' => true),
		'titulo' => array('type'=>'string', 'null' => true, 'length' => 50),
		'telefono_personal' => array('type'=>'string', 'null' => true, 'length' => 50),
		'telefono_institucional' => array('type'=>'string', 'null' => true, 'length' => 50),
		'email_personal' => array('type'=>'string', 'null' => true, 'length' => 100),
		'email_institucional' => array('type'=>'string', 'null' => true, 'length' => 100),
		'direccion' => array('type'=>'string', 'null' => true, 'length' => 100),
		'localidad_id' => array('type'=>'integer', 'null' => true),
		'departamento_id' => array('type'=>'integer', 'null' => true),
		'indexes' => array('PRIMARY' => array('unique' => true, 'column' => 'id'))
	);
	var $records = array(array(
		'id' => 1,
		'jurisdiccion_id' => 1,
		'nombre' => 'Nombre Autoridad 1',
		'apellido' => 'Apellido Autoridad 1',
		'fecha_asuncion' => '2011-03-03',
		'titulo' => 'Ing.',
		'telefono_personal' => '02214 42-5235',
		'telefono_institucional' => '02254 43-5326',
		'email_personal' => 'alala@gmail.com',
		'email_institucional' => 'alala@gob.edu.ar',
		'direccion' => 'Direccion Autoridad 1',
		'localidad_id' => 1,
		'departamento_id' => 1
	));
}
?>