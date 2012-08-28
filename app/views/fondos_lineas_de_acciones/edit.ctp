<div class="fondosLineasDeAcciones form">
<?php echo $form->create('FondosLineasDeAccion');?>
	<fieldset>
 		<legend><?php __('Edit FondosLineasDeAccion');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('fondo_id');
		echo $form->input('lineas_de_accion_id');
		echo $form->input('monto');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('FondosLineasDeAccion.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('FondosLineasDeAccion.id'))); ?></li>
		<li><?php echo $html->link(__('List FondosLineasDeAcciones', true), array('action' => 'index'));?></li>
	</ul>
</div>
