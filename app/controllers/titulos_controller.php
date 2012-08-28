<?php
class TitulosController extends AppController {

    var $name = 'Titulos';
    var $helpers = array('Html', 'Form');
    var $components = array('RequestHandler');

    var $sesNames = array(
            'nombre' => 'Titulo.tituloName',
            'oferta'   => 'Titulo.oferta_id',
            'sector' => 'Titulo.sector_id',
            'subsector' => 'Titulo.subsector_id',
            'page' => 'Titulo.page',
        );

    function index() {
        $ofertas = $this->Titulo->Oferta->find('list');
        $sectores = $this->Titulo->Sector->find('list',array('order'=>'Sector.name'));
        $subsectores = array(0 => 'Sin subsector');

        if (!empty($this->passedArgs['limpiar'])) {
            // limpia session
            foreach ($this->sesNames as $sesName) {
                $this->Session->write($sesName, '');
            }
        }

        $bySession = false;
        // si existe búsqueda en Session, realiza búsqueda
        if ($this->Session->read($this->sesNames['nombre'])) {
            $this->data['Titulo']['tituloName'] = $this->passedArgs['tituloName'] = $this->Session->read($this->sesNames['nombre']);
            $bySession = true;
        }
        if ($this->Session->read($this->sesNames['oferta'])) {
            $this->data['Titulo']['oferta_id'] = $this->passedArgs['ofertaId'] = $this->Session->read($this->sesNames['oferta']);
            $bySession = true;
        }
        if ($this->Session->read($this->sesNames['sector'])) {
            $this->data['Titulo']['sector_id'] = $this->passedArgs['sectorId'] = $this->Session->read($this->sesNames['sector']);
            $bySession = true;

            $subsectores = $this->Titulo->Subsector->con_sector('list', $this->Session->read($this->sesNames['sector']));
        }
        if ($this->Session->read($this->sesNames['subsector']) >= 0) {
            $this->data['Titulo']['subsector_id'] = $this->passedArgs['subsectorId'] = $this->Session->read($this->sesNames['subsector']);
            $bySession = true;
        }
        if ($this->Session->read($this->sesNames['page'])) {
            $bySession = true;
        }
        
        if (empty($subsectores)) {
            $subsectores = $this->Titulo->Subsector->con_sector('list');
        }

        $this->Titulo->recursive = 0;
        $this->set('titulos', $this->paginate());
        $this->set(compact('ofertas', 'sectores', 'subsectores', 'bySession'));
    }


    function list_por_oferta_id($oferta_id = 0) {
        $conditions = array();
        if (!empty($oferta_id)) {
            $conditions = array('Titulo.oferta_id'=>$oferta_id);
        }

        if (!empty($this->passedArgs['Plan.oferta_id'])) {
            $conditions = array('Titulo.oferta_id'=>$this->passedArgs['Plan.oferta_id']);
        }

        if (!empty($this->data['Plan']['oferta_id'])) {
            $conditions = array('Titulo.oferta_id'=>$this->data['Plan']['oferta_id']);
        }

        if ($this->RequestHandler->isAjax()) {
            $this->layout = false;
        }
        $this->set('titulos',$this->Titulo->find('list', array('conditions'=>$conditions)));
    }

    function view($id = null) {
        if (!$id) {
            $this->flash(__('Invalid Titulo', true), array('action'=>'index'));
        }

        $this->Titulo->recursive = -1;
        $conditions = '';
        $conditions['conditions'] = array('Titulo.id' => $id);
        $conditions['contain'] = array(
                            'Oferta',
                            'SectoresTitulo' => array('Sector', 'Subsector')
        );
        $titulo = $this->Titulo->find('first', $conditions);

        // Planes del Titulo
        $this->Titulo->Plan->recursive = -1;
        $this->paginate = array(
                'limit'    => 20,
                'page'    => 1,
                'conditions' => array('Plan.titulo_id' => $id),
                'contain' => array('Instit' => array('Tipoinstit', 'Jurisdiccion(name)')),
                'order'    => array('Plan.nombre' => 'asc')
        );
        $planes = $this->paginate('Plan');       
        
        // resumen de planes
        $this->Titulo->Plan->recursive = -1;
        $conditions = '';
        $conditions['conditions'] = array('Plan.titulo_id' => $id);
        $conditions['fields'] = array('Plan.nombre', 'count(*)');
        $conditions['group'] = array('Plan.nombre');
        $conditions['order'] = array('Plan.nombre', 'count(*) desc');
        $planesResumen = $this->Titulo->Plan->find('all', $conditions);

        $this->set(compact('titulo','planes','planesResumen'));
    }


