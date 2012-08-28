<div class="referentes form">
<?php echo $form->create('Referente');?>
	<fieldset>
 		<legend><?php __('Edit Referente');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('tipodoc_id');
		echo $form->input('nrodoc');
		echo $form->input('telefono');
		echo $form->input('mail');
		echo $form->input('jurisdiccion_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Referente.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Referente.id'))); ?></li>
		<li><?php echo $html->link(__('List Referentes', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Tipodocs', true), array('controller'=> 'tipodocs', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tipodoc', true), array('controller'=> 'tipodocs', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Jurisdicciones', true), array('controller'=> 'jurisdicciones', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Jurisdiccion', true), array('controller'=> 'jurisdicciones', 'action'=>'add')); ?> </li>
	</ul>
</div>
