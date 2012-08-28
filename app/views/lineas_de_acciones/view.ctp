<div class="lineasDeAcciones view">
<h2><?php  __('LineasDeAccion');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $lineasDeAccion['LineasDeAccion']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $lineasDeAccion['LineasDeAccion']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $lineasDeAccion['LineasDeAccion']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $lineasDeAccion['LineasDeAccion']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $lineasDeAccion['LineasDeAccion']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit LineasDeAccion', true), array('action' => 'edit', $lineasDeAccion['LineasDeAccion']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete LineasDeAccion', true), array('action' => 'delete', $lineasDeAccion['LineasDeAccion']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $lineasDeAccion['LineasDeAccion']['id'])); ?> </li>
		<li><?php echo $html->link(__('List LineasDeAcciones', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New LineasDeAccion', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
