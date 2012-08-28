<div class="gestiones form">
<?php echo $form->create('Gestion');?>
	<fieldset>
 		<legend><?php __('Edit Gestion');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Gestion.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Gestion.id'))); ?></li>
		<li><?php echo $html->link(__('List Gestiones', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Instits', true), array('controller'=> 'instits', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Instit', true), array('controller'=> 'instits', 'action'=>'add')); ?> </li>
	</ul>
</div>
