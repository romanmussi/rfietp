<div class="fondos index">
<h2><?php __('Fondos temporales');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
        <th><?php echo $paginator->sort('totales_checked');?></th>
        <th><?php echo $paginator->sort('cue_checked');?></th>
        <th><?php echo $paginator->sort('total');?></th>
        <th><?php echo $paginator->sort('suma_fila');?></th>
        <th><?php echo $paginator->sort('diferencia');?></th>
        <th><?php echo $paginator->sort('instit_id');?></th>
	<th><?php echo $paginator->sort('anio');?></th>
	<th><?php echo $paginator->sort('trimestre');?></th>
	<th><?php echo $paginator->sort('jurisdiccion_id');?></th>
	<th><?php echo $paginator->sort('jurisdiccion_name');?></th>
	<th><?php echo $paginator->sort('memo');?></th>
	<th><?php echo $paginator->sort('cuecompleto');?></th>
	<th><?php echo $paginator->sort('instit');?></th>
	<th><?php echo $paginator->sort('instit_name');?></th>
	<th><?php echo $paginator->sort('departamento');?></th>
        <th><?php echo $paginator->sort('localidad');?></th>
        <th><?php echo $paginator->sort('f01');?></th>
        <th><?php echo $paginator->sort('f02a');?></th>
        <th><?php echo $paginator->sort('f02b');?></th>
        <th><?php echo $paginator->sort('f02c');?></th>
        <th><?php echo $paginator->sort('f03a');?></th>
        <th><?php echo $paginator->sort('f03b');?></th>
        <th><?php echo $paginator->sort('f04');?></th>
        <th><?php echo $paginator->sort('f05');?></th>
        <th><?php echo $paginator->sort('f06a');?></th>
        <th><?php echo $paginator->sort('f06b');?></th>
        <th><?php echo $paginator->sort('f06c');?></th>
        <th><?php echo $paginator->sort('f07a');?></th>
        <th><?php echo $paginator->sort('f07b');?></th>
        <th><?php echo $paginator->sort('f07c');?></th>
        <th><?php echo $paginator->sort('f08');?></th>
        <th><?php echo $paginator->sort('f09');?></th>
        <th><?php echo $paginator->sort('equipinf');?></th>
        <th><?php echo $paginator->sort('refaccion');?></th>
        <th><?php echo $paginator->sort('aula_movil');?></th>
        <th><?php echo $paginator->sort('observacion');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($fondos as $fondo):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}

        $suma_fila = 0;
        $suma_fila = $fondo['FondoTemporal']['f01']+$fondo['FondoTemporal']['f02a']+
                    $fondo['FondoTemporal']['f02b']+$fondo['FondoTemporal']['f02c']+
                    $fondo['FondoTemporal']['f03a']+$fondo['FondoTemporal']['f03b']+
                    $fondo['FondoTemporal']['f04']+$fondo['FondoTemporal']['f05']+
                    $fondo['FondoTemporal']['f06a']+$fondo['FondoTemporal']['f06b']+
                    $fondo['FondoTemporal']['f06c']+$fondo['FondoTemporal']['f07a']+
                    $fondo['FondoTemporal']['f07b']+$fondo['FondoTemporal']['f07c']+
                    $fondo['FondoTemporal']['f08']+$fondo['FondoTemporal']['f09']+
                    $fondo['FondoTemporal']['equipinf']+$fondo['FondoTemporal']['refaccion'];
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $fondo['FondoTemporal']['id']; ?>
		</td>
		<td>
			<?php echo $fondo['FondoTemporal']['totales_checked']; ?>
		</td>
		<td>
			<?php echo $fondo['FondoTemporal']['cue_checked']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['total']; ?>
		</td>
                <td>
			<?php echo $suma_fila; ?>
		</td>
                <td><b>
			<?php echo $fondo['FondoTemporal']['total']-$suma_fila; ?>
                </b></td>
		<td>
			<?php echo $fondo['FondoTemporal']['instit_id']; ?>
		</td>
		<td>
			<?php echo $fondo['FondoTemporal']['anio']; ?>
		</td>
		<td>
			<?php echo $fondo['FondoTemporal']['trimestre']; ?>
		</td>
		<td>
			<?php echo $fondo['FondoTemporal']['jurisdiccion_id']; ?>
		</td>
		<td>
			<?php echo $fondo['FondoTemporal']['jurisdiccion_name']; ?>
		</td>
		<td>
			<?php echo $fondo['FondoTemporal']['memo']; ?>
		</td>
		<td>
			<?php echo $fondo['FondoTemporal']['cuecompleto']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['instit']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['instit_name']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['departamento']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['localidad']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f01']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f02a']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f02b']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f02c']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f03a']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f03b']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f04']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f05']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f06a']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f06b']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f06c']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f07a']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f07b']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f07c']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f08']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['f09']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['equipinf']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['refaccion']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['aula_movil']; ?>
		</td>
                <td>
			<?php echo $fondo['FondoTemporal']['observacion']; ?>
		</td>

		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $fondo['FondoTemporal']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $fondo['FondoTemporal']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $fondo['FondoTemporal']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $fondo['FondoTemporal']['id'])); ?>
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
		<li><?php echo $html->link(__('New Fondo', true), array('action'=>'add')); ?></li>
	</ul>
</div>
