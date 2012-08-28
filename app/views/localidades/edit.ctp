<div class="localidades form">
<?php echo $form->create('Localidad');?>
	<fieldset>
 		<legend><?php echo 'Editar Localidad de: '.$this->data['Departamento']['Jurisdiccion']['name'];?></legend>
	<?php
		
	
		echo $form->input('id');
		
		
	
		// DEPARTAMENTO
		echo $form->input('departamento_id');
        
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Localidad.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Localidad.id'))); ?></li>
		<li><?php echo $html->link(__('List Localidades', true), array('action'=>'index'));?></li>
	</ul>
</div>
