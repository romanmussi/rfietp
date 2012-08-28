<?php
class Etapa extends AppModel {

	var $name = 'Etapa';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
            'Anio' => array('dependent' => false)
	);
	
	var $validate = array(
		'name' => array(
			'notEmpty'=> array(
				'rule' => VALID_NOT_EMPTY,
				'required' => true,
				'allowEmpty' => false,
				//'on' => 'create', // or: 'update'
				'message' => 'Debe ingresar el nombre.'	
			)
		)
	);

        /**
	 * Me devuelve un array con las etapas_jurisdicciones de la jurisdiccion
	 *	
	 * @param $plan_id
	 * @return Array $aux_vec('plan_id'=>'matricula')
	 */
	function etapas_de_jurisdiccion($jurisdiccion_id){
		$this->EtapasJurisdiccion->recursive = 0;
		$temp= $this->EtapasJurisdiccion->find('all',array(
                                        'conditions'=>array('jurisdiccion_id'=>$jurisdiccion_id)));

                foreach ($temp as $reg) {
                    $etapa[$reg['Etapa']['id']] = $reg['Etapa']['name'];
                }
                
                return $etapa;
        }


}
?>