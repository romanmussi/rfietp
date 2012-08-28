<?php 
/* SVN FILE: $Id$ */
/* ZFondoWork Test cases generated on: 2010-04-22 12:01:13 : 1271948473*/
App::import('Model', 'ZFondoWork');

class ZFondoWorkTestCase extends CakeTestCase {
    /**
     * @var ZFondoWork
     */
    var $ZFondoWork = null;

    /* @var $fixtures array */
    var $fixtures = array(
            'app.z_fondo_work', 'app.jurisdiccion', 'app.instit', 'app.claseinstit',
            'app.orientacion',  'app.sector', 'app.plan', 'app.subsector',
            'app.lineas_de_accion', 'app.fondos_lineas_de_accion',
            'app.tipoinstit', 'app.dependencia', 'app.departamento', 'app.localidad',
            'app.etp_estado', 'app.oferta', 'app.titulo', 'app.anio', 'app.ciclo',
            'app.etapa', 'app.gestion', 'app.historial_cue', 'app.ticket', 'app.user',
            'app.user_login', 'app.fondo',
    );
//    var $fixtures = array(
//            'app.z_fondo_work', 'app.jurisdiccion', 'app.instit', 'app.claseinstit',
//            'app.lineas_de_accion', 'app.fondos_lineas_de_accion', 'app.orientacion',
//            'app.sector', 'app.plan', 'app.subsector');

    function startTest() {
        $this->ZFondoWork =& ClassRegistry::init('ZFondoWork');

    }

    function testZFondoWorkInstance() {
        $this->assertTrue(is_a($this->ZFondoWork, 'ZFondoWork'));
    }

    function testZFondoWorkFind() {
        $this->ZFondoWork->recursive = -1;
        $results = $this->ZFondoWork->find('first');
        $this->assertTrue(!empty($results));
        $expected['ZFondoWork'] = array(
                'id' => 1,
                'anio' => 2009,
                'trimestre' => 1,
                'jurisdiccion_id' => 2,
                'jurisdiccion_name' => 'CABA',
                'memo' => 'Lorem ipsum dolor',
                'cuecompleto' => '24567801',
                'instit' => 'Lorem ipsum dolor sit amet',
                'instit_name' => 'Lorem ipsum dolor sit amet',
                'departamento' => 'Lorem ipsum dolor sit amet',
                'localidad' => 'Lorem ipsum dolor sit amet',
                'f01' => 10,
                'f02a' => 0,
                'f02b' => 0,
                'f02c' => 0,
                'f03a' => 0,
                'f03b' => 0,
                'f04' => 0,
                'f05' => 15,
                'f06a' => 0,
                'f06b' => 0,
                'f06c' => 0,
                'f07a' => 0,
                'f07b' => 0,
                'f07c' => 0,
                'f08' => 0,
                'f09' => 0,
                'total' => 25,
                'f10' => 0,
                'equipinf' => 0,
                'refaccion' => 0,
                'instit_id' => 1,
                'observacion' => 'Lorem ipsum dolor sit amet',
                'totales_checked' => 1,
                'cue_checked' => 1,
                'tipo' => 'i',
        );
        $this->assertEqual($results, $expected);
    }


