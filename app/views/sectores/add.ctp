<div class="sectores form">
<?php echo $form->create('Sector');?>
	<fieldset>
 		<legend><?php __('Add Sector');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('orientacion_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div> 
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Sectores', true), array('action'=>'index'));?></li>
	</ul>
</div>
