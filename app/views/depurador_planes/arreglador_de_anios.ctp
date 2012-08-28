<?php
$ids_de_anios = array_keys($estructura_planes_anios);

if (!empty($plan['EstructuraPlan']['id'])) {

    echo $form->create('Anio', array('url'=>'/depurador_planes/arregladorDeAnios/'.$plan['Plan']['id']));

    ?>
    <hr>
    <h3 style='text-align: center'>Estructura del plan: <?=$plan['EstructuraPlan']['name']?></h3>
    <div id='arregladorAnios'>
    <?php
    $i = 0;
    foreach ($anios as $a) {
        echo "<div style='padding-bottom: 0.5em;'>";

        echo $a['id']."* Dato actual: <b>".$a['anio']."º ".$a['Etapa']['name']."";
        echo " (matrícula: ".$a['matricula'].")</b>";
        echo "<br>";
        echo $form->hidden($i.'.id', array('value'=>$a['id']));
        echo $form->hidden($i.'.ciclo_id', array('value'=>$a['ciclo_id']));

        // armo el input de la estructura con sugerencia
        $asug = null;
        $label = 'Nuevo Año ';
        if (!empty($ids_de_anios)) {
            $asug = array_shift($ids_de_anios);
            $label = 'Nuevo Año <b style="color:red; font-size: 7pt;">*** SUGERIDO ***</b> ';
        }
        echo $form->input($i.'.estructura_planes_anio_id', array(
        'label'=>$label,
        'options'=>$estructura_planes_anios,
        'default' => $asug,
        'style' => 'font-size: 9pt; margin:0px; padding: 0px;',
        ));

        echo '<div>Plan: ';
        echo $form->input($i.'.plan_id', array(
            'div' => false,
            'label' => false,
            'default' => $plan['Plan']['id'],
            'style' => 'font-size: 8pt;',
            ));
        echo '</div>';

        echo "</div>";
        echo "<hr>";

        $i++;

    }
        ?>
        <div style='text-align:center; padding-top:4px;'>
        <?php $form->hidden('ciclo_id', array('value'=>$a['id'])); ?>
        <?php echo $form->end('Guardar'); ?>
        </div>
    </div>
<?php
}

else {
    ?>
    <br>
    <p>
    <h1 class="message">No se pueden editar los años si aún no le seleccionó una estructura al Plan</h1>
    </p>
    <br>
<?php
}

?>
