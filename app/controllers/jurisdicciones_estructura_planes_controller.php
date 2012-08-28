<?php
class JurisdiccionesEstructuraPlanesController extends AppController {

	var $name = 'JurisdiccionesEstructuraPlanes';
	var $helpers = array('Html', 'Form');

	function index($id = null) {
          
                $notIn = array();
                $trayectos_asignados = array();
                $trayectos_restantes = array();

                if (!empty($this->data['JurisdiccionesEstructuraPlan'])) {
                    $this->JurisdiccionesEstructuraPlan->deleteAll(array('JurisdiccionesEstructuraPlan.jurisdiccion_id ='. $this->data['jurisdiccion_id']));
                    if(!empty($this->data['JurisdiccionesEstructuraPlan'])){
                        foreach($this->data['JurisdiccionesEstructuraPlan'] as $estructura){
                            if($estructura['asignado'] == 1){
                                $this->JurisdiccionesEstructuraPlan->create();
                                $estructuraJur = array("JurisdiccionesEstructuraPlan"=>array("jurisdiccion_id"=>$this->data['jurisdiccion_id'], "estructura_plan_id"=>$estructura['estructura_plan_id']));
                                $this->JurisdiccionesEstructuraPlan->save($estructuraJur);
                            }

                        }
                     
                    }
                    $this->redirect(array('action' => 'index',$this->data['jurisdiccion_id']));
                }

                $this->JurisdiccionesEstructuraPlan->Jurisdiccion->recursive = 0;
                $this->set('jurisdiccion', $this->JurisdiccionesEstructuraPlan->Jurisdiccion->read(null, $id));

		$this->JurisdiccionesEstructuraPlan->recursive = 0;

                $trayectos_asignados = $this->JurisdiccionesEstructuraPlan->find('all', array(
                                                                            'contain'=> array(
                                                                                'EstructuraPlan'=>array('order'=>array('EstructuraPlan.etapa_id'),'Etapa','EstructuraPlanesAnio'=>array('order'=> array('EstructuraPlanesAnio.edad_teorica')))
                                                                            ),
                                                                            'conditions'=> array(
                                                                                array('JurisdiccionesEstructuraPlan.jurisdiccion_id' => $id)
                                                                            )
                                                                        ));
                if(!empty($trayectos_asignados)){

                    foreach($trayectos_asignados as $trayecto){
                        array_push($notIn, $trayecto['EstructuraPlan']['id']);
                    }

                    $trayectos_restantes = $this->JurisdiccionesEstructuraPlan->EstructuraPlan->find('all', array(
                                                                                            'contain'=> array('Etapa',
                                                                                                              'EstructuraPlanesAnio'=>array(
                                                                                                                    'order'=> array('EstructuraPlanesAnio.edad_teorica')
                                                                                                              )),
                                                                                            'conditions'=> array('NOT'=>array("EstructuraPlan.id" => $notIn)),
                                                                                            'order'=>array('etapa_id')
                                                                                        )
                                                                                );

                }
                else{
                    $trayectos_restantes = $this->JurisdiccionesEstructuraPlan->EstructuraPlan->find('all', array(
                                                                                            'contain'=> array('Etapa',
                                                                                                              'EstructuraPlanesAnio'=>array('order'=> array('EstructuraPlanesAnio.edad_teorica'))
                                                                                            ),
                                                                                            'order'=>array('etapa_id')
                                                                                    ));

                }
                
                $this->set('trayectos_asignados', $trayectos_asignados);
                $this->set('trayectos_restantes', $trayectos_restantes);
                $this->set('jurisdiccion_id', $id);

           
	}

}
?>