    function testTemporalesFiltradosX() {
        $t1 = $this->ZFondoWork->temporalesFiltradosX('ijc');
        $this->assertEqual(1, count($t1));

        $t1 = $this->ZFondoWork->temporalesFiltradosX('j');
        $this->assertEqual(1, count($t1));

        $t1 = $this->ZFondoWork->temporalesFiltradosX('ij');
        $this->assertEqual(3, count($t1));

        $t1 = $this->ZFondoWork->temporalesFiltradosX('ijt');
        $this->assertEqual(4, count($t1));

        $t1 = $this->ZFondoWork->temporalesFiltradosX('tji');
        $this->assertEqual(4, count($t1));

        $t1 = $this->ZFondoWork->temporalesFiltradosX('i');
        $this->assertEqual(2, count($t1));

        $t1 = $this->ZFondoWork->temporalesFiltradosX('ic');
        $this->assertEqual(1, count($t1));

        $t1 = $this->ZFondoWork->temporalesFiltradosX('id');
        $this->assertEqual(0, count($t1));

        $t1 = $this->ZFondoWork->temporalesFiltradosX('idc');
        $this->assertEqual(2, count($t1));

        $t1 = $this->ZFondoWork->temporalesFiltradosX('ijtc');
        $this->assertEqual(2, count($t1));

        $t1 = $this->ZFondoWork->temporalesFiltradosX('d');
        $this->assertEqual(0, count($t1));

        $t1 = $this->ZFondoWork->temporalesFiltradosX('c');
        $this->assertEqual(2, count($t1));

        $t1 = $this->ZFondoWork->temporalesFiltradosX('ijtd');
        $this->assertEqual(0, count($t1));

        $t1 = $this->ZFondoWork->temporalesFiltradosX('jc');
        $this->assertEqual(0, count($t1));
    }


    function testLineasDeAccionesWithNameLowercaseAsId() {
        $lineas = $this->ZFondoWork->__getLineasDeAccionesWithNameLowercaseAsId();

        $this->assertTrue(is_array($lineas));

        $cont = 0;
        foreach ($lineas as $name=>$id) {
            $this->assertTrue(is_string($name));
            $this->assertTrue(is_numeric($id));
            $cont++;
        }
        $this->assertEqual($cont,count($lineas));
    }




    function testVerificarQueLasLineasExistanEnFondo() {
        $l = array('f01'=>1);
        $m = array('g01'=>1);
        $t = array('ZFondoWork'=>array(
                        'id' => 1,
                        'anio' => 2009,
                        'trimestre' => 1,
                        'jurisdiccion_id' => 2,
                        'jurisdiccion_name' => 'CABA',
                        'memo' => 'Lorem ipsum dolor sit amet',
                        'cuecompleto' => 24567801,
                        'instit' => 'Lorem ipsum dolor sit amet',
                        'instit_name' => 'Lorem ipsum dolor sit amet',
                        'departamento' => 'Lorem ipsum dolor sit amet',
                        'localidad' => 'Lorem ipsum dolor sit amet',
                        'f01' => 10,
                        'f02a' => 0,
                        'f02b' => 0,
                        'f02c' => 0,
        ));

        $this->assertEqual ('',$this->ZFondoWork->__verificarQueLasLineasExistanEnFondo($l,$t['ZFondoWork']));
        $this->assertTrue($this->ZFondoWork->__verificarQueLasLineasExistanEnFondo($m,$t['ZFondoWork']));

    }



