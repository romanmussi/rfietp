<div class="cargos form">
<?php echo $form->create('Cargo');?>
	<fieldset>
 		<legend><?php __('Edit Cargo');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('nombre');
		echo $form->input('rango');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Cargo.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Cargo.id'))); ?></li>
		<li><?php echo $html->link(__('List Cargos', true), array('action' => 'index'));?></li>
	</ul>
</div>
