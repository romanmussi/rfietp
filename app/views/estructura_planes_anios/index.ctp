<?
//debug($estructuraPlanesAnios);

?>
<div class="estructuraPlanesAnios index">
<h2><?php __('estructuraPlanesAnios');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('estructura_plan_id');?></th>
	<th><?php echo $paginator->sort('edad_teorica');?></th>
	<th><?php echo $paginator->sort('nro_anio');?></th>
	<th><?php echo $paginator->sort('anio_escolaridad');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($estructuraPlanesAnios as $estructuraPlanesAnio):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $estructuraPlanesAnio['EstructuraPlanesAnio']['id']; ?>
		</td>
		<td>
			<?php echo $estructuraPlanesAnio['EstructuraPlan']['name']. " <br><b>".$estructuraPlanesAnio['EstructuraPlan']['Etapa']['name']."</b>"; ?>
		</td>
		<td>
			<?php echo $estructuraPlanesAnio['EstructuraPlanesAnio']['edad_teorica']; ?>
		</td>
		<td>
			<?php echo $estructuraPlanesAnio['EstructuraPlanesAnio']['nro_anio']; ?>
		</td>
		<td>
			<?php echo $estructuraPlanesAnio['EstructuraPlanesAnio']['anio_escolaridad']; ?>
		</td>
		
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $estructuraPlanesAnio['EstructuraPlanesAnio']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $estructuraPlanesAnio['EstructuraPlanesAnio']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $estructuraPlanesAnio['EstructuraPlanesAnio']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $estructuraPlanesAnio['EstructuraPlanesAnio']['id'])); ?>
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
		<li><?php echo $html->link(__('New EstructuraPlanesAnio', true), array('action'=>'add')); ?></li>
	</ul>
</div>
