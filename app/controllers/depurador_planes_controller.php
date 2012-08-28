<?php
set_time_limit(30000000);

class DepuradorPlanesController extends AppController {

    var $name = 'DepuradorPlanes';
    var $helpers = array('Html', 'Form','Ajax');
    var $uses = array('Instit','Plan','Anio','Sector','Jurisdiccion',
            'EstructuraPlan','JurisdiccionesEstructuraPlan','EstructuraPlanesAnio');
    var $db;

    var $layout = 'depurador';

    function index($id) {
        //// dejo un log de ingreso
        $username = $this->Auth->user('nombre').' '.$this->Auth->user('apellido').' ('.$this->Auth->user('username').')';
        $grupo = $this->Session->read('User.group_alias');
        $this->Instit->logDepuradores($username, $grupo, "estructura_planes");
        //Configure::write('debug', '0');

        if ($id) {
            $instit = $this->Instit->find('first', array(
                    'contain' => array(
                            'Jurisdiccion' => 'name',
                            'Gestion' => 'name',
                            'Departamento' => 'name',
                            'Localidad' => 'name',
                            'Tipoinstit' => 'name',
                            'Plan' => array(
                                    'EstructuraPlan',
                                    'Anio' => array(
                                            'Etapa',
                                            'order'=>array('ciclo_id','etapa_id', 'anio')),
                                    'conditions'=> array('Plan.oferta_id'=> 3),
                            )),
                    'conditions' => array('Instit.id'=> $id)
            ));

            $instit['Plan'] = $this->ordenarPlanes($instit['Plan']);
            
            //print_r($instit);
            $jurisdiccion_id = $instit['Instit']['jurisdiccion_id'];

            // estructuras posibles en la jurisdiccion
            $estructuras = $this->JurisdiccionesEstructuraPlan->getEstructurasDeJurisdiccion($jurisdiccion_id, 'list');

            $this->set('instit',$instit);
            $this->set('estructuras',$estructuras);
        }
    }

    /*
     * Arcaido metodo de ordenamiento de los planes por sus etapas
     */
    function ordenarPlanes($planes) {
        $ordenados = array();
        $planes_aux = array();

        foreach ($planes as $plan) {
            if (!in_array($plan['id'], $ordenados)) {
                // si tiene estructura asociada no importan sus anios erroneos, ordena por estructura del plan
                if (!empty($plan['EstructuraPlan']))
                {
                    if ($plan['EstructuraPlan']['etapa_id'] == 1 ||
                         $plan['EstructuraPlan']['etapa_id'] == 4 ||
                         $plan['EstructuraPlan']['etapa_id'] == 102)
                    {
                        $planes_aux[] = $plan;
                        $ordenados[] = $plan['id'];
                    }
                }// si no tiene estructura, ordena por la etapa del primer año que tiene
                elseif (!empty($plan['Anio']) &&
                    ($plan['Anio'][0]['etapa_id'] == 1 ||
                     $plan['Anio'][0]['etapa_id'] == 4 ||
                     $plan['Anio'][0]['etapa_id'] == 102))
                {
                    $planes_aux[] = $plan;
                    $ordenados[] = $plan['id'];
                }

            }
        }

        foreach ($planes as $plan) {
            if (!in_array($plan['id'], $ordenados)) {
                // guarda el resto
                $planes_aux[] = $plan;
                $ordenados[] = $plan['id'];
            }
        }

        return $planes_aux;
    }



