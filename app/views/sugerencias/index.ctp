<div class="sugerencias index">
<h2><?php __('Sugerencias');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages% (%count% sugerencias en total)', true)
));
?></p>
<table cellpadding="0" cellspacing="0" style="font-size:9pt;">
<tr>
	<th></th>
        <th><?php echo $paginator->sort('asunto');?></th>
	<th><?php echo $paginator->sort('Usuario', 'user_id');?></th>
	<th><?php echo $paginator->sort('Recibida', 'created');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($sugerencias as $sugerencia):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class; echo ($sugerencia['Sugerencia']['leido'] == 0)?' style="font-weight: bold;"':'' ?>>
		<td>
			<?php echo ($sugerencia['Sugerencia']['leido'] == 0) ? $html->image('unread.png', array('valign'=>'absmiddle')) : $html->image('read.png', array('valign'=>'absmiddle')); ?>
		</td>
                <td style="text-align:left;">
			<?php echo $sugerencia['Sugerencia']['asunto']; ?>
		</td>
		<td style="text-align:left;">
			<?php echo $sugerencia['User']['username']; ?>
		</td>
		<td style="text-align:left;">
			<?php if ($time->isToday($sugerencia['Sugerencia']['created'])) {
                                echo "<b>Hoy</b> ".$time->format('G:i', $sugerencia['Sugerencia']['created'])." hs.";
                            } else {
                                echo $time->format('d/m/Y G:i', $sugerencia['Sugerencia']['created']) .' hs.';
                            } ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $sugerencia['Sugerencia']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $sugerencia['Sugerencia']['id']), null, sprintf(__('Seguro deseas eliminar la sugerencia # %s?', true), $sugerencia['Sugerencia']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
