<?

if(isset($script)){
	echo $script;
}

$ganchito = $this->data['Anio']['anio'] == 1?'er':'º';?>
<h1 align="center"> <?= "Agregar Datos" ?></h1>
<div class="anios form">
<?php echo $form->create('Anio', array('action'=>'save'));?>
	<fieldset>
	<?php

		echo $form->input('plan_id',array('type'=>'hidden','value'=>$plan_id));

		$anios = array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>9);
		echo $form->input('anio',array( 'options'=>$anios ,'label'=>'Año'));
		echo $form->input('etapa_id', array('default'=>ETAPA_POLIMODAL));
		//echo $form->input('ciclo_id',array('selected'=> date('Y')));
                echo $form->input('ciclo_id',array('selected'=> max(array_keys($ciclos))));



		echo $form->input('matricula',array('label'=>'Matrícula'));
		echo $form->input('secciones');
		echo $form->input('hs_taller',array('label'=>'Horas Taller'));
	?>
	</fieldset>
<?php echo $form->end('Guardar');?>
</div>