<div class="planes index">
<h2><?php echo $nombre;?></h2>
<p>
<?php
    echo $paginator->counter(array(
    'format' => __('Página %page% de %pages% (%count% Planes)', true)
    ));
    
    $paginator->options(array(
        'url'     => $this->passedArgs,
        ));
?>
</p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th>Institución</th>
	<th></th>
</tr>
<?php
    $i = 0;
    if (!empty($planes)) {
        foreach ($planes as $plan) {
            $class = null;
            if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
            }
        ?>
        <tr<?php echo $class;?>>            
            <td><?php echo $html->link($plan['Instit']['nombre_completo'], array('controller'=>'Instits', 'action'=>'view', $plan['Plan']['instit_id'])); ?></td>
            <td><?php echo $html->link('Ir al plan', array('controller'=>'planes', 'action'=>'view', $plan['Plan']['id'])); ?></td>
        </tr>
        <?php
        }
    }
    ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>