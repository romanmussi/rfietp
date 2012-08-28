<div class="titulos index"> 
<h1><?php __('Búsqueda de Títulos de Referencia');?></h1>
<?php
echo $javascript->link(array(
            'jquery.autocomplete',
            'jquery.loadmask.min',
            'jquery-ui-1.8.5.custom.min',
            'views/titulos/search_form'
        ));
echo $html->css(array('jquery.loadmask', 'smoothness/jquery-ui-1.8.6.custom'));
?>
<?php 
        echo $form->create('Titulo', array(
            'action' => 'ajax_index_search',
            'name'=>'TituloSearchForm',
            'id' =>'TituloSearchForm',
            )
        );

        echo $form->input(
        'oferta_id',
        array(
            'div'=>array('style'=>'width:200px;float:left;clear:none;'),
            'class' => 'autosubmit',
            'label'=> 'Oferta',
            'id' => 'ofertaId',
            'empty' => 'Todas',
            ));

        $meter = '<span class="ajax_update" id="ajax_indicator" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
        echo $form->input('sector_id', array(
            'div'=>array('style'=>'width:200px;float:left;clear:none;'),
            'class' => 'autosubmit',
            'type'=>'select','empty'=>'Todos','options'=>$sectores,'label'=>'Sector','id'=>'sectorId','after'=>$meter)
        );
        echo $form->input('subsector_id', array(
            'div'=>array('style'=>'width:200px;float:left;clear:none;'),
            'class' => 'autosubmit',
            'empty' => 'Todos','type'=>'select','label'=>'Subsector', 'id'=>'subsectorId','after'=> $meter)
        );

        echo $ajax->observeField('sectorId',
                                   array(  	'url' => '/subsectores/ajax_select_subsector_form_por_sector',
		                                   	'update'=>'subsectorId',
		                                   	'loading'=>'jQuery("#ajax_indicator").show();jQuery("#subsectorId").attr("disabled","disabled")',
		                                   	'complete'=>'jQuery("#ajax_indicator").hide();jQuery("#subsectorId").removeAttr("disabled")',
		                                   	'onChange'=>true
                                   ));

        echo $form->input(
        'tituloName',
        array(
            'label'=> 'Nombre del Título de Referencia',
            'id' => 'TituloName',
            'style'=>'width: 450px; clear:none; float:left;',
            ));

        echo $form->button('Limpiar búsqueda', array(
                'class' => 'boton-buscar',
                'style' => 'clear:both; float:left; width:130px;',
                'onclick' => 'location.href="'.$html->url("index").'/limpiar:1"',
         ));

        echo $form->input('bysession', array('type'=>'hidden', 'value'=>$bySession));
        echo $form->input('busquedanueva', array('type'=>'hidden', 'value'=>'1'));
        /*echo $form->button('Fusionar Títulos', array(
                'id' => 'fusion',
                'class' => 'boton-buscar',
                'style' => 'clear:none; float:right; width:130px;',
                'onclick' => 'this.href="'.$html->url("fusionar").'"; return (fusionarTitulos(this))',
                'disabled' => true
         ));*/

        echo $form->end();
?>

<!-- Aca se muestran los resultados de la busqueda-->
<div id='consoleResultWrapper'  style="clear:both; margin-top: 20px;">
    <div id='consoleResult' style="min-height: 200px; margin-bottom: 20px;">

    </div>
</div>

</div>

<div class="acl actions acl-editores acl-desarrolladores acl-administradores">
	<ul>
		<li><?php echo $html->link(__('Nuevo Título', true), array('action'=>'add')); ?></li>
	</ul>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
    <?php
    if ($bySession) {
    ?>
        jQuery("#TituloSearchForm").submit();
    <?php
    }
    ?>
});
</script>