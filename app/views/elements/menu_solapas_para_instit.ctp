<?php

/**
 *  me renderiza el menu de instits con tabs
 *
 *  le tengo que pasar el $instit_id para que funcione
 *
 *
 */

if (empty($instit_id)) {
    debug("Hay que pasarle un ID de instituci�n al menu");
}

$menuOptions = array(
        array(
                'nombre'=> 'Datos B�sicos',
                'link'=> array('controller'=>'Instits','action'=>'view', $instit_id),
        ),
        array(
                'nombre'=> 'Oferta Educativa',
                'link'=> array('controller'=>'Planes','action'=>'index', $instit_id),
        ),
        array(
                'nombre'=> 'Planes de Mejora',
                'link'=> array('controller'=>'Fondos','action'=>'index_x_instit', $instit_id),
                'options'=> array(
                    'class'=>'acl acl-directores acl-administradores acl-desarrolladores acl-referentes acl-ministros acl-editores',
                    ),
        ),
);

if (!empty($ultimo_ciclo_actualizado) && !empty($instit_activo)) {
    if($instit_activo && $ultimo_ciclo_actualizado > 0 && $ultimo_ciclo_actualizado < (date('Y')-2)) { 
    ?>
        <div class="ultima_act_ciclo">
            Atenci�n: La oferta educativa de la instituci�n no ha sido actualizada desde el a�o <?php echo $ultimo_ciclo_actualizado; ?>
        </div>
    <?php
    }
}

echo $this->element('menu_solapas',array('elementos' => $menuOptions));