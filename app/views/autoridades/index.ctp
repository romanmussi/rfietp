<div class="autoridades index">
<h2>Autoridades de <?echo $jurisdiccion['Jurisdiccion']['name'];?></h2>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('cargo');?></th>
        <th><?php echo $paginator->sort('nombre');?></th>
	<th class="actions"></th>
</tr>
<?php
$i = 0;
foreach ($autoridades as $autoridad):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
                <td>
                    <?php foreach($autoridad['Cargo'] as $cargo){?>
			<?php echo $cargo['nombre']; ?> /
                    <?}?>
		</td>
		<td>
			<?php echo $autoridad['Autoridad']['titulo'] . ' ' . $autoridad['Autoridad']['nombre'] .  ' ' . $autoridad['Autoridad']['apellido']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Ver', true), array('action' => 'view', $autoridad['Autoridad']['id'])); ?>
			<?php echo $html->link(__('Editar', true), array('action' => 'edit', $autoridad['Autoridad']['id'])); ?>
			<?php echo $html->link(__('Eliminar', true), array('action' => 'delete', $autoridad['Autoridad']['id']), null, sprintf(__('Esta seguro de eliminar la autoridad?', true), $autoridad['Autoridad']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('anterior', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('siguiente', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Nueva Autoridad', true), array('action' => 'add', $jurisdiccion_id)); ?></li>
	</ul>
</div>
