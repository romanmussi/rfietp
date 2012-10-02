<script type="text/javascript">
        /*
                    Este Script lo que hace es tomar la jurisdiccion en base al numero de CUE pasado
         */

        jQuery(document).ready(function () {

            if (jQuery('#InstitEtpEstadoId').val() == <?php echo ESTADO_ETP?>) {
                jQuery('#InstitModalidadId').val(<?php echo MODALIDAD_TECNICO_PROF?>);
                jQuery('#divModalidad').hide();
            }
            else if (jQuery('#InstitEtpEstadoId').val() == <?php echo ESTADO_CON_PROGRAMA_ETP?>) {
                jQuery('#divModalidad').show();
            }
            
            
            /**
             * combo de dependencia y visibilidad de nombre de 
             * la dependencia que depende de este valor
             */ 
            (function(){
                var $dependenciaId = jQuery('#InstitDependenciaId');
                
                function mostrar_ocultar_nombre_dependencia(){
                    
                    var $nombreDep = jQuery('#InstitNombreDep').parent('div');
 
                    if ( $dependenciaId.val() != <?php echo DEPENDENCIA_PROVINCIAL ?> ) {
                        $nombreDep.show();
                    } else {
                        $nombreDep.hide();
                        jQuery('#InstitNombreDep').val("");
                    }
                }
                
                $dependenciaId.change( mostrar_ocultar_nombre_dependencia );
                
                mostrar_ocultar_nombre_dependencia();
            })();
            
            
                
            jQuery('#InstitCue').change(function(){
                var cue = this.value;
                var send = false;
                var cue_jur;

                //Evaluo si concuerda con el codigo de institucion
                if (cue.match(/^(10|14|18|22|26|30|34|38|42|46|50|54|58|62|66|70|74|78|82|86|90|94)[0-9]{5}$/)){
                    jQuery('#jurisdiccion_id').val(cue.substring(0,2));
                    cue_jur= cue.substring(0,2);
                    send = true;
                }else if(cue.match(/^(2|6)[0-9]{5}$/)){
                    jQuery('#jurisdiccion_id').val(cue.substring(0,1));
                    cue_jur = cue.substring(0,1);
                    send = true;
                }

                if(send){
                    jQuery.ajax({
                          type: "POST",
                          url: '<? echo $html->url('/tipoinstits/ajax_select_form_por_jurisdiccion')?>',
                          success: function(data) {
                            jQuery('#InstitTipoinstitId').html(data);
                            jQuery("#ajax_indicator").hide();
                            jQuery("#InstitTipoinstitId").removeAttr("disabled");

                          },
                          beforeSend: function(data) {
                              jQuery("#ajax_indicator").show();
                              jQuery("#InstitTipoinstitId").attr("disabled","disabled");
                          },
                          data: "data[Instit][jurisdiccion_id]=" + cue_jur

                    });

                    jQuery.ajax({
                          type: "POST",
                          url: '<? echo $html->url('/departamentos/ajax_select_departamento_form_por_jurisdiccion')?>',
                          success: function(data) {
                            jQuery('#InstitDepartamentoId').html(data);
                            jQuery("#ajax_indicator").hide();
                            jQuery("#InstitDepartamentoId").removeAttr("disabled");

                          },
                          beforeSend: function(data) {
                              jQuery("#ajax_indicator").show();
                              jQuery("#InstitDepartamentoId").attr("disabled","disabled");
                          },
                          data: "data[Instit][jurisdiccion_id]=" + cue_jur

                    });
                }
            });
            
            jQuery('#InstitEtpEstadoId').change(function() {
                if (jQuery('#InstitEtpEstadoId').val() == <?php echo ESTADO_ETP?>) {
                    jQuery('#InstitModalidadId').val(<?php echo MODALIDAD_TECNICO_PROF?>);
                    jQuery('#divModalidad').hide();
                }
                else if (jQuery('#InstitEtpEstadoId').val() == <?php echo ESTADO_CON_PROGRAMA_ETP?>) {
                    jQuery('#divModalidad').show();
                }
            });
        });
</script>

<div id="instits-similares">
    <ul>
        <?php foreach ($similares as $s):?>
        <li><?php echo $html->link($s['Instit']['nombre_completo'],'/instits/view/'.$s['Instit']['id'],array('target'=>'_blank'))?></li>
        <?php endforeach;?>
    </ul>
</div>


