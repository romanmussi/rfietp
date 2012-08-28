<?php
class FondoTemporal extends AppModel {

	var $name = 'FondoTemporal';
        var $useTable = 'z_fondo_work';
        var $actsAs = array('Containable');
        
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Instit' => array('className' => 'Instit',
								'foreignKey' => 'instit_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Jurisdiccion' => array('className' => 'Jurisdiccion',
								'foreignKey' => 'jurisdiccion_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);
        


        function getCueCompleto($cueincompleto, $anexo=0) {
            return $cueincompleto*100 + $anexo;
        }

        function getInstitByCueIncompleto($instits, $cue_incompleto) {
            foreach ($instits as $instit) {
                if ($instit['Instit']['cue']*100+$instit['Instit']['anexo'] == $cue_incompleto)
                {
                    return $instit;
                }
            }

            /*$historiales = $this->HistorialCue->find('all', array(
                                    'conditions'=>array('cue'=>$cue_incompleto)
                            ));
            $this->findAllById($historiales[0]['instit_id']);*/
        }

        function asignarInstitYEstadoATemp($instit_id, $estado, $temp_id, $obs=NULL) {
            /*$this->data = $this->read(null, $temp_id);
            if (!empty($this->data)) {
                $this->data['FondoTemporal']['cue_checked'] = $estado;
                $this->data['FondoTemporal']['instit_id'] = $instit_id;
                if ($this->save($this->data)) {
                } else {
                        $this->Session->setFlash(__('El FondoTemporal id '.$temp_id.' no pudo ser actualizado.', true));
                }
            }
            */
            // evita un select gigante en cada update
            if ($obs)
                $this->query("UPDATE z_fondo_work SET cue_checked=".$estado.", instit_id=".$instit_id.", observacion='".$obs."' WHERE id=".$temp_id.";");
            else
                $this->query("UPDATE z_fondo_work SET cue_checked=".$estado.", instit_id=".$instit_id." WHERE id=".$temp_id.";");
        }



        /**
	 *
	 * compara dos nombres de instit sin tipo ni numero
	 *
	 * @param $text_temp
         * @param $text
	 */
        function compara_InstitNombres($text_temp, $text, $tipoInstits=NULL)
        {
            $text_temp = $this->str_sin_tipoInstit($this->optimizar_cadena($text_temp), $tipoInstits);
            $text = $this->str_sin_tipoInstit($this->optimizar_cadena($text), $tipoInstits);

            if ($text_temp == $text)
                return true;

            $array_words = explode(" ", $text);
            $array_words_temp = explode(" ", $text_temp);
            
            // chequea si uno es anexo y otro no
            $res1 = array_search('anexo', $array_words);
            $res2 = array_search('anexo', $array_words_temp);

            if (!$res1 && $res2 || $res1 && !$res2)
                return false;

            // quitar N° , comparar cada posicion con todas las de array_words
            $palabras_totales_temp = count($array_words_temp);
            $palabras_totales = count($array_words);
            $peso = 0;
            for ($i=0; $i < count($array_words_temp); $i++) {
                // que no sea nº
                if (strpos($array_words_temp[$i],'nº') === false) {
                    foreach ($array_words as $array_word) {
                        // que no sea nº
                        if (strpos($array_word,'nº') === false) {
                            if ($array_words_temp[$i] == $array_word) {
                                $peso++;
                                break;
                            }
                            elseif (strlen($array_word) >= 4 && strlen($array_words_temp[$i]) >= 4) {
                                if (levenshtein($array_words_temp[$i], $array_word) <= 1) {
                                    $peso++;
                                    break;
                                }
                            }
                        }
                        else {
                            $palabras_totales--;
                        }
                    }
                }
                else {
                    $palabras_totales_temp--;
                }
            }

            if ($palabras_totales > $palabras_totales_temp) {
                $limit = $palabras_totales;
            } else {
                $limit = $palabras_totales_temp;
            }
            
            // compara limit con el peso encontrado
            if ($peso > 0 && $peso > $limit/2) {
                /*pr($array_words_temp);
                pr($array_words);
                echo "TRUE! limit: ".$limit."   -   peso: ".$peso;*/
                return true;
            }

            return false;
        }

        function length_cmp( $a, $b ) {
            return strlen($b)-strlen($a);
        }

         /**
	 *
	 * optimiza nombre de instits para una futura comparacion
	 *
	 * @param $text
	 */
	function optimizar_cadena($text) {
            // elimina acentos y especiales
            $a = array('Á','É','Í','Ó','Ú','à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
            $b = array('a','e','i','o','u','a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
            $text = str_replace($a, $b, $text);

            $text = strtolower($text);

            // algunos casos tienen = en lugar de -
            $text = str_replace("=","-",$text);

            // mas especiales
            $a = array('etagro','agro.', 'e. ', 'e.t..'," -", '- ', '. ', '°', '_');
            $b = array('et agro','agro ', 'e ', 'et ', ' ', ' ', ' ', 'º', ' ');
            $text = str_replace($a, $b, $text);

            // elimina espacios en blanco en exceso (maximo deja uno)
            $text = preg_replace('/\s\s+/', ' ', $text);

            $palabras_reservadas = array("- ", " - ", ".");

            // elimina palabras reservadas
            $text = str_replace($palabras_reservadas, '', $text);

            // junta los n°
            $text = str_replace("nº ","nº",$text);
            // algunos casos tienen N'
            $text = str_replace("n' ","nº",$text);
            // algunos casos tienen N|
            $text = str_replace("n| ","nº",$text);

            // separa "nº" si esta pegado al nombre
            $pos = '';
            $pos_fin = strlen($text)-1;
            $pos = strpos($text,'º');
            if ($pos !== false)
            {
                for ($i=($pos+1); $i<strlen($text); $i++)
                {
                    if ($text[$i]=='-' && !is_numeric($text[$i+1])) {
                        $pos_fin = $i-1;
                        break;
                    }
                    elseif ($text[$i]!='-' && !is_numeric($text[$i])) {
                        $pos_fin = $i;
                        break;
                    }
                }
                
                if ($pos_fin > $pos) {
                    // pone espacio luego del numero (...._espacio_nºX_espacio_....)
                    $text = substr($text, 0, $pos-1)." ".substr($text, $pos-1, $pos_fin-($pos-2))." ".substr($text, $pos_fin+1);
                }
            }

            // elimina espacios en blanco en exceso (maximo deja uno)
            $text = preg_replace('/\s\s+/', ' ', $text);

            return trim($text);
	}



        /**
	 *
	 * compara el nro de instit inmerso en el nombre con el enviado
         * por parametro
	 *
	 * @param $text
         * @param $nroinstit
	 */
        function compara_numeroInstit($text, $nroinstit) {
            $numero = '';
            $text = $this->optimizar_cadena($text);
            $words = explode(" ", $text);
            //$words = $text;
            foreach ($words as $value1) {
                // busca por nº
                $pos = strpos($value1,'nº');
                if ($pos !== false) {
                    $numero = trim(str_replace('nº','',$value1));
                    break;
                }
                else
                {
                    // busca por A- (privados)
                    $pos = strpos($value1,'a-');
                    if ($pos !== false) {
                        $numero = trim($value1);
                        break;
                    }
                }

                // busca por D.E.
                /*$pos = strpos($value1,'de');
                if ($pos !== false) {
                    $numero = str_replace('nº','',$value1);
                }*/
            }

            if (!strlen($numero)) {
                // no tiene ningun numero en su nombre
                return true;
            }

            if (is_numeric($numero)) {
                return ((int)$numero == (int)strtolower($nroinstit));
            }
            else {
                return (strtolower($numero) == strtolower($nroinstit));
            }
        }

        /**
	 *
	 * compara el tipo de instit inmerso en el nombre con los tipos existentes
	 *
	 * @param $instit
         * @param $tiposInstit
	 */
        function compara_tipoInstit($instit, $tiposInstit)
        {
            //$instit = $this->optimizar_cadena($instit);
            $instit = $this->completa_tipoInstit_abreviados($instit);
            $instit_optimizado = $this->optimizar_cadena($instit);

            foreach ($tiposInstit as $tipoInstit) {
                $tipo_sin_abrev = '';
                $pos1 = $pos2 = false;
                $str_optimizado = $this->optimizar_cadena($tipoInstit['Tipoinstit']['name']);
                
                // si no tiene abreviatura
                $pos = strpos($str_optimizado, "(");
                if ($pos !== false) {
                    $tipo_sin_abrev = trim(substr($str_optimizado, 0, $pos-1));
                    $pos2 = strpos($instit_optimizado, $tipo_sin_abrev);
                }
                $pos1 = strpos($instit_optimizado, $str_optimizado);
                
                if ($pos1 !== false || $pos2 !== false)
                {
                    // contiene el TIPO
                    return $tipoInstit['Tipoinstit']['id'];
                }
            }



            return 0;

        }

        /**
	 *
	 * compara la localidad del fondo con la del instit, la cual puede venir
         * en un campo o incluida en el nombre del fondo
	 *
	 * @param $instit
	 */
        function compara_Localidad($fondo, $instit) {
            if (!strlen($instit['Localidad']['name']))
                return false;

            if (strlen($fondo['FondoTemporal']['localidad'])) {
                if ($this->optimizar_cadena($instit['Localidad']['name']) == $this->optimizar_cadena($fondo['FondoTemporal']['localidad'])) {
                    return true;
                }
            }
            else {
                if ((strlen($fondo['FondoTemporal']['instit_name']) && strpos($this->optimizar_cadena($fondo['FondoTemporal']['instit_name']), $this->optimizar_cadena($instit['Localidad']['name'])) !== false) ||
                    (strlen($fondo['FondoTemporal']['instit']) && strpos($this->optimizar_cadena($fondo['FondoTemporal']['instit']), $this->optimizar_cadena($instit['Localidad']['name'])) !== false))
                {
                    return true;
                }
            }

            return false;
        }


        /**
	 *
	 * completa cadena en caso de tener abreviaturas
	 *
	 * @param $instit
	 */
        function completa_tipoInstit_abreviados($instit)
        {
            $instit = $this->optimizar_cadena($instit);
            $instit = str_replace('.','',strtolower($instit));

            $a = array('eet',
                       'escuela de educacion tecnica',
                       'e alternancia',
                       'et agro ',
                       'etagro ',
                       'etagro',
                       'eagro ',
                       'escuela agrotecnica provincial',
                       'escuela de educacion agropecuaria',
                       'epet',
                       'et ',
                       'inspt',
                       'cent ',
                       'centro educativo de nivel terciario',
                       'cfl',
                       'cfp',
                       'centro fp',
                       'centro de formacion profesional',
                       'centro de formacion laboral',
                       'cea',
                       'centro de educacion agricola',
                       'cem',
                       'centro de educacion media',
                       'centro de educacion tecnica',
                       'centro de educacion especial',
                       'eeat',
                       'eea',
                       'escuela de educacion agraria',
                       'cfr',
                       'eee',
                       'efa',
                       'efp',
                       'cept',
                       'centro educativo para la produccion total',
                       'centro educativo para la produccion',
                       'cpet',
                       'ies',
                       'iea',
                       'eem',
                       'escuela de educacion media',
                       'isfdyt',
                       'isfd y t',
                       'instituto superior de formacion docente continua y tecnica',
                       'instituto superior de formacion docente y tecnica',
                       'mm',
                       'mision monotecnica y de extension cultural',
                       'mision monotecnica',
                       'monotec ',
                       'enet',
                       'isp',
                       'ceder',
                       'ipem',
                       'cens',
                       'copyco',
                       'centro de orientacion profesional y capacitacion obrera',
                       'uep',
                       'iset',
                       'cecla',
                       'centro de capacitacion laboral',
                       'epnm',
                       'etp',
                       'itec ',
                       'cct',
                       'cemoe',
                       'epea',
                       'cepaho',
                       'ufidet',
                       'eetpi',
                       'eetpa',
                       'ispi',
                       'centro ',
                );

            $b = array("ESCUELA DE EDUCACIÓN TÉCNICA (E.E.T.)",
                       "ESCUELA DE EDUCACIÓN TÉCNICA (E.E.T.)",
                       "ESCUELA DE ALTERNANCIA",
                       "ESCUELA TÉCNICA AGROPECUARIA ",
                       "ESCUELA TÉCNICA AGROPECUARIA ",
                       "ESCUELA TÉCNICA AGROPECUARIA ",
                       "ESCUELA AGROTÉCNICA ",
                       "ESCUELA AGROTÉCNICA PROVINCIAL",
                       "ESCUELA DE EDUCACIÓN AGROPECUARIA",
                       "ESCUELA PROVINCIAL DE EDUCACIÓN TÉCNICA (E.P.E.T.)",
                       "ESCUELA DE EDUCACIÓN TÉCNICA (E.E.T.) ",
                       "INSTITUTO NACIONAL SUPERIOR DEL PROFESORADO TÉCNICO (I.N.S.P.T.)",
                       "CENTRO EDUCATIVO DE NIVEL TERCIARIO (C.E.N.T.) ",
                       "CENTRO EDUCATIVO DE NIVEL TERCIARIO (C.E.N.T.) ",
                       "CENTRO DE FORMACIÓN LABORAL",
                       "CENTRO DE FORMACIÓN PROFESIONAL (C.F.P.)",
                       "CENTRO DE FORMACIÓN PROFESIONAL (C.F.P.)",
                       "CENTRO DE FORMACIÓN PROFESIONAL (C.F.P.)",
                       "CENTRO DE FORMACIÓN LABORAL",
                       "CENTRO DE EDUCACIÓN AGRÍCOLA (C.E.A.)",
                       "CENTRO DE EDUCACIÓN AGRÍCOLA (C.E.A.)",
                       "CENTRO DE EDUCACIÓN MEDIA",
                       "CENTRO DE EDUCACIÓN MEDIA",
                       "CENTRO DE EDUCACIÓN TÉCNICA",
                       "CENTRO DE EDUCACIÓN ESPECIAL",
                       "ESCUELA DE EDUCACIÓN AGROTÉCNICA (E.E.A.T.)",
                       "ESCUELA DE EDUCACIÓN AGRARIA (E.E.A.)",
                       "ESCUELA DE EDUCACIÓN AGRARIA (E.E.A.)",
                       "CENTRO DE FORMACIÓN RURAL (C.F.R.)",
                       "ESCUELA DE EDUCACIÓN ESPECIAL (E.E.E.)",
                       "ESCUELA DE LA FAMILIA AGRICÓLA (E.F.A.)",
                       "ESCUELA DE FORMACIÓN PROFESIONAL",
                       "CENTRO EDUCATIVO PARA LA PRODUCCIÓN TOTAL (C.E.P.T.)",
                       "CENTRO EDUCATIVO PARA LA PRODUCCIÓN TOTAL (C.E.P.T.)",
                       "CENTRO EDUCATIVO PARA LA PRODUCCIÓN TOTAL (C.E.P.T.)",
                       "COLEGIO PROVINCIAL DE EDUCACIÓN TECNOLÓGICA (C.P.E.T.)",
                       "INSTITUTO DE EDUCACIÓN SUPERIOR (I.E.S.)",
                       "INSTITUTO DE ENSEÑANZA AGROPECUARIA (I.E.A.)",
                       "ESCUELA DE EDUCACIÓN MEDIA (E.E.M.)",
                       "ESCUELA DE EDUCACIÓN MEDIA (E.E.M.)",
                       "INSTITUTO DE EDUCACIÓN SUPERIOR DE FORMACIÓN DOCENTE Y TÉCNICA (I.S.F.D.yT.)",
                       "INSTITUTO DE EDUCACIÓN SUPERIOR DE FORMACIÓN DOCENTE Y TÉCNICA (I.S.F.D.yT.)",
                       "INSTITUTO DE EDUCACIÓN SUPERIOR DE FORMACIÓN DOCENTE Y TÉCNICA (I.S.F.D.yT.)",
                       "INSTITUTO DE EDUCACIÓN SUPERIOR DE FORMACIÓN DOCENTE Y TÉCNICA (I.S.F.D.yT.)",
                       "MISIÓN MONOTÉCNICA (M.M.)",
                       "MISIÓN MONOTÉCNICA Y DE EXTENSION CULTURAL",
                       "MISIÓN MONOTÉCNICA (M.M.)",
                       "MISIÓN MONOTÉCNICA (M.M.) ",
                       "ESCUELA NACIONAL DE EDUCACIÓN TÉCNICA (E.N.E.T.)",
                       "INSTITUTO DE EDUCACIÓN SUPERIOR DEL PROFESORADO (I.S.P.)",
                       "CENTRO DE DESARROLLO REGIONAL (CE.DE.R.)",
                       "INSTITUTO PROVINCIAL DE EDUCACIÓN MEDIA (I.P.E.M.)",
                       "CENTRO EDUCATIVO DE NIVEL SECUNDARIO (C.E.N.S.)",
                       "CENTRO DE ORIENTACIÓN PROFESIONAL Y CAPACITACIÓN OBRERA (C.O.P.Y.C.O.)",
                       "CENTRO DE ORIENTACIÓN PROFESIONAL Y CAPACITACIÓN OBRERA (C.O.P.Y.C.O.)",
                       "UNIDAD EDUCATIVA PRIVADA (U.E.P.)",
                       "INSTITUTO DE EDUCACIÓN SUPERIOR DE EDUCACIÓN TÉCNICA (I.S.E.T.)",
                       "CENTRO DE CAPACITACIÓN LABORAL (CE.C.LA.)",
                       "CENTRO DE CAPACITACIÓN LABORAL (CE.C.LA.)",
                       "ESCUELA PROVINCIAL DE NIVEL MEDIO (E.P.N.M.)",
                       "ESCUELA TÉCNICA PROVINCIAL (E.T.P.)",
                       "INSTITUTO TECNOLÓGICO (I.TEC.) ",
                       "CENTRO DE CAPACITACIÓN PARA EL TRABAJO (C.C.T.)",
                       "CENTRO DE MANO DE OBRA ESPECIALIZADA (CE.M.O.E.)",
                       "ESCUELA PROVINCIAL DE EDUCACIÓN AGROPECUARIA (E.P.E.A.)",
                       "CENTRO EDUCATIVO PARA EL HOGAR (CE.PA.HO.)",
                       "UNIDAD DE FORMACIÓN, INVESTIGACIÓN Y DESARROLLO TECNOLÓGICO (U.F.I.D.E.T.)",
                       "ESCUELA DE ENSEÑANZA TÉCNICA PARTICULAR INCORPORADA (E.E.T.P.I.)",
                       "ESCUELA DE EDUCACIÓN TÉCNICA PARTICULAR AUTORIZADA (E.E.T.P.A.)",
                       "INSTITUTO DE EDUCACIÓN SUPERIOR PARTICULAR INCORPORADA (I.S.P.I.)",
                       "centro "
                );

            return trim(strtolower(str_replace($a, $b, $instit)));
        }

        /**
	 *
	 * elimina el tipoInstit de la cadena dada
	 *
	 * @param $instit
         * @param $tiposInstit
	 */
        function str_sin_tipoInstit($instit, $tiposInstit)
        {
            foreach ($tiposInstit as $tipoInstit) {
                $str_optimizado = $this->optimizar_cadena($tipoInstit['Tipoinstit']['name']);
                $b[] = $str_optimizado;

                // si no tiene abreviatura
                $pos = strpos($str_optimizado, "(");
                if ($pos !== false) {
                    $b[] = trim(substr($str_optimizado, 0, $pos-1));
                }
            }

            // agregados
            $b_sin_abrev[] = "centro fp";
            $b_sin_abrev[] = "mision monotecnica";

            $instit = strtolower(str_replace($b, '', $instit));

            $instit = str_replace('.','',strtolower($instit));

            $a = array('eet',
                       'escuela de educacion tecnica',
                       'e alternancia',
                       'et agro ',
                       'etagro ',
                       'etagro',
                       'eagro ',
                       'et ',
                       'inspt',
                       'cent ',
                       'cfp',
                       'cfl',
                       'centro fp',
                       'cea',
                       'cem ',
                       'eea',
                       'cfr',
                       'eee',
                       'efa',
                       'efp',
                       'cept',
                       'cpet',
                       'ies',
                       'iea',
                       'eem',
                       'isfdyt',
                       'isfd y t',
                       'isfd yt',
                       'mm',
                       'enet',
                       'isp',
                       'ceder',
                       'ipem',
                       'cens',
                       'copyco',
                       'uep',
                       'iset',
                       'eeat',
                       'cecla',
                       'epet',
                       'epnm',
                       'etp',
                       'itec',
                       'cct',
                       'cemoe',
                       'epea',
                       'cepaho',
                       'ufidet',
                       'eetpi',
                       'eetpa',
                       'ispi'
                );

            $instit = str_replace($a, '', $instit);
            $instit = str_replace('()', '', $instit);

            // elimina espacios en blanco en exceso (maximo deja uno)
            $instit = preg_replace('/\s\s+/', ' ', $instit);

            return trim(strtolower($instit));
        }


        function str_sin_localidades($text, $localidades)
        {
            return str_replace($localidades, '', $text);
        }

        function setObservacion(&$fondo, $comment) {
            $fondo['FondoTemporal']['observacion'] .= "[".date('d-m-Y H:i:s')."] ".$comment."\r\n";
        }


        function validarInstit($fondo, $instits, $tipoInstits)
        {
            /*$this->Instits = ClassRegistry::init("Instit");
            $this->Instits->recursive = 0;
            $this->Instits->Tipoinstit->recursive = 0;
            $this->Instits->Departamento->Localidad->recursive = 0;
*/
            $jurisdiccion_id = '';

            // todas las localidades (solo una vez)
          /*  $localidades = $this->Instits->Departamento->Localidad->find('all', array(
                                'order'=> array('LENGTH(Localidad.name)'=>'desc')
                            ));
*/
            // auditoria
            $instits_checked = $instits_en_duda = $instits_no_checked = 0;

            if ($fondo)
            {
                $cue_checked = $instit_checked = false;
                $en_duda_instit_id = $tipoInstitMatchedId = '';

                // 1. Acota proceso a Jurisdiccion con jurisdiccion_id
                if ($jurisdiccion_id != $fondo['FondoTemporal']['jurisdiccion_id'])
                {
                    // si cambia la jurisdiccion re-setea la coleccion de instits con
                    // la que va a trabajar
                    $jurisdiccion_id = $fondo['FondoTemporal']['jurisdiccion_id'];
                    /*
                    // acota a instits de esta jurisdiccion
                    $instits = $this->Instits->find("all", array(
                    'conditions'=> array('Instit.jurisdiccion_id' => $jurisdiccion_id),
                    'fields'=> array('id','cue','nombre','nroinstit','anexo')));

                    // trae todos los tipoInstits de esta jurisdiccion ordenados por cantidad de
                    $tipoInstits = $this->Instits->Tipoinstit->find("all", array(
                            'conditions'=> array('jurisdiccion_id' => $jurisdiccion_id),
                            'order'=> array('LENGTH(Tipoinstit.name)'=>'desc')
                        ));
                    */
                    //$localidades = $this->Instits->Departamento->Localidad->con_depto_y_jurisdiccion('all',$jurisdiccion_id);
                    $localidades = '';
                }

                // instit_name tiene prioridad, viene mas completo
                if (strlen($fondo['FondoTemporal']['instit_name'])) {
                    $text = $fondo['FondoTemporal']['instit_name'];
                }
                elseif (strlen($fondo['FondoTemporal']['instit'])) {
                    $text = $fondo['FondoTemporal']['instit'];
                }
                else {
                    $text = '';
                }

                // 2. Compara CUEs
                if (strlen($fondo['FondoTemporal']['cuecompleto']))
                {
                    // valida por nro de CUE
                    $instit = $this->getInstitByCueIncompleto($instits, $fondo['FondoTemporal']['cuecompleto']);

                    if ($instit)
                    {
                        // el CUE fue encontrado
                        // chequea el numero y tipo de instit
                        if ($this->compara_numeroInstit($text, $instit['Instit']['nroinstit']))
                        {
                            $tipoInstitMatchedId = $this->compara_tipoInstit($text, $tipoInstits);
                            if ($tipoInstitMatchedId == @$instit['Instit']['tipoinstit_id'])
                            {
                                $instit_checked = true;
                                return 1;
                            }
                            elseif ($this->compara_institNombres($text, $instit['Instit']['nombre'], $tipoInstits, $localidades)) {
                                // tienen el mismo nombre
                                $instit_checked = true;
                                return 1;
                            }
                            else {
                                //$this->setObservacion($fondo, "La institucion se encuentra en duda. No coincidieron tipo y nombre.");
                            }
                        }
                        else {
                           //$this->setObservacion($fondo, "La institucion se encuentra en duda. No coincide número.");
                        }

                        if (!$instit_checked)
                        {
                            $en_duda_instit_id = $instit['Instit']['id'];
                        }

                        $cue_checked = true;
                    }
                }

                if (!$instit_checked)
                {
                    if (strlen($text))
                    {
                        // compara nombres
                        if (count($instits)) {
                            foreach ($instits as $instit)
                            {
                                // chequea el numero de instit
                                if ($this->compara_numeroInstit($text, $instit['Instit']['nroinstit']))
                                {
                                    if ($this->compara_institNombres($text, $instit['Instit']['nombre_completo'], $tipoInstits, $localidades)) {
                                        // tienen el mismo nombre
                                        $instit_checked = true;
                                        return 1;
                                    }
                                }
                            }
                        }
                    }

                    if (!$instit_checked) {
                        if ($en_duda_instit_id) {
                            // edita cue_checked en 2 (duda)
                            return 2;
                        }
                        else {
                            $instits_no_checked++;
                            return 0;
                        }
                    }
                }
            }
        }

}
?>