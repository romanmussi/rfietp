<div class="dependencias form">
<?php echo $form->create('Dependencia');?>
	<fieldset>
 		<legend><?php __('Edit Dependencia');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Dependencia.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Dependencia.id'))); ?></li>
		<li><?php echo $html->link(__('List Dependencias', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Instits', true), array('controller'=> 'instits', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Instit', true), array('controller'=> 'instits', 'action'=>'add')); ?> </li>
	</ul>
</div>
