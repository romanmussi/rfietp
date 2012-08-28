<?php
$menus = array(
    array(
        'nombre' => 'Búsqueda Rápida',
        'link'=> array('controller'=>'Instits', 'action'=>'search_form'),
    ),
    array(
        'nombre'=> 'Búsqueda Avanzada',
        'link'=> array('controller'=>'Instits', 'action'=>'advanced_search_form'),
    )
);
echo $this->element('menu_solapas',array('elementos'=>$menus));