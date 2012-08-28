<?php

class CustomQuery extends AppModel{
	var $sql;
	var $limit = 20;
	var $useTable = false;
	
	function setSql($sql){
		$this->sql = $sql;
	}
	
	function setLimit($l=20) {
		$this->limit=$l;
	}

	/**
	 * Esta funcion sobreescribe a la del paginador. Como son 
	 * consultas guardadas en la tabla query, tengo que calcular 
	 * la cantidad de registros para que pagine bien.
	 * @param $conditions, $recursive
	 * @return cantidad de registro.
	 */
		
	function paginateCount($conditions, $recursive){

		$sql  = "SELECT COUNT(*) AS total FROM (" . $this->sql . ") AS CONSUL";
		
		if( $aux  = $this->query($sql) ){
			return $aux[0][0]['total'];
		}

		return false;
	}

	/**
	 * Esta funcion sobreescribe a la del paginador. Como son 
	 * consultas guardadas en la tabla query, tengo que  
	 * reescribir el limit y el offset para poder mostrar por pantalla
	 * @param $conditions, $recursive
	 * @return registros paginados.
	 */
		
	function paginate($conditions, $fields, $order, $limit, $page, $recursive){

		$sql  = $this->sql;
		$sql .= " LIMIT " . $this->limit . " ";
		$sql .= " OFFSET " . (($page - 1) * $this->limit);

		return $this->query($sql);
	}	
	
	
	//TODO deprecated
	function getData(){
		return $this->query();
	}
	
	
	function query($sql = null){
		if(!empty($sql)){
			return parent::query($sql);
		}
		else{
			return parent::query($this->sql);
		}
	}
	
}


?>
