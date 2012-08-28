<?php
class InstitsController extends AppController {

    var $name = 'Instits';
    var $helpers = array('Html','Form','Ajax','Cache');
    //var $paginate = array('order'=>array('Instit.cue' => 'asc'),'limit'=>'10');
    var $components = array('RequestHandler', 'Buscable');


   
    function beforeFilter() {
        parent::beforeFilter();
        $this->rutaUrl_for_layout[] =array('name'=> 'Buscador','link'=>'/Instits/search_form' );
    }

    function index() {
        $this->Instit->recursive = 0;
        $this->set('instits', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Institución Inválida.', true));
            $this->redirect(array('action'=>'index'));
        }

        $instit = $this->Instit->read(null, $id);

        $instit['Instit']['dir_tipodoc_name'] = '';
        $tipodoc = ClassRegistry::init('Tipodoc')->find('first', array(
            'conditions'=>array(
                'Tipodoc.id'=> $instit['Instit']['dir_tipodoc_id'],
        )));
        $instit['Instit']['dir_tipodoc_name'] = $tipodoc['Tipodoc']['abrev'];

        $tipodoc = ClassRegistry::init('Tipodoc')->find('first', array(
            'conditions'=>array(
                'Tipodoc.id'=> $instit['Instit']['vice_tipodoc_id'],
        )));
        $instit['Instit']['vice_tipodoc_name'] = $tipodoc['Tipodoc']['abrev'];

        $programa_de_etp = false;
        // si la institucion es con programa de ETP
        if($instit['EtpEstado']['id']== 1) {
            $programa_de_etp = true;
        }
        
        $this->set('con_programa_de_etp', $programa_de_etp);
        $this->set('relacion_etp', $instit['EtpEstado']['name']);
        $this->set('instit', $instit);
        $this->set('ultimo_ciclo_actualizado',$this->Instit->getUltimoCiclo($id));
    }

    function add() {
        $similares = array();
        $force_save = false;

        $this->rutaUrl_for_layout[] =array('name'=> 'Agregar','link'=>'/Instits/add' );
        if (!empty($this->data)) {
            // si ingrese el formulario por primera vez, y la esta variable no esta setteada
            // que me busque los similares
            if(empty($this->data['Instit']['force_save'])) {
                $similares = $this->Instit->getSimilars($this->data);
            }

            if(count($similares) == 0) {
                $this->Instit->create();
                if ($this->Instit->save($this->data)) {
                    $this->Session->setFlash(__('Se ha guardado la Institución correctamente', true));
                    $this->redirect(array('action'=>'view/'.$this->Instit->id));
                } else {
                    $this->Session->setFlash(__('La Institución no pudo ser guardada. Escriba nuevamente el campo incorrecto.', true));
                }
            }else {
                $this->Session->setFlash(__('Hay instituciones similares.', true));
                $force_save = true;
            }
        }

        $gestiones = $this->Instit->Gestion->find('list',array('order'=>'id ASC'));
        $dependencias = $this->Instit->Dependencia->find('list');

        $v_condiciones = array();
        if(!empty($this->data['Instit']['jurisdiccion_id'])) {
            $v_condiciones = array('jurisdiccion_id'=>$this->data['Instit']['jurisdiccion_id']);
        }

        $tipoinstits = $this->Instit->Tipoinstit->find('list',array('order'=>'Tipoinstit.name','conditions'=>$v_condiciones));
        $departamentos = $this->Instit->Departamento->con_jurisdiccion('list');

        $jurisdicciones = $this->Instit->Jurisdiccion->find('list',array('order'=>'name'));

        $v_condiciones = array();
        if(!empty($this->data['Instit']['departamento_id'])) {
            $v_condiciones = array('departamento_id'=>$this->data['Instit']['departamento_id']);
        }

        $localidades = $this->Instit->Localidad->con_depto_y_jurisdiccion('list',0);

        $etp_estados = $this->Instit->EtpEstado->find('list');
        $modalidades = $this->Instit->Modalidad->find('list');
        $this->Instit->Claseinstit->order = "Claseinstit.name DESC";
        $claseinstits = $this->Instit->Claseinstit->find('list');
        $tipoDocs = ClassRegistry::init('Tipodoc')->find('list',array('fields'=>array('id','abrev')));
        $ciclos = $this->Instit->Plan->Anio->Ciclo->find('list');
        
        $this->set(compact('ciclos','tipoDocs','etp_estados','claseinstits','gestiones','dependencias','jurisdicciones','similares','tipoinstits','departamentos','localidades','modalidades'));
        $this->set('force_save', $force_save);
        $this->set('orientaciones', $this->Instit->Orientacion->find('list'));
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Instit', true));
            $this->redirect(array('action'=>'search_form'));
        }

