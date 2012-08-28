<?php
class PlanesController extends AppController {

    var $name = 'Planes';
    var $helpers = array('Html','Form','Ajax');

    function beforeFilter() {
        parent::beforeFilter();
        //preparo la rutaUrl_for_layout ver en appController para mas informacion
        $this->rutaUrl_for_layout[] = array('name'=> 'Buscador','link'=>'/Instits/search_form' );

    }

    function testi(){
        
        $c = array(
            'conditions' => array(
                'Plan.instit_id' => 1410,
                ),
            'asociarAnio' => true,
            );
        debug("find comun   : ".$this->Plan->find('count',$c));
        debug("find completo: ".$this->Plan->__findCompleto('count',$c));
        debug($this->Plan->__findCompleto('buscar',$c));
        die('termino');
    }


    /**
     * Listado de planes para una determinada institucion
     * @param $id ID de institucion
     */
    function index($id = null) {

        // posibles controllers de ofertas
        $ofertasControllers[FP_ID] = 'view_fp';
        $ofertasControllers[ITINERARIO_ID] = 'view_it_sec_sup';
        $ofertasControllers[SEC_TEC_ID] = 'view_it_sec_sup';
        $ofertasControllers[SUP_TEC_ID] = 'view_it_sec_sup';
        $ofertasControllers[SEC_ID] = 'view_it_sec_sup';
        $ofertasControllers[SUP_ID] = 'view_it_sec_sup';

        $v_plan_matricula = array();

        if (empty($id)) {
            $this->Session->setFlash(__('La institución pasada como parámetro es inválida.', true));
            $this->redirect('/pages/home');
        }

        /* *************************** */
        /*  Si tiene ticket pendiente  */

        $data_ticket = $this->Plan->Instit->Ticket->dameTicketPendiente($id);
        $ticket_id = isset($data_ticket['Ticket']['id'])?$data_ticket['Ticket']['id']:0;
        $this->set('ticket_id', $ticket_id);

        $action = ($this->Auth->user('role')=='admin' || $this->Auth->user('role')=='editor' || $this->Auth->user('role')=='desarrollo')?'edit':'view';
        $this->set('action', $action);

        /*  Fin Si tiene ticket pendiente * */
        /* ******************************** */

        //seteo el ID a la Instit
        $this->Plan->Instit->id = $id;
        $this->Plan->Instit->read();

        if(!empty($this->Plan->Instit->data)) {
            $cont = 0;
            foreach ($this->Plan->Instit->data['Plan'] as $p):
                $v_plan_matricula[$cont] = $this->Plan->Anio->matricula_del_plan($p['id']);
                $v_plan_matricula[$cont]['ciclo'] = $this->Plan->Anio->ciclo_lectivo_matricula_del_plan($p['id']);
                $cont++;
            endforeach;

            $this->set('sumatoria_matriculas',$this->Plan->Instit->dameSumatoriaDeMatriculasPorOferta($id));
            $this->set('planes',$this->Plan->Instit->data);
            $this->set('v_plan_matricula',$v_plan_matricula);
            $this->rutaUrl_for_layout[] =array('name'=> 'Datos Institución','link'=>'/Instits/view/'.$id );
        }

        $ciclos = $this->Plan->Instit->getCiclosLectivosXOferta($id);
        
        $ofertas  = $this->Plan->Instit->getOfertas($id,'');
        $sectores = $this->Plan->Instit->getSectores($id,isset($url_conditions['Anio.ciclo_id'])?$url_conditions['Anio.ciclo_id']:'');

        $this->set(compact('ofertas','ciclos','sectores'));
        $this->set('ofertasControllers', $ofertasControllers);
        $this->set('ultimo_ciclo_actualizado',$this->Plan->Instit->getUltimoCiclo($id));
    }
    
    
    /**
     * Listado de planes por nombre
     * @param $id ID de institucion
     */
    function index_x_nombre($nombre=null, $titulo_id=null) {

        $nombre = urldecode($nombre);
        $this->paginate = array(
                'limit'    => 50,
                'conditions' => array('Plan.nombre' => $nombre),
                'contain' => array('Instit' => array('Tipoinstit', 'Jurisdiccion(name)')),
                'order'    => array('Instit.nombre' => 'asc')
        );
        
        if (!empty($titulo_id)) {
            // que sean del mismo título
            $this->paginate['conditions']['Plan.titulo_id'] = $titulo_id; 
        }
        
        $planes = $this->paginate('Plan');
        $this->set(compact('planes', 'nombre'));
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('El Plan no es correcto.', true));
            $this->redirect(array('action'=>'index'));
        }

        
        $this->Plan->contain(array(
            'Anio' => array('EstructuraPlanesAnio'),
            'Oferta',
            'PlanEstado',
            'PlanTurno',
            'EstructuraPlan' => array('Etapa'),
            'Titulo' => array(
                'SectoresTitulo' => array('Sector','Subsector','order'=>array('SectoresTitulo.prioridad DESC'))
                )
            )
        );

        $plan = $this->Plan->read(null, $id);

        //ordenos los años para ue puedan ser mostrados en la vista
        $anios = array();
        if(!empty($plan['Anio'])) {
            foreach($plan['Anio'] as $p) {
                $anios[$p['ciclo_id']][]= $p;
            }
        }

        $this->set('anios',$anios);
        $this->set('plan',$plan);

        $this->Plan->Instit->recursive = 1;
        $instit = $this->Plan->Instit->read(null, $plan['Plan']['instit_id']);

        $this->set('instit',$instit['Instit']);
        $this->set('matricula', $this->Plan->Anio->matricula_del_plan($id));

        /*$sectores = $this->Plan->Titulo->find('all', array(
                        'conditions'=>array('Titulo.id'=> $plan['Plan']['titulo_id']),
                        'contain'=>array('Sector','Subsector')
                    ));
        $this->set('sectores', $sectores);*/

        $this->rutaUrl_for_layout[] = array('name'=> 'Datos Institución','link'=>'/Instits/view/'.$instit['Instit']['id'] );
        $this->rutaUrl_for_layout[] = array('name'=> 'Oferta Educativa','link'=>'/Planes/index/'.$instit['Instit']['id'] );

        $planes_view_tabla['element'] = 'planes_view_tabla_normal';
        $planes_view_tabla['options'] = array();
        //	Si es FP mostrar la vista para FP, sino mostrar la vista por default (view)
        switch ($plan['Plan']['oferta_id']):
            case FP_ID: // FP
                $planes_view_tabla['element'] = 'planes_view_tabla_fp';
                break;
            case SUP_TEC_ID: // SUP TEC
            case SUP_ID: //SUP NO TECNICO
                $planes_view_tabla['element'] = 'planes_view_tabla_snu';
                break;
            case ITINERARIO_ID: //IT
            case SEC_ID: //SNU
                $planes_view_tabla['element'] = 'planes_view_tabla_normal';
                break;
            case SEC_TEC_ID: //MT, SEC
            // 'planes_view_tabla_st_old' es una solucion temporal,
            // vamos atener que usar el elemento $planes_view_tabla['element'] = 'planes_view_tabla_st' en un futuro
                $planes_view_tabla['element'] = 'planes_view_tabla_st_old';
                $this->set('plan_tiene_estructura_valida', $this->Plan->estructuraValida($id));
                break;
            default:
                $this->Session->setFlash('ID inválido para la oferta_id del Plan');
                $this->redirect('/');
            endswitch;

        $this->set('planes_view_tabla',$planes_view_tabla);
    }

    function add($instit_id = null) {
        if (!empty($this->data) && !$instit_id) {
            $this->Session->setFlash(__('Institución incorrecta', true));
            $this->redirect(array('controller'=>'pages', 'action'=>'home'));
        }
        if (!empty($this->data)) {
            $instit_id = $this->data['Plan']['instit_id'];
            
            // si la institucion tiene otro/s tipo/s de oferta, se marca para depurar tipoinstit
            // (chequea antes de guardar la oferta)
            $depurar_tipoinstit = false;
            $ofertas = $this->Plan->Instit->getOfertas($instit_id);
            if (!empty($ofertas) && !array_key_exists($this->data['Plan']['oferta_id'], $ofertas)) {
                $depurar_tipoinstit = true;
            }
            
            $this->Plan->create();
            if ($this->Plan->save($this->data)) {   
                // marca para depurar tipoinstit
                if ($depurar_tipoinstit) {
                    $this->Plan->Instit->id = $instit_id;
                    $this->Plan->Instit->saveField('depurar_tipoinstit', 1);
                }
                $this->Session->setFlash(__('Se ha creado un nuevo Plan', true));
                $this->redirect(array('controller'=>'Planes','action'=>'view/'.$this->Plan->id));
            } else {
                $this->Session->setFlash(__('No se ha podido crear el Plan. Por favor, intente nuevamente.', true));
            }
        }

        $this->Plan->Instit->recursive = 1;
        $instit = $this->Plan->Instit->read(null, $instit_id);
        $this->set('instit',$instit['Instit']);

        $ofertas = $this->Plan->Oferta->find('list');
        $this->set(compact('ofertas'));

        $titulos = $this->Plan->Titulo->find('list');
        $sectores = $this->Plan->Titulo->Sector->find('list',array('order'=>'Sector.name'));
        $subsectores = $this->Plan->Titulo->Subsector->con_sector('list');
        $ciclos = $this->Plan->Anio->Ciclo->find('list');
        $plan_estados = $this->Plan->PlanEstado->find('list');
        $plan_turnos = $this->Plan->PlanTurno->find('list');

        $estructuraPlanesGrafico = $this->Plan->EstructuraPlan->JurisdiccionesEstructuraPlan->find('all',array(
                'contain'=>array(
                        'EstructuraPlan'=>array('Etapa'=>array('order'=> array('Etapa.orden')),'EstructuraPlanesAnio'=>array('order'=> array('EstructuraPlanesAnio.edad_teorica')))
                ),
                'conditions'=>array('jurisdiccion_id'=>$instit['Instit']['jurisdiccion_id'])
        ));

        $estructura_planes = array();
        $estructuras_ordenadas = $estructuraPlanesGrafico;
        usort($estructuras_ordenadas, array( $this, 'comparar_planes_por_orden' ));
        
        foreach($estructuras_ordenadas as $estructura) {
            $estructura_planes[$estructura['EstructuraPlan']['id']] = $estructura['EstructuraPlan']['name'];
        }

        $this->set(compact('subsectores','sectores','titulos', 'ciclos', 'estructura_planes','estructuraPlanesGrafico','plan_estados','plan_turnos'));

        $this->rutaUrl_for_layout[] =array('name'=> 'Datos Institución','link'=>'/Instits/view/'.$instit['Instit']['id'] );
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Plan Inválido', true));
            $this->redirect(array('controller'=>'Pages','action'=>'home'));
        }
        if (!empty($this->data)) {
            $instit_id = $this->data['Plan']['instit_id'];
            
            // si la institucion tiene otro/s tipo/s de oferta, se marca para depurar tipoinstit
            // (chequea antes de guardar la oferta)
            $depurar_tipoinstit = false;
            $ofertas = $this->Plan->Instit->getOfertas($instit_id);
            if (!empty($ofertas) && !array_key_exists($this->data['Plan']['oferta_id'], $ofertas)) {
                $depurar_tipoinstit = true;
            }
            
            if ($this->Plan->save($this->data)) {
                // marca para depurar tipoinstit
                if ($depurar_tipoinstit) {
                    $this->Plan->Instit->id = $instit_id;
                    $this->Plan->Instit->saveField('depurar_tipoinstit', 1);
                }
                
                $this->Session->setFlash(__('El Plan ha sido guardado', true));
                $this->redirect(array('action'=>'view/'.$this->data['Plan']['id']));
            } else {
                $this->Session->setFlash(__('El Plan no pudo ser guardado. Por favor, intente de nuevo.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Plan->read(null, $id);
        }
        $this->Plan->Instit->recursive = 1;
        $instit = $this->Plan->Instit->read(null, $this->data['Plan']['instit_id']);
        $this->set('instit',$instit['Instit']);

        $titulos = $this->Plan->Titulo->find('list', array('conditions'=>array('oferta_id'=>$this->data['Plan']['oferta_id'])));
        $ofertas = $this->Plan->Oferta->find('list');

        $sectores = $this->Plan->Titulo->Sector->find('list',array('order'=>'Sector.name'));

        $plan_estados = $this->Plan->PlanEstado->find('list');
        $plan_turnos = $this->Plan->PlanTurno->find('list');

        if(!isset($this->data['Plan']['sector_id'])) {
            $this->data['Plan']['sector_id'] = 0;
        }
        $subsectores = $this->Plan->Titulo->Subsector->con_sector('list',$this->data['Plan']['sector_id']);
        $ciclos = $this->Plan->Anio->Ciclo->find('list');

        $estructuraPlanesGrafico = $this->Plan->EstructuraPlan->JurisdiccionesEstructuraPlan->find('all',array(
                'contain'=>array(
                        'EstructuraPlan'=>array('Etapa','EstructuraPlanesAnio'=>array('order'=> array('EstructuraPlanesAnio.edad_teorica')))
                ),
                'conditions'=>array('jurisdiccion_id'=>$instit['Instit']['jurisdiccion_id'])
        ));

        $estructuras_ordenadas = $estructuraPlanesGrafico;
        usort($estructuras_ordenadas, array( $this, 'comparar_planes_por_orden' ));

        foreach($estructuras_ordenadas as $estructura) {
            $estructura_planes[$estructura['EstructuraPlan']['id']] = $estructura['EstructuraPlan']['name'];

        }

        $estructuraSugeridaId = $this->Plan->getEstructuraSugerida();

        $this->set(compact('ofertas','subsectores','sectores','titulos','ciclos', 'estructura_planes','estructuraPlanesGrafico', 'estructuraSugeridaId', 'plan_estados', 'plan_turnos'));

        $this->rutaUrl_for_layout[] = array('name'=> 'Datos Institución','link'=>'/Instits/view/'.$this->data['Plan']['instit_id'] );
        $this->rutaUrl_for_layout[] = array('name'=> 'Oferta Educativa','link'=>'/Planes/index/'.$this->data['Plan']['instit_id'] );
        $this->rutaUrl_for_layout[] = array('name'=> $this->data['Plan']['nombre'],'link'=>'/Planes/view/'.$this->data['Plan']['id'] );
    }

    function delete($id = null) {
        $this->Plan->recursive = -1;
        $this->data = $this->Plan->read(null,$id);
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Plan', true));
        }
        if ($this->Plan->del($id)) {
            $this->Session->setFlash(__('Plan Eliminado', true));
            $this->redirect(array('controller'=>'planes','action'=>'index/'.$this->data['Plan']['instit_id']));
        }
    }

    function view_fp($instit_id, $oferta_id, $ciclo=0) {
        Controller::disableCache();
        $es_una_busqueda = false;

        $sesNames = array(
            'instit' => 'Instit.id',
            'plan'   => 'Plan.nombre'.$instit_id.$oferta_id.$ciclo,
            'sector' => 'Sector.id'.$instit_id.$oferta_id,
            'page' => 'page'.$instit_id.$oferta_id.$ciclo,
        );
        
        if(!empty($this->data['Plan']['nombre'])){
            $this->data['Plan']['nombre'] = utf8_decode($this->data['Plan']['nombre']);
        }

        if (!empty($this->data)) {
            $es_una_busqueda = true;
            $this->Session->write($sesNames['instit'],$instit_id);
            $this->Session->write($sesNames['plan'], $this->data['Plan']['nombre']);
            $this->Session->write($sesNames['sector'], $this->data['Sector']['id']);
            $this->Session->write('page', '');
        }
        else {
            // busqueda en Session
            if ($this->Session->read($sesNames['instit']) == $instit_id) {
                if ($this->Session->read($sesNames['plan'])) {
                    $this->data['Plan']['nombre'] = $this->Session->read($sesNames['plan']);
                }

                if ($this->Session->read($sesNames['sector'])) {
                    $this->data['Sector']['id'] = $this->Session->read($sesNames['sector']);
                }
                $es_una_busqueda = true;
            }
        }
        
        $url_conditions = $this->passedArgs;
        
        if (!empty($this->passedArgs['page'])) {
            $this->Session->write($sesNames['page'], $this->passedArgs['page']);
        }
        elseif ($this->Session->read($sesNames['page'])) {
            $this->paginate['page'] = $this->Session->read($sesNames['page']);
        }

        $planNombre = null;
        if (!empty($this->data['Plan']['nombre'])) {
            $planNombre = $this->data['Plan']['nombre'];
        }
        if (!empty($this->passedArgs['Plan.nombre'])) {
            $planNombre = utf8_decode($this->passedArgs['Plan.nombre']);
        }
        if (!empty($planNombre)) {
            $this->paginate['conditions']['lower(Plan.nombre) SIMILAR TO ?'] = array(convertir_para_busqueda_avanzada($planNombre));
            $url_conditions['Plan.nombre'] = $planNombre;
        }

        $sectorId = null;
        if (!empty($this->data['Sector']['id'])) {
            $sectorId = $this->data['Sector']['id'];
        }
        if (!empty($this->passedArgs['Sector.id'])) {
            $sectorId = $this->passedArgs['Sector.id'];
        }
        if (!empty($sectorId)) {
            $this->paginate['conditions']['SectoresTitulo.sector_id'] = $sectorId;
            $url_conditions['Sector.id'] = $sectorId;
        }


        if(!empty($ciclo)) {
            $this->paginate['conditions']['Anio.ciclo_id'] = $ciclo;
        }

        $this->paginate['asociarAnio'] = true;
        
        $this->paginate['conditions']['Plan.oferta_id'] = $oferta_id;
        $this->paginate['conditions']['Instit.id'] = $instit_id;
        $this->paginate['order'] = array("Plan.nombre");
        $this->paginate['recursive'] = 3;   // find completo

        $planes = $this->paginate();
        
        $newVecPlanes = array();
        $i = 0;
        foreach($planes as &$plan){
            if($ciclo == 0){
                $ultimo_ciclo = $this->Plan->getUltimoCiclo($plan['Plan']['id']);
                $plan['Plan']['matricula'] = $this->Plan->dameMatriculaDeCiclo($plan['Plan']['id'],$ultimo_ciclo);
            }
            else{
                $plan['Plan']['matricula'] = $this->Plan->dameMatriculaDeCiclo($plan['Plan']['id'],$ciclo);
            }
        }

        $sectores = $this->Plan->Instit->listSectoresConOferta($instit_id, $oferta_id);
        $ciclos_anios = $this->Plan->Instit->getCiclosLectivosXOferta($instit_id, $agregar_anio_actual = false);
        $ciclos_anios = $ciclos_anios[FP_ID]['ciclo'];

        $this->set('es_una_busqueda',$es_una_busqueda);
        $this->set('sectores', $sectores);
        $this->set('planes', $planes);
        $this->set('instit_id', $instit_id);
        $this->set('oferta_id', $oferta_id);
        $this->set('ciclo', $ciclo);
        $this->set('ciclos_anios', $ciclos_anios);
        $this->set('url_conditions', $url_conditions);
    }

    function comparar_planes_por_orden($a, $b)
    {
        $a_order = $a['EstructuraPlan']['Etapa']['orden'];
        $b_order = $b['EstructuraPlan']['Etapa']['orden'];

        if ($a_order == $b_order) {
            return 0;
        }
        return ($a_order > $b_order) ? +1 : -1;
    }

    function view_it_sec_sup($instit_id,$oferta_id,$ciclo=null) {        
        $conds = array();
        if (!empty($instit_id)) {
            $conds['Plan.instit_id'] = $instit_id;
        }
        if (!empty($oferta_id)) {
            $conds['Plan.oferta_id'] = $oferta_id;
        }
        if (!empty($ciclo)) {
            $conds['Anio.ciclo_id'] = $ciclo;
        }

        $this->paginate['Plan']['order'] = array("Etapa.orden", "Plan.nombre");
        $this->paginate['Plan']['recursive'] = 3;   // find completo
        $planes = $this->paginate('Plan', $conds);

        if ($oferta_id == SEC_TEC_ID) {
            // ordena por Orden de Etapa
            usort($planes, array( $this, 'comparar_planes_por_orden' ));
        }

        // calcula el total "matricula" y que directamente que dependa de "Plan"
        foreach($planes as &$plan){
            if ( !empty($plan['Plan']) ) {
                $plan['Plan']['matricula'] = 0;
        
                foreach($plan['Anio'] as $anio){
                    $plan['Plan']['matricula'] += $anio['matricula'];
                }
            }
        }

        $this->set('planes', $planes);
        $this->set('instit_id', $instit_id);
        $this->set('oferta_id', $oferta_id);
        $this->set('ciclo', $ciclo);

        switch ($oferta_id) {
            case ITINERARIO_ID:
            case SEC_ID:
                $this->render('view_it_sec');
                break;
            case SUP_ID:
            case SUP_TEC_ID:
                $this->render('view_sup');
                break;
            case SEC_TEC_ID:
                $this->render('view_sectec');
                break;
        }
    }
    
    function ajax_similars($name, $instit_id, $id=null) {
        $similars = array();
        if (strlen($name)) {
            $pos = strpos('/', $name);
            if ($pos !== false) {
                $name = substr($name, 0, $pos);
            }

            $this->Plan->recursive = 0;
            $similars = $this->Plan->getSimilars($name, $instit_id, $id);
        }

        $this->set('name', $name);
        $this->set('similars', $similars);
    }
    
    
    function edicionMasiva1Dot6Dot3() {
        set_time_limit(30000000);
        $this->Plan->recursive = 0;
        $planes = $this->Plan->find("all",array(
                'conditions'=>array(
                        'EstructuraPlan.etapa_id' => 102
                )
        ));

        foreach ($planes as &$plan) {
            $nombre = $plan['Plan']['nombre'];
            $pos=strpos($nombre, '(');
            if ($pos !== false) {
                $plan['Plan']['nombre'] = "PRIMER CICLO ".substr($nombre, $pos);
            }
            else {
                $plan['Plan']['nombre'] = "PRIMER CICLO";
            }
            $plan['Plan']['titulo_id'] = 997;

            $planes_to_save['Plan'][] = $plan['Plan'];
        }

        // descomentar para su uso => $this->Plan->saveAll($planes_to_save['Plan']);

        die('done');
    }

}
?>
