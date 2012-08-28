<?php

define("OFERTA_SECTEC", 3 );
define("SS_LIMIT", 200 );

class DepuradorShell extends Shell {
    var $uses = array('Instit','Plan','Sector','Jurisdiccion', 'Tipoinstit');

    function main($command = null) {
        while (true) {
            if (empty($command)) {
                $command = trim($this->in(''));
            }

            switch ($command) {
                case '':
                case 'help':
                    $this->out('Ayuda del Depurador:');
                    $this->out('-------------');
                    $this->out('debe escribir alguna opción');
                    $this->out('Las opciones son:');
                    $this->out('');
                    $this->out('1) "anios_correlativos"');
                    $this->out('2) "anios_sgn_estructura": me indica cuales son los años, dentro de los correctos, que no coinciden con una estructura válida.');
                    $this->out('3) "arreglar_anios"');
                    $this->out('99) "Todo Junto". Me ejecuta 1, 2 y 3 de un saque');
                    $this->out('');
                    break;

                case 1:
                case 'anios_correlativos':
                    $this->anios_correlativos();
                    break;

                case 2:
                case 'anios_sgn_estructura':
                    $this->anios_sgn_estructura();
                    break;

                case 3:
                case 'arreglar_anios':
                    $this->arreglar_anios();
                    break;


                case 99:
                case 'todo junto':
                    $this->anios_correlativos();
                    $this->anios_sgn_estructura();
                    $this->arreglar_anios();
                    $this->out("¡¡¡ FIN DE TODO JUNTO !!!!");
                    break;


                case 'q':
                case 'quit':
                case 'exit':
                    return true;
                    break;

                default:
                    $this->out("Invalid command\n");
                    break;
            }
            $command = '';
        }
    }



    