    function ajax_view_planes_asociados($id) {
        // Planes del Titulo
        $this->Titulo->Plan->recursive = -1;
        $this->paginate = array(
                'limit'    => 10,
                'page'    => 1,
                'conditions' => array('Plan.titulo_id' => $id),
                'contain' => array('Instit' => array('Tipoinstit', 'Jurisdiccion(name)')),
                'order'    => array('Plan.nombre' => 'asc')
        );
        $planes = $this->paginate('Plan');

        $this->set('planes', $planes);
    }


    function add_and_give_me_select_options() {
        if ($this->RequestHandler->isAjax()) {
            $this->layout = false;
        }
        if (!empty($this->data)) {
            $this->Titulo->create();
            $this->data['Titulo']['name'] = utf8_decode($this->data['Titulo']['name']);
            if ($this->Titulo->save($this->data)) {
                $this->Session->setFlash(__('Titulo guardado.', true));
                $this->data['Titulo']['id'] = $this->Titulo->id;
            } else {
                $this->Session->setFlash(__('El Titulo no se pudo guardar. Por favor, intente de nuevo.', true));
            }
        }
        $this->set('titulos',$this->Titulo->find('list'));

    }

    function add() {
        $similares = array();
        $force_save = false;

        if (!empty($this->data)) {
            $this->Titulo->create();

            $sectores = $this->data['Titulo']['SectoresTitulos']['sector_id'];
            $subsectores = $this->data['Titulo']['SectoresTitulos']['subsector_id'];
            $prioridades = $this->data['Titulo']['SectoresTitulos']['prioridad'];

            $this->data['Sector'] = array();

            foreach($sectores as $key=>$sector) {
                $this->data['Sector'][$key]['sector_id'] = $sector ;
                $this->data['Sector'][$key]['subsector_id'] = $subsectores[$key] ;
                $this->data['Sector'][$key]['prioridad'] = $prioridades[$key] ;
            }

            if ($this->Titulo->save($this->data)) {
                $this->Session->setFlash(__('Titulo guardado.', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('El Titulo no se pudo guardar. Por favor, intente de nuevo.', true));
            }
        }
        $ofertas = $this->Titulo->Oferta->find('list');
        $sectores = $this->Titulo->Sector->find('list');
        $this->set('force_save', $force_save);
        $this->set(compact('ofertas','sectores'));
    }

    function edit($id = null) {
        $similares = array();
        $force_save = false;
        
        if (!$id && empty($this->data)) {
            $this->flash(__('Invalid Titulo', true), array('action'=>'index'));
        }
        if (!empty($this->data)) {
            $this->Titulo->SectoresTitulo->deleteAll(array('SectoresTitulo.titulo_id' => $id));

            $sectores = $this->data['Titulo']['SectoresTitulos']['sector_id'];
            $subsectores = $this->data['Titulo']['SectoresTitulos']['subsector_id'];
            $prioridades = $this->data['Titulo']['SectoresTitulos']['prioridad'];

            $this->data['Sector'] = array();

            foreach($sectores as $key=>$sector) {
                $this->data['Sector'][$key]['titulo_id'] = $this->data['Titulo']['id'] ;
                $this->data['Sector'][$key]['sector_id'] = $sector ;
                $this->data['Sector'][$key]['subsector_id'] = $subsectores[$key] ;
                $this->data['Sector'][$key]['prioridad'] = $prioridades[$key] ;
            }
            
            if ($this->Titulo->save($this->data)) {
                $this->Session->setFlash(__('Titulo guardado.', true));
                $this->redirect(array('action'=>'index'));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Titulo->read(null, $id);
        }



        $ofertas = $this->Titulo->Oferta->find('list');
        $sectores = $this->Titulo->Sector->find('all', array(
                'contain'=>array('Subsector')));

        $this->set(compact('ofertas','sectores'));
    }
    

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Titulo inválido', true));
        }
        else {
            if ($this->Titulo->del($id)) {
                $this->Session->setFlash(__('Titulo eliminado', true));
            }
            else {
                $txt = 'No se puede eliminar el Título: ';
                foreach( $this->Titulo->validationErrors as $v){
                    $txt .= $v.', ';
                }
                $this->Session->setFlash($txt);
            }
            
            $this->redirect(array('action'=>'index'));
        }
    }


