<?php
App::import('Model','Pquery.CustomQUery');

class QueriesController extends PqueryAppController {

	var $name = 'Queries';
	var $helpers = array('Time');
        
        function beforeFilter() {
            parent::beforeFilter();
            $this->RequestHandler->setContent('xls', 'application/vnd.ms-excel');
        }

	function index() {
		$this->Query->recursive = 0;
		$this->set('queries', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Query.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('query', $this->Query->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
                        if($this->validate($this->data['Query']['query'])){
                            $this->data['Query']['columns'] = implode(",",$this->get_columnas($this->data['Query']['query']));
                            $this->Query->create();
                            if ($this->Query->save($this->data)) {
                                    $this->Session->setFlash(__('The Query has been saved', true));
                                    $this->redirect(array('action'=>'index'));
                            } else {
                                    $this->Session->setFlash(__('The Query could not be saved. Please, try again.', true));
                            }
                        }
                        else{
                            $this->Session->setFlash(__('La consulta SQL tiene errores', true));
                        }
		}
                $this->set('pquery_categories',$this->Query->PqueryCategory->find('list'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Query', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
                        if($this->validate($this->data['Query']['query'])){
                            $this->data['Query']['columns'] = implode(", ",$this->get_columnas($this->data['Query']['query']));
                            if ($this->Query->save($this->data)) {
                                    $this->Session->setFlash(__('The Query has been saved', true));
                                    $this->redirect(array('action'=>'index'));
                            } else {
                                    $this->Session->setFlash(__('The Query could not be saved. Please, try again.', true));
                            }
                        } else {
                                $this->Session->setFlash(__('La consulta SQL tiene errores', true));
                        }
		}
		if (empty($this->data)) {
			$this->data = $this->Query->read(null, $id);
		}
                $this->set('pquery_categories',$this->Query->PqueryCategory->find('list'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Query', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Query->del($id)) {
			$this->Session->setFlash(__('Query deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

        
	function descargar_queries() {
            $categorias = $this->Query->PqueryCategory->find('list');
            $this->set('categorias',$categorias);

            $queries = array();
            foreach ($categorias as $k=>$c) {
                $queries[$c]  = $this->Query->find('all',array(
                    'order' => 'Query.id,Query.modified DESC',
                    'conditions' => array(
                        'OR' => array (
                            'Query.expiration_time >' => 'NOW()',
                            'Query.expiration_time IS NULL',
                        ),
                        'Query.pquery_category_id' => $k,
                    )
                    ));    
            }
                    
            $this->set('queries',$queries);
	}
        
	
	/**
	 * esto me construye un excel en la vista con el id de la query
	 * @param $id
	 */
	function contruye_excel($id){
                
		$res = $this->Query->findById($id);
		$sql = $res['Query']['query'];
		$this->Query->recursive = -1;
		$consulta_ejecutada = $this->Query->query($sql);

		$precols = array_keys($consulta_ejecutada[0]);

                $quitar_columnas = $consulta_ejecutada[0][0];
		while(list($key,$value) = each($quitar_columnas)):
			$columnas[] = $key;
		endwhile;

		$this->set('name',limpiar_nombre($res['Query']['filename']));
		$this->set('columnas',$columnas);
		$this->set('filas',$consulta_ejecutada);
	}

        function validate($query){

                Configure::write('debug',0);
                
		$sql = $query . ' LIMIT 1';
		$this->Query->recursive = -1;
		$consulta_ejecutada = $this->Query->query($sql);

                Configure::write('debug',2);

                return !empty($consulta_ejecutada);

	}

        function get_columnas($query){

		$sql = $query . ' LIMIT 1';
		$this->Query->recursive = -1;
		$consulta_ejecutada = $this->Query->query($sql);

		$precols = array_keys($consulta_ejecutada[0]);

                $quitar_columnas = $consulta_ejecutada[0][0];
		while(list($key,$value) = each($quitar_columnas)):
			$columnas[] = $key;
		endwhile;

		return $columnas;
	}
	

    function list_view($id="") {
        $this->layout = "sin_menu";
        $this->CustomQuery =& ClassRegistry::init('Pquery.CustomQuery');

        if (isset($this->passedArgs['query.id'])) {
            $id = $this->passedArgs['query.id'];
        }

        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Query', true));
            $this->redirect(array('action'=>'index'));
        }

        $this->rutaUrl_for_layout[] =array('name'=> 'Queries','link'=>'/Instits/add' );
        $res = $this->Query->findById($id);

        $this->CustomQuery->setSql($res['Query']['query']);

        
        if (!empty($this->passedArgs['viewAll'])) {
            if ($this->passedArgs['viewAll'] == 'true') {
                $data = $this->CustomQuery->query();
                $viewAll = false;
            }
        }
        else if (!empty($this->passedArgs['preview'])) {
            if ($this->passedArgs['preview']) {
                $this->layout = null;
                $this->CustomQuery->setSql($res['Query']['query']. " LIMIT 5");
                $data = $this->CustomQuery->query();
                $viewAll = true;
            }
        } else {
            $data = $this->paginate($this->CustomQuery);
            $viewAll = true;
        }

        $precols = array_keys($data[0]);
        //$cols = array_keys($data['0']['0']);
        $this->set('cols', $precols);
        $url_conditions['query.id'] = $id;
        $this->set('queries', $data);
        $this->set('url_conditions', $url_conditions);
        $this->set('name', $res['Query']['name']);
        $this->set('descripcion', $res['Query']['description']);
        $this->set('viewAll', $viewAll);
        $this->set('preview', !empty($this->passedArgs['preview']));


        if ($this->RequestHandler->ext == 'xls') {
            $this->layout = 'xls';
            $this->render('xls/'.$this->action);
        }
    }
    
    function edit_description($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Query', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Query->save($this->data)) {
                    $this->Session->setFlash(__('La descripción ha sido modificada', true));
            } else {
                $this->Session->setFlash(__('No se pudo guardar la descripción. Por favor, reintente', true));
            }
            $this->redirect(array('action'=>'descargar_queries'));
        }
        if (empty($this->data)) {
            $this->data = $this->Query->read(null, $id);
        }
    }
}
?>