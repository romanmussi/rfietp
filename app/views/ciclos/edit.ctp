<div class="ciclos form">
<?php echo $form->create('Ciclo');?>
	<fieldset>
 		<legend><?php __('Edit Ciclo');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Ciclo.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Ciclo.id'))); ?></li>
		<li><?php echo $html->link(__('List Ciclos', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Anios', true), array('controller'=> 'anios', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Anio', true), array('controller'=> 'anios', 'action'=>'add')); ?> </li>
	</ul>
</div>
