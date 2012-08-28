<?php
if (empty($planes)) {
    ?>
<p class="msg-atencion"><br /><br />La Institución no presenta actualizaciones para este año</p>
<?
}
?>

<div id="tabs-oferta-it-sec" class="oferta-contanier">
        <?php
        $i = 0;
        foreach($planes as $plan) {
            if ($ciclo > 0)
            {
                if (!empty($plan['Anio'])) {
                ?>
                <div class="plan_item">
                    <table class="tabla_plan" width="100%" border="2" cellpadding="2" cellspacing="0">
                        <caption>
                            <span class="plan_mas_info btn-ir">
                            <?php echo $html->link("ver más",
                                array('controller'=> 'planes', 'action'=>'view', $plan['Plan']['id']), array(
                                    'title'=>'Ver más información del plan',
                                    ));
                            ?>
                            </span>
                            
                            <?php 
                            $nombre = $plan['Plan']['nombre'];
                            if($plan['PlanEstado']['id'] != PLAN_ESTADO_ACTIVO) $nombre .= ' (' . $plan['PlanEstado']['nombre'] . ')';
                            if($plan['PlanTurno']['id'] != PLAN_TURNO_DIURNO) $nombre .= ' (' . $plan['PlanTurno']['nombre'] . ')';  
                            echo $html->link($nombre,
                            array('controller'=> 'planes', 'action'=>'view', $plan['Plan']['id']),
                            null,null,false);
                            ?>

                            <?php
                            if($ciclo == 0){
                                $primer_anio = current($plan['Anio']);
                                echo " (" . $primer_anio['Anio']['ciclo_id'] . ")";
                            }
                            ?>
                            
                        </caption>
                        <thead>
                            <tr>
                                <th>Año</th>
                                <th>Etapa</th>
                                <th>Matrícula</th>
                                <th>Secciones</th>
                                <th>Horas Taller</th>
                            </tr>
                        </thead>
                        <?php
                        $sumMatricula = $sumSecciones = 0;
                        foreach($plan['Anio'] as $anio){
                        ?>
                        <tr>
                            <td><?php echo $anio['anio']?>º</td>
                            <td><?php echo $anio['Etapa']['name'];?></td>
                            <td><?php echo $anio['matricula']?></td>
                            <td><?php echo $anio['secciones']?></td>
                            <td><?php echo $anio['hs_taller']?></td>
                        </tr>
                    <?php
                        $sumMatricula +=$anio['matricula'];
                        $sumSecciones +=$anio['secciones'];
                    }?>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td>Total</td>
                                <td><?php echo $sumMatricula ?></td>
                                <td><?php echo $sumSecciones ?></td>
                                <td>&nbsp;</td>
                            </tr>
                        </tfoot>
                    </table>
                 </div>
                <?php
                }
            }
            else { //mostrar todos
                $class = null;
                if ($i++ % 2 == 0) $class = 'altrow';
               
                $ciclo_plan = '';
                if($ciclo == 0) {
                    if (!empty($plan['Anio'][0]['ciclo_id'])) {
                        $ciclo_plan =  (!empty($plan['Anio'][0]['ciclo_id'])? $plan['Anio'][0]['ciclo_id']:"") ;
                    }
                    echo $this->element('planes/plan_resumen_para_listado', array(
                        'class' => $class,
                        'plan'  => $plan,
                        'ciclo' => $ciclo_plan,
                    ));
                }
                else if(count($plan['Anio']) > 0) {
                    echo $this->element('planes/plan_resumen_para_listado', array(
                        'class' => $class,
                        'plan'  => $plan,
                        'ciclo' => $ciclo_plan,
                    ));
                }
            }
        }
        ?>
</div>
