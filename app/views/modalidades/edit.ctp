<div class="modalidades form">
<?php echo $form->create('Modalidad');?>
	<fieldset>
 		<legend><?php __('Editar Modalidad');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name', array('label'=>'Nombre'));
	?>
	</fieldset>
<?php echo $form->end('Guardar');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Borrar', true), array('action'=>'delete', $form->value('Modalidad.id')), null, sprintf(__('Borrar %s?', true), $form->value('Modalidad.name'))); ?></li>
		<li><?php echo $html->link(__('Listar Modalidades', true), array('action'=>'index'));?></li>
	</ul>
</div>