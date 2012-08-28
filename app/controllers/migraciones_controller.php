<?php

class MigracionesController extends AppController {

	var $name = 'Migraciones';
	var $helpers = array('Html', 'Form');
	var $uses = array('Instit', 'TemporalFondo');
	
	
	
	function actualizador(){
		App::import('Vendor','StringMatch',false,null,'stringmatch.php');
		
		$this->Instit->recursive = 1;
		$this->Instit->unBindModel(array('hasMany' =>'Plan'));
		$instituciones = $this->Instit->find('all',array('limit'=>200,'offset'=> 3000));
	debug($instituciones);
		//	$instituciones = array();
		
		foreach ($instituciones as $i):
			$this->TemporalFondo->recursive = -1;
			
			//"700068000"
			// $i['Instit']['cue']*100+$i['Instit']['anexo']
			//$excel = $this->TemporalFondo->findByCue(($i['Instit']['cue']*100)+$i['Instit']['anexo']);
			$excel = $this->TemporalFondo->find('all',
												array('conditions'=>array('cue'=>($i['Instit']['cue']*100)+$i['Instit']['anexo'])));
			
			if(sizeof($excel)>0){
						
				foreach ($excel as $e):
					$pos = sizeof($this->data);
					$this->data[$pos]['TemporalFondo']['id'] = $e['TemporalFondo']['id'];
				
					$string1 = strtolower(" ".$i['Instit']['nombre']);								
					$string2 = strtolower($e['TemporalFondo']['nombre']);
					
					$length1 = strlen($string1);
					$length2 = strlen($string2);
					$limit = 0.4;
					$comparison = new StringMatch;
					$resultado = $comparison->fstrcmp ($string1, $length1, $string2, $length2, $limit);
			
					
					$e['TemporalFondo']['similitud'] = $resultado;
					$this->TemporalFondo->id = $e['TemporalFondo']['id'];
					if ($this->TemporalFondo->save($e))
						debug("guardo tdoo joya");
					else pr("TODO MAL no guardo");
						
				endforeach;
			}
						
			
		endforeach;
		echo "alaslsakslkals";
		exit();
	}
	
	
	function test(){
		App::import('Vendor','StringMatch',false,null,'stringmatch.php');
		
		$string1 = strtolower("alejandro");								
		$string2 = strtolower("jose");
					
		$length1 = strlen($string1);
		$length2 = strlen($string2);
		$limit = 0.4;
		$comparison = new StringMatch;
		$resultado = $comparison->fstrcmp ($string1, $length1, $string2, $length2, $limit);
				
	}
	
	
}
	
	

?>