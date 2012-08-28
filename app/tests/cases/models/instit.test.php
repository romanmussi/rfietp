<?php 
/* SVN FILE: $Id$ */
/* Instit Test cases generated on: 2009-09-17 10:09:16 : 1253194756*/



require_once dirname(__FILE__) . DS . '..' . DS . 'extra_functions.php';

function arrays_are_similar($a, $b) {
  // if the indexes don't match, return immediately
  if (count(array_diff_assoc($a, $b))) {
    return false;
  }
  // we know that the indexes, but maybe not values, match.
  // compare the values between the two arrays
  foreach($a as $k => $v) {
    if ($v !== $b[$k]) {
      return false;
    }
  }
  // we have identical indexes, and no unequal values
  return true;
}


class InstitTestCase extends CakeTestCase {

    var $autoFixtures = true;
	 /* @var $fixtures array */
    var $fixtures = array();

    var $Instit = null;

    function __construct(){
        $this->fixtures = getAllFixtures();
    }
	 
    function startTest() {
        $this->Instit = ClassRegistry::init('Instit');
    }

    function testInstitInstance() {
		$this->assertTrue(is_a($this->Instit, 'Instit'));
    }

    function testFindQueNoTraigaNada(){
        $insId = 1651;
        $this->Instit->recursive = -1;
        $cond = array('conditions'=> array('id'=>$insId));
        $results = $this->Instit->find('first', $cond);
        $this->assertEqual($results, array());

        $results = $this->Instit->find('all', $cond);
        $this->assertEqual($results, array());

        $results = $this->Instit->find('count', $cond);
        $this->assertEqual($results, 0);
    }

    function testInstitFind() {
            $instit_id = rand(100000,95959595);
            $this->Instit->recursive = -1;
            $results = $this->Instit->find('first', array('conditions'=> array('id'=>1)));
            $this->assertTrue(!empty($results));
    }


     function testInstitSave() {
         $instit_id = rand(100000,95959595)+2;
            $expected['Instit'] =  array (
                'id' => $instit_id,
                'gestion_id'=>1,
                'dependencia_id'=>1,
                'nombre_dep'=>"''",
                'tipoinstit_id' => 33,
                'jurisdiccion_id' => 2,
                'cue' => 200192,
                'anexo' => 0 ,
                'esanexo' => 0,
                'nombre' => "FERNANDO FADER",
                'nroinstit' => "06",
                'anio_creacion' => 1934,
                'direccion' => "SALTA 1226",
                'cp' => "1137",
                'telefono' => "4305-1244",
                'mail' => "''",
                'web' => "''",
                'dir_nombre' => "MÓNICA LILIANA UGARTE",
                'dir_tipodoc_id' => 1,
                'dir_nrodoc' => 13285880,
                'dir_telefono' => "''", 'dir_mail' => "''",
                'vice_nombre' => "ELISA SUSANA BARRERA",
                'vice_tipodoc_id' => 1,
                'vice_nrodoc' => 5940865,
                'actualizacion' => "''",
                'observacion' => "''",
                'activo' => 1,
                'ciclo_alta' => 2007,
                'created' => '2007-03-18 10:43:23',
                //'modified' => "2009-08-13 12:17:33",
                'localidad_id' => 1,
                'departamento_id' => 1,
                'lugar' => "''",
                 'mail_alternativo' => '',
                'telefono_alternativo' => '',
                'etp_estado_id' => 0,
                'claseinstit_id' => 0,
                'orientacion_id' => 0,
            );
            
            //$this->Instit->create();
            $this->assertTrue($this->Instit->save($expected, false));
            $expected['Instit']['id'] = $this->Instit->id;
            //debug($this->Instit);
            $this->Instit->recursive = -1;
            $results = $this->Instit->read(null, $instit_id);
            unset ($results['Instit']['nombre_completo']);
            unset ($results['Instit']['modified']);
            $this->assertEqual($results, $expected);
     }


