<div class="localidades index">
<h2><?php __('Localidades');?></h2>
<? 
$paginator->options(array('url' => $url_conditions));
?>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>

<?php echo $form->create('Localidad',array('action'=>'ver'));?>
<?php echo $form->input('jurisdiccion_id',array('type'=>'select','options'=>$jurisdicciones,'onchange'=>'jQuery("#LocalidadVerForm").submit()'));?>
<?php echo $form->end(null);?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo 'Jurisdicción';?></th>
	
	<th><?php echo $paginator->sort('departamento','Departamento.name');?></th>
		
	<th><?php echo $paginator->sort('name');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($localidades as $localidad):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $localidad['Localidad']['id']; ?>
		</td>
		<td>
			<?php echo $localidad['Departamento']['Jurisdiccion']['name']; ?>
		</td>
		<td>
			<?php echo $localidad['Departamento']['name']; ?>
		</td>
		<td>
			<?php echo $localidad['Localidad']['name']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $localidad['Localidad']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $localidad['Localidad']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $localidad['Localidad']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $localidad['Localidad']['id'])); ?>
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
		<li><?php echo $html->link(__('New Localidad', true), array('action'=>'add')); ?></li>
	</ul>
</div>
