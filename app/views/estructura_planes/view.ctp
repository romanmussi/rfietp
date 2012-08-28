<div class="estructuraplanes view">
<h2><?php  __('EstructuraPlan');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $EstructuraPlan['EstructuraPlan']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $EstructuraPlan['EstructuraPlan']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $EstructuraPlan['EstructuraPlan']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $EstructuraPlan['EstructuraPlan']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit EstructuraPlan', true), array('action'=>'edit', $EstructuraPlan['EstructuraPlan']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete EstructuraPlan', true), array('action'=>'delete', $EstructuraPlan['EstructuraPlan']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $EstructuraPlan['EstructuraPlan']['id'])); ?> </li>
		<li><?php echo $html->link(__('List estructuraplanes', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New EstructuraPlan', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
