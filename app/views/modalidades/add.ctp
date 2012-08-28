<div class="modalidades form">
<?php echo $form->create('Modalidad');?>
	<fieldset>
 		<legend><?php __('Agregar Modalidad');?></legend>
	<?php
		echo $form->input('name', array('label'=>'Nombre'));
	?>
	</fieldset>
<?php echo $form->end('Guardar');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Modalidades', true), array('action'=>'index'));?></li>
	</ul>
</div>
