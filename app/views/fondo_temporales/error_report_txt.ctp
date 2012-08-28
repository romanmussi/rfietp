<div class="fondo_temporales form">
<?php echo $form->create('FondoTemporal', array('name'=>'FondoTemporal'));?>
	
    <legend><?php __('Reporte de Errores de Totales');?></legend>
    <br /><br />
    <?
    foreach ($fondos as $fondo)
    {
    ?>
        <div>
        Plan de mejora (Id: <?=$fondo['FondoTemporal']['id']?>) | Memo: <?=$fondo['FondoTemporal']['memo']?><br />
        Jurisdicción: <?=$fondo['FondoTemporal']['jurisdiccion_name']?> | Año: <?=$fondo['FondoTemporal']['anio']?> | Trimestre: <?=$fondo['FondoTemporal']['trimestre']?><br />
        Tipo de plan: <?=($fondo['FondoTemporal']['tipo']=='i'?'Institucional':'Juridisccional')?><br />

        <?
        if ($fondo['FondoTemporal']['tipo'] == 'i')
        { ?>
            CUE: <?=$fondo['FondoTemporal']['cuecompleto']?><br />
            Institución: <?=$fondo['FondoTemporal']['instit_name']?><br />
        <? } ?>
        <?
        if (@$this->passedArgs['obs']) { ?>
            Línea en Excel: <?=$fondo['FondoTemporal']['linea']?><br />
        <? } ?>
        </div>
            <table border="0" cellspacing="0" cellpadding="0" style="width:50%;font-size:12px;">
                <tr>
                    <td style="text-align:left;"><b>Línea de acción</b></td>
                    <td style="text-align:right;"><b>Monto</b></td>
                </tr>
                <? if ($fondo['FondoTemporal']['f01']) { ?>
                <tr>
                    <td style="text-align:left;">F01</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f01'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f02a']) { ?>
                <tr>
                    <td style="text-align:left;">F02a</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f02a'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f02b']) { ?>
                <tr>
                    <td style="text-align:left;">F02b</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f02b'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f02c']) { ?>
                <tr>
                    <td style="text-align:left;">F02c</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f02c'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f03a']) { ?>
                <tr>
                    <td style="text-align:left;">F03a</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f03a'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f03b']) { ?>
                <tr>
                    <td style="text-align:left;">F03b</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f03b'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f04']) { ?>
                <tr>
                    <td style="text-align:left;">F04</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f04'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f05']) { ?>
                <tr>
                    <td style="text-align:left;">F05</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f05'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f06a']) { ?>
                <tr>
                    <td style="text-align:left;">F06a</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f06a'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f06b']) { ?>
                <tr>
                    <td style="text-align:left;">F06b</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f06b'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f06c']) { ?>
                <tr>
                    <td style="text-align:left;">F06c</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f06c'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f07a']) { ?>
                <tr>
                    <td style="text-align:left;">F07a</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f07a'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f07b']) { ?>
                <tr>
                    <td style="text-align:left;">F07b</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f07b'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f07c']) { ?>
                <tr>
                    <td style="text-align:left;">F07c</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f07c'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f08']) { ?>
                <tr>
                    <td style="text-align:left;">F08</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f08'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f09']) { ?>
                <tr>
                    <td style="text-align:left;">F09</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f09'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['f10']) { ?>
                <tr>
                    <td style="text-align:left;">F10</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['f10'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['equipinf']) { ?>
                <tr>
                    <td style="text-align:left;">equipinf</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['equipinf'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['refaccion']) { ?>
                <tr>
                    <td style="text-align:left;">refaccion</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['refaccion'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['aula_movil']) { ?>
                <tr>
                    <td style="text-align:left;">refaccion</td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['aula_movil'],2,",",".")?></td>
                </tr>
                <? } ?>
                <? if ($fondo['FondoTemporal']['total']) { ?>
                <tr>
                    <td style="text-align:left;"><b>Suma Líneas de Acción</b></td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['suma_lineas'],2,",",".")?></td>
                </tr>
                <tr>
                    <td style="text-align:left;"><b>Total</b></td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['total'],2,",",".")?></td>
                </tr>
                <!--
                <tr>
                    <td style="text-align:left;"><p>La suma de las lineas de acción ($<?=number_format($fondo['FondoTemporal']['suma_lineas'],2,",",".")?>) no coincide con el total ($<?=number_format($fondo['FondoTemporal']['total'],2,",",".")?>). La diferencia es de $<?=number_format($fondo['FondoTemporal']['diff'],2,",",".")?></p></td>
                </tr>-->
                <? } ?>
                <? if (@$this->passedArgs['obs']) { ?>
                <tr>
                    <td style="text-align:left;"><b>Diferencia</b></td>
                    <td style="text-align:right;"><?=number_format($fondo['FondoTemporal']['diff'],2,",",".")?></td>
                </tr>
                <? } ?>
            </table>
            <b>Problema:</b> <br/>
            <?=$fondo['FondoTemporal']['obs_problema']?><br/>
            <? if (@$this->passedArgs['obs']) { ?>
            <b>Otras fuentes de información:</b> <br/>
            Dictamen: <?=$fondo['FondoTemporal']['obs_dictamen']?> <br/>
            Protocolo: <?=$fondo['FondoTemporal']['obs_protocolo']?> <br/>
            Resolucion: <?=$fondo['FondoTemporal']['obs_resolucion']?> <br/>
            <b>Solucion:</b> <br/>
            <?=$fondo['FondoTemporal']['obs_solucion']?> <br/>
            <? } ?>
        <div>
            <br>
        Notas: <br><br><br>
        
        </div>
            <br>
        <hr>
   <?
    }
    ?>
<?php echo $form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Reporte con observaciones', true), array('controller'=>'fondo_temporales','action'=>'error_report_txt','obs'=>'1'));?></li>
        </ul>
</div>
