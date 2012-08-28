<option value="0">Seleccione</option>

<?
foreach($localidades as $d):	
		$depto = $d['Departamento']['name'];
		if(strlen($depto)>19){
				$depto = substr($depto,0,19);
				$depto .= '...';
		}
		
		$poner = $d['Localidad']['name']." (Depto: $depto)";
		
		// $todos es una variable boolean que me dice si se estan listando 
		// TODAS las localidades o solo las de un departamento en particular
		if($todos){
			$depto = $d['Departamento']['name'];
			$jur = $d['Jurisdiccion']['name'];
		
			if(strlen($depto)>19){
				$depto = substr($depto,0,19);
				$depto .= '...';
			}
			if(strlen($jur)>19){
				$jur = substr($jur,0,19);
				$jur .= "...";
			}
			$poner .= " (Depto: $depto, Jur: $jur)";
			
			if(strlen($poner)>66){
				$poner = substr($poner,0,66);
				$poner .= "...)";
				
			}
		}
	?>
		<option value="<?= $d['Localidad']['id']?>"><?=$poner?></option>
	<?
endforeach;
	
?>