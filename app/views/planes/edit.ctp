<?
echo $javascript->link(array('jquery.autocomplete', 'jquery.blockUI', 'jquery.loadmask.min', 'views/planes/add', 'activespell/cpaint/cpaint2.inc.compressed.js', 'activespell/js/spell_checker'));
echo $html->css(array('jquery.autocomplete.css', 'spell_checker.css'));
?>
<script type="text/javascript">
    init("<?echo $html->url(array('controller'=>'titulos','action'=>'ajax_search'));?>", "<?echo $html->url(array('controller'=>'planes','action'=>'ajax_similars'));?>");
</script>

<h1>Editar Plan</h1>

<?
$anexo = ($instit['anexo']<10)?'0'.$instit['anexo']:$instit['anexo'];
$cue_instit = $instit['cue'].$anexo;
?>
<h2><?php echo $cue_instit." - ".$instit['nombre_completo']; ?></h2>

<div class="planes form">
    <?php echo $form->create('Plan',array('id'=>'planAdd'));?>
    <fieldset>
        <?php
        echo $form->input('id');
        echo $form->input('instit_id',array('type'=>'hidden'));

        if (empty($this->data['Anio']))
        {
            echo $form->input('oferta_id',array('empty'=>'Seleccione','onchange'=>'oferta_change();'));
        ?>
            <div id="PlanEstructura">
                <span id="selectEstructura" style="float:left">
                    <?php
                            echo $form->input('estructura_plan_id',array('empty'=>'Seleccione'));
                    ?>
                </span>
                <span id="graficosEstructura">
                    <?php if(sizeof($estructuraPlanesGrafico)  > 0){ ?>
                    <?
                            foreach($estructuraPlanesGrafico as $estructura){
                    ?>

                    <div id="timelineLimiterMini" estructura_plan_id="<?php echo $estructura['EstructuraPlan']['id']?>" class="clickeable" style="display:none">
                        <div id="timelineScroll" style="margin-left: 0px;">
                            <div>
                                <div class="event">
                                    <div class="eventHeading blue"><?php echo $estructura['EstructuraPlan']['Etapa']['name']?></div>
                                        <ul class="eventList">
                                <?php
                                $j = 0;
                                foreach($estructura['EstructuraPlan']['EstructuraPlanesAnio'] as $anio ):
                                ?>
                                    <li><?php echo $anio['alias'];?></li>
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
                    else{
                ?>
                    <div class="message">No existen estructuras asignadas a la jurisdicción</div>
                <?php }?>
                </span>
            </div>
        <?php
        }
        else {
            echo $form->input('oferta_id_aux',array('type'=>'select', 'empty'=>$this->data['Oferta']['name'], 'label'=>'Oferta', 'disabled'=>true));
            echo $form->input('oferta_id',array('type'=>'hidden'));
            ?>
            <div id="PlanEstructura">
            <?php
                echo $form->input('estructura_plan_id',array('disabled'=>true));
            ?>
            </div>
            <?php
        }
        
        echo $ajax->observeField(
                'PlanOfertaId',
                array(
                    'update'=> 'PlanTituloId',
                    'url'=>'/titulos/list_por_oferta_id',
                    'loading'=>'jQuery("#ajax_indicator").show();jQuery("#PlanTituloId").attr("disabled","disabled")',
                    'complete'=>'jQuery("#ajax_indicator").hide();jQuery("#PlanTituloId").removeAttr("disabled")',
                    'onChange'=>true)
                     );
                
        echo $form->input('norma',array('label'=>'Normativa'));

        $meter = '<span class="ajax_update" id="ajax_indicator2" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
        
        echo $form->input('nombre', array('id' => 'spell_checker1',
                                                  'title' => 'spellcheck_icons',
                                                  'style' => 'width: 85%; clear: none;',
                                                  ((Configure::read('modo_linux'))? 'accesskey': '') => ($html->url('/js/activespell/').'spell_checker.php')
                                        )
                         );
        
        ?>
            
        <div id="similars" class="attention"></div>

        <?php
        echo $form->input('perfil', array('id' => 'spell_checker2',
                                                  'title' => 'spellcheck_icons',
                                                  'style' => 'width: 85%; clear: none;',
                                                  ((Configure::read('modo_linux'))? 'accesskey': '') => ($html->url('/js/activespell/').'spell_checker.php')
                                        )
                         );
        ?>
        <div id="divPlanTituloName">
            <div id="filtros_titulo" onclick="jQuery('#filtros_contenido').toggle();">
                Haga click para filtrar el titulo de referencia
            </div>
            <div id="filtros_contenido">
                <?php
                echo $form->input('sector_id',array('type'=>'select','div'=>array('style'=>'width:250px;float:left;clear:none;'),'empty'=>'Seleccione','options'=>$sectores,'label'=>'Sector','id'=>'sector_id','value'=>0));

                echo $form->input('subsector_id', array('empty' => 'Seleccione','div'=>array('style'=>'width:250px;float:left;clear:none;'),'type'=>'select','label'=>'Subsector','value'=>0));
                echo $ajax->observeField('sector_id',
                                   array(  	'url' => '/subsectores/ajax_select_subsector_form_por_sector',
                                                        'update'=>'PlanSubsectorId',
                                                        'loading'=>'jQuery("#ajax_indicator2").show();jQuery("#PlanSubsectorId").attr("disabled","disabled")',
                                                        'complete'=>'jQuery("#ajax_indicator2").hide();jQuery("#PlanSubsectorId").removeAttr("disabled")',
                                                        'onChange'=>true
                                   ));
                ?>
            </div>
            <?php
            $meter = '<span class="ajax_update" id="ajax_indicator" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
            echo $form->input(
            'tituloName',
            array(
                'label'=> 'Título de Referencia',
                'id' => 'PlanTituloName',
                'name' => 'data[Titulo][name]',
                'style'=>'max-width: 550px;',
                'value'=> $this->data['Titulo']['name'],
                'after'=> $meter.'<cite>Seleccione primero una oferta.</cite>',
                'div'=>array('id'=>'divPlanTituloName')
                ));
            echo $form->input('titulo_id',array('type'=>'hidden'));
            ?>
        </div>

        <?php  
            echo $form->input('plan_estado_id',array('label'=>'Estado'));
            echo $form->input('plan_turno_id',array('label'=>'Turno'));
        ?>

        <?php
        echo "<br>Duración:";
        echo $form->input('duracion_hs',array('label'=>' - Horas','maxlength'=>9, 'div'=>array('id'=>"div_hs")));
        //echo $form->input('duracion_semanas',array('label'=>' - Semanas','maxlength'=>9));
        echo $form->input('duracion_anios',array('label'=>' - Años','maxlength'=>9, 'div'=>array('id'=>"div_anios")));


        echo "<br>";
        /**
         *    OBSERVACION
         */
        echo $form->input('observacion');


        /**
         *    CICLOS ALTA Y MODIFICACION
         */
        echo $form->input('ciclo_alta', array(
            "type" => "select",
            "options" => $ciclos,
            'label'=>'Alta'
        ));

        ?>
    </fieldset>
    <?php echo $form->end('Guardar');?>
</div>
