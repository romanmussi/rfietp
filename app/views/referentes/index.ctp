<div class="referentes index">
<h2><?php __('Referentes');?></h2>
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
	<th><?php echo $paginator->sort('tipodoc_id');?></th>
	<th><?php echo $paginator->sort('nrodoc');?></th>
	<th><?php echo $paginator->sort('telefono');?></th>
	<th><?php echo $paginator->sort('mail');?></th>
	<th><?php echo $paginator->sort('jurisdiccion_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($referentes as $referente):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $referente['Referente']['id']; ?>
		</td>
		<td>
			<?php echo $referente['Referente']['name']; ?>
		</td>
		<td>
			<?php echo $html->link($referente['Tipodoc']['name'], array('controller'=> 'tipodocs', 'action'=>'view', $referente['Tipodoc']['id'])); ?>
		</td>
		<td>
			<?php echo $referente['Referente']['nrodoc']; ?>
		</td>
		<td>
			<?php echo $referente['Referente']['telefono']; ?>
		</td>
		<td>
			<?php echo $referente['Referente']['mail']; ?>
		</td>
		<td>
			<?php echo $html->link($referente['Jurisdiccion']['name'], array('controller'=> 'jurisdicciones', 'action'=>'view', $referente['Jurisdiccion']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $referente['Referente']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $referente['Referente']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $referente['Referente']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $referente['Referente']['id'])); ?>
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
		<li><?php echo $html->link(__('New Referente', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Tipodocs', true), array('controller'=> 'tipodocs', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tipodoc', true), array('controller'=> 'tipodocs', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Jurisdicciones', true), array('controller'=> 'jurisdicciones', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Jurisdiccion', true), array('controller'=> 'jurisdicciones', 'action'=>'add')); ?> </li>
	</ul>
</div>
