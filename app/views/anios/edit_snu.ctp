<?
if(isset($script)){
	echo $script;
}
?>
<? $ganchito = $this->data['Anio']['anio'] == 1?'er':'º';?>	
<h1 align="center"> <?= "Editar Datos SNU" ?></h1>
<div class="anios form">
<?php echo $form->create('Anio', array('action'=>'save'));?>
	<fieldset>	
	<?php
		echo $form->input('id');
		echo $form->input('plan_id',array('type'=>'hidden'));
		
		$anios = array('1'=>1,'2'=>2,'3'=>3,'4'=>4);
		echo $form->input('anio',array( 'options'=>$anios ,'label'=>'Año'));
		echo $form->input('etapa_id',array('type'=>'hidden'));
		echo $form->input('ciclo_id');
		
		echo $form->input('matricula',array('label'=>'Matrícula'));
		echo $form->input('secciones');
		echo $form->input('hs_taller',array('label'=>'Horas Taller'));
	?>
	</fieldset>
<?php echo $form->end('Guardar');?>
</div>
