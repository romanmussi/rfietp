<h1>Cambiar su password</h1>
<div class="users form">
<?php echo $form->create('User',array('action' => 'password_reset'));?>
	<fieldset>
	<?php
		echo $form->input('password',array('label'=>'Ingrese una nueva contrase�a', 'value'=>''));
	
		echo $form->input('password_check',array('label'=>'Reingrese su contrase�a','type'=>'password'));

	?>
	</fieldset>
<?php echo $form->end('Guardar');?>
</div>
