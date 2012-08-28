<div class="sectores view">
<h2><?php  __('Sector');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sector['Sector']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sector['Sector']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div> 
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Sector', true), array('action'=>'edit', $sector['Sector']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Sector', true), array('action'=>'delete', $sector['Sector']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sector['Sector']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Sectores', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Sector', true), array('action'=>'add')); ?> </li>
	</ul>
</div>