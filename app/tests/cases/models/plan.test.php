<?php 
/* SVN FILE: $Id$ */
/* Plan Test cases generated on: 2010-04-22 12:01:13 : 1271948473*/
 require_once dirname(__FILE__) . DS . '..' . DS . 'extra_functions.php';

class PlanTestCase extends CakeTestCase {
    /**
     * @var Plan
     */
    var $Plan = null;

     /* @var $fixtures array */
    var $fixtures = array();
    

    function  __construct() {
        $this->fixtures = getAllFixtures();
    }
    
    function startTest() {
        $this->Plan =& ClassRegistry::init('Plan');
    }

    function testPlanInstance() {
        $this->assertTrue(is_a($this->Plan, 'Plan'));
    }



    function testGetEstructuraSugerida() {
        // plan 1: 2009: mezclado - 2010: 2 de POLI
        // pero la jurisdiccion 2 tiene tambien el de 3 de POLI asignado
        $this->assertEqual($this->Plan->getEstructuraSugerida(5), 1);

        //$this->assertEqual($this->Plan->getEstructuraSugerida(1), 3);

        // con busqueda forzada, quiere sugerencia igual por mas que tenga el
        // id de estructura ya asignado en Plan
        $this->assertEqual($this->Plan->getEstructuraSugerida(5, true), 0);

        $this->assertEqual($this->Plan->getEstructuraSugerida(8), 3);
        $this->assertEqual($this->Plan->getEstructuraSugerida(11), 2);
        $this->assertEqual($this->Plan->getEstructuraSugerida(7), -1);
        $this->Plan->id = 7;

        $this->Plan->recursive = -1;
   //     debug($this->Plan->read(null, 7));
        if(!$this->Plan->saveField('oferta_id', 3, false)) {
                $this->fail('No se pudo guardar un campo del plan');
        }
        if(!$this->Plan->saveField('estructura_plan_id', 3, false)) {
                $this->fail('No se pudo guardar la estructura sugerida');
        }
        $this->assertEqual($this->Plan->getEstructuraSugerida(7), 3);
    }



    function testTieneEstructuraDefinida() {
        $this->assertFalse($this->Plan->tieneEstructuraDefinida(1));
        $this->assertTrue($this->Plan->tieneEstructuraDefinida(2));
        $this->assertFalse($this->Plan->tieneEstructuraDefinida(3));
        $this->assertTrue($this->Plan->tieneEstructuraDefinida(8));
        $this->assertTrue($this->Plan->tieneEstructuraDefinida(11));

        $this->assertFalse($this->Plan->tieneEstructuraDefinida(7));
        $this->Plan->id = 7;
        $this->Plan->recursive = -1;
        if(!$this->Plan->saveField('oferta_id', 3, false)) {
                $this->fail('No se pudo guardar un campo del plan');
        }
        if(!$this->Plan->saveField('estructura_plan_id', 3, false)) {
                $this->fail('No se pudo guardar la estructura sugerida');
        }
        $this->assertTrue($this->Plan->tieneEstructuraDefinida(7));
    }

    function testFindComun(){
        $institId = 2;
        $this->Plan->recursive = 0;
        $is1 = $this->Plan->find('all', array(
                    'conditions'=>array(
                        'Plan.instit_id' => $institId,
                        )
                    )
                );

        $cantPlanesQueHayEnFixture = 2;
        $this->assertEqual(count($is1), $cantPlanesQueHayEnFixture, "me tenia que haber traido $cantPlanesQueHayEnFixture planes");
        $this->assertEqual($is1[0]['Instit']['id'], $institId);
    }


    function testFindCompletoPorInstit(){
        // BUSCO POR INSTIT
        //
        //
        $institId = 2;

        $is1 = $this->Plan->__findCompleto('buscar', array(
                    'recursive' => 3,
                    'conditions'=>array(
                        'Instit.id' => $institId,
                        )
                    )
                );
        // verifico que todas las condiciones de la busqueda sean cumplidas.
        // o sea, que la Instit.id retornada sea la misma que la buscada
        foreach ($is1 as $i){
            $this->assertEqual($i['Instit']['id'], $institId);
        }

        $cantTrajo = count($is1);
        $cantPlanes = 2;
        $this->assertEqual($cantTrajo, $cantPlanes, "la cantidad de planes para la instit $institId es de $cantPlanes mientras que la busqueda trajo $cantTrajo");

        $cantCount = $this->Plan->__findCompleto('count', array(
                    'recursive' => 3,
                    'conditions'=>array(
                        'Instit.id' => $institId,
                        )
                    )
                );
        $this->assertEqual($cantTrajo, $cantCount);
    }


