<div class="orientaciones index">
<h2><?php __('Orientaciones');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, desde %start% hasta %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('Nombre','name');?></th>
	<th><?php echo $paginator->sort("Orientaciones",'Orientaciones.name');?></th>
	<th class="actions"><?php __('Acciones');?></th>
</tr>
<?php
$i = 0;
foreach ($orientaciones as $orientacion):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $orientacion['Orientacion']['id']; ?>
		</td>
		<td>
			<?php echo $orientacion['Orientacion']['name']; ?>
		</td>
		<td>
			<?php 
			$show = (empty($orientacion['Orientacion']['name']))? "" : $orientacion['Orientacion']['name'];
			echo $show; 
			?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Ver', true), array('action'=>'view', $orientacion['Orientacion']['id'])); ?>
			<?php echo $html->link(__('Editar', true), array('action'=>'edit', $orientacion['Orientacion']['id'])); ?>
			<?php echo $html->link(__('Borrar', true), array('action'=>'delete', $orientacion['Orientacion']['id']), null, sprintf(__('Borrar # %s?', true), $orientacion['Orientacion']['name'])); ?>
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
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Nueva Orientación', true), array('action'=>'add')); ?></li>
	</ul>
</div>