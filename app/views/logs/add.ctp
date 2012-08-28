<div class="logs form">
<?php echo $form->create('Log');?>
	<fieldset>
 		<legend><?php __('Add Log');?></legend>
	<?php
		echo $form->input('username');
		echo $form->input('fecha_in');
		echo $form->input('hora_in');
		echo $form->input('fecha_out');
		echo $form->input('hora_out');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Logs', true), array('action'=>'index'));?></li>
	</ul>
</div>
