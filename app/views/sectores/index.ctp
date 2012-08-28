<div class="sectores index">
<h2><?php __('Sectores');?></h2>
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
	<th><?php echo $paginator->sort("Orientación",'Orientacion.name');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr> 
<?php
$i = 0;
foreach ($sectores as $sector):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $sector['Sector']['id']; ?>
		</td>
		<td>
			<?php echo $sector['Sector']['name']; ?>
		</td>
		<td>
			<?php 
			$show = (empty($sector['Orientacion']['name']))? "" : $sector['Orientacion']['name'];
			echo $show; 
			?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $sector['Sector']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $sector['Sector']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $sector['Sector']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sector['Sector']['id'])); ?>
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
		<li><?php echo $html->link(__('New Sector', true), array('action'=>'add')); ?></li>
	</ul>
</div>