<div class="gestiones view">
<h2><?php  __('Gestion');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gestion['Gestion']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $gestion['Gestion']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Gestion', true), array('action'=>'edit', $gestion['Gestion']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Gestion', true), array('action'=>'delete', $gestion['Gestion']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $gestion['Gestion']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Gestiones', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Gestion', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Instits', true), array('controller'=> 'instits', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Instit', true), array('controller'=> 'instits', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Instits');?></h3>
	<?php if (!empty($gestion['Instit'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Gestion Id'); ?></th>
		<th><?php __('Dependencia Id'); ?></th>
		<th><?php __('Tipoinstit Id'); ?></th>
		<th><?php __('Jurisdiccion Id'); ?></th>
		<th><?php __('Cue'); ?></th>
		<th><?php __('Anexo'); ?></th>
		<th><?php __('Esanexo'); ?></th>
		<th><?php __('Nombre'); ?></th>
		<th><?php __('Nroinstit'); ?></th>
		<th><?php __('Anio Creacion'); ?></th>
		<th><?php __('Direccion'); ?></th>
		<th><?php __('Depto'); ?></th>
		<th><?php __('Localidad'); ?></th>
		<th><?php __('Cp'); ?></th>
		<th><?php __('Telefono'); ?></th>
		<th><?php __('Telefono Alternativo'); ?></th>
		<th><?php __('Mail'); ?></th>
		<th><?php __('Mail Alternativo'); ?></th>
		<th><?php __('Web'); ?></th>
		<th><?php __('Dir Nombre'); ?></th>
		<th><?php __('Dir Tipodoc Id'); ?></th>
		<th><?php __('Dir Nrodoc'); ?></th>
		<th><?php __('Dir Telefono'); ?></th>
		<th><?php __('Dir Telefono Alternativo'); ?></th>
		<th><?php __('Dir Mail'); ?></th>
		<th><?php __('Dir Mail Alternativo'); ?></th>
		<th><?php __('Vice Nombre'); ?></th>
		<th><?php __('Vice Tipodoc Id'); ?></th>
		<th><?php __('Vice Nrodoc'); ?></th>
		<th><?php __('Actualizacion'); ?></th>
		<th><?php __('Observacion'); ?></th>
		<th><?php __('Fecha Mod'); ?></th>
		<th><?php __('Activo'); ?></th>
		<th><?php __('Ciclo Alta'); ?></th>
		<th><?php __('Ciclo Mod'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($gestion['Instit'] as $instit):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $instit['id'];?></td>
			<td><?php echo $instit['gestion_id'];?></td>
			<td><?php echo $instit['dependencia_id'];?></td>
			<td><?php echo $instit['tipoinstit_id'];?></td>
			<td><?php echo $instit['jurisdiccion_id'];?></td>
			<td><?php echo $instit['cue'];?></td>
			<td><?php echo $instit['anexo'];?></td>
			<td><?php echo $instit['esanexo'];?></td>
			<td><?php echo $instit['nombre'];?></td>
			<td><?php echo $instit['nroinstit'];?></td>
			<td><?php echo $instit['anio_creacion'];?></td>
			<td><?php echo $instit['direccion'];?></td>
			<td><?php echo $instit['depto'];?></td>
			<td><?php echo $instit['localidad'];?></td>
			<td><?php echo $instit['cp'];?></td>
			<td><?php echo $instit['telefono'];?></td>
			<td><?php echo $instit['telefono_alternativo'];?></td>
			<td><?php echo $instit['mail'];?></td>
			<td><?php echo $instit['mail_alternativo'];?></td>
			<td><?php echo $instit['web'];?></td>
			<td><?php echo $instit['dir_nombre'];?></td>
			<td><?php echo $instit['dir_tipodoc_id'];?></td>
			<td><?php echo $instit['dir_nrodoc'];?></td>
			<td><?php echo $instit['dir_telefono'];?></td>
			<td><?php echo $instit['dir_mail'];?></td>
			<td><?php echo $instit['vice_nombre'];?></td>
			<td><?php echo $instit['vice_tipodoc_id'];?></td>
			<td><?php echo $instit['vice_nrodoc'];?></td>
			<td><?php echo $instit['actualizacion'];?></td>
			<td><?php echo $instit['observacion'];?></td>
			<td><?php echo $instit['activo'];?></td>
			<td><?php echo $instit['ciclo_alta'];?></td>
			<td><?php echo $instit['created'];?></td>
			<td><?php echo $instit['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'instits', 'action'=>'view', $instit['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'instits', 'action'=>'edit', $instit['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'instits', 'action'=>'delete', $instit['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $instit['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Instit', true), array('controller'=> 'instits', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
