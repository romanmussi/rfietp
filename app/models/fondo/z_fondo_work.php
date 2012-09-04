<?php
class ZFondoWork extends AppModel {

	var $name = 'ZFondoWork';
	var $useTable = 'z_fondo_work';
        var $migrationStatus = array('ok');
        

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Jurisdiccion' => array(
			'className' => 'Jurisdiccion',
			'foreignKey' => 'jurisdiccion_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Instit' => array(
			'className' => 'Instit',
			'foreignKey' => 'instit_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);



         /**
         *
         * Me ejecuta la migracion de todos ls campos de z_fondo_work
         * y me los guarda en las tablas de fondos, lineas-de_acciones, etc
         *
         * @param string $cosasMigrar default en 'ij'
         * @param integer $registrosATraer es el LIMIT, para utilizar en desarrollo unicamente
         * @param boolean $borrarDatosFondo  default en false
         * @return integer cant de registros migrados
         */
        function migrar($cosasMigrar = 'ij', $registrosATraer = 0) {
            // marco los jurisdiccionales como CUE checked = 1
            if (!$this->updateAll(array('ZFondoWork.cue_checked'=>1), array('ZFondoWork.tipo'=>'j'))){
                debug("no se pudo pone los jurisdiccionales como cue_checked = 1");
            }


            
            /**
             * @var Fondo
             */
            $this->Fondo =& ClassRegistry::init('Fondo');

            /**
             * array con las lineas de accion del tipo
             * $linea['name_en_minuscula']= $id
             * @var array
             */
            $aLineasDeAcciones = $this->__getLineasDeAccionesWithNameLowercaseAsId();

            /**
             * find de los registros de z_fondo_work
             * @var array
             */
            $temps = $this->temporalesFiltradosX($cosasMigrar, $registrosATraer);

            /*
             * Esta variable guarda los mensajes a mostrar del proceso de migracion
             * @var string $consoleText
             */
            $consoleText = "<p>iniciando</p>";

            
            if (count($temps) == 0){
                $this->migrationStatus[] = 'No hay más registros en la tabla z_fondo_work!!! se detuvo la migración.';
                return -2;
            }
            
       
            $consoleText = "Chequeando que existan las lineas de accion.....<br />";
            //algunas verificaciones previas
            $lineaChecked = $this->__verificarQueLasLineasExistanEnFondo($aLineasDeAcciones, $temps[0]['ZFondoWork']);
            if (!empty($lineaChecked)) {
                $this->migrationStatus[] = "fallo la verificacion de las lineas de accion. la línea $lineaChecked no existe en la tabla de fondos";
                return -1;
            }

            $consoleText .= "limpiando temporales dejando solo lineas de accion con datos....<br />";
            /** @var array  */
            $lineasFiltradas = $this->__dameTemporalFiltrandoLineasVacias($aLineasDeAcciones, $temps);

            $consoleText .= "Convirtiendo lineas y temps en algo lindo para guardar.....<br />";
            $data = $this->__convertirLineasYTempsEnAlgoLindoParaGuardar($temps, $lineasFiltradas);
           
            $consoleText .= "Guardando fondos.....<br />";

            $cantFondos = 0;
            $cantLineas = 0;
            foreach ($data as $f) {
                $this->Fondo->create();
                if ($this->Fondo->save($f['Fondo'])) { // guardar el fondo
                    $this->delete($f['Fondo']['z_fondo_work_id'], false);
                    if (!empty($f['Fondo']['FondosLineasDeAccion'])){
                        foreach ($f['Fondo']['FondosLineasDeAccion'] as $la) {
                            // guardar cada linea de accion del fondo
                            $this->Fondo->FondosLineasDeAccion->create();
                            $la['fondo_id'] = $this->Fondo->id;
                            if (!$this->Fondo->FondosLineasDeAccion->save($la)) {
                                $this->ZFondoWork->migrationStatus[] = $this->Fondo->FondosLineasDeAccion->validationErrors;
                                pr('No se pudo guardar la linea de accion');
                                debug($la);
                                return -4;
                            }
                            $cantLineas++;
                        }
                    }
                    $cantFondos++;
                } else { // no se pudo guardar el fondo
                    $this->ZFondoWork->migrationStatus[] = 'Error al guardar el fondo';
                    pr('No se pudo guardar el fondo');
                    debug( $this->Fondo->validationErrors);
                    return -5;
                }
            }

           $consoleText .= "Finalizando.....<br />";
           $cosas = implode(',',$this->temporalesFiltradosX);
           $resumen = "se procesaron ".count($data)." fondos de ".count($temps)." $cosas del excel de MR.";
           $consoleText .= $resumen;

           //pr($consoleText);
           
           $this->migrationStatus[] = $consoleText;
           debug("Termino todo  perfectamente con $cantFondos fondos y $cantLineas lineas de acción migradas.");
           return count($data);
            //debug($count . " y el size: ". count($temps));
        }



        /**
         * me dice si las lineas que tengo en la tabla estan todas en la tabla temporal
         * @param array $lineas listado de lineas array('f01'=>1) tabla lineas_de_acciones
         * @param array $temporales listado de z_fondo_work
         * @return string '' si paso todo OK, si ubo un error me devuelve la linea de accion
         */
        function __verificarQueLasLineasExistanEnFondo($lineas, $temporales){
            foreach ($lineas as $name=>$id) {
                if (!array_key_exists($name, $temporales)){
                    return $name;
                }
            }
            return '';
        }


        /**
         * Me genera un array preparado para luego hacer el SAVE
         * 
         * @param array $xlsTemps registros de la tabla z_fondo_work
         * @param array $lineas lineas de accion procesadas de z_fondo_work
         * @return array lindo con la relacion Fondo -> FondoLineasDeAccion -> LineasDeAccion
         */
        function __convertirLineasYTempsEnAlgoLindoParaGuardar($xlsTemps, $lineas){
            /**
             * esta variable es para convertir las lineas de accion en algo compatible
             * con la estructura definitiva de Fondo, o sea:
             * se prepara para la tabla fondos, con su FK a linea_de_acciones
             * @var array
             */
            $data = array();

            $aLineasDeAccion = $this->__getLineasDeAccionesWithNameLowercaseAsId();

            $cont = 0;
            //recorro las lineas que tienen algun monto inputado
            foreach ($lineas as $fondoTempId=>$l) {
                $cont2 = 0;

                $vAux = $xlsTemps[$fondoTempId]['ZFondoWork'];
                if (empty($vAux['memo'])){
                    $vAux['memo'] = '-';
                }
                if (empty($vAux['observacion'])){
                    $vAux['description'] = '';
                }
                $data[$cont]['Fondo'] = array(
                    'instit_id'          => $vAux['instit_id'],
                    'jurisdiccion_id'    => $vAux['jurisdiccion_id'],
                    'memo'               => $vAux['memo'],
                    'anio'               => $vAux['anio'],
                    'trimestre'          => $vAux['trimestre'],
                    'total'              => $vAux['total'],
                    'resolucion'         => "''",
                    'description'        => $vAux['observacion'],
                    'z_fondo_work_id'        => $vAux['id'],
                    );
                
                foreach ($l as $lineaForm=>$monto){                    
                    $data[$cont]['Fondo']['FondosLineasDeAccion'][$cont2] = array(
                        'monto'              => $monto,
                        'lineas_de_accion_id'=> $aLineasDeAccion[$lineaForm],
                        );
                    $cont2++;                    
                }
                 $cont++;
            }
            return $data;
        }



        /**
         *  Me hace un listado de todas las lineas de accion, pero en vez de
         * devolverme un array del tipo $a['id] = name, me lo genera al reves:
         * $a['name'] = id.
         * Y me asegura que el key 'name' este en minusculas
         * 
         * @return array @return array
         */
        function __getLineasDeAccionesWithNameLowercaseAsId(){
             /**
             * @var LineasDeAccion
             */
            $this->LineasDeAccion =& ClassRegistry::init('LineasDeAccion');

             // lleno la variable con las lineas de accion correspondientes
            $aLineasDeAcciones = $this->LineasDeAccion->find('list',array(
                                                'fields'=>array('name','id')));
            $lAux = array();
            // las paso a minusculas
            foreach ($aLineasDeAcciones as $lsId=>$lsD) {
                $lAux[strtolower($lsId)]=$lsD;
            }
            return $lAux;
        }


        /**
         * me limpia la tabvla de temporal quitando las lineas de accion
         * que no tienen dinero asignado
         *
         * @param array $aLineasAccion listado de lineas de acciones con forma array(name=>id)
         * @param array $temps array de registros ZFondoWork
         * @return array lineas de accion limpias vinculada con un registro de z_fondo_work
         */
        function __dameTemporalFiltrandoLineasVacias($aLineasAccion, $temps){
            $count = 0;
            //aca voy a ir guardando todas las lineas de accion cuyo monto es <> de CERO
            $lineas = array();
            //es una copia mejorada de la linea de accion
            $newLin = array();
            // recorro todos los registros de z_fondo_work
            foreach ($temps as $id=>$t ) {
                foreach ($aLineasAccion as $lineaName=>$lineaId) {
                    $lineas[$id][$lineaName]  = $t['ZFondoWork'][$lineaName];
                }
                //recorro las lineas de accion del registro
                foreach ($lineas as $regId=>$l) {
                    foreach ($l as $form=>$v) {
                        $valor = (int)$v;
                        //dejo SOLO las lineas que tiene dinero asignado
                        if ( empty($valor) ) {
                            //elimino las lineas de accion cuyo monto es CERO
                            unset($l[ $form]);
                        }
                    }
                    $newLin[$regId] = $l;
                }
                $count++;
            }
           return $newLin;
        }


        /**
         * Me devuelve los temporales de la tabla z_fondo_work
         * filtrando de acuerdo a los parametrros pasados
         * @param string $cosasMigrar
         *  esta variable me dice que elementos traer de la tabla de fondos temp
         *      las opciones son:
         *      'i': trae solo instituciones
         *      'j': trae solo jurisdiccionales
         *      'ij': trae instits y jurisdiccionales'
         *      't': trae los totales (esto no deberia usarlo nunca
         *      'c': trae solo los chekeados (tanto el cue como los totales)
         *      'd': trae instituciones en duda cue_checked = 2
         *           para las dudas de los totales solo trae diferencias pequeñas,
         *           las diferencias grandes no las trae
         *          (diff Grandes = >totales_checked = 3)
         *      false: me trae todo
         *
         * @param integer $registrosATraer es el LIMIT, para utilizar en desarrollo unicamente
         */
        function temporalesFiltradosX($cosasMigrar = 'ijc', $registrosATraer = 0){
            // me traigo el z_fondo_work con las condiciones:
            // utilizo la variable $cosasMigrar para filtrar
            // ya sea por Instituciones, Jurisdiccionales o Totales
            // en realidad yo voy a necesitar solo migrar instituciones
            // y jurisdiccionales, pero el total lo necesito para validar
            $arrayQueryATemps = array();
            // este flag es para saber el tipo de query que tengo que hacer
            $flag1 = (strlen($cosasMigrar)==2)? true:false;
            // esta variable se usa para mostrar en pantalla que fue lo que se migro
            $this->temporalesFiltradosX = array();
            
            $conditions = array(
                'ZFondoWork.tipo' => array(),
                'ZFondoWork.cue_checked' => array(),
                'ZFondoWork.totales_checked' => array(),
            );

            if ($cosasMigrar){
                if (strpos($cosasMigrar,'i') !== false) {
                    $conditions['ZFondoWork.tipo'][] = 'i';
                }
                if (strpos($cosasMigrar,'j') !== false) {
                    $conditions['ZFondoWork.tipo'][] = 'j';
                }
                if (strpos($cosasMigrar,'t') !== false) {
                    $conditions['ZFondoWork.tipo'][] = 't';
                }
                if (strpos($cosasMigrar,'c') !== false) {
                    $conditions['ZFondoWork.cue_checked'][] = 1;
                    $conditions["ZFondoWork.totales_checked"][] = 1;
                }
                if (strpos($cosasMigrar,'d') !== false) {
                    $conditions['ZFondoWork.cue_checked'][] = 2;
                    $conditions["ZFondoWork.totales_checked"][] = 2;
                }
            }
            
            if (count($conditions['ZFondoWork.tipo']) == 0) {
                unset ($conditions['ZFondoWork.tipo']);
            }
            if (count($conditions['ZFondoWork.cue_checked']) == 0) {
                unset ($conditions['ZFondoWork.cue_checked']);
            }
            if (count($conditions['ZFondoWork.totales_checked']) == 0) {
                unset ($conditions['ZFondoWork.totales_checked']);
            }
            
            // en $temps van todas las filas del excel filtradas segun las condiciones de arriba
            $temps = $this->find('all', array(
                'conditions'=> $conditions,
                'limit' => $registrosATraer));
             return $temps;
        }


         /**
         * me procesa el $data y me realiza el save
         *
         * @param array $data aray data del save de Cake
         * @return boolean
         */
        function guardarFondos($data){
            /* @var $fondo Fondo */
            $fondo =& ClassRegistry::init('Fondo');

            $fondoLineas =& ClassRegistry::init('FondosLineasDeAccion');
            //  $fondo->$this->useDbConfig = 'test';
            
            foreach ($data as $d) {
                if (!$fondo->saveAll($d)){
                    // si no guardo algun registro que me devuelva false
                    return false; 
                }
            }            
            return true;
        }


        /**
         * Me corrobora el numero pasado como parametro y la cantidad de registros que
         * hay en la tabla fondos
         * Si coinciden me devuelve 0. Caso contrario me devuelve la cantidad de registros que
         *  estan en la tabla migrada
         *
         * @param integer $totalDelExcel
         * @return integer 0 on success, On failure: cant de registros en fondo
         */
        function checkCantRegistrosFondoConExcel($totalDelExcel){
            $fondo =& ClassRegistry::init('Fondo');
            $cantMig = $fondo->find('count');
            if ($cantMig == $totalDelExcel){
                return 0;
            } else {
                return $cantMig;
            } 
        }
}
?>