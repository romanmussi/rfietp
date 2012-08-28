<div class="tipoinstits view">
<h2><?php  __('Tipoinstit');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tipoinstit['Tipoinstit']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Jurisdiccion'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($tipoinstit['Jurisdiccion']['name'], array('controller'=> 'jurisdicciones', 'action'=>'view', $tipoinstit['Jurisdiccion']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tipoinstit['Tipoinstit']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Tipoinstit', true), array('action'=>'edit', $tipoinstit['Tipoinstit']['id'])); ?> </li>
		
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Instits');?></h3>
	<?php if (!empty($tipoinstit['Instit'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Cue'); ?></th>
		<th><?php __('Anexo'); ?></th>
		<th><?php __('Nombre'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($tipoinstit['Instit'] as $instit):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $instit['id'];?></td>
			<td><?php echo $instit['cue'];?></td>
			<td><?php echo $instit['anexo'];?></td>
			<td><?php echo $instit['nombre'];?></td>
			<td class="actions">
				<?php echo $html->link(__('Edit', true), array('controller'=> 'instits', 'action'=>'edit', $instit['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php endif; ?>
</div>
