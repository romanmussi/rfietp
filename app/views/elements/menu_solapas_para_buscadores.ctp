<?php
$menus = array(
    array(
        'nombre' => 'B�squeda R�pida',
        'link'=> array('controller'=>'Instits', 'action'=>'search_form'),
    ),
    array(
        'nombre'=> 'B�squeda Avanzada',
        'link'=> array('controller'=>'Instits', 'action'=>'advanced_search_form'),
    )
);
echo $this->element('menu_solapas',array('elementos'=>$menus));