<div class="ofertas form">
<?php echo $form->create('Oferta');?>
	<fieldset>
 		<legend><?php __('Add Oferta');?></legend>
	<?php
		echo $form->input('abrev');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Ofertas', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Planes', true), array('controller'=> 'planes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Plan', true), array('controller'=> 'planes', 'action'=>'add')); ?> </li>
	</ul>
</div>