    function ajax_similars($name=null, $id=null) {
        $similars = array();
        if (strlen($name)) {
            $pos = strpos('/', $name);
            if ($pos !== false) {
                $name = substr($name, 0, $pos);
            }

            $this->Titulo->recursive = 0;
            $similars = $this->Titulo->getSimilars($name, $id);
        }

        $this->set('name', $name);
        $this->set('similars', $similars);
    }


    function ajax_search($q = null) {
        $this->autoRender = false;
        $result = array();
        $jur= 0;

        if (!empty($this->params['url']['oferta_id'])) {
            $oferta_id = utf8_decode(strtolower($this->params['url']['oferta_id']));
        }
        if (!empty($this->params['url']['sector_id'])) {
            $sector_id = utf8_decode(strtolower($this->params['url']['sector_id']));
        }
        if (!empty($this->params['url']['subsector_id'])) {
            $subsector_id = utf8_decode(strtolower($this->params['url']['subsector_id']));
        }

        if(empty($q)) {
            if (!empty($this->params['url']['q'])) {
                $q = utf8_decode(strtolower($this->params['url']['q']));
            } else {
                return utf8_encode("parámetro vacio");
            }
        }

        if ( $this->RequestHandler->isAjax() ) {
            Configure::write ( 'debug', 0 );
        }

        $response = '';

        $conditions = array();
        $subconditions = array();

        $conditions["lower(Titulo.name) SIMILAR TO ?"] = convertir_para_busqueda_avanzada($q);
        $subconditions = array('Titulo.id = SectoresTitulos.titulo_id');

        if(@$oferta_id > 0) {
            $conditions["Titulo.oferta_id"] = $oferta_id;
        }

        if(@$sector_id > 0) {
            $subconditions["SectoresTitulos.sector_id ="] = $sector_id;
        }

        if(@$subsector_id > 0) {
            $subconditions["SectoresTitulos.subsector_id ="] = $subsector_id;
        }

        $this->Titulo->recursive = -1;
        $titulos = $this->Titulo->find("all", array(
                'fields' =>array('DISTINCT Titulo.id','Titulo.name'),
                'conditions'=> $conditions,
                'order' => array('Titulo.name'),
                'joins'=>array(
                        array('table' => 'sectores_titulos',
                                'alias' => 'SectoresTitulos',
                                'type' => 'INNER',
                                'conditions' => $subconditions
                        )
                )
                )
        );


        foreach ($titulos as $item) {
            array_push($result, array(
                    "id" => $item['Titulo']['id'],
                    "type" => "Titulo",
                    "name" => utf8_encode($item['Titulo']['name'])
            ));
        }

        if(sizeof($result) == 0) {
            array_push($result, array(
                    "id" => '',
                    "type" => "Vacio",
                    "name" => 'No se encontraron resultados'
            ));
        }

        echo json_encode($result);
    }


