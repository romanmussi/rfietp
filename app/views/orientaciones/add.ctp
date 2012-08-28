<div class="orientaciones form">
<?php echo $form->create('Orientacion');?>
	<fieldset>
 		<legend><?php __('Agregar Orientación');?></legend>
	<?php
		echo $form->input('name', array('label'=>'Nombre'));
	?>
	</fieldset>
<?php echo $form->end('Guardar');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Orientaciones', true), array('action'=>'index'));?></li>
	</ul>
</div>
