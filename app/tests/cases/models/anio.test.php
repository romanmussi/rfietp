<?php 
/* SVN FILE: $Id$ */
/* Plan Test cases generated on: 2010-04-22 12:01:13 : 1271948473*/
App::import('Model', 'Anio');

class AnioTestCase extends CakeTestCase {
    /**
     * @var Plan
     */
    var $Plan = null;

    /* @var $fixtures array */
    var $fixtures = array(
            'app.z_fondo_work', 'app.estructura_plan', 'app.estructura_planes_anio', 'app.jurisdicciones_estructura_plan',
            'app.jurisdiccion', 'app.instit', 'app.claseinstit',
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
        $this->Anio =& ClassRegistry::init('Anio');

    }

    function testPlanInstance() {
        $this->assertTrue(is_a($this->Anio, 'Anio'));
    }

    function testEstructuraValida() {
        $this->assertEqual(count($this->Anio->estructuraValida(7)), 4);
        $this->assertEqual(count($this->Anio->estructuraValida(8)),1);
        $this->assertTrue(count($this->Anio->estructuraValida(1)) > 0);
    }


}
?>