    /**
     * Esta accion es el procesamiento del formulario de busqueda
     * maneja las condiciones de la busqueda y el paginador
     *
     */
    function ajax_index_search() {

        //para mostrar en vista los patrones de busqueda seleccionados
        $array_condiciones = array();
        // para el paginator que pueda armar la url
        $url_conditions = array();

        if (!empty($this->data)) {
            // si se realizó una búsqueda se limpia la session
            foreach ($this->sesNames as $sesName) {
                if ($sesName != $this->sesNames['page']) {
                    $this->Session->write($sesName, '');
                }
            }

            if (!empty($this->data['Titulo']['busquedanueva']) && !$this->data['Titulo']['bysession']) {
                $this->Session->write($this->sesNames['page'], '');
            }

            if(!empty($this->data['Titulo']['tituloName'])) {
                $this->passedArgs['tituloName'] = $this->data['Titulo']['tituloName'];
                $this->Session->write($this->sesNames['nombre'], $this->data['Titulo']['tituloName']);
            }
            if(!empty($this->data['Titulo']['oferta_id'])) {
                $this->passedArgs['ofertaId'] = $this->data['Titulo']['oferta_id'];
                $this->Session->write($this->sesNames['oferta'], $this->data['Titulo']['oferta_id']);
            }
            if(!empty($this->data['Titulo']['sector_id'])) {
                $this->passedArgs['sectorId'] = $this->data['Titulo']['sector_id'];
                $this->Session->write($this->sesNames['sector'], $this->data['Titulo']['sector_id']);
            }
            if(isset($this->data['Titulo']['subsector_id'])) {
                $this->passedArgs['subsectorId'] = $this->data['Titulo']['subsector_id'];
                $this->Session->write($this->sesNames['subsector'], $this->data['Titulo']['subsector_id']);
            }
        }
              
        if(!empty($this->passedArgs['tituloName'])) {
            $q = utf8_decode(strtolower($this->passedArgs['tituloName']));
            $this->paginate['conditions']['lower(Titulo.name) SIMILAR TO ?'] = convertir_texto_plano($q);
        }
        if(!empty($this->passedArgs['ofertaId'])) {
            $q = utf8_decode($this->passedArgs['ofertaId']);
            $this->paginate['conditions']['Titulo.oferta_id'] = $q;
        }
        if(isset($this->passedArgs['sectorId']) || isset($this->passedArgs['subsectorId']) ) {

            $conditions_sector = array();
            if(!empty($this->passedArgs['sectorId'])){
                $q = utf8_decode($this->passedArgs['sectorId']);
                $this->paginate['conditions']['SectoresTitulo.sector_id'] = $q;
            }
            if(isset($this->passedArgs['subsectorId']) && $this->passedArgs['subsectorId'] != ''){
                $q = utf8_decode($this->passedArgs['subsectorId']);
                $this->paginate['conditions']['SectoresTitulo.subsector_id'] = $q;
            }

            $this->paginate['joins'] = array(
                array('table'=>'sectores_titulos',
                      'type' => 'LEFT',
                      'alias' => 'SectoresTitulo',
                      'conditions'=> array('SectoresTitulo.titulo_id = Titulo.id')
                    )
                );
        }

        if (!empty($this->passedArgs['page'])) {
            //$this->paginate['page'] = $this->passedArgs['page'];
            $this->Session->write($this->sesNames['page'], $this->passedArgs['page']);
        }
        elseif ($this->Session->read($this->sesNames['page'])) {
            $this->paginate['page'] = $this->Session->read($this->sesNames['page']);
        }

        //datos de paginacion
        $this->paginate['fields'] = array('DISTINCT ("Titulo"."id")', 'Titulo.name','Titulo.marco_ref', 'Titulo.oferta_id', 'Oferta.abrev', 'Titulo.es_bb');
        $this->paginate['order'] = array('Titulo.name ASC, Titulo.oferta_id ASC');
 
        $titulos = $this->paginate();

        $this->set('titulos', $titulos);
        $this->set('url_conditions', $url_conditions);
        //devuelve un array para mostrar los criterios de busqueda
        $this->set('conditions', $array_condiciones);

        $this->render('ajax_index_search');
    }


    function fusionar() {
        if (empty($this->passedArgs) && empty($this->data['Titulo'])) {
            $this->Session->setFlash(__('No es posible fusionar', true));
            $this->redirect('/titulos/index');
        }

        if (!empty($this->data['Titulo'])) {
            $titulos = explode(',', $this->data['Titulo']['titulos']);
            $titulos_a_tratar = array();
            foreach($titulos as $titulo) {
                if ($titulo != $this->data['Titulo']['titulo_definitivo'])
                    $titulos_a_tratar[] = $titulo;
            }

            // asigna el titulo definitivo a los planes de los otros titulos que se fusionan
            $this->Titulo->Plan->updateAll(
                    array('Plan.titulo_id' => $this->data['Titulo']['titulo_definitivo']),
                    array('Plan.titulo_id' => $titulos_a_tratar)
            );

            // se eliminan los titulos que no se fusionaron
            $this->Titulo->deleteAll(array('Titulo.id' => $titulos_a_tratar), false);

            $this->Session->setFlash(__('Los Títulos se han fusionado correctamente', true));
            $this->redirect('/titulos/index');
        }

        if (!empty($this->passedArgs)) {
            $this->Titulo->recursive = -1;
            $titulos = $this->Titulo->find('list', array(
                    'conditions' => array('Titulo.id' => $this->passedArgs)
            ));

            $this->set('titulos', $titulos);
        }
    }
}
?>