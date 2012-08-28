<?php

App::import('Controller', 'Tipoinstits');
class TestTipoinstits extends TipoinstitsController {

	var $cacheSources = false;
}


class CompleteWebTestCase extends CakeWebTestCase{
	var $baseurl;
	
	function CompleteWebTestCase(){
  		   $this->baseurl = current(split("webroot", $_SERVER['PHP_SELF']));
	}
	
	
	function TestAjaxSelectFormPorJurisdiccionDebeFallar(){
		$data = array('Instit'=>array('jurisdiccion_id' => 6));
		$this->post("http://localhost/regetp/tipoinstits/ajax_select_form_por_jurisdiccionssss", $data);
		
		//$this->assertResponse(200);
		$this->assertText('Error','este deberia fallar');
	}
	
	
	function TestAjaxSelectFormPorJurisdiccion(){
		$data = array('Instit'=>array('jurisdiccion_id' => 6));
		$this->post("http://localhost/regetp/tipoinstits/ajax_select_form_por_jurisdiccion", $data);
		
		$this->assertResponse(200);
		$this->assertNoText('Error');
	}
	
	
}

?>