    function darle_ok_al_plan($plan_id){
        if (empty($plan_id)) {
            $this->Session->setFlash("Debe pasar el Plan ID como parámetro");
            $this->redirect('/');
        }
        $this->Plan->contain(array(
            'EstructuraPlan'=> array(
                    'EstructuraPlanesAnio'=> array(
                        'order'=>'EstructuraPlanesAnio.nro_anio'),
                    ),
            'Anio' => array(
                'EstructuraPlanesAnio',
                'order'=>'Anio.ciclo_id, Anio.anio',
            )
        ));        
        $plan = $this->Plan->read(null,$plan_id);

        if (empty($plan['Plan']['estructura_plan_id'])){
            $this->Session->setFlash("Primero debe seleccionarle una estructura al plan");
            $this->redirect('/depuradorPlanes/index/'.$plan['Plan']['instit_id']);
        }

        $total = 0;
        $i = 0;
        if (!empty($plan['Anio'])) {
            $ciclo_ant = $plan['Anio'][0]['ciclo_id'];
            foreach ($plan['Anio'] as &$a) {
                
                // error corregido: si estaba incompleto uno el que viene sigue mal
                // controlar corte de control por ciclo anterior
                if ($a['ciclo_id'] != $ciclo_ant) {
                    $i = 0;
                    $ciclo_ant = $a['ciclo_id'];
                }

                $epa = $plan['EstructuraPlan']['EstructuraPlanesAnio'][$i];

                if ($a['anio'] != $epa['nro_anio'] && !$a['estructura_planes_anio_id']) {
                    $this->Session->setFlash("Primero debe ordenar los años del ciclo ".$a['ciclo_id']);
                    $this->redirect('/depuradorPlanes/index/'.$plan['Plan']['instit_id']);
                }

                $a['estructura_planes_anio_id'] = $epa['id'];

                $i++;
                /*if (count($plan['EstructuraPlan']['EstructuraPlanesAnio']) == $i) {
                    $i = 0;
                }*/
                // corregido arriba

                if ($a['etapa_id'] != $plan['EstructuraPlan']['etapa_id']) {
                    $this->Session->setFlash("La etapa de alguno de los ciclos no es correcta");
                    $this->redirect('/depuradorPlanes/index/'.$plan['Plan']['instit_id']);
                }

            }
        }

        if (count($plan['Anio']) % count($plan['EstructuraPlan']['EstructuraPlanesAnio'])==0) {
            if ($this->Anio->saveAll($plan['Anio'])){
                $this->Session->setFlash("Se guardó todo el plan en masa", 'default', array('class' => 'message_exito'));
            } else {
                $txt = '';
                foreach($this->Anio->validationErrors as $kk=>$eee) {
                        $txt .= empty($txt)?'':', ';
                        if (is_array($eee))
                            $txt .= array_shift($eee);
                    }
                    $this->Session->setFlash('Error al guardar algún Anio por: '.$txt);
            }
        } else {
            $this->Session->setFlash('No se guardó nada porque la cantidad de años no es correcta');
        }
        $this->redirect('/depuradorPlanes/index/'.$plan['Plan']['instit_id']);
        
    }

    function tr_plan($plan_id) {
        $plan = $this->Plan->find('all', array(
                'contain' => array(
                        'Anio' => array(
                                'Etapa',
                                'order'=>array('ciclo_id','etapa_id', 'anio')),
                ),
                'conditions' => array('Plan.oferta_id'=> 3,'Plan.id'=> $plan_id)
        ));

        // funcion de Ale
        $return = $this->Plan->estructuraValida($plan_id);

        $anios_incorrectos = array();
        if (is_array($return))
            foreach($return as $anio) {
                $anios_incorrectos[] = $anio['Anio']['ciclo_id'];
            }
        //debug($anios_incorrectos);
        $this->set('anios_incorrectos', $anios_incorrectos);
        $this->set('plan', $plan[0]);
    }

    function cambiarEstructuraPlan($plan_id, $estructura_plan_id) {
        if ($estructura_plan_id > 0) {
            $this->Plan->recursive = -1;
            $plan = $this->Plan->read(null, $plan_id);
            $plan['Plan']['estructura_plan_id'] = $estructura_plan_id;

            $this->Plan->save($plan);
        }
        // renderiza el plan
        $this->redirect('/depurador_planes/tr_plan/'.$plan_id);
    }

    function test_graficador($id, $ciclo, $depurado) {
        $plan = $this->Plan->find('first',
                array('conditions'=>array(
                        'Plan.id' => $id
                ),
                'contain'=>array('Anio'=>array('Etapa','conditions'=>array('Anio.ciclo_id'=>$ciclo)))
                )
        );

        $this->set('plan', $plan);
        $this->set('depurado', $depurado);
    }


