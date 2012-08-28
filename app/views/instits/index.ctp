<div class="instits index">
<h2><?php __('Instits');?></h2>
<p class="paginate_msg">
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('gestion_id');?></th>
	<th><?php echo $paginator->sort('dependencia_id');?></th>
	<th><?php echo $paginator->sort('tipoinstit_id');?></th>
	<th><?php echo $paginator->sort('jurisdiccion_id');?></th>
	<th><?php echo $paginator->sort('cue');?></th>
	<th><?php echo $paginator->sort('anexo');?></th>
	<th><?php echo $paginator->sort('esanexo');?></th>
	<th><?php echo $paginator->sort('nombre');?></th>
	<th><?php echo $paginator->sort('nroinstit');?></th>
	<th><?php echo $paginator->sort('anio_creacion');?></th>
	<th><?php echo $paginator->sort('direccion');?></th>
	<th><?php echo $paginator->sort('depto');?></th>
	<th><?php echo $paginator->sort('localidad');?></th>
	<th><?php echo $paginator->sort('cp');?></th>
	<th><?php echo $paginator->sort('telefono');?></th>
	<th><?php echo $paginator->sort('telefono_alternativo');?></th>
	<th><?php echo $paginator->sort('mail');?></th>
	<th><?php echo $paginator->sort('mail_alternativo');?></th>
	<th><?php echo $paginator->sort('web');?></th>
	<th><?php echo $paginator->sort('dir_nombre');?></th>
	<th><?php echo $paginator->sort('dir_tipodoc_id');?></th>
	<th><?php echo $paginator->sort('dir_nrodoc');?></th>
	<th><?php echo $paginator->sort('dir_telefono');?></th>
	<th><?php echo $paginator->sort('dir_mail');?></th>
	<th><?php echo $paginator->sort('vice_nombre');?></th>
	<th><?php echo $paginator->sort('vice_tipodoc_id');?></th>
	<th><?php echo $paginator->sort('vice_nrodoc');?></th>
	<th><?php echo $paginator->sort('actualizacion');?></th>
	<th><?php echo $paginator->sort('observacion');?></th>
	<th><?php echo $paginator->sort('activo');?></th>
	<th><?php echo $paginator->sort('ciclo_alta');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($instits as $instit):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $instit['Instit']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($instit['Gestion']['name'], array('controller'=> 'gestiones', 'action'=>'view', $instit['Gestion']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($instit['Dependencia']['name'], array('controller'=> 'dependencias', 'action'=>'view', $instit['Dependencia']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($instit['Tipoinstit']['name'], array('controller'=> 'tipoinstits', 'action'=>'view', $instit['Tipoinstit']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($instit['Jurisdiccion']['name'], array('controller'=> 'jurisdicciones', 'action'=>'view', $instit['Jurisdiccion']['id'])); ?>
		</td>
		<td>
			<?php echo $instit['Instit']['cue']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['anexo']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['esanexo']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['nombre']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['nroinstit']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['anio_creacion']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['direccion']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['depto']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['localidad']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['cp']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['telefono']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['telefono_alternativo']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['mail']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['mail_alternativo']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['web']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['dir_nombre']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['dir_tipodoc_id']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['dir_nrodoc']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['dir_telefono']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['dir_mail']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['vice_nombre']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['vice_tipodoc_id']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['vice_nrodoc']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['actualizacion']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['observacion']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['activo']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['ciclo_alta']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['created']; ?>
		</td>
		<td>
			<?php echo $instit['Instit']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $instit['Instit']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $instit['Instit']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $instit['Instit']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $instit['Instit']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Instit', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Gestiones', true), array('controller'=> 'gestiones', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Gestion', true), array('controller'=> 'gestiones', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Dependencias', true), array('controller'=> 'dependencias', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Dependencia', true), array('controller'=> 'dependencias', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Tipoinstits', true), array('controller'=> 'tipoinstits', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tipoinstit', true), array('controller'=> 'tipoinstits', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Jurisdicciones', true), array('controller'=> 'jurisdicciones', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Jurisdiccion', true), array('controller'=> 'jurisdicciones', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Planes', true), array('controller'=> 'planes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Plan', true), array('controller'=> 'planes', 'action'=>'add')); ?> </li>
	</ul>
</div>
