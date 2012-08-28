<div class="cargos view">
<h2><?php  __('Cargo');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cargo['Cargo']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nombre'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cargo['Cargo']['nombre']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Rango'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cargo['Cargo']['rango']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Cargo', true), array('action' => 'edit', $cargo['Cargo']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Cargo', true), array('action' => 'delete', $cargo['Cargo']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cargo['Cargo']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Cargos', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Cargo', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
