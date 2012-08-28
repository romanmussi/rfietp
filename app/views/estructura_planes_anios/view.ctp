<?

debug($trayectoAnio);

?>
<div class="trayectoAnios view">
<h2><?php  __('TrayectoAnio');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trayectoAnio['TrayectoAnio']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Trayecto Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trayectoAnio['TrayectoAnio']['trayecto_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Edad Teorica'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trayectoAnio['TrayectoAnio']['edad_teorica']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Anio'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trayectoAnio['TrayectoAnio']['anio']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Etapa Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trayectoAnio['TrayectoAnio']['etapa_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Anio Escolaridad'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trayectoAnio['TrayectoAnio']['anio_escolaridad']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trayectoAnio['TrayectoAnio']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trayectoAnio['TrayectoAnio']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit TrayectoAnio', true), array('action'=>'edit', $trayectoAnio['TrayectoAnio']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete TrayectoAnio', true), array('action'=>'delete', $trayectoAnio['TrayectoAnio']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $trayectoAnio['TrayectoAnio']['id'])); ?> </li>
		<li><?php echo $html->link(__('List TrayectoAnios', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New TrayectoAnio', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