    function anios_correlativos() {
        $this->out("comienza la milonga....");
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        $limit = SS_LIMIT;
        

        /* @var $Plan Model */
        $Plan =& $this->Instit->Plan;
        /* @var $Anio Model */
        $Anio =& $this->Instit->Plan->Anio;

        $offset = (-1)*$limit;

        $this->out($Plan->query('update planes set z_anios_correlativos = 0;'));

        $cantPlanes = 0;
        $cantBien = 0;
        $cantMal = 0;
        $contadorpp = 0;        
        
        
        do {
            $offset += $limit;
            $planes = $Plan->find('all', array(
                    'limit'=>$limit,
                    'offset'=> $offset,
                    'contain' => array(
                            'Anio'=> array('order'=>array(
                                            'Anio.ciclo_id',
                                            'Anio.etapa_id',
                                            'Anio.anio')),
                    ),
                    'conditions' => array(
                            'Plan.oferta_id'=>OFERTA_SECTEC,
                            //'Plan.z_anios_correlativos' => 0,
                    ),
                    'order'=>array('Plan.id'),
            ));
            $contadorpp += $Plan->find('count', array(
                    'limit'=>$limit,
                    'offset'=> $offset,
                    'contain' => array(
                            'Anio'=> array('order'=>array(
                                            'Anio.ciclo_id',
                                            'Anio.etapa_id',
                                            'Anio.anio')),
                    ),
                    'conditions' => array(
                            'Plan.oferta_id'=>OFERTA_SECTEC,
                            //'Plan.z_anios_correlativos' => 0,
                    ),
                    'order'=>array('Plan.id'),
            ));

            // terminar la ejecucion cuando ya no haya planes que recorrer
            if (empty($planes)){
                $this->out("´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´ termino 'Anios Correlativos'");
                break;
            }
    
//            if ($offset > 10){
//                $this->out("termino por el offset");
//                return -1;
//            }

            foreach ($planes as $p) {
                $cantPlanes++;
                /* @var integer $aaa es para indicar el número de año y compararlo*/
                $aaa = 0;
                $cicloAnt = 0;
                $todosLosAniosCorrectos = true;
                foreach ($p['Anio'] as $a) {
                    $aaa = ($aaa == 0) ? $a['anio']   :   $aaa;
                    $aaa = ($cicloAnt == $a['ciclo_id']) ? $aaa : $a['anio'];
                    $cicloAnt = ($cicloAnt != $a['ciclo_id']) ? $a['ciclo_id'] : $cicloAnt;

                    if ($aaa != $a['anio']) {
                        $this->out("    ---- A actual es: ".$aaa." y el anio que recorro: ".$a['anio']." para el ciclo: ".$a['ciclo_id']);
                        $todosLosAniosCorrectos = false;
                        break;
                    }
                    $aaa++;
                }
                if ($todosLosAniosCorrectos) {
                    $Plan->id = $p['Plan']['id'];
                    $Plan->saveField('z_anios_correlativos', -1 );
                    $cantBien++;
                } else {
                    $this->out("****** encontró plan malo ID: ".$p['Plan']['id'] ." *****");
                    $Plan->id = $p['Plan']['id'];
                    $Plan->saveField('z_anios_correlativos', 2);
                    $cantMal++;
                }
            }
        } while(1);
        
        $this->out("¡¡¡ TERMINO !!!!");
        $this->out(" ");
        $this->out("Total de planes: $cantPlanes y en el count: $contadorpp");
        $this->out("Bien: $cantBien");
        $this->out("Mal: $cantMal");
        $this->out("´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´ termino 'Anios SGN Estructura'");
    }





    
    function anios_sgn_estructura() {
        $this->out("comienza la milonga....");
        
        $this->layout = 'ajax';
        $this->autoRender = false;
        $limit = SS_LIMIT;

        $Plan =& $this->Instit->Plan;
         /* @var $EstructPlan Model */
        $EstructPlan =& $this->Instit->Plan->EstructuraPlan;
        /* @var $EstructAnio Model */
        $EstructAnio =& $this->Instit->Plan->Anio->EstructuraPlanesAnio;

        $offset = (-1)*$limit;

        $this->out($Plan->query('update planes set z_anios_correctos_sgn_estruct = 0;'));

        do {
            // me traigo los planes
            $offset += $limit;
            $planes = $Plan->find('all', array(
                    'limit'=>$limit,
                    'offset'=> $offset,
                    'recursive' => 1,
                    'contain' => array(
                            'Instit(jurisdiccion_id)',
                            'Anio'=> array('order'=>array(
                                            'Anio.ciclo_id',
                                            'Anio.etapa_id',
                                            'Anio.anio')),
                    ),
                    'conditions' => array(
                            'Plan.oferta_id'=>OFERTA_SECTEC,
                            'Plan.z_anios_correlativos <' => 0, // los que estan bien
                    ),
            ));

            // cuando no encuentra mas pplanos termina la ejecucion
            if (empty($planes)){
                $this->out("´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´ BYE ! Off: $offset");
                break;
            }

//            if ($offset > 10){
//                $this->out("termino por el offset");
//                return -1;
//            }

            // recorro los planes encontrados
            $this->out("Recorriendo ".count($planes)." planes");
            foreach ($planes as $p) {
                $cantAnios = count($p['Anio']);

                // saco el primer año dato del plan
                $primerAnio = array_shift($p['Anio']);

                // traigo las estructuras para esa etapa y jurisdiccion
                $estruc = $EstructPlan->JurisdiccionesEstructuraPlan->find('all', array(
                        'contain' => array(
                            'EstructuraPlan' => array(
                                'EstructuraPlanesAnio'=> array(
                                    'order'=>'EstructuraPlanesAnio.nro_anio'),
                                )),
                        'conditions' => array(
                            'EstructuraPlan.etapa_id'=>$primerAnio['etapa_id'],
                            'JurisdiccionesEstructuraPlan.jurisdiccion_id'=>$p['Instit']['jurisdiccion_id'],
                            ),
                    ));

                // si la jurisdiccion no tiene ese tipo de estructura sigo leyendo el proximo
                if (empty($estruc)){
                    $this->out(array_keys($e));
                    $this->out('finish HIM:::: plan: '.$p['Plan']['id']. ' para jurisdiccion: '.$p['Instit']['jurisdiccion_id']);
                    $Plan->id =  $primerAnio['plan_id'];
                    $Plan->saveField('z_anios_correctos_sgn_estruct', 3 );
                    continue;
                }
                

                // recorro las estructuras y verifico si tengo la misma cantidad de años DATO
                $primerAnioEstruct = array();
                $this->out("++++++ Se encontraron ".count($estruc)." estructuras posibles, recorrientolas");
                foreach ($estruc as $e) {
                    if (count($e['EstructuraPlan']['EstructuraPlanesAnio']) == $cantAnios){
                        $this->out("----    joya, tiene la misma cant de años para el plan ".$p['Plan']['id']);
                       //saco el primer año de la estructura
                       $primerAnioEstruct = array_shift($e['EstructuraPlan']['EstructuraPlanesAnio']);
                       $primerAnioEstruct['name'] = $e['EstructuraPlan']['name'];
                       break;
                    }
                }

                // si la estructura tiene la misma cantidad de años verifico que el año inicial sea el mismo
                if (!empty($primerAnioEstruct)){
                    if ($primerAnioEstruct['nro_anio'] == $primerAnio['anio']) {
                        //$this->out(array_keys($primerAnioEstruct));
                        $Plan->id =  $primerAnio['plan_id'];
                        $Plan->saveField('z_anios_correctos_sgn_estruct', (-1) * $primerAnioEstruct['estructura_plan_id'] );
                        $this->out("    ++++    Anio correcto con estructura: ".$primerAnioEstruct['name']. " del plan ID: ".$primerAnio['plan_id']);
                    } else {
                        $Plan->id =  $primerAnio['plan_id'];
                        $Plan->saveField('z_anios_correctos_sgn_estruct', 100 + $primerAnioEstruct['estructura_plan_id'] );
                        $this->out("    ****    Los años iniciales no coinciden nro_anio: ".$primerAnioEstruct['nro_anio']." primer anio segun datoa actual: ".$primerAnio['anio']);
                    }
                } else { // no tiene la misma cantidad de años
                     $Plan->id =  $primerAnio['plan_id'];
                     $Plan->saveField('z_anios_correctos_sgn_estruct', 2 );
                     $this->out("****** NO fué encontrada ninguna estructura por culpa de la cantidad de años para el plan ID: ".$primerAnio['plan_id'] ."*****");
                }
            }
        } while (1);
        $this->out("´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´ termino 'Correcciòn de Anios'");

    }






    

