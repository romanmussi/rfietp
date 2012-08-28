<?php
class Ticket extends AppModel {

	var $name = 'Ticket';
	var $validate = array(
		'instit_id' => array('numeric'),
		'user_id' => array('numeric'),
		'estado' => array('numeric'),
		'observacion' => array(
				'notEmpty'=> array(
					'rule' => VALID_NOT_EMPTY,
					'required' => true,
					'allowEmpty' => false,
					//'on' => 'create', // or: 'update'
					'message' => 'Debe ingresar una Observación.'
					)	
			)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Instit',
			'User',
	);

	/**
	 * 
	 * @param $instit_id
	 * @return unknown_type
	 */
	function dameTicketPendiente($instit_id)
	{
		$this->recursive = -1;
		return  $this->find('first', array('conditions' => array('Ticket.instit_id' => $instit_id, 'Ticket.estado' => 0)));
	}
	
	function dameProvinciasConPendientes()
	{
            if(!is_a($this->Instit->Jurisdiccion,'jurisdiccion')) return array();

		// Busco todas las jurisdicciones
		$this->Instit->Jurisdiccion->recursive = -1;
		$prov_pend = array();

		$prov_pend = $this->Instit->Jurisdiccion->find('list', array('order'=>'Jurisdiccion.name'));
		
		// Por cada jurisdiccion veon cuantos pendientes tiene
		// Si no tiene la saco
		foreach($prov_pend as $id=>$name)
		{
			$this->recursive = 0;
			$count = $this->find('count', array(
								'conditions'=>array('Ticket.estado'=>0,
													'Instit.jurisdiccion_id'=>$id)
							));

			if($count>0)
				$prov_pend[$id] = $name." ($count)";
			else 
				 unset($prov_pend[$id]);		 
		}
		
		return $prov_pend;	
	}

}
?>