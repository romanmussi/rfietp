<?php
class JurisdiccionesController extends AppController {

	var $name = 'Jurisdicciones';
	var $helpers = array('Html', 'Form','Time');
	var $paginate = array('limit' => 25, 'order'=>array('Jurisdiccion.name'=>'asc'));

        function beforeFilter() {
            parent::beforeFilter();
            $this->rutaUrl_for_layout[] =array('name'=> 'Listado de Jurisdicciones','link'=>'/Jurisdicciones/listado' );
        }

	function index() {
		$this->Jurisdiccion->recursive = 0;
		$this->set('jurisdicciones', $this->paginate());
	}


	function comparar_cargo($a, $b)
  	{
    	return $b['Cargo'][0]["rango"] - $a['Cargo'][0]["rango"];
  	}



	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('La jurisdicción no existe', true));
			$this->redirect(array('action'=>'listado'));
		}
                
        $ministros = $this->Jurisdiccion->Autoridad->find('all',
        	array('conditions'=>array('Autoridad.jurisdiccion_id'=>$id),
        		  'contain'=>array('Cargo'))
        );

	  	function __compare_rango($a, $b) {
		    return($a['Cargo'][0]["rango"] > $b['Cargo'][0]["rango"]);
		}
		
		usort($ministros, "__compare_rango");

        $this->Jurisdiccion->recursive = 0;
        $this->set('ministro',$ministros[0]);
		$this->set('jurisdiccion', $this->Jurisdiccion->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Jurisdiccion->create();
			if ($this->Jurisdiccion->save($this->data)) {
				$this->Session->setFlash(__('La Jurisdiccion ha sido creada', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Jurisdiccion could not be saved. Please, try again.', true));
			}
		}

                //$localidades = $this->Jurisdiccion->Departamento->Localidad->con_depto_y_jurisdiccion('list',0);

                //$this->set('localidades', $localidades);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Jurisdiccion', true));
			$this->redirect(array('action'=>'listado'));
		}
		if (!empty($this->data)) {
			if ($this->Jurisdiccion->save($this->data)) {
				$this->Session->setFlash(__('La Jurisdiccion ha sido guardada', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Jurisdiccion could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Jurisdiccion->read(null, $id);
		}

                $localidades = $this->Jurisdiccion->Departamento->Localidad->con_depto_y_jurisdiccion('list',$id);
                
                $this->set('localidades', $localidades);
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Jurisdiccion', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Jurisdiccion->del($id)) {
			$this->Session->setFlash(__('Jurisdiccion deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

        function listado() {
		$this->Jurisdiccion->recursive = 0;
		$this->set('jurisdicciones', $this->paginate());
	}
	
	
	
	/********************************************************************
	 * 
	 * 
	 *  RequestAction
	 * 
	 * 
	 */
	
	function get_name($id){
		$this->Jurisdiccion->recursive = -1;
		$varaux = $this->Jurisdiccion->read(null,$id);
		return $varaux['Jurisdiccion']['name'];
	}
}
?>