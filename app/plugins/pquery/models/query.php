<?php
class Query extends PqueryAppModel {

	var $validate = array(
		'name' => array('notempty'),
		'query' => array('notempty'),
	);

        var $belongsTo = array('PqueryCategory');
	
	
	function beforeSave(){
		parent::beforeSave();
		
		//----------------------------------------------------
		// Con esto hago que si se puso un punto y coma en la consulta, lo elimine.
		// Por convencion estamos guardando las queries sin punto y coma.
		if(!empty($this->data['Query']['query'])){
			$query = trim($this->data['Query']['query']);
			
			$ult_char = substr($query,strlen($query),1);
			if($ult_char == ';'){
				$this->data['Query']['query'] = substr($query,0,strlen($query)-1);
			}
		}
		return true;
	}
}
?>