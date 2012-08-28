<div class="localidades view">
<h2><?php  __('Localidad');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $localidad['Localidad']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Departamento Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $localidad['Localidad']['departamento_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $localidad['Localidad']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Localidad', true), array('action'=>'edit', $localidad['Localidad']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Localidad', true), array('action'=>'delete', $localidad['Localidad']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $localidad['Localidad']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Localidades', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Localidad', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
