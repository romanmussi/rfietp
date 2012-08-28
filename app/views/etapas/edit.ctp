<div class="etapas form">
<?php echo $form->create('Etapa');?>
	<fieldset>
 		<legend><?php __('Edit Etapa');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
                echo $form->input('abrev');
                echo $form->input('orden');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Etapa.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Etapa.id'))); ?></li>
		<li><?php echo $html->link(__('List Etapas', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Anios', true), array('controller'=> 'anios', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Anio', true), array('controller'=> 'anios', 'action'=>'add')); ?> </li>
	</ul>
</div>
