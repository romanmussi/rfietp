<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery(".clickeable").click(function(){
            jQuery(this).toggleClass("green");
            if(jQuery(this).hasClass("green")){
                jQuery(this).find("#JurisdiccionesTrayectoAsignado").attr("checked", "checked");
            }else{
                jQuery(this).find("#JurisdiccionesTrayectoAsignado").removeAttr("checked");
            }
            
        });
    });
</script>
<div class="jurisdiccionesTrayectos index">
<h2><?php __('JurisdiccionesTrayectos');?></h2>
<?php echo $form->create('JurisdiccionesTrayecto', array('action'=>'index'));?>
<?php echo $form->hidden('jurisdiccion_id',array('name'=>'data[jurisdiccion_id]','value'=> $jurisdiccion_id))?>

<?php
$i = 0;
$j = 0;
$etapa_anterior = '';
$colors = array('green','blue','chreme');
foreach ($trayectos_asignados as $jurisdiccionesTrayecto):
?>
            <?php echo $form->hidden('trayecto_id',array('name'=>'data[JurisdiccionesTrayecto]['. $i . '][trayecto_id]','value'=> $jurisdiccionesTrayecto['Trayecto']['id']))?>
            <!--<?php echo $jurisdiccionesTrayecto['Trayecto']['name']; ?>-->
            <div id="timelineLimiter" class="clickeable green">
                <div id="timelineScroll" style="margin-left: 0px;">
                <span style="width:55px;display:inline;float:left;margin-top:7px">Edades:</span>
                <ul class="edadesList">
                    <li>12</li>
                    <li>13</li>
                    <li>14</li>
                    <li>15</li>
                    <li>16</li>
                    <li>17</li>
                    <li>18</li>
                    <li>19</li>
                </ul>
                    <div class="events">
                        <?php
                        $j = 0;
                        foreach($jurisdiccionesTrayecto['Trayecto']['TrayectoAnio'] as $anio ):
                            if($i == 0 && $j == 0){
                                if($anio['edad_teorica'] != 12){
                                    $class = 'mover';
                                }
                                else {
                                    $class ='';
                                }
                            }else{
                                $class ='';
                            }
                            if($etapa_anterior != $anio['Etapa']['id']){
                                if(!empty($etapa_anterior)){
                                    echo '</ul></div>';
                                }
                                $etapa_anterior = $anio['Etapa']['id'];
                                ?>
                            <div class="event">
                            <div class="eventHeading <?php echo $colors[$j++%3]?>"><?php echo $anio['Etapa']['name']?></div>
                                <ul class="<?php echo $class?> eventList">
                        <?php
                            }
                        ?>
                                    <li><?php echo $anio['anio'];?>º</li>
                        <?php
                        endforeach;
                        ?>
                                </ul>
                            </div>
                        <div class="instit_link_list" style="clear:none">
                            <?php echo $form->checkbox('asignado',array('name'=>'data[JurisdiccionesTrayecto]['. $i . '][asignado]','checked'=>'checked')); ?>
                        </div>
                    </div>
                </div>
            </div>
<?php
$j = 0;
$etapa_anterior = '';
$i++;
endforeach; ?>

<?php
foreach ($trayectos_restantes as $jurisdiccionesTrayecto):
?>
            <?php echo $form->hidden('trayecto_id',array('name'=>'data[JurisdiccionesTrayecto]['. $i . '][trayecto_id]','value'=> $jurisdiccionesTrayecto['Trayecto']['id']))?>
            <!--<?php echo $jurisdiccionesTrayecto['Trayecto']['name']; ?>-->
            <div id="timelineLimiter" class="clickeable">
            <div id="timelineScroll" style="margin-left: 0px;">
                 <span style="width:55px;display:inline;float:left;margin-top:7px">Edades:</span>
                <ul class="edadesList">
                    <li>12</li>
                    <li>13</li>
                    <li>14</li>
                    <li>15</li>
                    <li>16</li>
                    <li>17</li>
                    <li>18</li>
                    <li>19</li>
                </ul>
                <div class="events">
            <?php
            $j = 0;
            foreach($jurisdiccionesTrayecto['TrayectoAnio'] as $anio ):
                if($etapa_anterior != $anio['Etapa']['id']){
                    if(!empty($etapa_anterior)){
                        echo '</ul></div>';
                    }
                    $etapa_anterior = $anio['Etapa']['id'];
                    ?>
                <div class="event">
                <div class="eventHeading <?php echo $colors[$j++%3]?>"><?php echo $anio['Etapa']['name']?></div>
                    <ul class="eventList">
            <?php
                }
            ?>
                        <li><?php echo $anio['anio'];?>º</li>
            <?php
            endforeach;
            ?>
                    </ul>
                </div>
            <div class="instit_link_list" style="clear:none">
                <?php echo $form->checkbox('asignado',array('name'=>'data[JurisdiccionesTrayecto]['. $i . '][asignado]')); ?>
            </div>
            </div>
            </div>
            </div>
<?php
$i++;
endforeach; ?>

</div>
<?php echo $form->end('Guardar');?>
