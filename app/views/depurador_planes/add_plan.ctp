<script type="text/javascript">
    function validarPlan() {
        var error = '';
        if (jQuery('#PlanEstructuraPlanId :selected').val() == '') {
            error += 'Debe seleccionar la estructura\n';
        }
        if (jQuery('#PlanNombre').val() == '') {
            error += 'Debe ingresar el nombre del plan\n';
        }
        if (jQuery('#sector_id :selected').val() == '') {
            error += 'Debe seleccionar el sector del plan\n';
        }

        if (error.length > 0) {
            alert(error);
            return false;
        }

        return true;
    }
</script>

<h1>Nueva Oferta Educativa</h1>
<?
$anexo = ($instit['anexo']<10)?'0'.$instit['anexo']:$instit['anexo'];
$cue_instit = $instit['cue'].$anexo;
?>
<h2><?php echo $cue_instit." - ".$instit['nombre_completo']; ?></h2>

<div class="depuradorPlanes form">
<?php echo $form->create('Plan',array('id'=>'planAdd', 'onsubmit'=>'return validarPlan();','url' => array('controller' => 'depuradorPlanes', 'action' => 'add_plan/'.$instit['id'])));?>

    <table cellspacing="2">
        <tr>
            <td style="vertical-align:top;text-align:right;">Estructura Plan</td>
            <td><?=$form->input('estructura_plan_id',array('empty'=>'Seleccione',
                                    'id' => 'PlanEstructuraPlanId',
                                    'onchange' => 'ChangeEstructura()',
                'style' => 'float:left;width:230px; font-size:9pt;','div'=>false,'label'=>false))?>
        
                <div id="PlanEstructura">
                <span id="graficosEstructura">
                <?php 
                if(sizeof($estructuraPlanesGrafico) > 0) { 
                    foreach($estructuraPlanesGrafico as $estructura){
                ?>

                <div id="timelineLimiterMini" estructura_plan_id="<?php echo $estructura['EstructuraPlan']['id']?>" class="clickeable" style="display:none">
                    <div id="timelineScroll" style="margin-left: 0px;">
                        <div>
                            <div class="event" style="margin-left:5px;margin-bottom:0px">
                                <div class="eventHeading blue"><?php echo $estructura['EstructuraPlan']['Etapa']['name']?></div>
                                    <ul class="eventList">
                            <?php
                            $j = 0;
                            foreach($estructura['EstructuraPlan']['EstructuraPlanesAnio'] as $anio ):
                            ?>
                                <li><?php echo $anio['nro_anio'];?>º</li>
                            <?php
                            endforeach;
                            ?>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                        }
                    }
                    else {
                ?>
                    <div class="message">No existen estructuras asignadas a la jurisdicción</div>
                <?php }?>
                </span>
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">Título</td>
            <td><?=$form->input('titulo_id', array('empty'=>'Seleccione', 'label'=> false,
                                    'style'=>'width:450px; font-size:9pt;', 'div'=>false))?></td>
        </tr>
        <tr>
            <td style="text-align:right;">Normativa</td>
            <td><?=$form->input('norma',array('div'=>false,'label'=>false))?></td>
        </tr>
        <tr>
            <td style="text-align:right;">Nombre</td>
            <td><?=$form->input('nombre',array('div'=>false,'label'=>false))?></td>
        </tr>
        <tr>
            <td style="text-align:right;">Perfil</td>
            <td><?=$form->input('perfil',array('div'=>false,'label'=>false))?></td>
        </tr>
        <tr>
            <td style="text-align:right;">Sector</td>
            <td><?php
                $meter = '<span class="ajax_update" id="ajax_indicator2" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
		echo $form->input('sector_id',array('type'=>'select','empty'=>'Seleccione',
                        'options'=>$sectores,'default'=>5,'label'=>false,'id'=>'sector_id',
                        'style'=>'width:330px; font-size:9pt;', 'after'=>$meter));
            ?>
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">Subsector</td>
            <td><?php
                echo $form->input('subsector_id', array('empty' => 'Seleccione','type'=>'select',
                                        'style'=>'width:330px; font-size:9pt;', 'label'=>false,'after'=> $meter.'<br /><cite style="font-size:8pt;">Seleccione primero un sector.</cite>'));

                echo $ajax->observeField('sector_id',
                                   array(  	'url' => '/subsectores/ajax_select_subsector_form_por_sector',
                                                'update'=>'PlanSubsectorId',
                                                'loading'=>'console.debug("lasklaslk"); jQuery("#ajax_indicator2").show();jQuery("#PlanSubsectorId").attr("disabled","disabled")',
                                                'complete'=>'jQuery("#ajax_indicator2").hide();jQuery("#PlanSubsectorId").removeAttr("disabled")',
                                                'onChange'=>true
                                   ));
            ?>
            </td>
        </tr>
        <tr>
            <td style="text-align:right;">Duración Años</td>
            <td><?=$form->input('duracion_anios',array('div'=>false,'label'=>false, 'style'=>'width: 30px;','maxlength'=>9))?></td>
        </tr>
        <tr>
            <td style="text-align:right;">Observación</td>
            <td><?=$form->input('observacion',array('div'=>false,'label'=>false,'rows'=>'3'))?></td>
        </tr>
        <tr>
            <? if (empty($ciclo_id)) { ?>
            <td style="text-align:right;">Alta</td>
            <td><?=$form->input('ciclo_alta', array("type" => "select", "options" => $ciclos,
                                    'style'=>'font-size:9pt;', 
                                    'div'=>false,
                                    'label'=>false,
                                    "selected" => date('Y'))
                    )?>
            </td>
            <?php } else { ?>
                <?= $form->hidden('ciclo_alta', array(
                                    'value' => $ciclo_id,
                    ))?>
            <?php
            }
            ?>
        </tr>
        <tr>
            <td><?php
            echo $form->input('instit_id',array('type'=>'hidden','value'=>$instit['id']));
            echo $form->input('oferta_id',array('type'=>'hidden','value'=>3));
            ?>
            </td>
            <td style="text-align: center;"><?php echo $form->end('Guardar', array('style'=>'font-weigth:bold;'))?></td>
        </tr>

    </table>

</div>
	
