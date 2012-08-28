<div class="subsectores index">
<h2><?php __('Subsectores');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('sector_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($subsectores as $subsector):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $subsector['Subsector']['id']; ?>
		</td>
		<td>
			<?php echo $subsector['Subsector']['name']; ?>
		</td>
		<td>
			<?php echo $html->link($subsector['Sector']['name'], array('controller'=> 'sectores', 'action'=>'view', $subsector['Sector']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $subsector['Subsector']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $subsector['Subsector']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $subsector['Subsector']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $subsector['Subsector']['id'])); ?>
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
		<li><?php echo $html->link(__('New Subsector', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Sectores', true), array('controller'=> 'sectores', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Sector', true), array('controller'=> 'sectores', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Planes', true), array('controller'=> 'planes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Plan', true), array('controller'=> 'planes', 'action'=>'add')); ?> </li>
	</ul>
</div>
