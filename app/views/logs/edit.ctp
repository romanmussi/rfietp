<div class="logs form">
<?php echo $form->create('Log');?>
	<fieldset>
 		<legend><?php __('Edit Log');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('username');
		echo $form->input('fecha_in');
		echo $form->input('hora_in');
		echo $form->input('fecha_out');
		echo $form->input('hora_out');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Log.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Log.id'))); ?></li>
		<li><?php echo $html->link(__('List Logs', true), array('action'=>'index'));?></li>
	</ul>
</div>
