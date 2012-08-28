<div class="departamentos view">
<h2><?php  __('Departamento');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $departamento['Departamento']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Jurisdiccion Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $departamento['Departamento']['jurisdiccion_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $departamento['Departamento']['name']; ?>
			&nbsp;
		</dd>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $departamento['Departamento']['created']; ?>
			&nbsp;
		</dd>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $departamento['Departamento']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Departamento', true), array('action'=>'edit', $departamento['Departamento']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Departamento', true), array('action'=>'delete', $departamento['Departamento']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $departamento['Departamento']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Departamentos', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Departamento', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