        if (!empty($this->data)) {
            /******* Guardo en el historico de CUES si cambió */
            $cueanterior = array();
            if ($datos_viejos = $this->Instit->cambioCue($this->data)) {
                $cueanterior['HistorialCue']['cue'] 	  = $datos_viejos['Instit']['cue'];
                $cueanterior['HistorialCue']['anexo'] 	  = $datos_viejos['Instit']['anexo'];
                $cueanterior['HistorialCue']['instit_id'] = $datos_viejos['Instit']['id'];
                $cueanterior['HistorialCue']['observaciones'] = 'El CUE fue modificado debido a que se ingresó otro valor cuando se actualizaron los datos de la institución.';
            }


            if ($this->Instit->save($this->data)) {
                // si hay cambio de cue lo inserto en la tabla historial_cues
                if(count($cueanterior) > 0) {
                    if($this->Instit->HistorialCue->hacerCambioDeCue($cueanterior)) {
                        $this->Session->setFlash(__('No se pudo insertar el cambio de CUE al historial de CUEs en la base de datos', true));
                    }
                }

                $this->Session->setFlash(__('Se ha guardado la Institución correctamente', true));
                $this->redirect(array("action"=>"view/$id"));
            } else {
                $this->Session->setFlash(__('La Institución no pudo ser guardada. Escriba nuevamente el campo incorrecto.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Instit->read(null, $id);

            //le pongo el valor vacio para que la vista muestre vacio. Luego el beforeSave se va a encargar d eagregarle un CERO para que cumpla con el NOT NULL de la BD
            if(isset($this->data['Instit']['anio_creacion']) && $this->data['Instit']['anio_creacion'] == 0) {
                $this->data['Instit']['anio_creacion'] = '';
            }
        }

        $gestiones = $this->Instit->Gestion->find('list');
        $dependencias = $this->Instit->Dependencia->find('list');

        $v_condiciones = array();
        if(isset($this->data['Instit']['jurisdiccion_id'])) {
            $v_condiciones = array('jurisdiccion_id'=>$this->data['Instit']['jurisdiccion_id']);
        }

        $tipoinstits = $this->Instit->Tipoinstit->find('list',array('order'=>'Tipoinstit.name','conditions'=>$v_condiciones));
        $departamentos = $this->Instit->Departamento->find('list',array('order'=>'name','conditions'=>$v_condiciones));

        $jurisdicciones = $this->Instit->Jurisdiccion->find('list',array('order'=>'name'));

        $v_condiciones = array();
        if(isset($this->data['Instit']['departamento_id'])) {
            $v_condiciones = array('departamento_id'=>$this->data['Instit']['departamento_id']);
        }
        $localidades = $this->Instit->Localidad->find('list',array('order'=>'name','conditions'=>$v_condiciones));

        $etp_estados = $this->Instit->EtpEstado->find('list');
        $modalidades = $this->Instit->Modalidad->find('list');
        $this->Instit->Claseinstit->order = "Claseinstit.name DESC";
        $claseinstits = $this->Instit->Claseinstit->find('list');
        $tipoDocs = ClassRegistry::init('Tipodoc')->find('list',array('fields'=>array('id','abrev')));
        $ciclos = $this->Instit->Plan->Anio->Ciclo->find('list');
        
        $this->set(compact('ciclos','tipoDocs','claseinstits','etp_estados','gestiones','dependencias','jurisdicciones','similares','tipoinstits','departamentos','localidades','modalidades'));

        $this->set('orientaciones', $this->Instit->Orientacion->find('list'));
        $this->rutaUrl_for_layout[] =array('name'=> 'Datos Institución','link'=>'/Instits/view/'.$id );
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Se ha pasado un id que no existe para esa Institución', true));

        }
        if ($this->Instit->del($id)) {
            $this->Session->setFlash(__('Se ha eliminado la Institución correctamente', true));
            $this->redirect(array('controller'=>'pages', 'action'=>'home'));
        }
    }

    /**
     * Esta accion maneja el formulario de busqueda
     * que sera impreso por pantalla
     *
     */
    function old_search_form() {

        if (!empty($this->data)) {
            $this->redirect('search');
        }

        $this->Instit->Gestion->recursive = -1;
        $this->Instit->Gestion->order = 'Gestion.name';
        $gestiones = $this->Instit->Gestion->find('list');

        $this->Instit->Dependencia->recursive = -1;
        $this->Instit->Dependencia->order ='Dependencia.name';
        $dependencias = $this->Instit->Dependencia->find('list');

        //$tipoinstits = $this->Instit->Tipoinstit->find('list');


        $this->Instit->Jurisdiccion->recursive = -1;
        $this->Instit->Jurisdiccion->order = 'Jurisdiccion.name';
        $jurisdicciones = $this->Instit->Jurisdiccion->find('list');

        // que me liste todos los detarpamentos
        $this->Instit->Departamento->recursive = -1;
        $departamentos = $this->Instit->Departamento->con_jurisdiccion('list');
        //$departamentos = array();


        // con CERO me trae TODAS las jurisdicciones
        $this->Instit->Localidad->recursive = -1;
        $localidades = $this->Instit->Localidad->con_depto_y_jurisdiccion('list');
        //$localidades = array();

        $this->Instit->Plan->Oferta->recursive = -1;
        $ofertas = $this->Instit->Plan->Oferta->find('list');

        $this->Instit->Plan->Titulo->Sector->recursive = -1;
        $this->Instit->Plan->Titulo->Sector->order ='Sector.name';
        $sectores = $this->Instit->Plan->Titulo->Sector->find('list');

        $this->Instit->Plan->Titulo->Subsector->order ='Subsector.name';
        $subsectores = $this->Instit->Plan->Titulo->Subsector->find('list');

        $this->Instit->Claseinstit->recursive = -1;
        $this->Instit->Claseinstit->order = 'Claseinstit.name';
        $claseinstits = $this->Instit->Claseinstit->find('list');

        $this->Instit->EtpEstado->recursive = -1;
        $this->Instit->EtpEstado->order = 'EtpEstado.name';
        $etpEstados = $this->Instit->EtpEstado->find('list');

        $orientaciones = $this->Instit->Orientacion->find('list');

        $titulos = $this->Instit->Plan->Titulo->find('list');

        $this->set(compact(
                'gestiones', 'dependencias', 'jurisdicciones',
                'ofertas','localidades','departamentos','sectores',
                'claseinstits','etpEstados','orientaciones', 'subsectores', 'titulos'));
    }

    function search_form() {
        $this->set('jurisdicciones', $this->Instit->Jurisdiccion->find('list'));
    }
    
    /**
     * Esta accion maneja el formulario de busqueda
     * que sera impreso por pantalla
     *
     */
    function advanced_search_form() {
        $this->cacheAction = '1 day';

        if (!empty($this->data)) {
            $this->redirect('search');
        }

        $this->Instit->Gestion->recursive = -1;
        $this->Instit->Gestion->order = 'Gestion.name';
        $gestiones = $this->Instit->Gestion->find('list');

        $this->Instit->Dependencia->recursive = -1;
        $this->Instit->Dependencia->order ='Dependencia.name';
        $dependencias = $this->Instit->Dependencia->find('list');

        $this->Instit->Jurisdiccion->recursive = -1;
        $this->Instit->Jurisdiccion->order = 'Jurisdiccion.name';
        $jurisdicciones = $this->Instit->Jurisdiccion->find('list');

        // que me liste todos los detarpamentos
        $this->Instit->Departamento->recursive = -1;
        $departamentos = $this->Instit->Departamento->con_jurisdiccion('list');
        //$departamentos = array();


        // con CERO me trae TODAS las jurisdicciones
        $this->Instit->Localidad->recursive = -1;
        $localidades = $this->Instit->Localidad->con_depto_y_jurisdiccion('list');
        //$localidades = array();

        $this->Instit->Plan->Oferta->recursive = -1;
        $ofertas = $this->Instit->Plan->Oferta->find('list');

        $this->Instit->Plan->Titulo->Sector->recursive = -1;
        $this->Instit->Plan->Titulo->Sector->order ='Sector.name';
        $sectores = $this->Instit->Plan->Titulo->Sector->find('list');

        $this->Instit->Plan->Titulo->Subsector->order ='Subsector.name';
        $subsectores = $this->Instit->Plan->Titulo->Subsector->find('list');

        $this->Instit->Claseinstit->recursive = -1;
        $this->Instit->Claseinstit->order = 'Claseinstit.name';
        $claseinstits = $this->Instit->Claseinstit->find('list');

        $this->Instit->EtpEstado->recursive = -1;
        $this->Instit->EtpEstado->order = 'EtpEstado.name';
        $etpEstados = $this->Instit->EtpEstado->find('list');

        $orientaciones = $this->Instit->Orientacion->find('list');

        $titulos = $this->Instit->Plan->Titulo->find('list');

        $this->set(compact(
                'gestiones', 'dependencias', 'jurisdicciones',
                'ofertas','localidades','departamentos','sectores',
                'claseinstits','etpEstados','orientaciones', 'subsectores', 'titulos'));
    }

    function simpleSearch() {

       if (!empty($this->data)) {
            $this->redirect(array('action' => 'view', $this->data['Instit']['instit_id']));
       }

    }

    function ajax_search($q = null){
        $this->autoRender = false;

        if ( $this->RequestHandler->isAjax() ) {
          Configure::write ( 'debug', 0 );
        }

        $response = '';

        if(empty($q)) {
            if (!empty($this->params['url']['q'])) {
                $q = utf8_decode(strtolower($this->params['url']['q']));
            } else {
                return utf8_encode("parámetro vacio");
            }
        }

        if(is_numeric($q)){
            $items = $this->Instit->find("all", array(
                'contain'=> array(
                    'Tipoinstit', 'Jurisdiccion', 'HistorialCue'
                ),
                'conditions'=> array(
                    "to_char(cue*100+anexo, 'FM999999999FM') SIMILAR TO ?" => "%". $q ."%"

                )
            ));
        }
        else{
            $items = $this->Instit->find("all", array(
                'contain'=> array(
                    'Tipoinstit', 'Jurisdiccion', 'HistorialCue'
                ),
                'conditions'=> array(
                    "(lower(Tipoinstit.name) || lower(Instit.nombre)) SIMILAR TO ?" => convertir_para_busqueda_avanzada($q)
                )
            ));
        }

        $result = array();

        foreach ($items as $item) {
            $cuecompleto = $item['Instit']['cue']*100+$item['Instit']['anexo'];

            array_push($result, array(
                    "id" => $item['Instit']['id'],
                    "cue" => $item['Instit']['cue']*100+$item['Instit']['anexo'],
                    "nombre" => utf8_encode($item['Instit']['nombre']),
                    "gestion" => utf8_encode($item['Gestion']['name']),
                    "nroinstit" => utf8_encode($item['Instit']['nroinstit']),
                    "anio_creacion" => utf8_encode($item['Instit']['anio_creacion']),
                    "direccion" => utf8_encode($item['Instit']['direccion']),
                    "depto" => utf8_encode($item['Instit']['depto']),
                    "localidad" => utf8_encode($item['Instit']['localidad']),
                    "cp" => utf8_encode($item['Instit']['cp']),
                    "tipo" => utf8_encode($item['Tipoinstit']['name']),
                    "jurisdiccion" => utf8_encode($item['Jurisdiccion']['name']),
                    "jurisdiccion_id" => utf8_encode($item['Jurisdiccion']['id']),
                    "cue_anterior" => utf8_encode($item['HistorialCue'][0]['cue'])
            ));
        }

        echo json_encode($result);
    }

    /**
     * Esta accion es el procesamiento del formulario de busqueda
     * maneja las condiciones de la busqueda y el paginador
     *
     */
    function search() {
        //para mostrar en vista los patrones de busqueda seleccionados
        $this->paginate['viewConditions'] = array();

        // primero seteo si vino formulario o fue el paginador quien llego a este action"
        $vino_formulario = (!empty($this->data)) ? true : false;
        
        // dejo un log de la busqueda realizada
        $username = $this->Auth->user('nombre').' '.$this->Auth->user('apellido').' ('.$this->Auth->user('username').')';
        $grupo = $this->Session->read('User.group_alias');


        /*******************************************************************
         *    INICIALIZACION DE FILTROS
         *
         *   Los filtros pueden provenir del formulario o de las variables de paginacion.
         *
         * 	Para el primer caso se esta leyendo informacion de $this->data
         * 	en el segundo caso de this->passedArgs
         *
         *
         */

        /*
         *          BUSQUEDA LIBRE
         */

        if(!empty($this->data['Instit']['busqueda_libre'])) {
            $this->passedArgs = array('busqueda_libre' => $this->data['Instit']['busqueda_libre']);
        }
        if(!empty($this->passedArgs['busqueda_libre'])) {
            $q = utf8_decode(strtolower($this->passedArgs['busqueda_libre']));
            
            if(is_numeric($q)){
                $q = (int) $q;
                $this->paginate['Instit']['conditions'] = array("to_char(cue*100+anexo, 'FM999999999FM') SIMILAR TO ?" => "%". $q ."%");
            }
            else{
                //debug(convertir_para_busqueda_avanzada($q));  die();
                $this->paginate['Instit']['conditions'] = array("(lower(Tipoinstit.name) || ' n ' || lower(Instit.nroinstit) || ' ' || lower(Instit.nombre)) SIMILAR TO ?" => convertir_para_busqueda_avanzada($q));
            }
        }

        /*
         *          CUE
         */
        if(!empty($this->data['Instit']['cue'])) {
            $is_cue_valido = $this->Instit->isCUEValid($this->data['Instit']['cue']);
            if($is_cue_valido < 1) {
                switch ($is_cue_valido) {
                    case -1:
                        $mensaje = "<H1>El CUE: '".$this->data['Instit']['cue']."' no es válido.</H1> Ingrese un valor <b>numúrico</b> de al menos <b>3 dígitos</b>.";
                        $this->Session->setFlash($mensaje,'default',array('class' => 'flash-warning'));
                        break;
                }
            }
            // con esto hago que no se busque con un cero adelante
            $this->data['Instit']['cue'] = (int)$this->data['Instit']['cue'];
            $this->passedArgs = array('cue' => $this->data['Instit']['cue']);
        }

        if(!empty($this->passedArgs['cue'])) {
            // set the conditions
            $arr_cond1 = array('CAST(((Instit.cue*100)+Instit.anexo) as character(60)) SIMILAR TO ?' => '%'.$this->passedArgs['cue'].'%');
            $this->paginate['Instit']['conditions'] = $arr_cond1;

            // set the Search data, so the form remembers the option
            $this->paginate['viewConditions']['CUE'] = $this->passedArgs['cue'];
        }
        

        /**
         *          ACTIVO
         */
        if(isset($this->data['Instit']['activo'])) {
            switch ((int)$this->data['Instit']['activo']):
                case -1: break; // es el valor vacio. O sea, buscar por todos
                case 0: // inactivas
                case 1: //buscar activas
                    $this->passedArgs['activo'] = $this->data['Instit']['activo'];
                endswitch;
        }
        if(isset($this->passedArgs['activo'])) {
            switch ((int)$this->passedArgs['activo']):
                case -1: $basura = 1;
                    break; // es el valor empty. O sea, buscar por todos
                case 0: //inactivas
                case 1: //activas
                    $this->paginate['Instit']['conditions']['Instit.activo'] = $this->passedArgs['activo'];
                    $aux = $this->passedArgs['activo']? 'Si':'No';
                    $this->paginate['viewConditions']['Ingresada al RFIETP'] = $aux;
                    break;
                endswitch;
        }



        /**
         *      NOMBRE COMPLETO
         */
        if(!empty($this->data['Instit']['nombre_completo'])) {
             $this->passedArgs['nombre_completo'] = utf8_encode($this->data['Instit']['nombre_completo']);
        }
        if(!empty($this->passedArgs['nombre_completo'])) {
            $this->paginate['Instit']['conditions'][
                            "lower(Tipoinstit.name) ||' n '||".
                            "lower(Instit.nroinstit) ||' '||".
                            "lower(Instit.nombre) SIMILAR TO ?"] = array(convertir_para_busqueda_avanzada(utf8_decode($this->passedArgs['nombre_completo'])));

            $this->paginate['viewConditions']['Tipo, Número o Nombre '] = utf8_decode($this->passedArgs['nombre_completo']);
        }


        //////////////// Automagiccccs filter

        //     Nro Institucion
         $ops[] = array(
            'model' => 'Instit',
            'field' => 'nroinstit',
            'friendlyName' => 'Nº de Institución',
             'forceText' => true,
             );

         //     Jurisdiccion
         $ops[] = array(
            'field' => 'jurisdiccion_id',
            'friendlyName' => 'Jurisdicción');
        
         //      TIPO INSTIT
         $ops[] = array(
            'field' => 'tipoinstit_id',
            'friendlyName' => 'Tipo Institución');

          //      Nombre
         $ops[] = array(
            'field' => 'nombre',
            'friendlyName' => 'Nombre');

         //      Direccion
         $ops[] = array(
            'field' => 'direccion',
            'friendlyName' => 'Domicilio');

         //      Departamento
         $ops[] = array(
            'field' => 'departamento_id',
            'friendlyName' => 'Departamento');

         //      Localidad
         $ops[] = array(
            'field' => 'localidad_id',
            'friendlyName' => 'Localidad');
        
         //      GESTION
         $ops[] = array(
            'field' => 'gestion_id',
            'friendlyName' => 'Ámbito de Gestión');

         //      DEPENDENCIA
         $ops[] = array(
            'field' => 'dependencia_id',
            'friendlyName' => 'Dependencia');         

         //      OFERTA
         $ops[] = array(
            'model' => 'Plan',
            'field' => 'oferta_id',
            'friendlyName' => 'Con Oferta',
            'asociarPlan' => true,
             );

         //      SECTOR
         $ops[] = array(
            'model' => 'SectoresTitulo',
            'field' => 'sector_id',
            'friendlyName' => 'Sector',
            'asociarPlan' => true,
             );

         //      Subsector
         $ops[] = array(
            'model' => 'SectoresTitulo',
            'field' => 'subsector_id',
            'friendlyName' => 'Subsector',
             'asociarPlan' => true);

         //      TITULOS REFERENCIALES
         $ops[] = array(
            'model' => 'Plan',
            'field' => 'titulo_id',
            'friendlyName' => 'Con Título de Referencia',
            'asociarPlan' => true,
             );

         //      ORIENTACION
         $ops[] = array(
            'field' => 'orientacion_id',
            'friendlyName' => 'Orientación');

         //      NORMA
         $ops[] = array(
            'model' => 'Plan',
            'field' => 'norma',
            'friendlyName' => 'Norma',
            'asociarPlan' => true,
             );

         //      Tipo Instit
         $ops[] = array(
            'field' => 'claseinstit_id',
            'friendlyName' => 'Tipo de Institución de ETP');

         //      Tipo Instit
         $ops[] = array(
            'model' => 'Instit',
            'field' => 'etp_estado_id',
            'friendlyName' => 'Relación con ETP');
         
         $this->Buscable->aplicarCriteriosDeBusqueda($ops);         

        /*********************************************************************/
        /*          FIN -*-CONDITIONS-*- de busqueda                         */
        /*********************************************************************/

        $this->Instit->recursive = 1;//para alivianar la carga del server
        $pagin = $this->paginate('Instit');

        $this->set('instits', $pagin);
        $this->set('url_conditions', $this->passedArgs);      
        $this->set('conditions', $this->paginate['viewConditions']);

        // genero un log sobre las busquedas realizadas
        $this->Instit->searchLog($this->data, $username, $grupo, $this->params['paging']['Instit']['count']);
        
        if (!$this->RequestHandler->isAjax()) {         
            // si se encontro solo 1 institucion, ir directamente a la vista de esa institucion
            // si el resultado me trajo 1, y eestoy buscando por CUE, entonces ir directamente a la vista d esas institucion
            if(sizeof($pagin) == 1 && $vino_formulario)
                if(!empty($this->data['Instit']['cue'])) 
                    if(($pagin[0]['Instit']['cue'] == $this->data['Instit']['cue']) || (($pagin[0]['Instit']['cue']*100+$pagin[0]['Instit']['anexo'] == $this->data['Instit']['cue']))) {
                        $this->redirect('view/'.$pagin[0]['Instit']['id']);
                    }
        } else {
            // si es ajax renderizo otra vista
            $this->render('ajax_search');
        }
    }

   
    /**
     * Action para mostrar los planes relacionados
     *
     * @param $instit_id
     */
    function planes_relacionados($id = null) {
        $v_plan_matricula = array();
        if (!$id) {
            $this->Session->setFlash(__('Institución Inválida.', true));
            $this->redirect(array('controller'=>'Istits','action'=>'view/'.$id));
        }

        //$this->Instit->order = 'Plan.oferta_id ASC';
        $this->data = $this->Instit->read(null,$id);
        if($this->data) {
            $cont = 0;
            foreach ($this->data['Plan'] as $p):
                $v_plan_matricula[$cont] = $this->Instit->Plan->Anio->matricula_del_plan($p['id']);
                $v_plan_matricula[$cont]['ciclo'] = $this->Instit->Plan->Anio->ciclo_lectivo_matricula_del_plan($p['id']);
                $cont++;
            endforeach;



            $this->set('sumatoria_matriculas',$this->Instit->dameSumatoriaDeMatriculasPorOferta($id));

            $this->set('planes',$this->data);
            $this->set('v_plan_matricula',$v_plan_matricula);
            $this->rutaUrl_for_layout[] =array('name'=> 'Datos Institución','link'=>'/Instits/view/'.$this->data['Instit']['id'] );
        }
    }

    function depurar() {
        //debug($this->data);die();
        if (!empty($this->data)) {
            if ($valor = $this->Instit->save($this->data)) {
                $this->Session->setFlash(__('Se ha guardado la Institución correctamente', true));

            } else {
                print_r($this->Instit->validationErrors);
                $this->Session->setFlash(__('La Institución no pudo ser guardada. Escriba nuevamente el campo incorrecto.', true));
            }
        }

        $conditions = array('Instit.activo'=>1,'Instit.departamento_id'=>0, 'Instit.localidad_id'=>0);

        $this->data =$this->Instit->find('first',array('conditions'=>$conditions,'order'=>'Instit.jurisdiccion_id DESC'));
        $total =$this->Instit->find('count',array('conditions'=>$conditions));

        //le pongo el valor vacio para que la vista muestre vacio. Luego el beforeSave se va a encargar d eagregarle un CERO para que cumpla con el NOT NULL de la BD
        if(isset($this->data['Instit']['anio_creacion']) && $this->data['Instit']['anio_creacion'] == 0) {
            $this->data['Instit']['anio_creacion'] = '';
        }

        $tipoinstits = $this->Instit->Tipoinstit->find('list');
        $jurisdicciones = $this->Instit->Jurisdiccion->find('list');
        $departamentos = $this->Instit->Departamento->find('list',array('order'=>'name','conditions'=>array('jurisdiccion_id'=>$this->data['Instit']['jurisdiccion_id'])));
        $localidades = $this->Instit->Localidad->find('list',array('order'=>'name'));
        $this->set(compact('jurisdicciones','departamentos','localidades','tipoinstits'));
        $this->set('falta_depurar',$total);
    }

    function prueba() {
        $this->autoRender = false; // para uqe no muestre la vista

        die(convertir_para_busqueda_avanzada("pepino"));
    }
    
    function observar_oferta($id=null) {
        $this->layout = 'popup';

        if ( $this->RequestHandler->isAjax() ) {
          Configure::write ( 'debug', 1 );
        }

        if (!empty($this->data)) {   
            $observacion_oferta = $this->data['Instit']['observacion_oferta'];
            
            $this->data = $this->Instit->read(null, $this->data['Instit']['id']);
            $this->data['Instit']['observacion_oferta'] = $observacion_oferta;
            
            $this->Instit->save($this->data);
            
            $this->set('cerrar',true);
        }
        else {
            $this->Instit->recursive = 0;
            $instit = $this->Instit->find('first',array('conditions'=>array('Instit.id' => $id)));

            $observacion_oferta = '';

            if (!empty($instit)) {
                $observacion_oferta = $instit['Instit']['observacion_oferta'];
            }

            $this->set('instit_id', $id);
            $this->set('observacion_oferta', $observacion_oferta);
        }   
    }


    
}
?>
