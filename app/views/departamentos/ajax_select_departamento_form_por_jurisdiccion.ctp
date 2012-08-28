<?php //debug($deptos);?>
<option value="0">Seleccione</option>

<?
foreach($deptos as $d):
		$poner = $d['Departamento']['name'];
		if($todos){
			$poner .= ' ('.$d['Jurisdiccion']['name'].')';
		}
	?>
		<option value="<?= $d['Departamento']['id']?>"><?=$poner?></option>
	<?
endforeach;
	
?>