<div class="instits form">
    <h1>Nueva Institución </h1>
    <?php echo $form->create('Instit');?>
    <?php
    echo $form->input('id');

    /**
     *    ACTIVO
     */
    echo $form->input('activo',array('type'=> 'checkbox','checked'=>true,'label'=>array('text'=>'Institución ingresada al RFIETP', 'class'=>'label-checkbox')));


    /**
     *    CUE
     */
    echo $form->input('cue',array(	'maxlength'=>7,
    'label'=>array('text' => 'CUE','class'=>'input_label'),
    'class'=> 'input_text_peque'
    ));

    /**
     *    ANEXO
     */
    echo $form->input('anexo',array('maxlength'=>2,
    'label'=>array('class'=>'input_label'),
    'class'=> 'input_text_peque'
    ));


    /**
     *    ES ANEXO
     */
    echo $form->input('esanexo',array('type'=> 'checkbox','label'=>array('text'=>'Es Anexo', 'class'=>'label-checkbox')));


    /**
     *    GESTION
     */
    echo $form->input('gestion_id',array('empty' => 'Seleccione', 'label'=>'Gestión','label'=>'Ámbito de Gestión'));

    /**
     *    DEPENDENCIA
     */
    echo $form->input('dependencia_id', array('label'=>'Tipo de Dependencia'));
    /**
     *    NOMBRE DE LA DEPENDENCIA
     */
    echo $form->input('nombre_dep',array('label'=>'Nombre de la Dependencia'));


    /**
     *    Estado de la institucion respecto del programa ETP
     */
    echo $form->input('etp_estado_id',array(
    'label'=>'Relación con ETP',
        'empty'=>'Seleccione Relación con ETP',
    'default' => 0 //instit de ETP
    ));
    
    /**
     *    Clase de Instituicion
     */
    echo $form->input('claseinstit_id',array(
    'label'=>'Tipo de Institución de ETP',
    'empty'=>'Seleccione una clase'
    ));
    
    /**
     *    Modalidad
     */
    echo $form->input('modalidad_id',array(
    'label'=>'Modalidad',
    'empty'=>'Seleccione una modalidad',
    'div' => array('id' => 'divModalidad')
    ));

    
     /**
     *    Orientacion
     */
    echo $form->input('orientacion_id',array(
    'label'=>'Orientación',
        'empty' => 'Seleccione Orientación',
    ));





    /**
     *   AJAX ::> JURISDICCION - Departamentop - Localidad - Tipo de Institucion
     */
    $meter = '<span class="ajax_update" id="ajax_indicator" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
    echo $form->input('jurisdiccion_id', array('empty' => array('0'=>'Todas'),'id'=>'jurisdiccion_id','label'=>'Jurisdicción','after'=>$meter));


    // DEPARTAMENTO
    $meter = '<span class="ajax_update" id="ajax_indicator_dpto" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
    echo $form->input('departamento_id', array('empty' => 'Seleccione','type'=>'select','label'=>'Departamento','after'=> $meter.'<br /><cite>Seleccione primero una jurisdicción.</cite>'));
    echo $ajax->observeField('jurisdiccion_id',
    array(  	'url' => '/departamentos/ajax_select_departamento_form_por_jurisdiccion',
    'update'=>'InstitDepartamentoId',
    'loading'=>'jQuery("#ajax_indicator").show();jQuery("#InstitDepartamentoId").attr("disabled","disabled")',
    'complete'=>'jQuery("#ajax_indicator").hide();jQuery("#InstitDepartamentoId").removeAttr("disabled")',
    'onChange'=>true
    ));



    //LOCALIDAD
    echo $form->input('localidad_id', array('empty' => 'Seleccione','label'=>'Localidad','after'=> '<br /><cite>Seleccione primero un Departamento.</cite>'));
    echo $ajax->observeField('InstitDepartamentoId',
    array(  	'url' => '/localidades/ajax_select_localidades_form_por_departamento',
    'update'=>'InstitLocalidadId',
    'loading'=>'jQuery("#ajax_indicator_dpto").show();jQuery("#InstitLocalidadId").attr("disabled","disabled")',
    'complete'=>'jQuery("#ajax_indicator_dpto").hide();jQuery("#InstitLocalidadId").removeAttr("disabled")',
    'onChange'=>true
    ));
    echo $form->input('lugar',array('label'=>'Lugar: Barrio/Pueblo/Comuna/'));

    // TIPO DE INSTITUCION
    //echo $form->input('tipoinstit_id', array('empty' => 'Todas','disabled'=>true,'type'=>'select','label'=>'Tipo De Institución','after'=> '<br /><cite>Para activar este campo, seleccione primero una jurisdicción</cite>'));
    echo $form->input('tipoinstit_id', array('empty' => 'Seleccione','label'=>'Tipo de Establecimiento','after'=> '<br /><cite>Seleccione primero una jurisdicción, así selecciona los tipos de institución posibles</cite>'));
    echo $ajax->observeField('jurisdiccion_id',
    array(  	'url' => '/tipoinstits/ajax_select_form_por_jurisdiccion',
    'update'=>'InstitTipoinstitId',
    'loading'=>'jQuery("#ajax_indicator").show();jQuery("#InstitTipoinstitId").attr("disabled","disabled")',
    'complete'=>'jQuery("#ajax_indicator").hide();jQuery("#InstitTipoinstitId").removeAttr("disabled")',
    'onChange'=>true
    ));
    ?>

    <?

    /**
     *    NOMBRE
     */
    echo $form->input('nombre');


    /**
     *    Nro Instit
     */
    echo $form->input('nroinstit',array('label'=>array(	'text'=>'Nº de Institución',
            'class'=>'input_label'),
    'class'=> 'input_text_peque'
    ));




    /**
     *    AÑO CREACION
     */
    echo $form->input('anio_creacion',array('label'=>array('text'=>'Año de Creación',
            'class'=>'input_label'),
    'class'=> 'input_text_peque'
    ));

    /**
     *    DIRECCION
     */
    echo $form->input('direccion',array('label'=>array(	'text'=> 'Domicilio',
            'class'=>'input_label'),
    'class' => 'input_text_peque'
    ));




    /**
     *    CODIGO POSTAL
     */
    echo $form->input('cp',array('label'=>array('text'=>'Código Postal','class'=>'input_label'),
    'class' => 'input_text_peque'
    ));

    /**
     *    TELEFONO
     */
    echo $form->input('telefono',array('label'=>array(	'text'=>'Teléfono',
            'class'=>'input_label'),
    'class' => 'input_text_peque'
    ));
    echo $form->input('telefono_alternativo',array('label'=>array(	'text'=>'Teléfono Alternativo',
            'class'=>'input_label'),
    'class' => 'input_text_peque'
    ));

    /**
     *    WEB Y MAIL
     */
    echo $form->input('mail',array('label'=>array('text'=> 'E-Mail',
            'class'=>'input_label'),
    'class' => 'input_text_peque'
    ));
    echo $form->input('mail_alternativo',array('label'=>array('text'=> 'E-Mail Alternativo',
            'class'=>'input_label'),
    'class' => 'input_text_peque'
    ));
    echo $form->input('web',array('label'=>array('class'=>'input_label'),
    'class' => 'input_text_peque'));




    /******************************************************************************
	* 
	* 
	*    DATOS DIRECTOR
	* 
	* 
     */
    ?><H2>Datos Director</H2><?
    echo $form->input('dir_nombre',array('label'=>array('text'=>'Nombre y Apellido',
            'class'=>'input_label'),
    'class'=>'input_text_peque'));
    echo $form->input('dir_tipodoc_id',array('label'=>'Tipo de Documento',
    'options'=>$tipoDocs,
    'empty'=>'Seleccionar'));
    echo $form->input('dir_nrodoc',array('label'=>array('text'=> 'Nº de Documento',
            'class'=>'input_label'),
    'class'=>'input_text_peque'
    ));
    echo $form->input('dir_telefono',array(	'label'=>array(	'text'=> 'Teléfono',
            'class'=>'input_label'),
    'class'=>'input_text_peque'
    ));
    echo $form->input('dir_mail',array('label'=>array(	'text'=> 'E-Mail',
            'class'=>'input_label'),
    'class'=>'input_text_peque'
    ));

    /******************************************************************************
	* 
	* 
	*    DATOS VICE DIRECTOR
	* 
	* 
     */
    ?><H2>Datos Vice Director</H2><?
    echo $form->input('vice_nombre',array('label'=>array(	'text'=> 'Nombre y Apellido',
            'class'=>'input_label'),
    'class'=>'input_text_peque'
    ));
    echo $form->input('vice_tipodoc_id',array('label'=>'Tipo de Documento',
    'options'=>$tipoDocs,
    'empty'=>'Seleccionar'));
    echo $form->input('vice_nrodoc',array('label'=>array(	'text'=> 'Nº de Documento',
            'class'=>'input_label'),
    'class'=>'input_text_peque'
    ));



    /****************************************************************************
	 *    
	 * 
	 * 
	 * 				DATOS ADICIONALES
	 * 
	 * 
     */
    ?><H2>Datos Adicionales</H2><?
    /**
     *    INGRESO/ACTUALIZACION
     */
    echo $form->input('actualizacion',array('label'=>array(	'text'=> 'Ingreso/Actualización',
            'class'=>'input_label'),
    'class'=>'input_text_peque'
    ));

    /**
     *    OBSERVACION
     */
    echo $form->input('observacion', array('label'=>'Observación'));



    /**
     *    CICLOS ALTA Y MODIFICACION
     */
    echo $form->input('ciclo_alta', array("type" => "select",
    "options" => $ciclos,'label'=>'Alta',
    "selected" => max(array_keys($ciclos))
    ));

    if($force_save) {
        //forzar al checkbox siempre
        $this->data['Instit']['force_save'] = 0;
        echo $form->input('force_save',array('type'=> 'checkbox','checked'=>false,'label'=>array('text'=>'Forzar guardado.', 'class'=>'label-checkbox')));
    }
    ?>
    <?php echo $form->end('Guardar');?>
</div>

