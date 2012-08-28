<div class="fondosLineasDeAcciones view">
<h2><?php  __('FondosLineasDeAccion');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fondosLineasDeAccion['FondosLineasDeAccion']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Fondo Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fondosLineasDeAccion['FondosLineasDeAccion']['fondo_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lineas De Accion Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fondosLineasDeAccion['FondosLineasDeAccion']['lineas_de_accion_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Monto'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fondosLineasDeAccion['FondosLineasDeAccion']['monto']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fondosLineasDeAccion['FondosLineasDeAccion']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $fondosLineasDeAccion['FondosLineasDeAccion']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit FondosLineasDeAccion', true), array('action' => 'edit', $fondosLineasDeAccion['FondosLineasDeAccion']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete FondosLineasDeAccion', true), array('action' => 'delete', $fondosLineasDeAccion['FondosLineasDeAccion']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $fondosLineasDeAccion['FondosLineasDeAccion']['id'])); ?> </li>
		<li><?php echo $html->link(__('List FondosLineasDeAcciones', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New FondosLineasDeAccion', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
