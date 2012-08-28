<?php
class Departamento extends AppModel {

	var $name = 'Departamento';
        var $actsAs = array('Containable');
	var $validate = array(
		'name' => array('notempty')
	);

        var $order = array('Departamento.name');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array('Jurisdiccion');

	var $hasMany = array(
			'Localidad' => array(
                            'className' => 'Localidad',
                            'foreignKey' => 'departamento_id',
                            'dependent'=> true, // borra en cascada
                            'conditions' => '',
                            'fields' => '',
                            'order' => '',
                            'limit' => '',
                            'offset' => '',
                            'exclusive' => '',
                            'finderQuery' => '',
                            'counterQuery' => ''
			),
			'instit' => array(
                            'className' => 'instit',
                            'foreignKey' => 'departamento_id',
                            'dependent' => false,
                            'conditions' => '',
                            'fields' => '',
                            'order' => '',
                            'limit' => '',
                            'offset' => '',
                            'exclusive' => '',
                            'finderQuery' => '',
                            'counterQuery' => ''
			)
	);
	
	
	
	/**
	 * 
	 * Esta es una funcion con una onda parecida al find de Cake
	 * Lo que hace es devolverme los departamentos con sus jurisdicciones.
	 * 
	 * 
	 * @param string $tipo 	si es 'all' me devuelve lo del find(), 
	 * 						si es 'list' me devuelve un array con [id][Departamento.nombre + Jurisdiccion.nombre]
	 * @param integer $jurisdiccion_id 	si es == 0 me busca TODAS las Jurisdicciones
	 * 									si es != 0 me busca los deptos de esa jurisdiccion_id
	 * @return array
	 */
	function con_jurisdiccion($tipo = 'all' , $jurisdiccion_id = 0){
		
		
		$this->recursive = 0;
		
		//inicializo la variable return
		$deptos = array();
         
		$this->unBindModel(array('hasMany' => array('Instit')));
		
		$this->order = 'Departamento.name ASC';
         if($jurisdiccion_id != 0 ){
        	$deptos = $this->find('all',array('conditions' => array('jurisdiccion_id' => $jurisdiccion_id)));
         }else{
        	$deptos = $this->find('all');
         }
         
		// me lo prepara para el combo del select  
         if($tipo == 'list')
         {
         	$d_aux = array();
			foreach($deptos as $d): 
				$jurisdiccion = $d['Jurisdiccion']['name'];
				$d_aux[$d['Departamento']['id']] = $d['Departamento']['name']." (Jur: $jurisdiccion)";
			endforeach;
	        $deptos = $d_aux;
         }
        
         // si no puse ni 'all', ni 'list', entonces que me devolverá un array vacio
         return $deptos;
	}
	

}
?>