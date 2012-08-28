<div class="jurisdiccionesTrayectos form">
<?php echo $form->create('JurisdiccionesTrayecto');?>
	<fieldset>
 		<legend><?php __('Add JurisdiccionesTrayecto');?></legend>
	<?php
		echo $form->input('jurisdiccion_id');
		echo $form->input('trayecto_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List JurisdiccionesTrayectos', true), array('action'=>'index'));?></li>
	</ul>
</div>
