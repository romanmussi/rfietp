
<?
/* @var $form FormHelper */

/* @var $javascript JavascriptHelper */
$javascript;


echo $javascript->link(array(
    'jquery.loadmask.min',
    'views/instits/search_form',
        ), false);

echo $html->css(array('jquery.loadmask', 'smoothness/jquery-ui-1.8.6.custom'));
?>

<h1><? __('Búsqueda de Instituciones')?></h1>
<br>
<div>
    <?php
    echo $form->create('Instit', array(
        'action' => 'search',
        'name'=>'InstitSearchForm',
        'id' =>'InstitSearchForm',
        )
    );

    echo $form->hidden('form_name',array('value'=>'buscador rapido'));

    echo $form->input('jurisdiccion_id',array(
            'label'=> 'Jurisdicción',
            'empty'=> 'Todas',
            'style' => 'width: 371px; height: 21px;',
            'div'  => array('style' => 'float:left; clear: none;'),
            'after' => '<cite>Filtro opcional. Si no selecciona una Jurisdicción se realizará una búsqueda en todo el Registro.</cite>'
            ));

    echo $form->input('busqueda_libre', array(
            'id'=>'InstitCue',
            'div' => array('style' => 'width:400px; float:left;'),
         //   'style'=>'border:1px solid #BBBBBB; width: 99%; font-size: 22px; height: 29px; color: rgb(117, 117, 117);',
            'label'=> 'Criterios de Búsqueda'
            ));
    
//    echo $html->link('Búsqueda avanzada','advanced_search_form',array(
//        'class'=>'link_right small',
//        'style'=>'margin-bottom: -18px; padding:0px; margin-right: 4px;'
//    ));
    
    echo $form->button('Buscar', array(
                'class' => 'boton-buscar',
                'style' => 'float: left; clear: none; margin-top: 18px; width: 10%',
                'onclick' => 'autoSubmit(true)',
         ));

    echo $form->end();
    ?>
    
    <?php
    
    $img =  $html->image('help.png', array(
        'alt' => 'Ayuda: ¿Cómo utilizar el buscador?',
        'id' => 'littleHelpers',
        'style'=>'float:left;',
        ));

    ?>
    <a href="javascript: abrirVentanaAyuda()" style="float:left; margin: 22px;" title="Ayuda sobre el buscador">

    <?php
    echo $img;
    
    ?>
       <span style="margin-left: 0px;">Ayuda</span>
    </a>
    

    <?php

    echo $this->element('boxBuscadorAyuda');
    ?>
    
    

    <div class="clear"></div>
    
    <!-- Aca se muestran los resultados de la busqueda-->
    <div id='consoleResultWrapper' style="border-top: 1px solid #CEE3F6;">
        <div id='consoleResult' style="min-height: 200px; margin-bottom: 20px;"></div>
    </div>
    
</div>
