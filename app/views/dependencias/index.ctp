<div class="dependencias index">
<h2><?php __('Dependencias');?></h2>
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
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($dependencias as $dependencia):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $dependencia['Dependencia']['id']; ?>
		</td>
		<td>
			<?php echo $dependencia['Dependencia']['name']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $dependencia['Dependencia']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $dependencia['Dependencia']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $dependencia['Dependencia']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $dependencia['Dependencia']['id'])); ?>
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
		<li><?php echo $html->link(__('New Dependencia', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Instits', true), array('controller'=> 'instits', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Instit', true), array('controller'=> 'instits', 'action'=>'add')); ?> </li>
	</ul>
</div>
