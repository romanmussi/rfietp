<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery(".clickeable").click(function(){
            jQuery(this).toggleClass("green");
            if(jQuery(this).hasClass("green")){
                jQuery("").append("<input id='estructura_plan_id' name='data[Plan][estructura_plan_id]' type='hidden' value='" + jQuery(this).attr("estructura_plan_id") + "'/>");
                jQuery(this).find("#JurisdiccionesEstructuraPlanAsignado").attr("checked", "checked");
            }else{
                jQuery(this).find("#JurisdiccionesEstructuraPlanAsignado").removeAttr("checked");
            }
        });
    });
</script>
<div class="jurisdiccionesTrayectos index">
<h2><?php __('Estructuras para '.$jurisdiccion['Jurisdiccion']['name']);?></h2>
<?php echo $form->create('JurisdiccionesEstructuraPlan', array('action'=>'index'));?>
<?php echo $form->hidden('jurisdiccion_id',array('name'=>'data[jurisdiccion_id]','value'=> $jurisdiccion_id))?>

<?php

$i = 0;
foreach ($trayectos_asignados as $jurisdiccionesTrayecto):
    $render['estructura'] =  $jurisdiccionesTrayecto['EstructuraPlan'];
    $render['anios'] =  $jurisdiccionesTrayecto['EstructuraPlan']['EstructuraPlanesAnio'];
    $render['etapa'] =  $jurisdiccionesTrayecto['EstructuraPlan']['Etapa'];
    $render['i'] =  $i;
    $render['asignado'] =  true;
?>
            <?php echo $form->hidden('estructura_plan_id',array('name'=>'data[JurisdiccionesEstructuraPlan]['. $i . '][estructura_plan_id]','value'=> $jurisdiccionesTrayecto['EstructuraPlan']['id']))?>
            <?php echo $this->element('graficadorDeEstructuras',$render);?>
            
<?php
$j = 0;
$i++;
endforeach; ?>

<?php
foreach ($trayectos_restantes as $jurisdiccionesTrayecto):
    $render['estructura'] =  $jurisdiccionesTrayecto['EstructuraPlan'];
    $render['anios'] =  $jurisdiccionesTrayecto['EstructuraPlanesAnio'];
    $render['etapa'] =  $jurisdiccionesTrayecto['Etapa'];
    $render['i'] =  $i;
    $render['asignado'] =  false;
?>
            <?php echo $form->hidden('estructura_plan_id',array('name'=>'data[JurisdiccionesEstructuraPlan]['. $i . '][estructura_plan_id]','value'=> $jurisdiccionesTrayecto['EstructuraPlan']['id']))?>
            <?php echo $this->element('graficadorDeEstructuras',$render);?>
<?php
$i++;
endforeach; ?>

</div>
<?php echo $form->end('Guardar');?>