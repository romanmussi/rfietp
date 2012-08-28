<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery(".js-opcional").each(function(index, value) {
        jQuery(".js-opcional").hide();
    });
});

function toogleDatosAnios() {
    if (jQuery("#mostraranios").is(":checked")) {
        jQuery(".js-opcional").each(function(index, value) {
            jQuery(".js-opcional").show();
        });
    }
    else {
        jQuery(".js-opcional").each(function(index, value) {
            jQuery(".js-opcional").hide();
        });
    }
}
</script>
<?php
if (empty($planes)) {
    ?>
<p class="msg-atencion"><br /><br />La Institución no presenta actualizaciones para este año</p>
<?
}
?>
<div id="tab_oferta">
    <?php
    if (!empty($planes) && !empty($ciclo)) {
        echo $form->input('mostraranios', array('type' => 'checkbox',
                'onclick' => 'toogleDatosAnios();',
                'style' => 'cursor:pointer;',
                'label' => '<font style="cursor:pointer; font-size:9pt;">Mostrar Año de Formación (A.F.) y Edad Teórica (E.T.).</font>'));
    }
    $i = 0;
    foreach($planes as $plan){
    ?>
    <?php if($ciclo > 0){ 
        if(!empty($plan['Anio'])){?>
    <div class="plan_item" title="Haciendo click verá más información de éste plan">
             <span  class="plan_etapa_name">
                    <?php echo $plan['EstructuraPlan']['Etapa']['name']?>
             </span>

             <span class="plan_mas_info btn-ir">
                    <?php echo $html->link("ver más",
                        array('controller'=> 'planes', 'action'=>'view', $plan['Plan']['id']), array('title'=>'Ver más información del plan'));
                    ?>
             </span>

            <table class="tabla_plan" cellpadding="2px" cellspacing="0px">
                <caption class="plan_title">
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
                            echo " (" . $primer_anio['ciclo_id'] . ")";
                        }
                     ?>
                </caption>
                <thead>
                    <tr>
                        <th>Año</th>
                        <th class="js-opcional">A.F</th>
                        <th class="js-opcional">E.T</th>
                        <th>Matrícula</th>
                        <th>Secciones</th>
                        <th>Horas Taller</th>
                    </tr>
                </thead>
            <?php
            $sumMatricula = 0;
            $sumSecciones = 0;
            foreach($plan['Anio'] as $anio) {
            ?>
            <tr>
                <td><?php echo $anio['EstructuraPlanesAnio']['alias']?></td>
                <td class="js-opcional"><?php echo @$anio['EstructuraPlanesAnio']['anio_escolaridad'];?></td>
                <td class="js-opcional"><?php echo @$anio['EstructuraPlanesAnio']['edad_teorica'];?></td>
                <td><?php echo $anio['matricula']?></td>
                <td><?php echo $anio['secciones']?></td>
                <td><?php echo $anio['hs_taller']?></td>
            </tr>
            <?php
            $sumMatricula += $anio['matricula'];
            $sumSecciones += $anio['secciones'];
            }?>

            <tfoot>
                    <tr>
                        <td>Total</td>
                        <td class="js-opcional">&nbsp;</td>
                        <td class="js-opcional">&nbsp;</td>
                        <td><?php echo $sumMatricula ?></td>
                        <td><?php echo $sumSecciones ?></td>
                        <td>&nbsp;</td>
                    </tr>
            </tfoot>
         </table>
         </div>
         <div class="clear"></div><br />
        <?php
            }
        }
        else{ // listar todos
            $class = null;
            if ($i++ % 2 == 0)
                $class = 'altrow';

            $primer_anio = current($plan['Anio']);
            $ciclo_plan =  (!empty($primer_anio['ciclo_id'])? $primer_anio['ciclo_id']:"") ;

            echo $this->element('planes/plan_resumen_para_listado', array(
                'class' => $class,
                'plan'  => $plan,
                'ciclo' => $ciclo_plan,
                'hstaller'  => $primer_anio["hs_taller"],
            ));
        }
    }
    ?>
</div>
