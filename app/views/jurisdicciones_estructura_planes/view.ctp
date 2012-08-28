<div class="jurisdiccionesTrayectos view">
<h2><?php  __('JurisdiccionesTrayecto');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $jurisdiccionesTrayecto['JurisdiccionesTrayecto']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Jurisdiccion Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $jurisdiccionesTrayecto['JurisdiccionesTrayecto']['jurisdiccion_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Trayecto Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $jurisdiccionesTrayecto['JurisdiccionesTrayecto']['trayecto_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $jurisdiccionesTrayecto['JurisdiccionesTrayecto']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $jurisdiccionesTrayecto['JurisdiccionesTrayecto']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit JurisdiccionesTrayecto', true), array('action'=>'edit', $jurisdiccionesTrayecto['JurisdiccionesTrayecto']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete JurisdiccionesTrayecto', true), array('action'=>'delete', $jurisdiccionesTrayecto['JurisdiccionesTrayecto']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $jurisdiccionesTrayecto['JurisdiccionesTrayecto']['id'])); ?> </li>
		<li><?php echo $html->link(__('List JurisdiccionesTrayectos', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New JurisdiccionesTrayecto', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
