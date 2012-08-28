<?php
class HistorialCuesController extends AppController {

	var $name = 'HistorialCues';
	var $helpers = array('Html', 'Form','Ajax');
	var $paginate = array('order'=>array('Instit.cue' => 'asc'),'limit'=>'10'); 

	function beforeFilter(){
		parent::beforeFilter();
		$this->rutaUrl_for_layout[] =array('name'=> 'Buscador Histórico','link'=>'/HistorialCues/search_form' );
	}
	
	function index($instit_id) {
		if(empty($instit_id)){
			$this->Session->flash('ID de Institución inválida');
		}	
		$this->set('cues',$this->HistorialCue->cuesDeInstit($instit_id));

                $this->HistorialCue->Instit->id = $instit_id;
                $this->set('instit',$this->HistorialCue->Instit->read());
		$this->set('instit_id',$instit_id);
		
		$this->rutaUrl_for_layout[] =array('name'=> 'Datos Institución','link'=>'/Instits/view/'.$instit_id );
	}


	function add($instit_id) {
		if (!empty($this->data)) {
			$this->HistorialCue->create();
			if ($this->HistorialCue->save($this->data)) {
				$this->Session->setFlash(__('El Historial fue guardado correctamente', true));
				$this->redirect('/HistorialCues/index/'.$instit_id);
			} else {
				$this->Session->setFlash(__('The Ciclo could not be saved. Please, try again.', true));
			}
		}
		$this->data['HistorialCue']['instit_id'] = $instit_id;
		$this->rutaUrl_for_layout[] =array('name'=> 'Datos Institución','link'=>'/Instits/view/'.$instit_id );
	}

	
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid HistorialCues', true));
		}
		if (!empty($this->data)) {
			if ($this->HistorialCue->save($this->data)) {
				$this->Session->setFlash(__('Se guardó el historial de CUE correctamente', true));
				$this->redirect(array('controller'=>'Instits','action'=>'view',$this->data['HistorialCue']['instit_id']));
			} else {
				$this->Session->setFlash(__('El CUE histórico no pudo ser guardado, por favor intente nuevamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->HistorialCue->read(null, $id);
		}
		$this->rutaUrl_for_layout[] =array('name'=> 'Datos Institución','link'=>'/Instits/view/'.$this->data['Instit']['id'] );
	}
	
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('ID inválido para el Historial de CUEs', true));
			$this->redirect('/pages/home');
		}
		if ($this->HistorialCue->del($id)) {
			$this->Session->setFlash(__('CUE Histórico borrado', true));
			$this->redirect('/pages/home');
		}
	}
	
	/**
	 * Esta accion maneja el formulario de busqueda 
	 * que sera impreso por pantalla
	 *
	 */
	function search_form(){		
		if (!empty($this->data)) {
			$this->redirect('search');
		}
	}
	
	/**
	 * Esta accion es el procesamiento del formulario de busqueda
	 * maneja las condiciones de la busqueda y el paginador
	 *
	 */
	function search(){

		$array_condiciones = array();
		$url_conditions    = array();
		
		/* **************************************************** */
		/* * Seteo la relaciòn con Instits en Full other join * */
		/* **************************************************** */

		$this->HistorialCue->setBelongsToInstitTypeFull();

		if(isset($this->data['HistorialCues']['cue'])){
			if($this->data['HistorialCues']['cue'] != '' || $this->data['HistorialCues']['cue'] != 0 ){

				if($this->data['HistorialCues']['cue'] < 99999 || $this->data['HistorialCues']['cue'] > 1000000000){
           	 				$mensaje = "<H1>El CUE: '".$this->data['HistorialCues']['cue']."' no es válido.</H1> Ingrese un valor numérico entre 6 (Ej: 600118) y 9 dígitos (CUE con anexo. Ej: 500021600).";
           	 				$this->Session->setFlash($mensaje,'default',array('class' => 'flash-warning'));
           	 				$this->redirect('search_form');         	 		
           	 	}
               
           	 	// con esto hago que no se busqeu con un cero adelante
            	$this->data['HistorialCues']['cue'] = (int)$this->data['HistorialCues']['cue'];
            	 	
				$arr_cond1 = array('OR' => array(
					              'CAST(((Instit.cue*100)+Instit.anexo) as character(60)) SIMILAR TO ?' => '%'.$this->data['HistorialCues']['cue'].'%',
                                  'CAST(((HistorialCue.cue*100)+HistorialCue.anexo) as character(60)) SIMILAR TO ?' => '%'.$this->data['HistorialCues']['cue'].'%'
				             ));
				
				$this->paginate['conditions'] = $arr_cond1;
				$array_condiciones['CUE']     = $this->data['HistorialCues']['cue'];
				$url_conditions['cue']        = $this->data['HistorialCues']['cue'];
			}
			else
			{
				$mensaje = "<H1>CUE inválido</H1>Ingrese un valor numérico entre 6 (Ej: 600118) y 9 dígitos (CUE con anexo. Ej: 500021600).";
            	$this->Session->setFlash($mensaje,'default',array('class' => 'flash-warning'));
            	$this->redirect('search_form');
			}
		}

		if(isset($this->passedArgs['cue'])){	
			if($this->passedArgs['cue'] != '' || $this->passedArgs['cue'] != 0 ){
				$arr_cond1 = array('OR' => array(
					               'CAST(((Instit.cue*100)+Instit.anexo) as character(60)) SIMILAR TO ?' => '%'.$this->passedArgs['cue'].'%',
                                   'CAST(((HistorialCue.cue*100)+HistorialCue.anexo) as character(60)) SIMILAR TO ?' => '%'.$this->passedArgs['cue'].'%'
								   								   ));
				            	 		
				$this->paginate['conditions'] = $arr_cond1;
				$array_condiciones['CUE']     = $this->passedArgs['cue'];
				$url_conditions['cue']        = $this->passedArgs['cue'];
			}
		}
            
	    $this->HistorialCue->recursive = 1;         
	    $data = $this->paginate();

	    /* ************************************************************ */
		/* * Llamo el find de instit para que arme el nombre completo * */
		/* ************************************************************ */
	
	    $totInstit = count($data);
		for ($i=0;$i<$totInstit;$i++){
			$nombre_completo = $this->HistorialCue->Instit->find(array('Instit.id'=>$data[$i]['Instit']['id']));
			$data[$i]['Instit']['nombre_completo'] = $nombre_completo['Instit']['nombre_completo'];
		}
		//debug($data);
        $this->set('instits', $data);
        $this->set('url_conditions', $url_conditions);
        $this->set('conditions', $array_condiciones);
	}
}
?>