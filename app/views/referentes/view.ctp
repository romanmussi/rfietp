<div class="referentes view">
<h2><?php  __('Referente');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $referente['Referente']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $referente['Referente']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tipodoc'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($referente['Tipodoc']['name'], array('controller'=> 'tipodocs', 'action'=>'view', $referente['Tipodoc']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nrodoc'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $referente['Referente']['nrodoc']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Telefono'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $referente['Referente']['telefono']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Mail'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $referente['Referente']['mail']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Jurisdiccion'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($referente['Jurisdiccion']['name'], array('controller'=> 'jurisdicciones', 'action'=>'view', $referente['Jurisdiccion']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Referente', true), array('action'=>'edit', $referente['Referente']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Referente', true), array('action'=>'delete', $referente['Referente']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $referente['Referente']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Referentes', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Referente', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Tipodocs', true), array('controller'=> 'tipodocs', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tipodoc', true), array('controller'=> 'tipodocs', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Jurisdicciones', true), array('controller'=> 'jurisdicciones', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Jurisdiccion', true), array('controller'=> 'jurisdicciones', 'action'=>'add')); ?> </li>
	</ul>
</div>
