<?php 
class InstitFixture extends CakeTestFixture {
    var $name = 'Instit';
    //var $import = 'Instit'; 
	//var $import = array('model' => 'Instit', 'records' => true); 
    
    var $fields = array( 
          'id' => 			array	('type' => 'integer', 	'key' => 'primary', 'null' => false), 
          'gestion_id' => 	array	('type' => 'integer', 	'null' => false),
      	  'dependencia_id'=>array	('type' => 'integer', 	'null' => false), 
          'nombre_dep' => 	array	('type' => 'string', 	'length' => 100, 	'null' => false), 
      	  'tipoinstit_id' =>array	('type' => 'integer', 	'null' => false),
      	  'jurisdiccion_id'=> array	('type' => 'integer', 	'null' => false),
      	  'cue' => 	array		('type' => 'integer', 	'null' => false, 	'default' => '0'),
      	  'anexo' => array		('type' => 'integer', 	'null' => false, 	'default' => '0'),
      	  'esanexo' => array		('type' => 'integer', 	'null' => false, 	'default' => '0'),
      	  'nombre' => array		('type' => 'string', 	'length' => 150, 	'null' => false),
      	  'nroinstit' => array		('type' => 'string', 	'length' => 20, 	'null' => false),
      	  'anio_creacion' => array	('type' => 'integer', 	'null' => false, 	'default' => '0'),
      	  'direccion' => array		('type' => 'string', 	'length' => 100, 	'null' => false),
      	  'cp' => array			('type' => 'string', 	'length' => 8, 		'null' => false),
      	  'telefono' => array		('type' => 'string', 	'length' => 60, 	'null' => false),
      	  'mail' => array		('type' => 'string', 	'length' => 60, 	'null' => false),
      	  'web' => array		('type' => 'string', 	'length' => 60, 	'null' => false),
   	  'dir_nombre' => array		('type' => 'string', 	'length' => 60, 	'null' => false),
      	  'dir_tipodoc_id' => array	('type' => 'integer', 	'null' => false, 	'default' => '0'),
      	  'dir_nrodoc' => array		('type' => 'integer', 	'null' => false, 	'default' => '0'),
      	  'dir_telefono' => array	('type' => 'string', 	'length' => 60, 	'null' => false),
      	  'dir_mail' => array		('type' => 'string', 	'length' => 60, 	'null' => false),
      	  'vice_nombre' => array	('type' => 'string', 	'length' => 60, 	'null' => false),
      	  'vice_tipodoc_id' => array('type' => 'integer', 	'null' => false, 	'default' => '0'),
      	  'vice_nrodoc' => array	('type' => 'integer', 	'null' => false, 	'default' => '0'),
      	  'actualizacion' => array	('type' => 'string', 	'length' => 30, 	'null' => false),
      	  'observacion' => array	('type' => 'text', 		'null' => false),
      	  'activo' => array			('type' => 'integer', 	'null' => false, 	'default' => '0'),
      	  'ciclo_alta' => array		('type' => 'integer', 	'null' => false, 	'default' => '0'),
      	  'created' => array		('type' => 'timestamp'),
      	  'modified' => array		('type' => 'timestamp'),
      	  'localidad_id' => array	('type' => 'integer', 	'default' => '0'),
      	  'departamento_id' => array('type' => 'integer', 	'default' => '0'),
	  'lugar' => array              ('type' => 'string', 	'length' => 110, 	'null' => false, 	'default' => "''"),
          'mail_alternativo' => array              ('type' => 'string', 	'length' => 110, 	'null' => false, 	'default' => "''"),
          'telefono_alternativo' => array              ('type' => 'string', 	'length' => 110, 	'null' => false, 	'default' => "''"),
          'etp_estado_id' =>array	('type' => 'integer', 	'null' => false, 	'default' => '0'),
          'claseinstit_id' =>array	('type' => 'integer', 	'null' => false, 	'default' => '0'),
          'orientacion_id' =>array	('type' => 'integer', 	'null' => false, 	'default' => '0'),
          'modalidad_id' =>array	('type' => 'integer', 	'null' => false, 	'default' => '0'),

   );
    
    
    var $records = array(
        array (
        'id' => 1, 
        'gestion_id'=>1, 
        'dependencia_id'=>1, 
        'nombre_dep'=>"''",      
        'tipoinstit_id' => 33,
        'jurisdiccion_id' => 2, 
        'cue' => 200192, 'anexo' => 0 , 'esanexo' => 0,
        'nombre' => "FERNANDO FADER TEST",
        'nroinstit' => "06",
        'anio_creacion' => 1934, 
        'direccion' => "SALTA 1226", 
        'cp' => "1137", 
        'telefono' => "4305-1244", 
        'mail' => "''", 
        'web' => "''", 
        'dir_nombre' => "M�NICA LILIANA UGARTE", 
        'dir_tipodoc_id' => 1, 
        'dir_nrodoc' => 13285880, 
        'dir_telefono' => "''", 'dir_mail' => "''", 
        'vice_nombre' => "ELISA SUSANA BARRERA", 'vice_tipodoc_id' => 1, 
        'vice_nrodoc' => 5940865, 'actualizacion' => "''",
        'observacion' => "''", 'activo' => 1, 
        'ciclo_alta' => 2007,
        'created' => '2007-03-18 10:43:23', 
        //'modified' => "'2009-08-13 12:17:33'", 
        'localidad_id' => 1,
        'departamento_id' => 1,'lugar' => "''",
        'modalidad_id' => 1,
        ),
        array (
        'id' => 2, 
        'gestion_id'=>1, 
        'dependencia_id'=>1, 
        'nombre_dep'=>"''",      
        'tipoinstit_id' => 33,
        'jurisdiccion_id' => 2, 
        'cue' => 200334, 'anexo' => 0 , 'esanexo' => 0,
        'nombre' => "FERNANDO FADER 2",
        'nroinstit' => "06",
        'anio_creacion' => 1950, 
        'direccion' => "SALTA 1226", 
        'cp' => "1137", 
        'telefono' => "4305-1244", 
        'mail' => "''", 
        'web' => "''", 
        'dir_nombre' => "Director de institucion 2", 
        'dir_tipodoc_id' => 1, 
        'dir_nrodoc' => 13285880, 
        'dir_telefono' => "''", 'dir_mail' => "''", 
        'vice_nombre' => "vicedirector de Institucion 2", 'vice_tipodoc_id' => 1, 
        'vice_nrodoc' => 5940865, 'actualizacion' => "''",
        'observacion' => "''",'activo' => 1, 
        'ciclo_alta' => 2007,
        'created' => '2007-03-18 10:43:23', 
        //'modified' => "'2009-08-13 12:17:33'", 
        'localidad_id' => 1,
        'departamento_id' => 1,'lugar' => "''",
        'modalidad_id' => 1,
        ),
        array (
        'id' => 3, 
        'gestion_id'=>1, 
        'dependencia_id'=>1, 
        'nombre_dep'=>"''",      
        'tipoinstit_id' => 33,
        'jurisdiccion_id' => 2, 
        'cue' => 200015, 'anexo' => 0 , 'esanexo' => 0, 
        'nombre' => "SAN MARTIN", 
        'nroinstit' => "10",
        'anio_creacion' => 1950, 
        'direccion' => "SALTA 1226", 
        'cp' => "1137", 
        'telefono' => "4305-1244", 
        'mail' => "''", 
        'web' => "''", 
        'dir_nombre' => "Director de institucion 3", 
        'dir_tipodoc_id' => 1, 
        'dir_nrodoc' => 13285880, 
        'dir_telefono' => "''", 'dir_mail' => "''", 
        'vice_nombre' => "vicedirector de Institucion 3", 'vice_tipodoc_id' => 1, 
        'vice_nrodoc' => 5940865, 'actualizacion' => "''",
        'observacion' => "''", 'activo' => 1, 
        'ciclo_alta' => 2007,
        'created' => '2007-03-18 10:43:23', 
        //'modified' => "'2009-08-13 12:17:33'", 
        'localidad_id' => 2,
        'departamento_id' => 1,'lugar' => "''",
        'modalidad_id' => 1,
        ),
         array (
        'id' => 4, 
        'gestion_id'=>1, 
        'dependencia_id'=>1, 
        'nombre_dep'=>"''",      
        'tipoinstit_id' => 33,
        'jurisdiccion_id' => 2, 
        'cue' => 200000, 'anexo' => 0 , 'esanexo' => 0,
        'nombre' => "FERNANDO FADER 4",
        'nroinstit' => "12", 
        'anio_creacion' => 1950, 
        'direccion' => "SALTA 1226", 
        'cp' => "1137", 
        'telefono' => "4305-1244", 
        'mail' => "''", 
        'web' => "''", 
        'dir_nombre' => "Director de institucion 4", 
        'dir_tipodoc_id' => 1, 
        'dir_nrodoc' => 13285880, 
        'dir_telefono' => "''", 'dir_mail' => "''", 
        'vice_nombre' => "vicedirector de Institucion 4", 'vice_tipodoc_id' => 1, 
        'vice_nrodoc' => 5940865, 'actualizacion' => "''",
        'observacion' => "''",'activo' => 1, 
        'ciclo_alta' => 2007,
        'created' => '2007-03-18 10:43:23', 
        //'modified' => "'2009-08-13 12:17:33'", 
        'localidad_id' => 1,
        'departamento_id' => 1,'lugar' => "''",
        'modalidad_id' => 1,
        ),
         array (
        'id' => 5,
        'gestion_id'=>1,
        'dependencia_id'=>1,
        'nombre_dep'=>"''",
        'tipoinstit_id' => 214,
        'jurisdiccion_id' => 2,
        'cue' => 4200411, 'anexo' => 0 , 'esanexo' => 0,
        'nombre' => "JOS� INGENIEROS",
        'nroinstit' => "12",
        'anio_creacion' => 1950,
        'direccion' => "SALTA 1226",
        'cp' => "1137",
        'telefono' => "4305-1244",
        'mail' => "''",
        'web' => "''",
        'dir_nombre' => "Director de institucion 4",
        'dir_tipodoc_id' => 1,
        'dir_nrodoc' => 13285880,
        'dir_telefono' => "''", 'dir_mail' => "''",
        'vice_nombre' => "vicedirector de Institucion 4", 'vice_tipodoc_id' => 1,
        'vice_nrodoc' => 5940865, 'actualizacion' => "''",
        'observacion' => "''",'activo' => 1,
        'ciclo_alta' => 2007, 
        'created' => '2007-03-18 10:43:23',
        //'modified' => "'2009-08-13 12:17:33'",
        'localidad_id' => 1,
        'departamento_id' => 1,'lugar' => "''",
        'modalidad_id' => 1,
        ),
         array (
        'id' => 6,
        'gestion_id'=>1,
        'dependencia_id'=>1,
        'nombre_dep'=>"''",
        'tipoinstit_id' => 216,
        'jurisdiccion_id' => 2,
        'cue' => 1402115, 'anexo' => 0 , 'esanexo' => 0,
        'nombre' => "INGENIERO AGR�NOMO J. FREZZI",
        'nroinstit' => "12",
        'anio_creacion' => 1950,
        'direccion' => "SALTA 1226",
        'cp' => "1137",
        'telefono' => "4305-1244",
        'mail' => "''",
        'web' => "''",
        'dir_nombre' => "Director de institucion 4",
        'dir_tipodoc_id' => 1,
        'dir_nrodoc' => 13285880,
        'dir_telefono' => "''", 'dir_mail' => "''",
        'vice_nombre' => "vicedirector de Institucion 4", 'vice_tipodoc_id' => 1,
        'vice_nrodoc' => 5940865, 'actualizacion' => "''",
        'observacion' => "''", 'activo' => 1,
        'ciclo_alta' => 2007, 
        'created' => '2007-03-18 10:43:23',
        //'modified' => "'2009-08-13 12:17:33'",
        'localidad_id' => 1,
        'departamento_id' => 1,'lugar' => "''",
        'modalidad_id' => 1,
        )
    );

}
?> 