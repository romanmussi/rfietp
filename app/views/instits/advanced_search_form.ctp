<?
echo $javascript->link(array(
'jquery.autocomplete',
'jquery.blockUI',
'jquery.bgiframe'
));

echo $html->css('jquery.autocomplete.css', false);
?>



<script type="text/javascript" language="javascript">
    init__AdvancedSearchFormJs("<?echo $html->url(array('controller'=>'localidades','action'=>'ajax_search_localidades'));?>","<?echo $html->url(array('controller'=>'titulos','action'=>'ajax_search'));?>");
</script>

<h1><? __('Búsqueda Avanzada de Instituciones')?></h1>


<div>
    <?= $form->create('Instit',array('action' => 'search','name'=>'InstitSearchForm'));?>

    <fieldset id="search" class="search-div" >
        <legend>General</legend>

        <?php
        echo $form->input('cue', array(
        'label'=>'CUE',
        'div'=>array('style'=>'width:90px; float: left; clear: none'),
        'style'=> 'width:80px; float: left',
        'maxlength'=>9 ,
        'title'=> 'Ej: 600118 o 5000216. También puede buscar con el n° de anexo, Ej: 60011800'));

        echo $form->input('nombre_completo', array(
        'label'=>'Nombre',
        'div'=>array('style'=>'width:260px; float: left; clear: none'),
        'style'=> 'width:250px',
        'title'=> 'Realiza una búsqueda por tipo de establecimiento, número y nombre propio de la institución.<br>Ej: Escuela 3 San Martín'));

        echo $form->input('jurisdiccion_id', array(
        'label'=>'Jurisdicción',
        'div'=>array('style'=>'float: left;  clear: none; width: 175px;'),
        'class'=> 'display: block; clear: both;',
        'empty' => array('0'=>'Todas'),
        'id'=>'jurisdiccion_id'));
        echo '<span class="ajax_update" id="ajax_indicator" style="display:none; margin-top: -32px; float: right; clear: none">'.$html->image('ajax-loader.gif').'</span>';
        ?>
    </fieldset>


    <!--
				BUSQUEDA POR SU UBICACION
		-->
    <fieldset id="search-ubicacion" class="search-div" >
        <legend>Por Ubicación</legend>
        <?php echo $form->input('jur_dep_loc', array('label'=>'Departamento/Localidad', 'style'=>'width:92%;','title'=>'Ingrese al menos 3 letras para que comience la busqueda de Departamentos y Localidades.')); ?>
        <?php echo $form->input('direccion', array('label'=>'Domicilio', 'style'=>'width:92%;')); ?>
    </fieldset>


    <!--
				BUSQUEDA POR SU NOMBRE
		-->
    <fieldset id="search-denominacion"  class="search-div" >
        <legend>Por Nombre</legend>
        <?php
        echo $form->input('tipoinstit_id', array(
        'label'=>array('text'=>'Tipo','id'=>'label-tipoinstit'),
        //'div'=>false,
        'style'=> 'display:inline; width:92%;vertical-align:bottom',
        'empty' => 'Todos',
        'type'=>'select',
        'title'=> 'Para activar este campo, seleccione primero una jurisdicción'));

        echo $ajax->observeField('jurisdiccion_id',
        array('url' => '/tipoinstits/ajax_select_form_por_jurisdiccion',
        'update'=>'InstitTipoinstitId',
        'loading'=>'jQuery("#ajax_indicator").show();jQuery("#InstitTipoinstitId").attr("disabled","disabled")',
        'complete'=>'onSeleccionDeJurisdiccionDo();',
        'onChange'=>true
        ));
        ?>
        <?php
        echo $form->input('nroinstit', array(
        'label'=>'Número',
        'style'=> 'width:90px; float: left',
        'div'=>array('style'=>'float: left;  clear: none'),
        'class'=> 'display: block; clear: both;',
        'empty' => array('0'=>'Todas'),
        ));
        ?>
        <?php
        echo $form->input('nombre', array(
        'label'=>'Nombre',
        'style'=> 'width:420px; float: left',
        'div'=>array('style'=>'float: left;  clear: none'),
        'title'=> 'Ej: "Sarmiento" o "Gral. Belgrano". No confundir el nombre con el tipo de establecimiento'));
        ?>
    </fieldset>


    <!--
				BUSQUEDA POR SU OFERTA
		-->
    <fieldset id="search-planes"  class="search-div" >
        <legend>Por Oferta</legend>
        <?php
        echo $form->input('Plan.oferta_id',array(
        'options'=>$ofertas,
        'id'=>'OfertaId',
        'div'=>array('style'=>'float: left;  clear: none'),
        'style'=> 'display:inline;width:247px;vertical-align:bottom',
        'empty'=>'Seleccione',
        'label'=>'Con Oferta'));

        echo $form->input('Plan.norma',array(
        'label'=>'Normativa',
        'div'=>array('style'=>'float: left; width: 265px;  clear: none'),
        'style'=> 'display:inline;vertical-align:bottom;  width: 265px;',
        ));

        echo $form->input('SectoresTitulo.sector_id',array(
            'label'=>'Sector',
            'id'=>'SectorId',
            'div'=>array('style'=>'float: left;  clear: left'),
            'style'=> 'display:inline;width:247px;vertical-align:bottom',
            'options'=>$sectores,
            'empty'=>'Seleccione'
        ));

        echo $form->input('SectoresTitulo.subsector_id',array(
            'type' => 'select',
            'id'=>'SubsectorId',
            'label'=>'Subsector',
            'div'=>array('style'=>'float: left;  clear: none'),
            'style'=> 'display:inline;width:267px;vertical-align:bottom',
            'empty'=>'Seleccione',
        ));

        echo $ajax->observeField('SectorId',
        array('url' => '/subsectores/ajax_select_subsector_form_por_sector',
            'update'=>'SubsectorId',
            'loading'=>'jQuery("#SubsectorId").attr("disabled","disabled");',
            'complete'=>'jQuery("#SubsectorId").removeAttr("disabled");',
            'onChange'=>true
        ));
        
        echo $form->input(
        'tituloName',
        array(
            'label'=> 'Título de Referencia',
            'id' => 'PlanTituloName',
            'style'=>'max-width: 550px; width:92%;',
            //'after'=> '<cite>Seleccione primero una oferta.</cite>',
            'div'=>array('id'=>'divPlanTituloName')));
        
        echo $form->input('Plan.titulo_id',array('id'=>'PlanTituloId','type'=>'hidden'));
        
        ?>

    </fieldset>


    <!--
            BUSQUEDA POR OTRAS CARACTERISTICAS
    -->

    <fieldset id="search-otros"  class="search-div" >
        <legend>Por Otras Caracteristicas</legend>
        <?php
        echo $form->input('Instit.orientacion_id',array(
        'label'=> 'Orientación',
        'div'=>array('style'=>'float: left;  clear: none'),
        'style'=> 'display:inline;width:247px;vertical-align:bottom',
        'empty'=>'Seleccione',
        ));

        echo $form->input('Instit.claseinstit_id', array(
        'empty' => 'Todas',
        'label'=> 'Tipo de Institución de ETP',
        'div'=>array('style'=>'float: left;  clear: none'),
        'style'=> 'display:inline;width:270px;vertical-align:bottom',
        ));


        echo $form->input('Instit.etp_estado_id', array(
        'empty' => 'Todas',
        'label'=>'Relación con ETP',
        'div'=>array('style'=>'float: left; width:247px; clear: left'),
        'style'=> 'display:inline;width:247px;vertical-align:bottom',
        ));

        echo $form->input('Instit.gestion_id', array(
        'empty' => 'Todas',
        'label'=> 'Ámbito de Gestión',
        'div'=>array('style'=>'float: left; clear: none'),
        'style'=> 'display:inline;width: 270px;vertical-align:bottom',
        ));


        echo $form->input('Instit.dependencia_id', array(
        'empty' => 'Todas',
        'label'=> 'Tipo de Dependencia',
        'div'=>array('style'=>'float: left; width:247px; clear: left'),
        'style'=> 'display:inline;width:247px;vertical-align:bottom',));


        // no hay busqueda por anexo
        //$array_anexo = array('-1'=>'Buscar Todas','0'=>'No','1'=>'Si');
        //echo $form->input('esanexo',array('options'=> $array_anexo,'label'=>'Anexo'));

        $array_activa = array('-1'=>'Buscar Todas','0'=>'No','1'=>'Si');
        echo $form->input('activo',array(
        'options'=> $array_activa,
        'label'=> 'Institución Ingresada al RFIETP',
        'div'=>array('style'=>'float: left;  clear: none'),
        'style'=> 'display:inline;width:270px;vertical-align:bottom',
        ));
        ?>

    </fieldset>

    <?php echo $form->button('Buscar',array(
        'class'=>'boton-buscar',
        'style' => 'float:right; ',
        'onclick'=>'enviar()'));
    ?>
    <?php echo $form->end(); ?>

</div>