<?php
class DepartamentosController extends AppController {

	var $name = 'Departamentos';
	var $helpers = array('Html', 'Form');
        var $components = array('RequestHandler');

	function index() {
		$this->Departamento->recursive = 0;
		$this->set('departamentos', $this->paginate());
		$this->set('url_conditions', array());
		$this->set('jurisdicciones',$this->Departamento->Jurisdiccion->find('list'));
	}
	
	function ver($jurisdiccion = 0) {
		$this->Departamento->recursive = 0;
		
		$jurisdiccion =  (isset($this->passedArgs['jurisdiccion_id']))?$this->passedArgs['jurisdiccion_id']:$jurisdiccion;		
		$jurisdiccion =  (isset($this->data['Departamento']['jurisdiccion_id']))?$this->data['Departamento']['jurisdiccion_id']:$jurisdiccion;
		
		if ($jurisdiccion != 0):
		 	$this->paginate = array('limit' => 5000, 'page' => 1);
		 	 $this->set('departamentos', $this->paginate(null,array('jurisdiccion_id'=>$jurisdiccion)));
		else:
			$this->set('departamentos', $this->paginate());
		endif;
		$condiciones['jurisdiccion_id'] = $jurisdiccion;
		$this->set('url_conditions', $condiciones);
		$this->set('jurisdicciones',$this->Departamento->Jurisdiccion->find('list'));
		$this->render('/departamentos/index');
	}
		
	

	function view($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Departamento', true), array('action'=>'index'));
		}
		$this->set('departamento', $this->Departamento->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Departamento->create();
			if ($this->Departamento->save($this->data)) {
				$this->Session->setFlash(__('The Departamento has been saved', true));			
			}				 
		}
		$jurisdicciones = $this->Departamento->Jurisdiccion->find('list');
		$this->set(compact('jurisdicciones'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Departamento', true), array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Departamento->save($this->data)) {
				$this->flash(__('The Departamento has been saved.', true), array('action'=>'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Departamento->read(null, $id);
		}
		$jurisdicciones = $this->Departamento->Jurisdiccion->find('list');
		$this->set(compact('jurisdicciones'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Departamento', true), array('action'=>'index'));
		}
		if ($this->Departamento->del($id)) {
			$this->flash(__('Departamento deleted', true), array('action'=>'index'));
		}
	}
	
	function ajax_select_departamento_form_por_jurisdiccion(){
		$this->layout = 'ajax';
       Configure::write('debug',0);
         
         
         $jur_id = 0;
         if ($jur = current($this->data)):
         	if (isset($jur)):
         		$jur_id = $jur['jurisdiccion_id'];
         	endif;
         endif;

         $deptos = $this->Departamento->con_jurisdiccion('all',$jur_id);
              
         $this->set('todos', ($jur_id != 0 )?false:true);    
         
         $this->set('deptos', $deptos);                  	     
         
		 //prevent useless warnings for Ajax
	     $this->render('ajax_select_departamento_form_por_jurisdiccion','ajax');
	}
	
	function ajax_buscar_departamento(){
		$this->set('deptos',$this->Departamento->find('all'));
	}

        function search_departamentos($q = null){
            $this->autoRender = false;

            /*if ( $this->RequestHandler->isAjax() ) {
                Configure::write ( 'debug', 0 );
            }*/

            $response = '';

            if(empty($q)) {
                if (!empty($this->params['url']['q'])) {
                    $q = utf8_decode(strtolower($this->params['url']['q']));
                } else {
                    return utf8_encode("parámetro vacio");
                }
            }

            $items = $this->Departamento->find("all", array(
                            'contain'=> array("Localidad"),
                            'conditions'=> array("OR"=>array(
                                "to_ascii(lower(Localidad.name)) SIMILAR TO ?" => "%". $q ."%",
                                "to_ascii(lower(Departamento.name)) SIMILAR TO ?" => "%". $q ."%"
                                )
                            )
                        )
                    );

            $result = array();

            foreach ($items as $item) {

                array_push($result, array(
                        "id_localidad" => $item['Localidad']['id'],
                        "id_departamento" => $item['Departamento']['id'],
                        "id_jurisdiccion" => $item['Departamento']['Jurisdiccion']['id'],
                        "localidad" => utf8_encode($item['Localidad']['name']),
                        "departamento" => utf8_encode($item['Departamento']['name']),
                        "jurisdiccion" => utf8_encode($item['Departamento']['Jurisdiccion']['name'])
                ));
            }

            echo json_encode($result);
        }

}
?>