<div class="referentes form">
<?php echo $form->create('Referente');?>
	<fieldset>
 		<legend><?php __('Add Referente');?></legend>
	<?php
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
		<li><?php echo $html->link(__('List Referentes', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Tipodocs', true), array('controller'=> 'tipodocs', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tipodoc', true), array('controller'=> 'tipodocs', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Jurisdicciones', true), array('controller'=> 'jurisdicciones', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Jurisdiccion', true), array('controller'=> 'jurisdicciones', 'action'=>'add')); ?> </li>
	</ul>
</div>
