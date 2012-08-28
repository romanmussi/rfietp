<?php
class Localidad extends AppModel {

	var $name = 'Localidad';

        var $actsAs = array('Containable');
        
	var $validate = array(
		'name' => array('notempty')
	);

        var $order = array('Localidad.name');

        
	var $belongsTo = array(
                'Departamento',
	);
	
	var $hasMany = array(
                'instit' => array('dependent' => false),
	);
	
	
	/**
	 * me trae las localidades Bindeadas con el departamento y la jurisdiccion
	 * y me desbindea las instituciones para hacer mucho mas performante la query
	 * @return array [localidad, departamento, jurisdiccion]
	 */
	function con_depto_y_jurisdiccion($tipo = 'all', $jurisdiccion_id = 0, $order="asc")
	{
		 /*$localidades = Cache::read("localidades_con_depto_y_juirisdicion_id_$jurisdiccion_id-tipo_$tipo");
		 if ($localidades !== false) {
			 return $localidades;
		 }
		*/
            if ($order == "length") {
                $order = "LENGTH(Localidad.name) DESC";
            }
            else {
                $order = "Localidad.name ASC";
            }
		//inicializacion de la variable del return
		$localidades = array(); 
		
		$this->recursive = 0;
		// EL modelo Instit no me interesa
        $this->unBindModel(array('hasMany' => array('Instit')));
        $this->bindModel(array(
		    'belongsTo' => array(
		        'Jurisdiccion' => array(
		            'foreignKey' => false,
		            'conditions' => array('Jurisdiccion.id = Departamento.jurisdiccion_id')
		        )
		)));

         if ($jurisdiccion_id != 0){
         	$localidades = $this->find('all',array(	
         							'conditions' => array('Jurisdiccion.id' => $jurisdiccion_id),
         							'order'=>$order
         	));
         }else{
         	$localidades = $this->find('all', array('order'=>$order));
         }
         
         
         // si es un listado  entonces tengo que reescribirlo para que, por ejemplo
         // en los select options aparezca como name la localidad, y el nombre del 
         // departamento y jurisdiccion a la que pertenece
         if($tipo == 'list')
         {         	
         	foreach($localidades as $d):		
				$poner = $d['Localidad']['name'];
			
				// $todos es una variable boolean que me dice si se estan listando 
				// TODAS las localidades o solo las de un departamento en particular				
				$depto = $d['Departamento']['name'];
				$jur = $d['Jurisdiccion']['name'];
			
				if(strlen($depto)>19){
					$depto = substr($depto,0,19);
					$depto .= '...';
				}
				if(strlen($jur)>19){
					$jur = substr($jur,0,19);
					$jur .= "...";
				}
				$poner .= " (Depto: $depto, Jur: $jur)";
				
				if(strlen($poner)>66){
					$poner = substr($poner,0,66);
					$poner .= "...)";
					
				}
				$loc_aux[$d['Localidad']['id']]   = $poner ;
				
			endforeach;		
			$localidades = $loc_aux;
         }
         
         
         //Cache::write("localidades_con_depto_y_juirisdicion_id_$jurisdiccion_id-tipo_$tipo", $localidades);
         return $localidades;
         
	}
	
	function listado_localidades_con_jurisdiccion($jurisdiccion_id)
	{
		$localidades = $this->localidades_con_jurisdiccion($jurisdiccion_id);
		
		
	
         return $localidades;
         
	}
	
}
?>