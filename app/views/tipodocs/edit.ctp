<div class="tipodocs form">
<?php echo $form->create('Tipodoc');?>
	<fieldset>
 		<legend><?php __('Edit Tipodoc');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('abrev');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Tipodoc.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Tipodoc.id'))); ?></li>
		<li><?php echo $html->link(__('List Tipodocs', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Referentes', true), array('controller'=> 'referentes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Referente', true), array('controller'=> 'referentes', 'action'=>'add')); ?> </li>
	</ul>
</div>
