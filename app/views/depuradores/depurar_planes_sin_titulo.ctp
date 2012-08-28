<div class="planes index">
<h2><?php __('Planes sin Título de Referencia');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages% (%count% total)', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('nombre');?></th>
	<th><?php echo $paginator->sort('Institución', 'Instit.name');?></th>
	<th><?php echo $paginator->sort('Oferta', 'Oferta.name');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($planes as $plan):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $plan['Plan']['id']; ?>
		</td>
		<td>
			<?php echo $plan['Plan']['nombre']; ?>
		</td>
		<td>
			<?php echo $plan['Instit']['nombre_completo']; ?>
		</td>
		<td>
			<?php echo $plan['Oferta']['name']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Editar', true), array('controller'=>'planes', 'action'=>'edit', $plan['Plan']['id'])); ?>
			<?php echo $html->link(__('Eliminar', true), array('action'=>'delete', $plan['Plan']['id']), null, sprintf(__('Estas seguro que deseas eliminar el plan: %s?', true), $plan['Plan']['nombre'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('anterior', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('siguiente', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
