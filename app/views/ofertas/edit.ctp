<div class="ofertas form">
<?php echo $form->create('Oferta');?>
	<fieldset>
 		<legend><?php __('Edit Oferta');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('abrev');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Oferta.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Oferta.id'))); ?></li>
		<li><?php echo $html->link(__('List Ofertas', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Planes', true), array('controller'=> 'planes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Plan', true), array('controller'=> 'planes', 'action'=>'add')); ?> </li>
	</ul>
</div>
