<div class="lineasDeAcciones form">
<?php echo $form->create('LineasDeAccion');?>
	<fieldset>
 		<legend><?php __('Edit LineasDeAccion');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('LineasDeAccion.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('LineasDeAccion.id'))); ?></li>
		<li><?php echo $html->link(__('List LineasDeAcciones', true), array('action' => 'index'));?></li>
	</ul>
</div>
