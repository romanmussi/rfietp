<?
if(isset($script)) {
echo $script;
}
?>
<?php
$ganchito = $this->data['Anio']['anio'] == 1?'er':'º';
?>        
<h1 align="center"><?= "Editar Ciclo ".$this->data['Anio']['ciclo_id'] ?></h1>

<?php

/*
 * variable que viene del controlador
 * @var $trayectosDisponibles array 
 */
$trayectosDisponibles;


if (!empty($anios)  && empty($anios[0]['EstructuraPlanesAnio']['id'])){
    echo "<p class='error'>Mal Depurada la estructura, ejecute nuevamente el depurador</p>";
    echo "<p class='info'>Para ello debe volver a la  pestaña 'Oferta Educativa' y hacer click en 'Depurar Institución'</p>";
    return;
}

// me armo el array de opciones para el elemento que renderiza el recuadro de estructura
$trayectosData = array(
        'editable' => true,
        'form_action' => 'saveAll',
        'estructura' => array( // relacionado con la estructura para el encabezado
                array(
                        'title' => $trayectosDisponibles['EstructuraPlan']['name'],
                        'estructura_plan_id' => $trayectosDisponibles['EstructuraPlan']['id'],
                        'anios' => $trayectosDisponibles['EstructuraPlanesAnio'],
                )
        ),
        'ciclos' => array($ciclo_seleccionado=>$anios), // relacionado con los "datos"
);


// verificar que estè estructurado el dato
// caso contrario mando a seleccionar estructura
if (empty($trayectosDisponibles) || empty($trayectosData)) {
    ?>
    <p class="msg-atencion" style="padding: 30px 20px;">
        La estructura de la oferta no es válida.<br>
        Debe indicarla antes de agregar nuevos datos haciendo <?php echo $html->link('click aquì','/planes/edit/'.$plan_id);?>.
    </p>
    <?php
    return 1;
}


echo $this->element('planes_view_tabla_st', array('trayectosData'=>$trayectosData));
?>