    function arregladorDeAnios($plan_id, $ciclo_id = null) {
        $this->Plan->id = $plan_id;
        $this->Plan->contain(array(
                'Instit',
                'EstructuraPlan.EstructuraPlanesAnio',
                'Anio' => array(
                        'Etapa',
                        'EstructuraPlanesAnio',
                        'conditions' => array(
                                'Anio.plan_id' => $plan_id,
                                'Anio.ciclo_id'=> $ciclo_id,
                        )),
        ));
        $plan = $this->Plan->read();


       

        // si no encontro un plan redirijo a la pagina ppal
        if (empty($plan)) {
            $this->flash("El plan no existe",'/');
        }     

        // guardo en BD si me vino el formulario lleno
        if (!empty($this->data)) {
             //debug($this->data);
            if (!$this->Plan->tieneEstructuraDefinida()) {
                $this->Session->setFlash('El plan seleccionado no tiene estructura definida, no puede ser guardado. Primero seleccione una estructura al plan.');
                $this->redirect('/depuradorPlanes/index/'.$plan['Instit']['id']);
            }

            // meto la etapa y el añio de la estructura para mantener los viejos campos
            foreach ($this->data['Anio'] as &$a) {


                // verifico que no ingrese 2 veces el mismo año
                // que no repita año
                foreach ($this->data['Anio'] as &$a2) {
                    if ($a['estructura_planes_anio_id'] == $a2['estructura_planes_anio_id']
                        && 
                        $a['id'] != $a2['id']
                        &&
                        $a['plan_id'] == $a2['plan_id']){
                            $this->Session->setFlash("No se pueden ingresar años repetidos para el mismo plan id desde:".$a['plan_id']." hasta: ".$a2['plan_id']);
                            $this->redirect('/depuradorPlanes/index/'.$plan['Instit']['id']);
                    }
                }


                if ($a['plan_id'] != $plan_id) {
                    $plan_aux = $this->Plan->find('all', array(
                                    'contain' => array('EstructuraPlan.EstructuraPlanesAnio'),
                                    'conditions'=>array('Plan.id'=>$a['plan_id'])));

                    // puede ser vacio si no esta estructurado ese plan
                    $a['etapa_id'] = $plan_aux[0]['EstructuraPlan']['etapa_id'];
                }
                else {
                     $a['etapa_id'] = $plan['EstructuraPlan']['etapa_id'];
                }

                foreach ($plan['EstructuraPlan']['EstructuraPlanesAnio'] as $epp) {
                    if ($a['estructura_planes_anio_id'] == $epp['id']) {
                        $a['anio'] =  $epp['nro_anio'];
                    }
                }

                // Di quiero mover a otro plan, verifico que no exista ese año formativo
                if ($plan_id != $a['plan_id']) {
                    $this->Anio->EstructuraPlanesAnio->recursive = -1;
                    $currEstPlanAnio = $this->Anio->EstructuraPlanesAnio->read(null, $a['estructura_planes_anio_id']);
                    $anioMov = $this->Anio->find('count', array(
                        'conditions' => array(
                                'Anio.ciclo_id' => $a['ciclo_id'],
                                'Anio.plan_id' => $a['plan_id'],
                                'Anio.anio' => $currEstPlanAnio['EstructuraPlanesAnio']['nro_anio'],
                                'Anio.id <>' => $a['id'],
                        )
                    ));
                    if ($anioMov > 0) {
                        $this->Session->setFlash("El año ".$currEstPlanAnio['EstructuraPlanesAnio']['nro_anio']." ya existe en el plan al que quiere mover");
                        $this->redirect('/depuradorPlanes/index/'.$plan['Instit']['id']);
                    }
                }
            }
            
            if (!$this->Anio->saveAll($this->data['Anio'], array('validate'=>'first'))) {
                $txt = '';
                foreach($this->Anio->validationErrors as $kk=>$eee) {
                    $txt .= empty($txt)?'':', ';
                    $txt .= array_shift($eee);
                }
                $this->Session->setFlash('Error al guardar debido a el/los siguientes errores:<br> '.$txt);
            } else {
                $this->Session->setFlash('Se guardó todo Bien', 'default', array('class' => 'message_exito'));
            }
            $this->redirect('/depuradorPlanes/index/'.$plan['Instit']['id']);
        }



        //$ePlanId = $plan['Plan']['estructura_plan_id'];
        $ePlanId = $this->Plan->getEstructuraSugerida();

        //$ePlanId = 4;

        // traigo los anios posibles para la estructura definida en estructura_plan_id
        $estructura_planes_anios = $this->Anio->EstructuraPlanesAnio->find('list', array(
                'fields' => array('id','nro_anio'),
                'conditions' => array(
                        'EstructuraPlanesAnio.estructura_plan_id' => $ePlanId,
                ),
        ));


        // traigo TODOS los planes de la institucion, por si quiere MOVER
        // el dato de los anios hacia otro plan
        $planes = $this->Plan->find('list', array(
                'fields' => array('id','nombre'),
                'conditions' => array(
                        'Plan.oferta_id' => 3,
                        'Plan.instit_id' => $plan['Instit']['id'],
                )
        ));


        $planes[$plan_id] = 'No mover de: '.$planes[$plan_id];

        $this->set('anios', $plan['Anio']);
        $this->set('estructura_planes_anios', $estructura_planes_anios);
        $this->set(compact('plan', 'planes', 'ciclo_id'));

    }