    function testDameTemporalFiltrandoLineasVacias() {
        $l = array('f01'=>1, 'f02a' => 2, 'f02b' => 3, 'f02c' => 4);

        $t[3]['ZFondoWork'] = array(
                'id' => 15,
                'anio' => 2009,
                'trimestre' => 1,
                'jurisdiccion_id' => 2,
                'jurisdiccion_name' => 'CABA',
                'memo' => 'Lorem ipsum dolor sit amet',
                'cuecompleto' => 24567801,
                'instit' => 'Lorem ipsum dolor sit amet',
                'instit_name' => 'Lorem ipsum dolor sit amet',
                'departamento' => 'Lorem ipsum dolor sit amet',
                'localidad' => 'Lorem ipsum dolor sit amet',
                'f01' => 10,
                'f02a' => 0,
                'f02b' => 0,
                'f02c' => 0,
        );

        $t[13]['ZFondoWork'] = array(
                'id' => 21,
                'anio' => 2009,
                'trimestre' => 1,
                'jurisdiccion_id' => 2,
                'jurisdiccion_name' => 'CABA',
                'memo' => 'Lorem ipsum dolor sit amet',
                'cuecompleto' => 24567801,
                'instit' => 'Lorem ipsum dolor sit amet',
                'instit_name' => 'Lorem ipsum dolor sit amet',
                'departamento' => 'Lorem ipsum dolor sit amet',
                'localidad' => 'Lorem ipsum dolor sit amet',
                'f01' => 0,
                'f02a' => 40,
                'f02b' => 0,
                'f02c' => 20,
        );


        $lin = $this->ZFondoWork->__dameTemporalFiltrandoLineasVacias($l, $t);
        $expected = array(
                3  => array( 'f01'  => 10 ),
                13 => array( 'f02a' => 40, 'f02c'=>20 ),
        );

        $this->assertEqual($expected, $lin);

        unset($t);
        $t[0]['ZFondoWork'] = array(
                'id' => 15,
                'anio' => 2009,
                'trimestre' => 1,
                'jurisdiccion_id' => 2,
                'jurisdiccion_name' => 'CABA',
                'memo' => 'Lorem ipsum dolor sit amet',
                'cuecompleto' => 24567801,
                'instit' => 'Lorem ipsum dolor sit amet',
                'instit_name' => 'Lorem ipsum dolor sit amet',
                'departamento' => 'Lorem ipsum dolor sit amet',
                'localidad' => 'Lorem ipsum dolor sit amet',
                'f01' =>  0,
                'f02a' => 0,
                'f02b' => 0,
                'f02c' => 0,
        );
        $lin = $this->ZFondoWork->__dameTemporalFiltrandoLineasVacias($l, $t);
        //veo que me devuelva un array
        $this->assertTrue(is_array($lin));
        if(is_array($lin)) {
            //verifico que el array este vacio
            $this->assertEqual(0, count($lin[0]));
        }
    }



