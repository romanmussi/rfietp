<?php
class EstructuraPlanesController extends AppController {

	var $name = 'EstructuraPlanes';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->EstructuraPlan->recursive = 1;
		$this->set('estructuraPlanes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Estructura.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('estructuraPlan', $this->EstructuraPlan->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
                    $this->EstructuraPlan->create();

                    // etapas del EstructuraPlan
                    //$str = '[{"etapa_id":"6","edad_teorica":"11","nro_anio":"1","anio_escolaridad":""},{"etapa_id":"6","edad_teorica":"12","nro_anio":"2","anio_escolaridad":""},{"etapa_id":"6","edad_teorica":"13","nro_anio":"3","anio_escolaridad":""}]';
                    $aEtapas = json_decode($this->data['EstructuraPlan']['etapas'], true);

                    if ($this->EstructuraPlan->save($this->data)) {
                        // guarda el EstructuraPlan_id a cada etapa
                        if ($aEtapas) {
                             //debug($aEtapas);die;
                            foreach ($aEtapas as &$etapa) {
                                $etapa['alias'] = urldecode($etapa['alias']);
                                $etapa['estructura_plan_id'] = $this->EstructuraPlan->id;
                            }
                            //debug($aEtapas); exit;
                            $this->EstructuraPlan->EstructuraPlanesAnio->saveAll($aEtapas);
                        }
                        $this->Session->setFlash(__('Se ha creado un nuevo EstructuraPlan', true));
                        $this->redirect(array('action'=>'index'));
                    } else {
                        $this->Session->setFlash(__('No se ha podido crear la Estructura. Por favor, intente nuevamente.', true));
                    }
		}
                
                $etapas = $this->EstructuraPlan->Etapa->find('list', array('order'=>'name'));
		$this->set(compact('etapas'));
	}

	function edit($id = null) {
                //Configure::write('debug', 0);
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Estructura', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
                        // etapas del EstructuraPlan
                        //$str = '[{"etapa_id":"6","edad_teorica":"11","nro_anio":"1","anio_escolaridad":""},{"etapa_id":"6","edad_teorica":"12","nro_anio":"2","anio_escolaridad":""},{"etapa_id":"6","edad_teorica":"13","nro_anio":"3","anio_escolaridad":""}]';
                        $aEtapas = json_decode($this->data['EstructuraPlan']['etapas'], true);
                        
			if ($this->EstructuraPlan->save($this->data)) {
                            // elimina las etapas actuales
                            //$this->EstructuraPlan->EstructuraPlanesAnio->deleteAll(array('EstructuraPlanesAnio.estructura_plan_id' => $id));
                            // guarda el estructura_plan_id a cada etapa

                            // faltaria que borre las que se eliminaron en el form
                            if ($aEtapas) {
                                $i = 0;
                                foreach ($aEtapas as $etapa) {
                                    $etapas_aux[$i]['id'] = $etapa['id'];
                                    $etapas_aux[$i]['estructura_plan_id'] = $this->EstructuraPlan->id;
                                    $etapas_aux[$i]['edad_teorica'] = $etapa['edad_teorica'];
                                    $etapas_aux[$i]['nro_anio'] = $etapa['nro_anio'];
                                    $etapas_aux[$i]['alias'] = urldecode($etapa['alias']);
                                    $etapas_aux[$i]['anio_escolaridad'] = $etapa['anio_escolaridad'];
                                
                                    $i++;
                                }

                                $this->EstructuraPlan->EstructuraPlanesAnio->saveAll($etapas_aux);
                            }
                           
                            

                            $this->Session->setFlash(__('La Estructura ha sido guardada', true));
                            $this->redirect(array('action'=>'index'));
			} else {
                            $this->Session->setFlash(__('No se ha podido crear la Estructura. Por favor, intente nuevamente.', true));
			}
		}
		if (empty($this->data)) {
                        $this->data = $this->EstructuraPlan->read(null, $id);

                        // adjunta etapas en json
                        $i = 0;
                        if (count($this->data['EstructuraPlanesAnio'])) {
                            foreach ($this->data['EstructuraPlanesAnio'] as $etapa) {
                                $etapas_to_serialize[$i]['id'] = $etapa['id'];
                                $etapas_to_serialize[$i]['estructura_plan_id'] = $etapa['estructura_plan_id'];
                                $etapas_to_serialize[$i]['edad_teorica'] = $etapa['edad_teorica'];
                                $etapas_to_serialize[$i]['nro_anio'] = $etapa['nro_anio'];
                                $etapas_to_serialize[$i]['alias'] = urlencode($etapa['alias']);
                                $etapas_to_serialize[$i]['etapa_id'] = $this->data['EstructuraPlan']['etapa_id'];
                                $etapas_to_serialize[$i]['etapa_nombre'] = htmlentities($this->data['Etapa']['name']);
                                $etapas_to_serialize[$i]['anio_escolaridad'] = $etapa['anio_escolaridad'];

                                $i++;
                            }
                        
                            $etapas = @json_encode($etapas_to_serialize);
                            $this->data['EstructuraPlan']['etapas'] = $etapas;
                        }
		}

                $etapas = $this->EstructuraPlan->Etapa->find('list', array('order'=>'name'));

                $jurisdicciones = $this->EstructuraPlan->JurisdiccionesEstructuraPlan->find('all',
                                                                                            array('contain'=>array('Jurisdiccion'),
                                                                                                  'fields'=>array('Jurisdiccion.name'),
                                                                                                  'conditions'=>array('JurisdiccionesEstructuraPlan.estructura_plan_id'=>$id),
                                                                                                )
                                                                                           );


                $this->set('jurisdicciones',$jurisdicciones);
		$this->set(compact('etapas'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for EstructuraPlan', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EstructuraPlan->del($id)) {

                    // elimina las etapas actuales
                        $this->EstructuraPlan->EstructuraPlanesAnio->deleteAll(array('EstructuraPlanesAnio.estructura_plan_id' => $id));

			$this->Session->setFlash(__('Estructura de plan eliminada', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>