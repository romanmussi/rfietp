<div class="tipodocs view">
<h2><?php  __('Tipodoc');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tipodoc['Tipodoc']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Abrev'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tipodoc['Tipodoc']['abrev']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tipodoc['Tipodoc']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Tipodoc', true), array('action'=>'edit', $tipodoc['Tipodoc']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Tipodoc', true), array('action'=>'delete', $tipodoc['Tipodoc']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tipodoc['Tipodoc']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Tipodocs', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tipodoc', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Referentes', true), array('controller'=> 'referentes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Referente', true), array('controller'=> 'referentes', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Referentes');?></h3>
	<?php if (!empty($tipodoc['Referente'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Tipodoc Id'); ?></th>
		<th><?php __('Nrodoc'); ?></th>
		<th><?php __('Telefono'); ?></th>
		<th><?php __('Mail'); ?></th>
		<th><?php __('Jurisdiccion Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($tipodoc['Referente'] as $referente):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $referente['id'];?></td>
			<td><?php echo $referente['name'];?></td>
			<td><?php echo $referente['tipodoc_id'];?></td>
			<td><?php echo $referente['nrodoc'];?></td>
			<td><?php echo $referente['telefono'];?></td>
			<td><?php echo $referente['mail'];?></td>
			<td><?php echo $referente['jurisdiccion_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'referentes', 'action'=>'view', $referente['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'referentes', 'action'=>'edit', $referente['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'referentes', 'action'=>'delete', $referente['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $referente['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Referente', true), array('controller'=> 'referentes', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