    function testConvertirLineasYTempsEnAlgoLindoParaGuardar() {
        $aLineasDeAcciones = $this->ZFondoWork->__getLineasDeAccionesWithNameLowercaseAsId();
        //$aLineasDeAcciones = array('f01' => 1, 'f02a' => 2);
        // traerme los registros de z_fondo_work
        $temps = array(array(
                        'ZFondoWork' => array
                        (
                                'id' => 1,
                                'anio' => 2009,
                                'trimestre' => 1,
                                'jurisdiccion_id' => 2,
                                'jurisdiccion_name' => 'CABA',
                                'memo' => 'Lorem ipsum dolor sit amet',
                                'cuecompleto' => 24567801,
                                'instit' => 'Lorem ipsum dolor sit amet',
                                'instit_name' => 'Lorem ipsum dolor sit amet',
                                'departamento' => 'Lorem ipsum dolor sit amet',
                                'localidad' => 'Lorem ipsum dolor sit amet',
                                'f01' => 10,
                                'f02a' => 0,
                                'f02b' => 0,
                                'f02c' => 0,
                                'f03a' => 0,
                                'f03b' => 0,
                                'f04' => 0,
                                'f05' => 15,
                                'f06a' => 0,
                                'f06b' => 0,
                                'f06c' => 0,
                                'f07a' => 0,
                                'f07b' => 0,
                                'f07c' => 0,
                                'f08' => 0,
                                'f09' => 0,
                                'f10' => 0,
                                'equipinf' => 0,
                                'refaccion' => 0,
                                'total' => 25,
                                'instit_id' => 1,
                                'observacion' => 'Lorem ipsum dolor sit amet',
                                'totales_checked' => 1,
                                'cue_checked' => 1,
                                'tipo' => 'i',
                        )
                ), array(
                        'ZFondoWork' => array
                        (
                                'id' => 2,
                                'anio' => 2009,
                                'trimestre' => 1,
                                'jurisdiccion_id' => 2,
                                'jurisdiccion_name' => 'CABA',
                                'memo' => 'Lorem ipsum dolor sit amet',
                                'cuecompleto' => 24567801,
                                'instit' => 'jurisdiccional',
                                'instit_name' => 'jurisdiccional',
                                'departamento' => 'Lorem ipsum dolor sit amet',
                                'localidad' => 'Lorem ipsum dolor sit amet',
                                'f01'  => 0,
                                'f02a' => 0,
                                'f02b' => 0,
                                'f02c' => 0,
                                'f03a' => 0,
                                'f03b' => 0,
                                'f04'  => 10,
                                'f05'  => 0,
                                'f06a' => 0,
                                'f06b' => 0,
                                'f06c' => 0,
                                'f07a' => 0,
                                'f07b' => 0,
                                'f07c' => 0,
                                'f08'  => 0,
                                'f09'  => 0,
                                'f10'  => 0,
                                'equipinf' => 0,
                                'refaccion' => 0,
                                'total' => 10,
                                'instit_id' => 0,
                                'observacion' => 'Lorem ipsum dolor sit amet',
                                'totales_checked' => 1,
                                'cue_checked' => 1,
                                'tipo' => 'j',
                        )
                )
        );

        //$verificado = $this->ZFondoWork->__verificarQueLasLineasExistanEnFondo($aLineasDeAcciones, $temps[0]['ZFondoWork']);

        /** @var array  */
        $lineasFiltradas = $this->ZFondoWork->__dameTemporalFiltrandoLineasVacias($aLineasDeAcciones, $temps);


        $expected[0]['Fondo'] = array (
                'instit_id' => 1,
                'jurisdiccion_id' => 2,
                'memo' => 'Lorem ipsum dolor sit amet',
                'anio' => 2009,
                'trimestre' => 1,
                'total' => 25,
                'resolucion' => "''",
                'description' => 'Lorem ipsum dolor sit amet',
        );

        $expected[0]['Fondo']['FondosLineasDeAccion'] = array(
                array(
                        'monto' => 10,
                        'lineas_de_accion_id' => 1,
                ),
                array(
                        'monto' => 15,
                        'lineas_de_accion_id' => 7,
                )
        );

        $expected[1]['Fondo'] = array (
                'instit_id' => 0,
                'jurisdiccion_id' => 2,
                'memo' => 'Lorem ipsum dolor sit amet',
                'anio' => 2009,
                'trimestre' => 1,
                'total' => 10,
                'resolucion' => "''",
                'description' => 'Lorem ipsum dolor sit amet',
        );

        $expected[1]['Fondo']['FondosLineasDeAccion'] = array(
                array(
                        'monto' => 10,
                        'lineas_de_accion_id' => 6,
                )
        );
        $data = $this->ZFondoWork->__convertirLineasYTempsEnAlgoLindoParaGuardar($temps, $lineasFiltradas);
        $this->assertEqual($expected, $data);
    }