    function listado() {
        $jurisdiccionSql = ' > 0';
        $jurisdiccion_id = 0;

        $orientacionSql = ' > -1';
        $orientacion_id = 0;

        $cueSql = ' > 0';
        $cue = 0;

        $gestionSql  = ' > 0';
        $gestion_id = 0;
        $limit = 10;
        $orderBy = 'i.cue*100+i.anexo';
        $errores = 0; // es una variable pasada en el form de la vista para usar el $orderBy


        // CUE
        if (!empty($this->data['Depurador']['cue'])) {
            $cue = $this->data['Depurador']['cue'];
        } else {
            if ($this->data['Depurador']['cue'] !== '') {
                if ($this->Session->check('cue')) {
                    $cue = $this->Session->read('cue');
                }
            }
        }
        $this->Session->write('cue', $cue);
        if ($cue > 0) {
            $cueSql = " = ".$cue;
        }
        

        // JURISDICCION
        if (!empty($this->data['Depurador']['jurisdiccion_id'])) {           
            $jurisdiccion_id = $this->data['Depurador']['jurisdiccion_id'];
        } else {
            if ($this->data['Depurador']['jurisdiccion_id'] !== '') {
                if ($this->Session->check('jurisdiccion_id')) {
                    $jurisdiccion_id = $this->Session->read('jurisdiccion_id');
                }
            }
        }
        $this->Session->write('jurisdiccion_id', $jurisdiccion_id);
        if ($jurisdiccion_id > 0) {
            $jurisdiccionSql = " = ".$jurisdiccion_id;
        }


        // ORIENTACION
        if (!empty($this->data['Depurador']['orientacion_id'])) {
            $orientacion_id = $this->data['Depurador']['orientacion_id'];
        } else {
            if ($this->data['Depurador']['orientacion_id'] !== '') {
                if ($this->Session->check('orientacion_id')) {
                    $orientacion_id = $this->Session->read('orientacion_id');
                }
            }
        }
        $this->Session->write('orientacion_id', $orientacion_id);
        if ($orientacion_id > 0) {
            $orientacionSql = " = ".$orientacion_id;
        }



        // AMBITO GESTION
        if (!empty($this->data['Depurador']['gestion_id'])) {
            $gestion_id = $this->data['Depurador']['gestion_id'];
        } else {
            if ($this->data['Depurador']['gestion_id'] !== '') {
                if ($this->Session->check('gestion_id')) {
                    $gestion_id = $this->Session->read('gestion_id');
                }
            }
        }
        $this->Session->write('gestion_id', $gestion_id);
        if ($gestion_id > 0) {
            $gestionSql =  " = ".$gestion_id;
        }


        // LIMIT
        if (!empty($this->data['Depurador']['limit'])) {
            $limit = $this->data['Depurador']['limit'];
        } else {
            if ($this->data['Depurador']['limit'] !== '') {
                if ($this->Session->check('limit')) {
                    $limit = $this->Session->read('limit');
                }
            }
        }
        $this->Session->write('limit', $limit);

        if (!empty($this->data['Depurador']['errores'])) {
            $errores = $this->data['Depurador']['errores'];
        } else {
            if ($this->data['Depurador']['errores'] !== '') {
                if ($this->Session->check('errores')) {
                    $errores = $this->Session->read('errores');
                }
            }
        }
        $this->Session->write('errores', $errores);
        switch ($errores) {
                case 1: // ordeno por cantidad de errors
                    $orderBy = 'count(*) DESC';
                    break;
                case 2: // ordeno por cantidad de errors
                    $orderBy = 'count(*)';
                    break;
                case 0:
                default: // lo dejo como està
                    break;
       }


        $selectSQL = "
                 select
                    i.id as \"Instit__id\" ,
                    i.nombre as \"Instit__nombre\" ,
                    i.cue as \"Instit__cue\" ,
                    i.anexo as \"Instit__anexo\",
                    i.nroinstit as \"Instit__nro\" ,
                    t.name as \"Instit__tipoinstit\" ,
                    count(*) as \"Instit__errores\"
                 from instits i
                 left join tipoinstits t on (t.id = i.tipoinstit_id)
                 left join planes p on (p.instit_id = i.id)
                 left join estructura_planes ep on (ep.id = p.estructura_plan_id)
                 left join anios a on (a.plan_id = p.id)
                 where
                 (
                    p.estructura_plan_id = 0
                 or
                    a.estructura_planes_anio_id = 0
                 or
                    (
                        p.estructura_plan_id <> 0
                        and
                        a.estructura_planes_anio_id <> 0
                        and
                        a.estructura_planes_anio_id NOT IN (
                            select epa.id from
                            estructura_planes_anios epa
                            where epa.estructura_plan_id = ep.id
                        )
                    )
                 )
                 and
                     p.oferta_id = 3
                 and
                    i.jurisdiccion_id $jurisdiccionSql
                 and
                    i.gestion_id $gestionSql
                 and
                    i.orientacion_id $orientacionSql
                 and
                    (i.cue*100+i.anexo) $cueSql
                 group by i.id, i.nombre, i.cue, i.anexo, i.nroinstit, t.name
                 order by $orderBy
                ";

        $institsMal = $this->Instit->query($selectSQL. "  limit $limit");

        $cantFaltan = $this->Instit->query("SELECT COUNT(*) AS \"count\" from ($selectSQL) as tablacount");
        $cantFaltan = empty($cantFaltan[0][0]['count']) ? 0     :   $cantFaltan[0][0]['count'];

        $jurisdicciones = $this->Instit->Jurisdiccion->find('list');


        $gestiones = $this->Instit->Gestion->find('list');
        $orientaciones = $this->Instit->Orientacion->find('list');
        
        $this->set(compact('gestiones', 'orientaciones'));
        $this->set('cue',$cue);
        $this->set('gestion_id',$gestion_id);
        $this->set('orientacion_id',$orientacion_id);
        $this->set('errores',$errores);
        $this->set(compact('jurisdicciones'));
        $this->set('institsMal',$institsMal);
        $this->set('cantFaltan',$cantFaltan);
        $this->set('jurisdiccion_id',$jurisdiccion_id);
        $this->set('limit',$limit);
    }


