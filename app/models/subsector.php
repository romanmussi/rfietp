<?php
class Subsector extends AppModel {

	var $name = 'Subsector';
	var $validate = array(
		'name' => array('notempty'),
		'sector_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Sector',
	);

	var $hasMany = array(
                        'SectoresTitulo' => array( 'dependent' => true ),
			'Plan',
	);


        var $hasAndBelongsToMany = array(
            'Titulo' => array('joinTable' => 'sectores_titulos'),
             );

	
	
	/**
	 * 
	 * 	Te trae todos los subsectores que pertenecen a ese sector
	 * 
	 * @param string $tipo tipo del find
	 * @param integer $sector_id id del sector que estoy buscando
	 * @return array del find
	 */
	function con_sector($tipo = 'all' , $sector_id = 0, $conditions = array()){
            $this->recursive = 0;

            //inicializo la variable return
            $subsectores = array();

            $this->order = 'Subsector.name ASC';
            if($sector_id != 0 ){
                $conditions['sector_id'] = $sector_id;

            }

            $subsectores = $this->find('all',array('conditions' => $conditions));

            // me lo prepara para el combo del select
            if($tipo == 'list')
            {
                $ss_aux = array();
                $ss_aux[0] = 'Sin subsector';
                foreach($subsectores as $ss):
                        $ss_name = $ss['Subsector']['name']." (".$ss['Sector']['name'].")";
                        $ss_aux[$ss['Subsector']['id']] = (strlen($ss_name)>60)? substr($ss_name,0,60)."..." : $ss_name;
                endforeach;
                $subsectores = $ss_aux;
            }
            
            // si no puse ni 'all', ni 'list', entonces que me devolverá un array vacio
            return $subsectores;
	}

       

}
?>