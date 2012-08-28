<div class="estructuraPlanesAnios form">
<?php echo $form->create('EstructuraPlanesAnio');?>
	<fieldset>
 		<legend><?php __('Editar Año de Estructura');?></legend>
                <b><?=$this->data['EstructuraPlan']['name']?></b>
	<?php
		echo $form->input('id');
		echo $form->input('estructura_plan_id', array('type'=>'hidden'));
		echo $form->input('edad_teorica');
		echo $form->input('nro_anio');
		echo $form->input('anio_escolaridad');
                echo $form->input('alias');
	?>
	</fieldset>
<?php echo $form->end('Guardar');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Volver al listado de Estructuras', true), array('controller'=>'EstructuraPlanes', 'action'=>'index'));?></li>
	</ul>
</div>
