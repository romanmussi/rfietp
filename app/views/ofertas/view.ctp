<div class="ofertas view">
<h2><?php  __('Oferta');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $oferta['Oferta']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Abrev'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $oferta['Oferta']['abrev']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $oferta['Oferta']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Oferta', true), array('action'=>'edit', $oferta['Oferta']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Oferta', true), array('action'=>'delete', $oferta['Oferta']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $oferta['Oferta']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Ofertas', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Oferta', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Planes', true), array('controller'=> 'planes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Plan', true), array('controller'=> 'planes', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Planes');?></h3>
	<?php if (!empty($oferta['Plan'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Instit Id'); ?></th>
		<th><?php __('Oferta Id'); ?></th>
		<th><?php __('Old Item'); ?></th>
		<th><?php __('Norma'); ?></th>
		<th><?php __('Nombre'); ?></th>
		<th><?php __('Perfil'); ?></th>
		<th><?php __('Sector'); ?></th>
		<th><?php __('Duracion Hs'); ?></th>
		<th><?php __('Duracion Semanas'); ?></th>
		<th><?php __('Duracion Anios'); ?></th>
		<th><?php __('Matricula'); ?></th>
		<th><?php __('Observacion'); ?></th>
		<th><?php __('Ciclo Alta'); ?></th>
		<th><?php __('Ciclo Mod'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($oferta['Plan'] as $plan):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $plan['id'];?></td>
			<td><?php echo $plan['instit_id'];?></td>
			<td><?php echo $plan['oferta_id'];?></td>
			<td><?php echo $plan['norma'];?></td>
			<td><?php echo $plan['nombre'];?></td>
			<td><?php echo $plan['perfil'];?></td>
			<td><?php echo $plan['sector'];?></td>
			<td><?php echo $plan['duracion_hs'];?></td>
			<td><?php echo $plan['duracion_semanas'];?></td>
			<td><?php echo $plan['duracion_anios'];?></td>
			<td><?php echo $plan['matricula'];?></td>
			<td><?php echo $plan['observacion'];?></td>
			<td><?php echo $plan['ciclo_alta'];?></td>
			<td><?php echo $plan['created'];?></td>
			<td><?php echo $plan['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'planes', 'action'=>'view', $plan['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'planes', 'action'=>'edit', $plan['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'planes', 'action'=>'delete', $plan['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $plan['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Plan', true), array('controller'=> 'planes', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
