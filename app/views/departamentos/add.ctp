<div class="departamentos form">
<?php echo $form->create('Departamento');?>
	<fieldset>
 		<legend><?php __('Add Departamento');?></legend>
	<?php
		echo $form->input('jurisdiccion_id');
		echo $form->input('name',array('value'=>""));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Departamentos', true), array('action'=>'index'));?></li>
	</ul>
</div>
