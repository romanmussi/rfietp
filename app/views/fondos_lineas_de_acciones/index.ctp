<div class="fondosLineasDeAcciones index">
<h2><?php __('FondosLineasDeAcciones');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('fondo_id');?></th>
	<th><?php echo $paginator->sort('lineas_de_accion_id');?></th>
	<th><?php echo $paginator->sort('monto');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($fondosLineasDeAcciones as $fondosLineasDeAccion):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $fondosLineasDeAccion['FondosLineasDeAccion']['id']; ?>
		</td>
		<td>
			<?php echo $fondosLineasDeAccion['FondosLineasDeAccion']['fondo_id']; ?>
		</td>
		<td>
			<?php echo $fondosLineasDeAccion['FondosLineasDeAccion']['lineas_de_accion_id']; ?>
		</td>
		<td>
			<?php echo $fondosLineasDeAccion['FondosLineasDeAccion']['monto']; ?>
		</td>
		<td>
			<?php echo $fondosLineasDeAccion['FondosLineasDeAccion']['created']; ?>
		</td>
		<td>
			<?php echo $fondosLineasDeAccion['FondosLineasDeAccion']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $fondosLineasDeAccion['FondosLineasDeAccion']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $fondosLineasDeAccion['FondosLineasDeAccion']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $fondosLineasDeAccion['FondosLineasDeAccion']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $fondosLineasDeAccion['FondosLineasDeAccion']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New FondosLineasDeAccion', true), array('action' => 'add')); ?></li>
	</ul>
</div>
