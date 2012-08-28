<?php
echo $javascript->link(array(
    'jquery.loadmask.min',
    'jquery.autoscroll.packed',
    'jquery.loadmask.min',
    ));

echo $html->css(array('jquery.loadmask'));

?>
<script type="text/javascript">
       
    function RenderPlan(plan_id, estructura_id) {
        jQuery(document).ready(function() {
           jQuery('#col_der').mask('Cargando');
           jQuery('#plan_'+plan_id).load('<?=$html->url('/depurador_planes/tr_plan/')?>'+plan_id, function(){
               jQuery('#col_der').unmask();
           });

           if (estructura_id > 0) {
               // muestra link para confirmar todo
               jQuery('#todo_ok_'+plan_id).show();
               jQuery('#duplicar_'+plan_id).show();
           }
           else {
               jQuery('#todo_ok_'+plan_id).hide();
               jQuery('#duplicar_'+plan_id).hide();
           }
        });
    }

    function CambiarEstructuraPlan(plan_id, estructura_plan_id) {
        if (estructura_plan_id > 0) {
            jQuery(document).ready(function() {
                jQuery('#col_der').mask('Cargando');
                jQuery('#plan_'+plan_id).load('<?=$html->url('/depurador_planes/cambiarEstructuraPlan/')?>'+plan_id+'/'+estructura_plan_id,
                function(){
                    jQuery('#col_der').unmask();
                });
            });

            // muestra link para confirmar todo
            jQuery('#todo_ok_'+plan_id).show();
            jQuery('#duplicar_'+plan_id).show();
        }
    }

    function EditarCiclo(element) {

        var $dialog = jQuery('<div></div>')
                .html('... cargando años')
		.dialog({
                        width: 550,
                        position: 'top',
			title: 'Depurar Datos de los Años'
		})
                .load(element.href);

        return false;
    }

    function CrearPlan(element) {        
        var $dialog = jQuery('<div id="create_dialog"></div>')
                .html('... cargando nuevo plan')
		.dialog({
                        width: 750,
                        position: 'top',
                        zIndex: 3999,
			title: 'Nuevo Plan',
                        beforeclose: function(event, ui) { jQuery(".ui-dialog").remove(); jQuery("#create_dialog").remove(); }
	});

        jQuery.ajax({
          url: element.href,
          cache: false,
          success: function(data) {
            $dialog.html(data);

            jQuery('#sector_id').change( function() {
                        jQuery('#sector_id').parents('form').ajaxSubmit({
                            beforeSend:function(request) {
                                request.setRequestHeader('X-Update', 'PlanSubsectorId');
                                jQuery("#ajax_indicator2").show();
                                jQuery("#PlanSubsectorId").attr("disabled","disabled")
                            },
                            complete:function(request, textStatus) {
                                jQuery("#ajax_indicator2").hide();
                                jQuery("#PlanSubsectorId").removeAttr("disabled")
                            },
                            success:function(data, textStatus) {
                                jQuery('#PlanSubsectorId').html(data);
                            },
                            async:true,
                            type:'post',
                            url:'<?=$html->url('/subsectores/ajax_select_subsector_form_por_sector')?>'
                        });
                    })
          }
        });
      
        return false;
    }

    function ChangeEstructura() {
        jQuery("div[estructura_plan_id]").hide();
        jQuery("div[estructura_plan_id=" + jQuery('#PlanEstructuraPlanId :selected').val() + "]").show();
    }

    

</script>

    <div id="datos_instit">
            <?
            //el anexo viene con 1 solo digito por lo general. Pero para leerlo siempre hay que ponerlo
            // en formato de 2 digitos
            $armar_anexo = ($instit['Instit']['anexo']<10)?'0'.$instit['Instit']['anexo']:$instit['Instit']['anexo'];
            $nombreInstit = "".($instit['Instit']['cue']*100)+$instit['Instit']['anexo']." - ". $instit['Instit']['nombre_completo'];
            ?>
            <div class="instit_name"><b><?= $html->link($nombreInstit, '/instits/view/'.$instit['Instit']['id'], array('target'=>'_blank')) ?></b></div>
            <div class="instit_atributte"><b>Domicilio: </b> <?= $instit['Instit']['direccion'] ?></div>
            <br />
            <div class="instit_atributte"><b>Gestión: </b><?= $instit['Gestion']['name'] ?></div>
            <div class="instit_atributte"><b>Jurisdicción: </b> <?= $instit['Jurisdiccion']['name'] ?></div>
            <br />
            <div class="instit_atributte"><b>Departamento: </b><?= $instit['Departamento']['name'] ?></div>
            <div class="instit_atributte"><b>Localidad: </b><?= $instit['Localidad']['name'] ?></div>
    </div>

    <div id="volver"><h1><?=$html->link('Volver al Depurador de Planes', '/depurador_planes/listado')?></h1></div>

    <div id="cuerpo">

        <div id="col_izq">
            <div style="border-bottom:1px solid black; height:21px;"><?=$html->link('+ Crear Plan', '/depurador_planes/add_plan/'.$instit['Instit']['id'], array('onclick' => 'return CrearPlan(this)'))?></div>
            <?php
            foreach ($instit['Plan'] as $plan) {
            ?>
            <div class="planes_izq">
                <?= $html->link($plan['nombre'],'/planes/view/'.$plan['id'], array('target'=>'_blank'))?>
                 (<?=$plan['duracion_anios']?> años)
                <br />

                <br />
                <?php echo $form->input('estructura_id_'.$plan['id'],
                        array(  'options'=>$estructuras,
                                'label'=>'',
                                'empty'=>' -Seleccione- ',
                                'style'=>'width:160px; font-size:8pt;',
                                'onchange'=>'javascript: CambiarEstructuraPlan('.$plan['id'].',this.value)',
                                'selected'=>$plan['estructura_plan_id'],
                                'style'=>'float:left; width: 150px;',
                            )); ?>
                <div id="todo_ok_<?=$plan['id']?>" class="plan_ok_button"><?= $html->link('TODO OK', '/depuradorPlanes/darle_ok_al_plan/'.$plan['id']) ?></div>
                <div id="duplicar_<?=$plan['id']?>" style="margin-top:5px" class="plan_ok_button"><?= $html->link('DUPLICAR', '/depuradorPlanes/duplicar_plan/'.$plan['id']) ?></div>
            </div>
            <?php } ?>

            <div><?=$html->link('+ Crear Plan', '/depurador_planes/add_plan/'.$instit['Instit']['id'], array('onclick' => 'return CrearPlan(this)'))?></div>
        </div>
        <!-- pantalla principal -->

        <div id="col_der">
            
            <table class="table_planes_der">
                <tr class="tr_header">
                <?php
                for ($i=2006; $i <= date('Y'); $i++) {
                ?>
                    <th>
                    <?=$i?>
                    <?=$html->link('(+)', '/depurador_planes/add_plan/'.$instit['Instit']['id'].'/'.$i, array('onclick' => 'return CrearPlan(this)'))?>
                    </th>
                <?php } ?>
                </tr>

                <?php
                foreach ($instit['Plan'] as $plan) {
                ?>
                <tr class="tr_plan" id="plan_<?=$plan['id']?>">
                    <script type="text/javascript">RenderPlan(<?=$plan['id']?>, <?=$plan['estructura_plan_id']?>);</script>
                </tr>
                <?php } ?>

            </table>
        </div>
    </div>

   
