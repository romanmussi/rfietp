<div class="related">	
	<?php
	if (!empty($anios)):
	?>
	<table>
		<tr>
			<th><?php __('Ciclo'); ?></th>
			<th><?php __('Matrícula'); ?></th>
			<th><?php __('Duración en Horas'); ?></th>
			<th class="actions"><?php __('');?></th>
		</tr>
	<?
	//reccorro por cada ciclo
		while (list($key,$ciclo) = each($anios)){
		$i = 0;
		
			foreach ($ciclo as $anio):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>		

			<tr id="fila_plan_<?= $anio['ciclo_id'].'_'.$anio['anio']?>" <?php echo $class;?>>
				<th><?php echo $key //muestra el año, el ciclo ?></th>
				<td><?php echo $anio['matricula'];?></td>
				<td><?php echo $anio['hs_taller'];?></td>
				<td class="acl actions acl-editores acl-administradores acl-desarrolladores">
					<a href="<?= $html->url(array('controller'=> 'anios', 'action'=>'edit/'.$anio['id']))?>" class="ajax-link">Editar</a>
					<?php echo $html->link(__('Borrar', true), array('controller'=> 'anios', 'action'=>'delete', $anio['id']), null, sprintf(__('Seguro que desea eliminar el ciclo # %s', true), $anio['ciclo_id'])); ?>
				</td>
			</tr>
			<?php endforeach; //el que recorre los anios del ciclo	?>
		
		<?php }// fin del WHILE...el que recorre los ciclos, los años?>
	</table>
<?php endif; ?>
</div>