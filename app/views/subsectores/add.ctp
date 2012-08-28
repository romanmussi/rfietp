<div class="subsectores form">
<?php echo $form->create('Subsector');?>
	<fieldset>
 		<legend><?php __('Add Subsector');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('sector_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Subsectores', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Sectores', true), array('controller'=> 'sectores', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Sector', true), array('controller'=> 'sectores', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Planes', true), array('controller'=> 'planes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Plan', true), array('controller'=> 'planes', 'action'=>'add')); ?> </li>
	</ul>
</div>
