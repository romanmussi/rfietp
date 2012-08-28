
<?php
// Inicio del HTML a mostrar
echo $html->css('element_sectec_trayectos','stylesheet', array('media'=>'screen'));

if (empty($estructura) || empty($anios) || empty($etapa)) {
    debug("la variable estructura es necesaria para generar la maqueta de la estructura de éste elemento.");
}

if (empty($i)) {
    $i = 0;
}
?>

<?php echo $html->link(__($estructura['name'], true), '/estructura_planes/edit/'.$estructura['id']); ?>
<div id="timelineLimiter" class="clickeable <?php echo (isset($asignado) && $asignado)?'green':''?>">
    <div id="timelineScroll" style="margin-left: 0px;">
        <span style="width:55px;display:inline;float:left;margin-top:7px">Edades:</span>
        <ul class="edadesList">
            <?php
            $j = 0;
            foreach($anios as $anio ):
            ?>
                <li><?php echo $anio['edad_teorica'];?></li>
            <?php
            endforeach;
            ?>
        </ul>
        <div class="events">
            <div class="event">
                <div class="eventHeading blue"><?php echo $etapa['name']?></div>
                    <ul class="eventList">
            <?php
            $j = 0;
            foreach($anios as $anio ):
            ?>
                <li><?php echo $anio['nro_anio'];?>º</li>
            <?php
            endforeach;
            ?>
                    </ul>
            </div>
            <div class="instit_link_list" style="clear:none">
                <?php
                if(isset($asignado)){
                    if($asignado){
                        echo $form->checkbox('asignado',array('name'=>'data[JurisdiccionesEstructuraPlan]['. $i . '][asignado]','checked'=>'checked'));
                    }
                    else{
                        echo $form->checkbox('asignado',array('name'=>'data[JurisdiccionesEstructuraPlan]['. $i . '][asignado]'));
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>