    function arreglar_anios() {
        $this->layout = 'ajax';
        $this->autoRender = false;
        $limit = SS_LIMIT;

        $Plan =& $this->Instit->Plan;
         /* @var $EstructPlan Model */
        $EstructPlan =& $this->Instit->Plan->EstructuraPlan;
        /* @var $EstructAnio Model */
        $EstructAnio =& $this->Instit->Plan->Anio->EstructuraPlanesAnio;

        $offset = (-1)*$limit;

        $this->out($Plan->query('update anios set z_anio_correcto = 0;'));

        do {
            $this->out("comienza la milonga....");

            // me traigo los planes
            $offset += $limit;
            $planes = $Plan->find('all', array(
                    'limit'=>$limit,
                    'offset'=> $offset,
                    'recursive' => 1,
                    'contain' => array(
                            'Instit(jurisdiccion_id)',
                            'Anio'=> array('order'=>array(
                                            'Anio.ciclo_id',
                                            'Anio.etapa_id',
                                            'Anio.anio')),
                    ),
                    'conditions' => array(
                            'Plan.oferta_id'=>OFERTA_SECTEC,
                            'Plan.z_anios_correctos_sgn_estruct >' => 100, // los que tienen anos correlativos mal
                    ),
            ));

            // cuando no encuentra mas pplanos termina la ejecucion
            if (empty($planes)){
                $this->out("´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´´ BYE ! Off: $offset");
                break;
            }
//
//            if ($offset > 10){
//                $this->out("termino por el offset");
//                return -1;
//            }

            // recorro los planes encontrados
            $this->out("Recorriendo ".count($planes)." planes");
            foreach ($planes as $p) {
                $cantAnios = count($p['Anio']);

                // traigo la estructura de este plan
                $estruc = $EstructPlan->find('first', array(
                            'contain' => array(
                                    'EstructuraPlanesAnio'=> array(
                                        'order'=>'EstructuraPlanesAnio.nro_anio'),
                                    ),
                            'conditions' => array(
                                'EstructuraPlan.id'=>$p['Plan']['z_anios_correctos_sgn_estruct']%100,
                                ),
                        ));
                // si el plan no tiene estructura debo seguir con el pròximo
                if (empty($estruc)){
                    $this->out("Plan ".$p['Plan']['id']." sin estructura encontrada.");
                    continue;
                }

                // agrego el ID de la estructura del anio al array de Anio
                foreach ($p['Anio'] as &$aa) {
                    $ee = array_shift( $estruc['EstructuraPlanesAnio']);
                    if (!empty($ee)) {
                        $aa['z_anio_correcto'] = $ee['id'];
                    }
                }

                // guardo el array Anio
                if ($Plan->Anio->saveAll($p['Anio'])){
                    $this->out("--- Anios del Plan: ".$p['Plan']['id']. " guardado.");
                } else {
                    foreach ($Plan->Anio->validationErrors as $vv) {
                        $this->out($vv);
                    }
                    $this->out("*** ERROR al guardar Anios del Plan: ".$p['Plan']['id']);
                }
            }
        } while (1);
        $this->out("TEEERRRMMMIINÓÓÓÓ !!!!");

    }


}



?>
