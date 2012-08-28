<div class="sugerencias form">
<?php echo $form->create('Sugerencia');?>
	<fieldset>
 		<legend><?php __('Edit Sugerencia');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('asunto');
		echo $form->input('mensaje');
		echo $form->input('user_id');
		echo $form->input('email');
		echo $form->input('IP');
		echo $form->input('leido');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Sugerencia.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Sugerencia.id'))); ?></li>
		<li><?php echo $html->link(__('List Sugerencias', true), array('action' => 'index'));?></li>
	</ul>
</div>
