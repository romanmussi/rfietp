<?
if(isset($script)){
	echo $script;
}
?>

<? //$ganchito = $this->data['Anio']['anio'] == 1?'er':'º';?>	
<h1 align="center"> <?= "Agregar Datos" ?></h1>
<div class="anios form">
<?php echo $form->create('Ticket');?>
	<fieldset>	
	<?php
		echo $form->input('instit_id',array('type'=>'hidden','value'=>$instit_id));
		echo $form->input('observacion', array('label'=>'Observación'));
	?>
	</fieldset>
<?php echo $form->end('Guardar');?>
</div>