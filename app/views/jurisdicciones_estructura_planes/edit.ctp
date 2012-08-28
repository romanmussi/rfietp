<div class="jurisdiccionesTrayectos form">
<?php echo $form->create('JurisdiccionesTrayecto');?>
	<fieldset>
 		<legend><?php __('Edit JurisdiccionesTrayecto');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('jurisdiccion_id');
		echo $form->input('trayecto_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('JurisdiccionesTrayecto.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('JurisdiccionesTrayecto.id'))); ?></li>
		<li><?php echo $html->link(__('List JurisdiccionesTrayectos', true), array('action'=>'index'));?></li>
	</ul>
</div>