    function testGuardarFondos() {
        // $this->assertTrue($this->ZFondoWork->guardarFondos($data));
        $data[0]['Fondo'] = array (
                'id' => 452,
                'instit_id' => 2,
                'jurisdiccion_id' => 2,
                'memo' => 'Lorem ipsum',
                'anio' => 2009,
                'trimestre' => 1,
                'total' => 25,
                'resolucion' => 'una resolucion',
                'description' => 'unsa descripcion',
        );
        $data[0]['FondosLineasDeAccion'] = array(
                array(
                        'id' => 900,
                        'monto' => 10.2,
                        'lineas_de_accion_id' => 1,
                ),
                array(
                        'id' => 901,
                        'monto' => 15.5,
                        'lineas_de_accion_id' => 7,
                )
        );

        $data[1]['Fondo'] = array (
                'id' => 453,
                'instit_id' => 2,
                'jurisdiccion_id' => 2,
                'memo' => 'Lorem ipsum',
                'anio' => 2009,
                'trimestre' => 1,
                'total' => 25,
                'resolucion' => 'una resolucion',
                'description' => 'unsa descripcion',
        );
        $data[1]['FondosLineasDeAccion'] = array(
                array(
                        'id' => 902,
                        'monto' => 10,
                        'lineas_de_accion_id' => 1,
                )
        );


        $data[2]['Fondo'] = array (
                'id' => 454,
                'instit_id' => 2,
                'jurisdiccion_id' => 2,
                'memo' => 'Lorem ipsum',
                'anio' => 2009,
                'trimestre' => 1,
                'total' => 25,
                'resolucion' => 'una resolucion',
                'description' => 'unsa descripcion',
        );
        $data[2]['FondosLineasDeAccion'] = array(
                array(
                        'id' => 903,
                        'lineas_de_accion_id' => 1,
                        'monto' => 100.35,
                        'created' => '2010-04-22 10:39:45',
                        'modified' => '2010-04-22 10:39:45'
                )
        );
        
        /*
         * Es la suma de las lineas de accion que estan aca arriba
         * @var float $sumaDeLasLineas
         */
        $sumaDeLasLineas = 136.05;

       

        /* @var $fondo Fondo */
        $fondo =& ClassRegistry::init('Fondo');
        /* @var $lineas LineasDeAccion */
        $lineas =& ClassRegistry::init('FondosLineasDeAccion');

         // le sumo lo que esta en el fixture
        $sumaDeLasLineas = 136.05 + $lineas->find('sum');

        // me guardo los valores totales para luego hacer el assert
        $cantFondos = $fondo->find('count');
        $cantLineas = $lineas->find('count');
        //Guardo y chequeo que haya salido todo OK
        $this->assertTrue($this->ZFondoWork->guardarFondos($data));

        $this->assertEqual($cantFondos+3, $fondo->find('count'));
        $this->assertEqual($cantLineas+4, $lineas->find('count'));

        // 137.05 es el total de todos los montos sumados de todas las lineas de accion de los fondos
        $this->assertEqual($sumaDeLasLineas, $lineas->find('sum'));
    }


    function testCheckCantRegistrosFondoConExcel() {
        $dio1 = $this->ZFondoWork->checkCantRegistrosFondoConExcel(2);
        $dio2 = $this->ZFondoWork->checkCantRegistrosFondoConExcel(1);
        $dio3 = $this->ZFondoWork->checkCantRegistrosFondoConExcel(0);
        $this->assertEqual (0, $dio1);

//$dio2 y $dio3 me deberian devolver 2, que es el numero correcto de registors que hay en fondo
        $this->assertEqual(2, $dio2);
        $this->assertEqual(2, $dio3);
    }


    function testMigrar() {
        $this->ZFondoWork->Fondo =& ClassRegistry::init('Fondo');

        // Se elimina lo que esta en el fixture
        $this->ZFondoWork->Fondo->del(1);
        $this->ZFondoWork->Fondo->del(2);

        // asegurarse que no queda ningun registro
        $this->assertEqual(0, $this->ZFondoWork->Fondo->find('count'));

        // ciorro la migracion para instituciones y jurisdiccionales checkeados
        $resu = $this->ZFondoWork->migrar('ijc',0,true);

        $this->assertTrue($resu > 0); // esto asegura que no hubo error
        $this->assertEqual(1, $resu); // hay 1 registro
        $this->assertEqual(2, $this->ZFondoWork->Fondo->FondosLineasDeAccion->find('count'));
        $this->assertEqual(1, $this->ZFondoWork->Fondo->find('count'));

        
        // Se elimina lo que esta en el fixture
        $this->ZFondoWork->Fondo->del(1);

        
        // corro la migracion para instituciones y jurisdiccionales sin importar si estan  o no checkeados
        $resu = $this->ZFondoWork->migrar('ij',0,true);
        
        $this->assertEqual(3, $resu);
        $this->assertEqual(3, $this->ZFondoWork->Fondo->find('count'));
        $this->assertEqual(5, $this->ZFondoWork->Fondo->FondosLineasDeAccion->find('count'));
    }



}
?>