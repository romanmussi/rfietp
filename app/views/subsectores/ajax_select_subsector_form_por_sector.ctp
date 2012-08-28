<?php //debug($deptos);?>
<option value="">Todos</option>
<option value="0">Sin subsector</option>

<?
foreach($subsectores as $d):
		$poner = $d['Subsector']['name'];
		if($todos){
			$poner .= ' ('.$d['Sector']['name'].')';
		}
	?>
		<option value="<?= $d['Subsector']['id']?>"><?=$poner?></option>
	<?
endforeach;
	
?>