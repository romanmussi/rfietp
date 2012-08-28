<div class="modalidades view">
<h2><?php  __('Modalidad');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $modalidad['Modalidad']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nombre'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $modalidad['Modalidad']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Editar', true), array('action'=>'edit', $modalidad['Modalidad']['id'])); ?> </li>
		<li><?php echo $html->link(__('Borrar', true), array('action'=>'delete', $modalidad['Modalidad']['id']), null, sprintf(__('Borrar %s?', true), $modalidad['Modalidad']['name'])); ?> </li>
		<li><?php echo $html->link(__('Listar Modalidad', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('Nueva Modalidad', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
