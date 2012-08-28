<div class="orientaciones view">
<h2><?php  __('Orientación');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orientacion['Orientacion']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nombre'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $orientacion['Orientacion']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Editar', true), array('action'=>'edit', $orientacion['Orientacion']['id'])); ?> </li>
		<li><?php echo $html->link(__('Borrar', true), array('action'=>'delete', $orientacion['Orientacion']['id']), null, sprintf(__('Borrar %s?', true), $orientacion['Orientacion']['name'])); ?> </li>
		<li><?php echo $html->link(__('Listar Orientación', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('Nueva Orientación', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