    function testFindCompletoPorInstitTodosLosCiclos(){
        // aca lo que quiero testear es que, cuando no le
        // indico ningun ciclo lectivo. la funcion find_completo me trae
        // los ULTIMOS ciclos lectivos de cada plan de la instit
        $institId = 2;
        $is2 = $this->Plan->__findCompleto('buscar', array(
                    'recursive' => 3,
                    'conditions'=>array(
                        'Instit.id'=> $institId,
                        )
                    )
                );
        $aniosQueTieneEsteInstit = array(
                                         2009, 2009,// anios del ultimo ciclo del Plan id = 2
                                         2007,      // unico anio del ultimo ciclo del Plan id = 3
            );
        foreach ($is2 as $i) {
            foreach ($i['Anio'] as $a ) {
                $c = $a['ciclo_id'];
                $key = array_search($c, $aniosQueTieneEsteInstit);
                if ($key !== FALSE) {
                    unset($aniosQueTieneEsteInstit[$key]);
                } else {
                    $this->fail("el ciclo $c no aparece entre los ciclos que deberia tener esta instit. ¿fixtures outdated? ");
                }
            }
        }
        $this->assertEqual($aniosQueTieneEsteInstit, array());
        
    }

    function testFindCompletoPorInstitYOferta(){

        // BUSCO POR OFERTA
        //
        //
        $institId = 2;
        $ofertaId = 1;
        $is2 = $this->Plan->__findCompleto('buscar', array(
                    'recursive' => 3,
                    'conditions'=>array(
                        'Instit.id'=> $institId,
                        'Titulo.oferta_id' => $ofertaId,
                        )
                    )
                );

        // verifico que todas las condiciones de la busqueda sean cumplidas.
        // o sea, que la Instit.id y el Titulo.id sean los buscados
        foreach ($is2 as $i){
            $this->assertEqual($i['Instit']['id'], $institId);
            $this->assertEqual($i['Titulo']['oferta_id'], $ofertaId);
        }

    }


    function testFindCompletoPorInstitOfertaYCicloxEtapa(){

        // BUSCO POR CICLO
        //
        //
        $ciclo = 2006;
        $institId = 2;
        $ofertaId = 1;
        
        $is2 = $this->Plan->__findCompleto('buscar', array(
                    'conditions'=>array(
                        'Instit.id'=> $institId,
                        'Titulo.oferta_id' => $ofertaId,
                        'Anio.ciclo_id' => $ciclo,
                        ),
                    'recursive' => 3,
                    )
                );
        // verifico que todas las condiciones de la busqueda sean cumplidas.
        // o sea, que la Instit.id y el Titulo.id Anio.ciclo_id sean los buscados
        foreach ($is2 as $i){
            foreach ($i['Anio'] as $a){
                $this->assertEqual($a['ciclo_id'], $ciclo);
                $this->assertTrue(!empty($a['EstructuraPlanesAnio']),'No asoció el modelo EstructuraPlanesAnio');
                $this->assertTrue(!empty($a['Etapa']),'No asoció el modelo Etapa');
            }

            $this->assertEqual($i['Instit']['id'], $institId);
            $this->assertEqual($i['Titulo']['oferta_id'], $ofertaId);

        }

    }


    function testFindCompletoPorInstitOfertaYCiclo(){

        // BUSCO POR CICLO
        //
        //
        $ciclo = 2009;
        $institId = 2;
        $ofertaId = 1;
        $is2 = $this->Plan->__findCompleto('buscar', array(
                    'conditions'=>array(
                        'Instit.id'=> $institId,
                        'Titulo.oferta_id' => $ofertaId,
                        'Anio.ciclo_id' => $ciclo,
                        ),
                    'recursive' => 3,
                    )
                );
        // verifico que todas las condiciones de la busqueda sean cumplidas.
        // o sea, que la Instit.id y el Titulo.id Anio.ciclo_id sean los buscados
        foreach ($is2 as $i){
            foreach ($i['Anio'] as $a){
                $this->assertEqual($a['ciclo_id'], $ciclo);
                $this->assertTrue(!empty($a['EstructuraPlanesAnio']),'No asoció el modelo EstructuraPlanesAnio');
                $this->assertTrue(!empty($a['Etapa']),'No asoció el modelo Etapa');
            }

            $this->assertEqual($i['Instit']['id'], $institId);
            $this->assertEqual($i['Titulo']['oferta_id'], $ofertaId);

        }

    }

    function testDameMatriculaDeCiclo(){
        $planId = 1;
        $institId = 2;
        $ofertaId = 1;
        $matricula = $this->Plan->dameMatriculaDeCiclo( $planId );
        $this->Plan->recursive = 1;
        $plan = $this->Plan->read(null, $planId);
        $contMatricula = 0;
        foreach ($plan['Anio'] as $a) {
            $contMatricula += $a['matricula'];
        }

        $this->assertEqual( $contMatricula, $matricula );

        $planId = 1;
        $matricula = $this->Plan->dameMatriculaDeCiclo( $planId , 2010);

        $this->assertEqual( 2, $matricula );
    }


    function testTraerPlanesCompletosSinAnios(){
        $planIdSinAnios = 5;
        $params = array(
            'recursive' => 3,
            'conditions' => array('Plan.id' => $planIdSinAnios),
        );
        $ps = $this->Plan->__findCompleto($buscaroSoloContar = 'buscar', $params);

        $this->assertEqual(count($ps), 1);
        $this->assertTrue(empty($ps[0]['Anio']));
    }
    
}
?>