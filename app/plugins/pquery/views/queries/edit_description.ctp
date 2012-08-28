</script>
<?php echo $form->create('Query', array('action'=>'edit_description'));?>
	<fieldset>
	<?php
		echo $form->input('id');
		echo $form->input('description', array("label"=>"Descripción"));
	?>
	</fieldset>
<?php echo $form->end('Editar');?>
</div>
