
<option value="0">Todas</option>
<?
/**
* ajax_select_form_por_jurisdiccion.ctp
*
*	devuelve las opciones para actualizar el select
*@var $tipoinstit = array();
**/


foreach ($tipoinstits as $inst){
	?> 
		<option value="<?= $inst['Tipoinstit']['id']?>"><?=$inst['Tipoinstit']['name']?></option>
	<?
}
	
?>