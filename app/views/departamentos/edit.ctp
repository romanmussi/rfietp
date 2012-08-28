<div class="departamentos form">
<?php echo $form->create('Departamento');?>
	<fieldset>
 		<legend><?php __('Edit Departamento');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('jurisdiccion_id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Departamento.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Departamento.id'))); ?></li>
		<li><?php echo $html->link(__('List Departamentos', true), array('action'=>'index'));?></li>
	</ul>
</div>