    function testInstitSinPlanGetOrientacionSegunSusPlanes() {
        //$this->loadFixtures('Instit', 'Plan', 'Sector', 'Subsector', 'Orientacion');

        $instit_id = 1;
        $conditions = array('Plan.instit_id'=>$instit_id);
        $planes = $this->Instit->Plan->find('all',array(
                'conditions'=>$conditions));

        // le borro todos los planes
        foreach ($planes as $p) {
            $this->Instit->Plan->del($p['Plan']['id']);
        }

        $cant = $this->Instit->Plan->find('count',array('conditions'=>$conditions));

        if ($cant == 0) {
            $orientacion = $this->Instit->getOrientacionSegunSusPlanes($instit_id);
            $this->assertEqual($orientacion, -1); //sin orientacion
        } else {
            $this->fail("Se tenian que borrar los planes pero no se borraron");
        }

        //prueba una institucion que no existe
        $orientacion = $this->Instit->getOrientacionSegunSusPlanes(56456);
        $this->assertEqual($orientacion, -1); //sin orientacion
    }



    function testGetOrientacionMixtaSegunSusPlanes() {
        // orientaciones posibles
        //  -1. Instit Sin planes
        //   0. Mixta
        //   1. Agropecuaria
        //   2. Industrial
        //   3. Otros
        
        $instit_id = 1;
        $this->Instit->recursive = 1;

        $orientacion = $this->Instit->getOrientacionSegunSusPlanes($instit_id); // del sector informatica, orientacion "Otros"
        $this->assertEqual($orientacion, 2); //orientacion agro

        /*************** Para la Instit ID= 2 ****************************/
        $plan2_id = rand(10000,8999999);
        $plan['Plan'] = array(
                'id'                => $plan2_id,
                'instit_id'         => $instit_id,
                'oferta_id'         => 1,
                'norma'             => "",
                'nombre'            => "Titulo en nada",
                'perfil'            => "Algun Perfil",
                'duracion_hs'       => 3,
                'duracion_semanas'  => 2,
                'duracion_anios'    => 4,
                'matricula'         => 100,
                'observacion'       => "Alguna observacion",
                'ciclo_alta'        => 2007,
                'titulo_id'         => 55, // de orientacion "otros"
        );
        $this->Instit->Plan->create();
        $this->assertTrue($this->Instit->Plan->save($plan, false),'No se pudo guardar un nuevo plan con id: '.$plan2_id.' o este: '.$this->Instit->Plan->id);
        $orientacion = $this->Instit->getOrientacionSegunSusPlanes($instit_id);
        $this->assertEqual($orientacion, 0); //orientacion mixta

        $this->Instit->Plan->del(1); // el que era de sector informatica, orientacion otros
        $orientacion = $this->Instit->getOrientacionSegunSusPlanes($instit_id);
        $this->assertEqual($orientacion, 3); // orientacion industrial
    }


    function testGetOrientacionSegunSusPlanes() {
       // $this->loadFixtures('Instit', 'Plan', 'Sector', 'Subsector', 'Orientacion');

        /*************** Para la Instit ID= 1 ****************************/
        $orientacion = $this->Instit->getOrientacionSegunSusPlanes(1);
        $this->assertEqual($orientacion, 2);

        /* ************** Para la Instit ID= 2 *************************** */
        $orientacion = $this->Instit->getOrientacionSegunSusPlanes(2);
        $this->assertEqual($orientacion, 2);

        $orientacion = $this->Instit->getOrientacionSegunSusPlanes(3);
        $this->assertEqual($orientacion, 2);

        $orientacion = $this->Instit->getOrientacionSegunSusPlanes(4);
        $this->assertEqual($orientacion, 2);
    }

