<div class="logs index">
<h2><?php __('Logs');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('username');?></th>
	<th><?php echo $paginator->sort('fecha_in');?></th>
	<th><?php echo $paginator->sort('hora_in');?></th>
	<th><?php echo $paginator->sort('fecha_out');?></th>
	<th><?php echo $paginator->sort('hora_out');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($logs as $log):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $log['Log']['id']; ?>
		</td>
		<td>
			<?php echo $log['Log']['username']; ?>
		</td>
		<td>
			<?php echo $log['Log']['fecha_in']; ?>
		</td>
		<td>
			<?php echo $log['Log']['hora_in']; ?>
		</td>
		<td>
			<?php echo $log['Log']['fecha_out']; ?>
		</td>
		<td>
			<?php echo $log['Log']['hora_out']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $log['Log']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $log['Log']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $log['Log']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $log['Log']['id'])); ?>
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
		<li><?php echo $html->link(__('New Log', true), array('action'=>'add')); ?></li>
	</ul>
</div>
