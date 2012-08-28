<div class="fondos form">
<?php echo $form->create('Fondo',array('action'=>"add_institucion/$instit_id"));?>
	<fieldset>
 		<legend><?php __('Add Fondo');?></legend>
	<?php
		echo $form->input('instit_id',array('value'=>$instit_id,'type'=>'hidden'));
		
		echo $form->input('lineas_de_accion_id');
		echo $form->input('valor_asignado');
		echo $form->input('fecha_aprobacion',array('dateFormat'=>'DMY'));
		echo $form->input('memo');
		echo $form->input('resolucion');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Fondos', true), array('action'=>'index'));?></li>
	</ul>
</div>
