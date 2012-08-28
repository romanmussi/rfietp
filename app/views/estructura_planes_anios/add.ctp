<div class="estructuraPlanesAnios form">
<?php echo $form->create('EstructuraPlanesAnio');?>
	<fieldset>
 		<legend><?php __('Add EstructuraPlanesAnio');?></legend>
	<?php
		echo $form->input('estructura_planes_anio_id');
		echo $form->input('edad_teorica');
		echo $form->input('anio');
		echo $form->input('anio_escolaridad');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List estructuraPlanesAnios', true), array('action'=>'index'));?></li>
	</ul>
</div>