    function testIsCUEValid() {
        // casos que deberian dar 1, porque todo paso bien
        $this->assertEqual($this->Instit->isCUEValid("601254"),1);
        $this->assertEqual($this->Instit->isCUEValid("201254"),1);
        $this->assertEqual($this->Instit->isCUEValid("0601254"),1);
        $this->assertEqual($this->Instit->isCUEValid("0201254"),1);
        $this->assertEqual($this->Instit->isCUEValid("2601254"),1);
        $this->assertEqual($this->Instit->isCUEValid("9401254"),1);

        // Estos son casos que fallan
        $this->assertEqual($this->Instit->isCUEValid("2ss54"),-1);
        $this->assertEqual($this->Instit->isCUEValid("j.kjas"),-1);

        $this->assertEqual($this->Instit->isCUEValid("501254"),-6);
        $this->assertEqual($this->Instit->isCUEValid("9810125"),-7);
        $this->assertEqual($this->Instit->isCUEValid("05101255"),-8);
        $this->assertEqual($this->Instit->isCUEValid("051012555"),-9);

        // este es un numero intermedio entre 3 y 6 digitos
        $this->assertEqual($this->Instit->isCUEValid("6542"),2);

        //este es un numero menor a 3 digitos
        $this->assertEqual($this->Instit->isCUEValid("54"),-1);
    }



    function testEstructuraPlanes(){
        $this->assertFalse($this->Instit->estructuraPlanes('depurados', 1,0));

        $ie = $this->Instit->estructuraPlanes('no-depurados', 2,0);
        $canti = count($ie['Plan']);
        $this->assertTrue(1 == $canti);

        $ie = $this->Instit->estructuraPlanes('depurados', 2,0);
        $canti = count($ie['Plan']);
        $this->assertTrue(1 == $canti);

        $ie = $this->Instit->estructuraPlanes('depurados', 4,0);
        $canti = count($ie['Plan']);
        $this->assertEqual(1 ,$canti);

        $ie = $this->Instit->estructuraPlanes('no-depurados', 4,0);
        $canti = count($ie['Plan']);
        $this->assertTrue(2 == $canti);
    }

    

    function testFindConNombreCompleto(){
        $nombre1 = 'ESCUELA DE EDUCACION TECNICA (E.E.T.) Nº 06  "FERNANDO FADER TEST"';
        $nombre2 = 'ESCUELA DE EDUCACION TECNICA (E.E.T.) Nº 06  "FERNANDO FADER 2"';
        
        $this->Instit->recursive = 0;
        $iii = $this->Instit->find('first', array(
                                'conditions'=>array(
                                    'Instit.id' => 1
                                    )
                                  ));
                                  
        $this->assertNotEqual($iii['Instit']['nombre_completo'], '');
        $this->assertEqual($iii['Instit']['nombre_completo'], $nombre1);

        $iii = $this->Instit->find('first', array(
                                 'conditions'=>array(
                                     'Instit.id' => 2
                                     )));
        $this->assertNotEqual($iii['Instit']['nombre_completo'] , $nombre1);
        $this->assertEqual($iii['Instit']['nombre_completo'] , $nombre2);
    }


    function testDameSumatoriaDeMatriculasPorOferta(){
        $this->Instit->id = 1;
        $rta = $this->Instit->dameSumatoriaDeMatriculasPorOferta();

        $expected = Array(
            'array_de_ofertas' => Array(
                0 => Array(
                        'id' => 1,
                        'abrev' => 'FP'
                    )
                ),
             'array_de_ciclos' => Array(
                0 => 2010,
                1 => 2009,
                 ),
            'totales' => Array(
                2010 => Array(
                    'FP' => Array(
                            'total_matricula' => 2
                        )
                ),
                2009 => Array(
                    'FP' => Array(
                            'total_matricula' => 5
                        )
                )
            )
        );

        $this->assertEqual($rta, $expected);
    }

