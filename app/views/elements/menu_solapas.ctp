<?php

/**
 *  me renderiza el menu con tabs
 * 
 *  @var array $elementos
 *          OPCIONES POSIBLES
 *              string 'nombre' = 'nombre' del elemento
 *              string 'link'   = link del elemento es una url de cake
 *              array  'options'= opciones para el TAG, puede ser 'class', 'style', etc etc etc
 *              boolean activa  =  si existe este KEY lo toma como true
 *
 *
 */

if (empty($elementos)) {
    debug("Hay que pasarle parametros al menu");
}

?>

<div class="tabs-list no-imprimir">
    <?php
    foreach ($elementos as $e) {
        // marco la pestaña activa segun la pagina donde estoy ahora
        $claseActiva = 'tab-grande-inactiva';
        if (strtolower($e['link']['controller']) == strtolower($this->params['controller'])
                &&
            strtolower($e['link']['action']) == strtolower($this->params['action'])
            ){
            $claseActiva = 'tab-grande-activa';
        }

        $options = array();
        if (!empty($e['options'])){
            $options = $e['options'];
        }

        // agrego la claseActiva a las opciones
        if (!empty($options['class'])) {
            // si me vino el options cargado con clase CONCATENO
            $options['class'] = $claseActiva. " " .$options['class'];
        } else {
            // si no habia class en el options, entonces meto directo
            $options['class'] = $claseActiva;
        }
        
        echo $html->tag('span',
                $html->link($e['nombre'],$e['link']),
                   $options
                    );

    }
    ?>
</div>