<?php
class Tipoinstit extends AppModel {

	var $name = 'Tipoinstit';
	
	var $order = 'Tipoinstit.name';
	
	var $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Jurisdiccion',
	);

	var $hasMany = array(
			'Instit',
	);

	var $validate = array(
            'name' => array(
			'rule' => 'notEmpty', // or: array('ruleName', 'param1', 'param2' ...)
			'required' => true,
			'allowEmpty' => false,
			//'on' => 'create', // or: 'update'
			'message' => 'Se debe ingresar un nombre para la Jurisdicción. No puede quedar vacío.',
                )
   );
   
   
   
   /**
    * me devuelve todos los tipos de institucion para la priovincia requerida
    * 
    * @param $jur_id ID de jurisdiccion que quiero encontrar = 0 por default (trae todas)
    * @param $recursive -1 por default
    * @return array del find(all)
    */
   function dame_por_jurisdiccion($jur_id = 0, $recursividad = -1){
   		$this->recursive = $recursividad;
   		if($jur_id == 0 ){//buscar a todas
         	$inss = $this->find('all',array('order'=>'Tipoinstit.name ASC'));
        }else{
         	$inss = $this->find('all',array('conditions' => array('jurisdiccion_id' => $jur_id),
         											  'order'=>'Tipoinstit.name ASC'));
        }
        return $inss;
   }
   
   
   /**
    * Me devuelve un find de los tipoinstit pero con la jurisdiccion
    * 
    * @param string $type "find types"
    * @param array $options opciones del find
    * @return array del tipo find
    */
   function dameConJurisdiccion($type = 'all', $options = array()){  		
   		$options = array_merge($options, array('contain'=> array('Jurisdiccion')));
   		
   		if ($type == 'list') {
   			$tras = $this->find('all',$options);
   			foreach ($tras as $t) {
   				if(strlen($t['Tipoinstit']['name'])>59){
					$t['Tipoinstit']['name'] = substr($t['Tipoinstit']['name'],0,19);
					$t['Tipoinstit']['name'] .= '...';
				}
				if(strlen($t['Jurisdiccion']['name'])>19){
					$t['Jurisdiccion']['name'] = substr($t['Jurisdiccion']['name'],0,19);
					$t['Jurisdiccion']['name'] .= "...";
				}
   				$name = $t['Tipoinstit']['name']." (".$t['Jurisdiccion']['name'].")";
   				
   				$tipoins[$t['Tipoinstit']['id']] = $name; 
   			}
   			
   		} else {
   			$tipoins = $this->find($type,$options);
   		}
   		return $tipoins;
   }

   /**
     *
     * devuelve array con todos los tipo instits que tienen abreviaturas
     *
     */
    function getAbreviados()
    {
        $this->recursive = -1;
        $tipos = $this->find('all', array('conditions' => array('name LIKE' => '%(%')));

        $abrevstr = '';
        foreach ($tipos as $tipo) {
            $abrevstr = '';
            $tipo = $tipo['Tipoinstit']['name'];
            $pos_ini = strpos($tipo, '(');
            $pos_fin = strpos($tipo, ')');
            if ($pos_ini !== false && $pos_fin !== false && $pos_fin > $pos_ini) {
                $abrevstr = strtolower(substr($tipo, $pos_ini+1, $pos_fin-$pos_ini-2));
                if ($abrevstr !== false) {
                    $abrevs[str_replace('.','',$abrevstr)] = $abrevstr;
                }
            }
        }

        return $abrevs;
    }
	
}



?>