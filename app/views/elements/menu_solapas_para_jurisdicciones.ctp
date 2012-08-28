<?php

/**
 *  me renderiza el menu de Jurisdicciones con tabs
 *
 *  le tengo que pasar el $jurisdiccion_id para que funcione
 *
 *
 */


if (empty($jurisdiccion_id)) {
    debug("Hay que pasarle un ID de jurisdicción al menu");
}

$menuOptions = array(
        array(
                'nombre'=> 'Datos Básicos',
                'link'=> array('controller'=>'Jurisdicciones','action'=>'view', $jurisdiccion_id),
        ),
        array(
                'nombre'=> 'Equipo técnico',
                'link'=> array('controller'=>'Autoridades','action'=>'index_x_jurisdiccion', $jurisdiccion_id),
                'options' => array(
                    'class'=>'',
                    )
        ),
        array(
                'nombre'=> 'Planes de Mejora',
                'link'=> array('controller'=>'Fondos','action'=>'index_x_jurisdiccion', $jurisdiccion_id),
                'options' => array(
                    'class'=>'acl acl-directores acl-administradores acl-desarrolladores acl-referentes acl-ministros',
                    )
        ),

);

echo $this->element('menu_solapas',array('elementos' => $menuOptions));