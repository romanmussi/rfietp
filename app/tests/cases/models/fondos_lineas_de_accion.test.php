<?php 
/* SVN FILE: $Id$ */
/* FondosLineasDeAccion Test cases generated on: 2010-04-22 10:39:45 : 1271943585*/
App::import('Model', 'FondosLineasDeAccion');

class FondosLineasDeAccionTestCase extends CakeTestCase {
	var $FondosLineasDeAccion = null;
	var $fixtures = array(
            'app.z_fondo_work', 'app.jurisdiccion', 'app.instit', 'app.claseinstit',
            'app.orientacion',  'app.sector', 'app.plan', 'app.subsector',
            'app.lineas_de_accion', 'app.fondos_lineas_de_accion',
            'app.tipoinstit', 'app.dependencia', 'app.departamento', 'app.localidad',
            'app.etp_estado', 'app.oferta', 'app.titulo', 'app.anio', 'app.ciclo',
            'app.etapa', 'app.gestion', 'app.historial_cue', 'app.ticket', 'app.user',
            'app.user_login', 'app.fondo',
        );

	function startTest() {
		$this->FondosLineasDeAccion =& ClassRegistry::init('FondosLineasDeAccion');
	}

	function testFondosLineasDeAccionInstance() {
		$this->assertTrue(is_a($this->FondosLineasDeAccion, 'FondosLineasDeAccion'));
	}

	function testFondosLineasDeAccionFind() {
		$this->FondosLineasDeAccion->recursive = -1;
		$results = $this->FondosLineasDeAccion->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('FondosLineasDeAccion' => array(
			'id' => 1,
			'fondo_id' => 1,
			'lineas_de_accion_id' => 1,
			'monto' => 1,
			'created' => '2010-04-22 10:39:45',
			'modified' => '2010-04-22 10:39:45'
		));
		$this->assertEqual($results, $expected);
	}


       
        function testFind() {
            $montoSumar = 2.5;
            $other = array('FondosLineasDeAccion' => array(
			'id' => 2,
			'fondo_id' => 1,
			'lineas_de_accion_id' => 2,
			'monto' => $montoSumar,
			'created' => '2010-04-22 10:39:45',
			'modified' => '2010-04-22 10:39:45',
		));

            $suma = $this->FondosLineasDeAccion->find('sum');
            $sumaInicial = floatval($suma);

            //guarda y chequea la suma
            $this->FondosLineasDeAccion->save($other['FondosLineasDeAccion']);
            $trajo2 = $this->FondosLineasDeAccion->find('sum');            
            $this->assertEqual($sumaInicial+$montoSumar, floatval($trajo2));


            // este me suma solo la linea de accion id = 2
            $condicion = array('FondosLineasDeAccion.lineas_de_accion_id'=>2);
            $trajo3 = $this->FondosLineasDeAccion->find('sum', array('conditions'=>$condicion));
            $this->assertEqual($montoSumar, $trajo3);


            // ahora inserto otra linea de accion 2 para volver a checkear que pasa cuando voy insertando nuevas
            $montoSumar2 = 10.5;
            $other2 = array('FondosLineasDeAccion' => array(
			'id' => 3,
			'fondo_id' => 1,
			'lineas_de_accion_id' => 2,
			'monto' => $montoSumar2,
			'created' => '2010-04-22 10:39:45',
			'modified' => '2010-04-22 10:39:45',
		));
            $this->FondosLineasDeAccion->save($other2['FondosLineasDeAccion']);
            $trajo4 = $this->FondosLineasDeAccion->find('sum', array('conditions'=>$condicion));
            $this->assertEqual($montoSumar+$montoSumar2, $trajo4);


           
            // pruebo agrupar por 2 campos. No se deberia poder hacer esto
            $trajo5 = $this->FondosLineasDeAccion->find('sum', array(
                        'group' => '"FondosLineasDeAccion"."lineas_de_accion_id"',
            ));

            $expected = array(
                array(
                    'FondosLineasDeAccion' => array(
                        'sum' => 13,
                        'lineas_de_accion_id' => 2,
                    )
                ),
                array(
                    'FondosLineasDeAccion' => array(
                        'sum' => 1,
                        'lineas_de_accion_id' => 1,
                    )
                )
            );
            
            // 
            $this->assertEqual($expected, $trajo5);



            $trajo6 = $this->FondosLineasDeAccion->find('sum');
            $cont = 0;
            foreach ($trajo5 as $plata) {
                $cont += $plata['FondosLineasDeAccion']['sum'];
            }
            $this->assertEqual($trajo6, $cont);
        }
}
?>