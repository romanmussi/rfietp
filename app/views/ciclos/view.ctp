<div class="ciclos view">
<h2><?php  __('Ciclo');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ciclo['Ciclo']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $ciclo['Ciclo']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Ciclo', true), array('action'=>'edit', $ciclo['Ciclo']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Ciclo', true), array('action'=>'delete', $ciclo['Ciclo']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $ciclo['Ciclo']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Ciclos', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Ciclo', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Anios', true), array('controller'=> 'anios', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Anio', true), array('controller'=> 'anios', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Anios');?></h3>
	<?php if (!empty($ciclo['Anio'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Plan Id'); ?></th>
		<th><?php __('Ciclo Id'); ?></th>
		<th><?php __('Old Item'); ?></th>
		<th><?php __('Anio'); ?></th>
		<th><?php __('Etapa Id'); ?></th>
		<th><?php __('Matricula'); ?></th>
		<th><?php __('Secciones'); ?></th>
		<th><?php __('Hs Taller'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($ciclo['Anio'] as $anio):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $anio['id'];?></td>
			<td><?php echo $anio['plan_id'];?></td>
			<td><?php echo $anio['ciclo_id'];?></td>
			<td><?php echo $anio['anio'];?></td>
			<td><?php echo $anio['etapa_id'];?></td>
			<td><?php echo $anio['matricula'];?></td>
			<td><?php echo $anio['secciones'];?></td>
			<td><?php echo $anio['hs_taller'];?></td>
			<td><?php echo $anio['created'];?></td>
			<td><?php echo $anio['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'anios', 'action'=>'view', $anio['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'anios', 'action'=>'edit', $anio['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'anios', 'action'=>'delete', $anio['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $anio['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Anio', true), array('controller'=> 'anios', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
