<div class="departamentos index">
<h2><?php __('Departamentos');?></h2>
<p>
<? 
$paginator->options(array('url' => $url_conditions));
?>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>

<?php echo $form->create('Departamento',array('action'=>'ver'));?>
<?php echo $form->input('jurisdiccion_id',array('type'=>'select','options'=>$jurisdicciones,'onchange'=>'jQuery("#DepartamentoVerForm").submit()'));?>
<?php echo $form->end(null);?>


<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('jurisdiccion_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($departamentos as $departamento):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $departamento['Departamento']['id']; ?>
		</td>
		<td>
			<?php echo "(".$departamento['Departamento']['jurisdiccion_id'].") ".$departamento['Jurisdiccion']['name']; ?>
		</td>
		<td>
			<?php echo $departamento['Departamento']['name']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $departamento['Departamento']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $departamento['Departamento']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $departamento['Departamento']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $departamento['Departamento']['id'])); ?>
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
		<li><?php echo $html->link(__('New Departamento', true), array('action'=>'add')); ?></li>
	</ul>
</div>