    function add_plan($instit_id, $ciclo_id = null) {
        if (!empty($this->data) && !$instit_id) {
            $this->Session->setFlash(__('Institución incorrecta', true));
            $this->redirect('/depuradorPlanes/listado');
        }
        if (!empty($this->data)) {
            $this->Plan->create();
            if ($this->Plan->save($this->data)) {
                $this->Session->setFlash('Se ha creado un nuevo Plan', 'default', array('class' => 'message_exito'));

                // redirige al depurador
                $this->redirect('/depuradorPlanes/index/'.$instit_id);
            }
            else {
                $this->Session->setFlash(__('No se ha podido crear el Plan. Por favor, intente nuevamente.', true));
            }
        }

        $this->Plan->Instit->recursive = 1;
        $instit = $this->Plan->Instit->read(null, $instit_id);
        $this->set('instit',$instit['Instit']);

        $titulos = $this->Plan->Titulo->find('list',array('conditions'=> array('Titulo.oferta_id'=>3)));
        $sectores = $this->Plan->Titulo->Sector->find('list',array('order'=>'Sector.name'));
        //$subsectores = $this->Plan->Titulo->Subsector->con_sector('list',array('conditions'=> array('Subsector.sector_id'=>5)));
        $ciclos = $this->Plan->Anio->Ciclo->find('list');


        $estructuraPlanesGrafico = $this->Plan->EstructuraPlan->JurisdiccionesEstructuraPlan->find('all',array(
                'contain'=>array(
                        'EstructuraPlan'=>array('Etapa','EstructuraPlanesAnio'=>array('order'=> array('EstructuraPlanesAnio.edad_teorica')))
                ),
                'conditions'=>array('jurisdiccion_id'=>$instit['Instit']['jurisdiccion_id'])
        ));

        $estructura_planes = array();
        foreach($estructuraPlanesGrafico as $estructura) {
            $estructura_planes[$estructura['EstructuraPlan']['id']] = $estructura['EstructuraPlan']['name'];

        }

        
        $this->set('ciclo_id', $ciclo_id);
        $this->set(compact(
                'subsectores','sectores',
                'titulos', 'ciclos', 'estructura_planes','estructuraPlanesGrafico'));

        $this->rutaUrl_for_layout[] =array('name'=> 'Datos Institución','link'=>'/Instits/view/'.$instit['Instit']['id'] );
    }

    function duplicar_plan($plan_id){
        if (empty($plan_id)) {
            $this->Session->setFlash("Debe pasar el Plan ID como parámetro");
            $this->redirect('/');
        }
        $this->Plan->contain(array(
            'EstructuraPlan'=> array(
                    'EstructuraPlanesAnio'=> array(
                        'order'=>'EstructuraPlanesAnio.nro_anio'),
                    )
        ));
        $plan = $this->Plan->read(null,$plan_id);

        if (empty($plan['Plan']['estructura_plan_id'])){
            $this->Session->setFlash("Primero debe seleccionarle una estructura al plan");
            $this->redirect('/depuradorPlanes/index/'.$plan['Plan']['instit_id']);
        }

        $plan['Plan']['id'] = 0;

        $this->Plan->save($plan);
        
        $this->redirect('/depuradorPlanes/index/'.$plan['Plan']['instit_id']);
    }
}

?>