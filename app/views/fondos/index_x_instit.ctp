<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('A[href="#notas"]').click(function(){
             // scrollear hasta el div
            var destination = jQuery('#notas').offset().top;
            jQuery("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination-20});
            return false;
        });
    });
       
</script>

<?php
    echo $javascript->link('zeroclipboard/ZeroClipboard.js');
    
    $descripcionPlural = "Se presenta información sobre %u Planes de Mejora institucionales aprobados por un total de $%s. <br/>" .
                         "Período: 2006-1° semestre de 2013. <br/>".
                         "Para mayor información consulte las <a href='#notas'>notas metodológicas</a> al final de la página. <br/>";

    $descripcionSingular = "Se presenta información sobre 1 Plan de Mejora institucional aprobado por un total de $%s. <br/>" .
                           "Período: 2006-1° semestre de 2013. <br/>".
                           "Para mayor información consulte las <a href='#notas'>notas metodológicas</a> al final de la página. <br/>";

    define("DESCRIPCION_PLURAL", $descripcionPlural);
    define("DESCRIPCION_SINGULAR", $descripcionSingular);

?>
<div class="fondos index">
   <div id="escuela_estado" class="<? echo $instit['Instit']['activo']? 'instit_activa':'instit_inactiva';?>"><? echo $instit['Instit']['activo']? 'Institución Ingresada al RFIETP':'Institución NO Ingresada al RFIETP';?></div>
    <?
    $cue_instit = ($instit['Instit']['cue']*100)+$instit['Instit']['anexo'];
    ?>
    <h2><?= $cue_instit ?> - <?= $instit['Instit']['nombre_completo']?></h2>

    <div class="tabs">
            <?php
                echo $this->element('menu_solapas_para_instit',array('instit_id' => $instit['Instit']['id']));
            ?>

            <div id="d_clip_button" class="my_clip_button2"></div>
            <input id="infoToCopy" type="hidden" value="<?= ($instit['Instit']['cue']*100)+$instit['Instit']['anexo'] . ' - ' . $instit['Instit']['nombre_completo'] . ' - ' . $instit['Instit']['direccion'] . ' - ' . $instit['Departamento']['name'] . ' - ' . $instit['Localidad']['name'] ?> "/>
            
            <div class="tabs-content">

                <h2>Listado de Planes de Mejora</h2>
                <?php
                if($paginator->counter(array('format' => __('%count%', true))) == 1){
                ?>
                    <p><?php echo sprintf(DESCRIPCION_SINGULAR,number_format($sumalineas,2,",",".")); ?></p>
                <?php
                }
                ?>
                <?php
                if($paginator->counter(array('format' => __('%count%', true))) > 1){
                ?>
                    <p><?php echo sprintf(DESCRIPCION_PLURAL, $paginator->counter(array('format' => __('%count%', true))),number_format($sumalineas,2,",",".")); ?></p>
                <?php
                }
                ?>
                <ul style="padding-top: 20px" class="lista_fondos">
                <?php
                if(empty($fondos)){
                ?>
                    <p class='msg-atencion'>La Instituci&oacute;n no ha recibido planes de mejora</p>
                <?php
                }
                $i = 0;
                foreach ($fondos as $fondo):
                ?>
                     <li class="item_fondos" STYLE="padding-right: 0px;">
                        <div class="header">
                            <dt><?php echo $fondo['Fondo']['anio'];?> - <?php echo $fondo['Fondo']['trimestre']; ?>º Trimestre </dt>
                        </div>
                        <dl>
                            <dt></dt>
                            <dt>Memo:  <?php echo $fondo['Fondo']['memo']; ?></dt>
                        </dl>

                         <h2 style="padding-left: 15px">Líneas de Acción</h2>
                        <div class="collapsibleContainer">
                            <dl>
                            <?php
                                foreach ($fondo['LineasDeAccion'] as $linea):
                            ?>
                                <dt onmouseover="jQuery(this).toggleClass('item_fondos_seleccionado')"
                                    onmouseout="jQuery(this).toggleClass('item_fondos_seleccionado')">
                                    <?=$linea['description']?><? if (strlen($fondo['Fondo']['obs'])) { 
                                        echo " - <b>".$fondo['Fondo']['obs']."</b>"; } ?>
                                </dt>
                                <dd>$ <?=number_format($linea['FondosLineasDeAccion']['monto'],2,",",".");?></dd>
                            <?php endforeach; ?>
                                <dt>&nbsp;</dt>
                            </dl>
                        </div>
                        <div class="total">
                            Total $ <?php echo number_format($fondo['Fondo']['total'],2,",","."); ?>
                        </div>
                     </li>
                <?php endforeach; ?>
                </ul>
                <div class="acl actions acl-desarrolladores">
                    <ul>
                        <li><?php echo $html->link(__('Agregar Plan de Mejora', true), array('action'=>'add', 'instit_id'=>$instit['Instit']['id'])); ?> </li>
                    </ul>
                </div>
                    
                <div class="clear"></div>


                <?php
                if(!empty($fondos)){
                ?>
                    <div id="notas" style="font-size:8pt; font-style: italic; padding-top: 30px; margin-bottom: 30px">
                        <h3>Notas Metodológicas</h3>
                        <ul>
                            <li>
                                La información publicada corresponde a Planes de Mejora aprobados desde el año 2006 al 1° semestre de 2013 inclusive. La información será actualizada periódicamente.
                            </li>
                            <li>
                                Los Planes de Mejora correspondientes a Formularios F04A y F04B se presentan unificados bajo la línea de acción "F04 - Prácticas profesionalizantes".
                            </li>
                            <li>
                                Los Planes de Mejora correspondientes a Formularios F05A, F05B y F05C se presentan unificados bajo la línea de acción "F05 - Equipamiento de talleres, laboratorios y espacios productivos".
                            </li>
                            <li>
                                En algunos Planes de Mejora la suma de líneas de acción no coincide exactamente con el total por razones de redondeo o ajustes menores.
                            </li>
                            <li>
                                El listado anterior no incluye fondos recibidos por la Institución a través de Planes de Mejora jurisdiccionales, con la única excepción de la línea de acción Apoyo al Programa "Una computadora para cada alumno". Los planes jurisdiccionales pueden consultarse haciendo <?php echo $html->link(__('Click Aquí', true), array('controller'=>'jurisdicciones','action' => 'listado')); ?>.
                            </li>
                        </ul>
                    </div>
                <?php
                }
                ?>
           </div>
    </div>

</div>


<script language="JavaScript" type="text/javascript" defer="defer">
    jQuery(document).ready(function(){
        var clip = new ZeroClipboard.Client();

        ZeroClipboard.setMoviePath('<?php echo $html->url("/js/zeroclipboard/ZeroClipboard10.swf"); ?>');

        clip.setText( '' ); // will be set later on mouseDown
        clip.setHandCursor( true );
        clip.addEventListener( 'mouseDown', function(client) {
           client.setText(jQuery("#infoToCopy").val());
        } );

        clip.glue( 'd_clip_button' );
    })
</script>
