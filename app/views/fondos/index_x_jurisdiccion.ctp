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

    $descripcionPlural = "Se presenta informaci�n sobre %u Planes de Mejora juridiccionales aprobados por un total de $%s. <br/>" .
                         "Per�odo: 2006-2011. <br/>".
                         "Para mayor informaci�n consulte las <a href='#notas'>notas metodol�gicas</a> al final de la p�gina. <br/>";

    $descripcionSingular = "Se presenta informaci�n sobre 1 Plan de Mejora juridiccional aprobado por un total de $%s. <br/>" .
                           "Per�odo: 2006-2011. <br/>".
                           "Para mayor informaci�n consulte las <a href='#notas'>notas metodol�gicas</a> al final de la p�gina. <br/>";

    define("DESCRIPCION_PLURAL", $descripcionPlural);
    define("DESCRIPCION_SINGULAR", $descripcionSingular);
?>
<div class="fondos index">
   <br /><br />
   <h1><?= $jurisdiccion['Jurisdiccion']['name']?></h1>

    <div class="tabs">
            <?php echo $this->element('menu_solapas_para_jurisdicciones', array('jurisdiccion_id' => $jurisdiccion['Jurisdiccion']['id'])); ?>
        
            <div class="tabs-content">

                <h2>Listado de Planes de Mejora</h2>
                <?php
                if($paginator->counter(array('format' => __('%count%', true))) == 1){
                ?>
                <p><?php echo sprintf(DESCRIPCION_SINGULAR ,number_format($sumalineas,2,",","."))?></p>
                <?php
                }
                ?>
                <?php
                if($paginator->counter(array('format' => __('%count%', true))) > 1){
                ?>
                <p><?php echo sprintf(DESCRIPCION_PLURAL, $paginator->counter(array('format' => __('%count%', true))), number_format($sumalineas,2,",","."));?></p>
                <?php
                }
                ?>
                <ul style="padding-top: 20px" class="lista_fondos">
                <?php
                if(empty($fondos)){
                ?>
                    <p class='msg-atencion'>La Jurisdicci&oacute;n no ha recibido planes de mejora</p>
                <?php
                }
                $i = 0;
                foreach ($fondos as $fondo):
                ?>
                     <li class="item_fondos" STYLE="padding-right: 0px;">
                        <div class="header">
                            <dt><?php echo $fondo['Fondo']['anio'];?> - <?php echo $fondo['Fondo']['trimestre']; ?>� Trimestre </dt>
                        </div>
                        <dl>
                            <dt></dt>
                        <dt>Memo:  <?php echo $fondo['Fondo']['memo']; ?></dt>
                        <!--<dt>Resolucion:</dt>
                        <dd><?php echo $fondo['Fondo']['resolucion']; ?></dd>
                        <dt>Descripcion:</dt>
                        <dd><?php echo $fondo['Fondo']['description']; ?></dd>
                        -->
                        </dl>

                         <h2 style="padding-left: 15px">L�neas de Acci�n</h2>
                        <div class="collapsibleContainer">
                            <dl>
                            <?php
                                foreach ($fondo['LineasDeAccion'] as $linea):
                            ?>
                                <dt onmouseover="jQuery(this).toggleClass('item_fondos_seleccionado')"
                                    onmouseout="jQuery(this).toggleClass('item_fondos_seleccionado')">
                                    <?=$linea['description']?>
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


                 <?php
                    $paginator->options(array('url' => $this->passedArgs));

                    if($paginator->numbers()){
                    ?>
                            <div style="float:left" class="paging">
                                    <?php echo $paginator->prev('<< '.__('anterior', true), array(), null, array('class'=>'disabled'));?>
                             | 	<?php echo $paginator->numbers();?>
                                    <?php echo $paginator->next(__('siguiente', true).' >>', array(), null, array('class'=>'disabled'));?>
                            </div>
                 <?php  }?>



                <div class="acl actions acl-desarrolladores">
                    <ul>
                        <li><?php echo $html->link(__('Agregar Plan de Mejora', true), array('action'=>'add', 'jurisdiccion_id'=>$fondo['Fondo']['jurisdiccion_id'])); ?> </li>
                    </ul>
                </div>

                <div class="clear"></div>
                
                <?php
                if(!empty($fondos)){
                ?>
                    <div id="notas" style="font-size:8pt; font-style: italic; margin-bottom: 30px">
                        <h3>Notas Metodol�gicas</h3>
                        <ul>
                            <li>
                                La informaci�n publicada corresponde a Planes de Mejora aprobados desde el a�o 2006 a 2011 inclusive. La informaci�n ser� actualizada peri�dicamente.
                            </li>
                            <li>
                                Los Planes de Mejora correspondientes a Formularios F04A y F04B se presentan unificados bajo la l�nea de acci�n "F04 - Pr�cticas profesionalizantes".
                            </li>
                            <li>
                                Los Planes de Mejora correspondientes a Formularios F05A, F05B y F05C se presentan unificados bajo la l�nea de acci�n "F05 - Equipamiento de talleres, laboratorios y espacios productivos".
                            </li>
                            <li>
                                En algunos Planes de Mejora la suma de l�neas de acci�n no coincide exactamente con el total por razones de redondeo o ajustes menores.
                            </li>
                            <li>
                                Los Planes de Mejora jurisdiccionales no se discriminan por instituci�n.
                            </li>
                        </ul>
                    </div>
                <?php
                }
                ?>
           </div>
    </div>
   
</div>