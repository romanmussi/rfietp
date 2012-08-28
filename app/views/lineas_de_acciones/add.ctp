<div class="lineasDeAcciones form">
<?php echo $form->create('LineasDeAccion');?>
	<fieldset>
 		<legend><?php __('Add LineasDeAccion');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List LineasDeAcciones', true), array('action' => 'index'));?></li>
	</ul>
</div>
