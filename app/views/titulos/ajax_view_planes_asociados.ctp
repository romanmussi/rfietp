<?php
    echo $paginator->counter(array(
    'format' => __('Página %page% de %pages% (%count% Planes de Estudio Asociados)', true)
    ));

    $paginator->options(array(
        'url'     => $this->passedArgs,
        'update'  => 'tituloPlanes',
        'indicator' => 'spinner',
        ));

    $i = 0;
    if (!empty($planes)) {
    ?>
    <table style="font-size: 8pt;">
        <th><?php echo $paginator->sort('Plan','Plan.nombre');?></th>
        <th><?php echo $paginator->sort('Institución','Plan.instit_id');?></th>
        <th><?php echo $paginator->sort('Jurisdicción','Instit.jurisdiccion_id');?></th>
        <?php
        foreach ($planes as $plan) {
            $class = '';
            if ($i++ % 2 == 0) {
                $class = 'altrow';
            }
        ?>
        <tr>
            <td style="text-align:left; vertical-align: middle;"><?php echo $plan['Plan']['nombre']; ?></td>
            <td style="text-align:left; vertical-align: middle;"><?php echo $html->link($plan['Instit']['nombre_completo'], array('controller'=>'Instits', 'action'=>'view', $plan['Instit']['id'])); ?></td>
            <td style="text-align:left; vertical-align: middle;"><?php echo $plan['Instit']['Jurisdiccion']['name']; ?></td>
        </tr>
        <tr><td colspan="3" style="border-bottom:1px solid #CCCCCC;"></td></tr>
        <?php
        }
        ?>
    </table>
    <?php
    }
    ?>
    <div class="paginator_prev_next_links">
            <?php
            if($paginator->numbers()){
                    echo $paginator->prev('« Anterior ',null, null, array('class' => 'disabled'));
                    echo " | ".$paginator->numbers(array('modulus'=>'9'))." | ";
                    echo $paginator->next(' Siguiente »', null, null, array('class' => 'disabled'));
            }
            ?>
    </div>

    <div id="spinner" style="display: none; text-align: center; margin-top:10px;">
    <?php
    echo $html->image('loadercircle16x16.gif')
    ?>
    </div>