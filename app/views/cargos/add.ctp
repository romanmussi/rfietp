<div class="cargos form">
<?php echo $form->create('Cargo');?>
	<fieldset>
 		<legend><?php __('Add Cargo');?></legend>
	<?php
		echo $form->input('nombre');
		echo $form->input('rango');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Cargos', true), array('action' => 'index'));?></li>
	</ul>
</div>