    function testListSectoresConOferta(){
        $res = $this->Instit->listSectoresConOferta(1,1);
        $expected = array( 8 => 'Construcción');
        $this->assertEqual($res, $expected);
        
        $res = $this->Instit->listSectoresConOferta(5,1);
        $expected = array( 
            8 => 'Construcción',
            2 => 'Aeronáutica',
            );
        $this->assertEqual($res, $expected);
        
        $res = $this->Instit->listSectoresConOferta(5,3);
        $expected = array(
            24 => 'Seguridad, Ambiente e Higiene');
        $this->assertEqual($res, $expected);

        $res = $this->Instit->listSectoresConOferta(5,2);
        $this->assertTrue(empty($res));

        $res = $this->Instit->listSectoresConOferta(5);
        $expected = array(
            8 => 'Construcción',
            2 => 'Aeronáutica',
            24 => 'Seguridad, Ambiente e Higiene',
            );
         $this->assertEqual($res, $expected);
    }


    function testGetCiclosLectivos(){
        $institId = 1;
        $ciclos1 = $this->Instit->getCiclosLectivos( $institId );

        $this->Instit->id = $institId;
        $ciclos2 = $this->Instit->getCiclosLectivos();

        // no deben venir vacios, porque hay ciclos lectivos
        $this->assertTrue(!empty($ciclos1));
        $this->assertTrue(!empty($ciclos2));

        // deben traer exactamente lo mismo
        $this->assertEqual($ciclos1, $ciclos2);

        // busco los ciclos del Plan a mano, para luego hacer un doble checkeo
        $ps = $this->Instit->Plan->find('first', array(
            'conditions' => array(
                'Plan.instit_id' => $institId,
            ),
            'contain' => array('Anio'),
        ));

        // verifico que los planes traidos a mano tengan los ciclos que busque con mi funcion
        // deben tener los mismos ciclos lectivos y, a su vez, no deberia haber de mas.
        // son 2 formas de traer los ciclos, chequeadas una contra la otra
        foreach ( $ps['Anio'] as $a) {
            $ciclo = $a['ciclo_id'];
            if (!empty($ciclos1[$ciclo])){
                unset($ciclo);
            } else {
                $this->fail('la función "getCiclosLectivos() me tuvo que haber traido el ciclo: '.$ciclo.' pero no lo hizo.');
            }
        }
        // si esta vacio quiere decir que todos los ciclos fueron encontrados
        // por ende esta OK
        $this->assertTrue(empty($ciclo));
    }



     function testDameOfertaPorInstitucion(){
        $expected = array('1'=>'Formacion Profesional');
        $ofertas = $this->Instit->getOfertas(1);
        $this->assertEqual($ofertas, $expected);

        $ofertas = $this->Instit->getOfertas(1,2009);
        $this->assertEqual($ofertas, $expected);

        $ofertas = $this->Instit->getOfertas(1,1999);
        $this->assertTrue(empty($ofertas));

        $expected = array(
            '1'=> 'Formacion Profesional',
            '3'=> 'Secundario Tecnico',
            );
        $ofertas = $this->Instit->getOfertas(3);
        $this->assertEqual($ofertas, $expected);
    }


    function testDameCiclosPorOfertaInstits(){
        $ciclosXOf = $this->Instit->getCiclosLectivosXOferta(3, $agregarAnioActual = false);

        $expected = array(
            1 => array(
                'ciclo' => array(2007, 2006),
                'name'  => 'FP',
            ),
            3 => array(
                'ciclo' => array(),
                'name' => 'SEC TEC',
            )
        );

        $this->assertEqual($ciclosXOf, $expected);
    }


    function testGetSectores(){
        $s2010 = $this->Instit->getSectores(1, 2010);
        $s2009 = $this->Instit->getSectores(1, 2009);
        $s2000 = $this->Instit->getSectores(1, 2000);

        $expected = array(8=>'Construcción');
        $this->assertEqual($s2010, $expected);
        $this->assertEqual($s2009, $expected);
        $this->assertEqual($s2000, array());
    }
    

}
?>