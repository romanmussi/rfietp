<?php //debug($queries);?>

<script type="text/javascript">
    function ver_tabla(tabla){
        switch(tabla){
            case "total":
                jQuery("#gestion-titulo").html('Ámbito de Gestión: Total');
                jQuery("#table_total").show();
                jQuery("#tab_total").removeClass('tab-grande-inactiva');
                jQuery("#tab_total").addClass('tab-grande-activa');
                jQuery("#table_privada").hide();
                jQuery("#tab_privada").removeClass('tab-grande-activa');
                jQuery("#tab_privada").addClass('tab-grande-inactiva');
                jQuery("#table_estatal").hide();
                jQuery("#tab_estatal").removeClass('tab-grande-activa');
                jQuery("#tab_estatal").addClass('tab-grande-inactiva');
                break;
            case "privada":
                jQuery("#gestion-titulo").html('Ámbito de Gestión: Privada');
                jQuery("#table_total").hide();
                jQuery("#tab_total").removeClass('tab-grande-activa');
                jQuery("#tab_total").addClass('tab-grande-inactiva');
                jQuery("#table_privada").show();
                jQuery("#tab_privada").removeClass('tab-grande-inactiva');
                jQuery("#tab_privada").addClass('tab-grande-activa');
                jQuery("#table_estatal").hide();
                jQuery("#tab_estatal").removeClass('tab-grande-activa');
                jQuery("#tab_estatal").addClass('tab-grande-inactiva');
                break;
            case "estatal":
                jQuery("#gestion-titulo").html('Ámbito de Gestión: Estatal');
                jQuery("#table_total").hide();
                jQuery("#tab_total").removeClass('tab-grande-activa');
                jQuery("#tab_total").addClass('tab-grande-inactiva');
                jQuery("#table_privada").hide();
                jQuery("#tab_privada").removeClass('tab-grande-activa');
                jQuery("#tab_privada").addClass('tab-grande-inactiva');
                jQuery("#table_estatal").show();
                jQuery("#tab_estatal").removeClass('tab-grande-inactiva');
                jQuery("#tab_estatal").addClass('tab-grande-activa');
                break;
            default:
                ver_tabla('total');
                break;
        }
    }

    //Event.observe(window,'load', ver_tabla);
</script>

<style type="txt/css">
    /* ESTO ES PARA QUE NO ME IMPRIMA EL ENCABEZADO CUANDO MANDO A IMPRIMIR*/
    @media print
    {
        #header {
            display: none;
        }
    }
</style>


<div class="ver-solo-para-imprimir logos-header">
    <?php echo $html->image('logo_me_09.JPG',array('style'=>'float:left; height:86px; width:212px;'));?>
    <?php echo $html->image('logoinet1.gif',array('style'=>'float:right; height:98px; width:167px;'));?>
</div>


<h2  align="center" style="clear:both;">
		Total de Instituciones de Educación Técnica Profesional ingresadas a la Base de Datos 
		del Registro Federal de Instituciones de Educación Técnica Profesional (RFIETP) 
		por ámbito de gestión y tipo de institución de ETP según división político-territorial.
</h2>

<div class="tabs-list no-imprimir">
    <span id="tab_estatal" 	class="tab-grande-inactiva"><a href="javascript:void(null);" onclick="ver_tabla('estatal');">Gestión Estatal</a></span>
    <span id="tab_privada" 	class="tab-grande-inactiva"><a href="javascript:void(null);" onclick="ver_tabla('privada');">Gestión Privada</a></span>
    <span id="tab_total" 	class="tab-grande-activa"><a href="javascript:void(null);" onclick="ver_tabla('total');">Total</a></span>
</div>



<!-- ******************* Desde aca JS ******************* -->
<!-- ***************** las tres tablas ******************  -->	
<!-- ******************* Div estatal ******************* -->

<table width="90%" cellpadding = "0" cellspacing = "0" 
       summary="Total de Instituciones de Educación Técnica Profesional ingresadas a la Base de Datos del Registro Federal de Instituciones de Educación Técnica Profesional (RFIETP) por ámbito de gestión y tipo de institución de ETP según división político-territorial."
       style="border-left: 1px solid silver;">
    
    <thead>
        <tr>
            <th colspan="6" class="head_select" align="center"><br /><span id="gestion-titulo">Ámbito de Gestión: Total</span></th>
        </tr>

        <tr>
            <th rowspan="2" class="head_select" width="30%" align="center">División <br />político-territorial</th>
            <th colspan="4" class="head_select" width="60%" align="center">Tipo de Institución</th>
            <th rowspan="2" class="head_select" width="10%" align="center">Total</th>
        </tr>

        <tr>
            <th width="10%" class="head_select" align="center">Secundario</th>
            <th width="10%" class="head_select" align="center">Superior</th>
            <th width="10%" class="head_select" align="center">Formación Profesional</th>
            <th width="10%" class="head_select" align="center">Inst. con<br />Programa<br />de ETP</th>
        </tr>
    </thead>




    <!--      ESTATAL 					-->
    <!--      ESTATAL 					-->
    <!--      ESTATAL 					-->

    <tbody id="table_estatal" style="display: none;">

        <?php
        $i = 0;
        foreach ($queries as $query):
            $class = '';
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }

            $style = ($query[0]['División político-territorial']== 'Total')?' style="background-color: #fff; color: #233e87; font-weight: bolder; border-top: 1px solid silver;':'style="';
            ?>
        <tr<?php echo $class;?>>
                <?php foreach($query[0] as $head=>$line):
                    $style = $style." border-right: solid silver 1px; border-bottom: solid silver 1px;  ";
                    if($head == 'División político-territorial') {
                        $style1 = $style.'text-align:left;"';
                        ?>
            <td <?php echo $style1?>>
                            <?php echo (is_numeric($line))?number_format($line, 0, ',', '.'):$line; ?>
            </td>

                        <?php
                    } else {
                        $style1 = $style.'text-align:right;"';
                        if(substr_count($head, 'estatal')>0) {
                            ?>
            <td <?php echo $style1?>>
                                <?php echo (is_numeric($line))?number_format($line, 0, ',', '.'):$line; ?>
            </td>
                            <?php
                        }
                    }
                    ?>
                <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>




    <!--      PRIVADA 					-->
    <!--      PRIVADA 					-->
    <!--      PRIVADA 					-->
    <tbody id="table_privada" style="display: none">
        <!--
        <tr class="altrow2">
        <?php foreach ($precols as $key=>$precol):
            $colspan = ($key==1)? "colspan=2":"";
            ?>
                        <th <?php echo $colspan;?>><?php echo $precol;?></th>
        <?php endforeach; ?>
        </tr>
        <tr class="altrow2">
        <?php foreach ($cols as $col): ?>
                <th><?php echo $col;?></th>
        <?php endforeach; ?>
        </tr>
        -->

        <?php
        $i = 0;
        foreach ($queries as $query):
            $class = '';
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <?php
            $style = ($query[0]['División político-territorial']== 'Total')?' style="background-color: #fff; color: #233e87; font-weight: bolder; border-top: 1px solid silver;':'style="';
            ?>
        <tr<?php echo $class;?>>
                <?php foreach($query[0] as $head=>$line):
                    $style = $style." border-right: solid silver 1px; border-bottom: solid silver 1px;  ";
                    if($head == 'División político-territorial') {
                        $style1 = $style.'text-align:left;"';
                        ?>

            <td <?php echo $style1?>>
                            <?php echo (is_numeric($line))?number_format($line, 0, ',', '.'):$line; ?>
            </td>

                        <?php
                    } else {
                        $style1 = $style.'text-align:right;"';
                        if(substr_count($head, 'privada')>0) {
                            ?>
            <td <?php echo $style1?>>
                                <?php echo (is_numeric($line))?number_format($line, 0, ',', '.'):$line; ?>
            </td>
                            <?php
                        }
                    }
                    ?>
                <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>




    <!--      TOTAL 					-->
    <!--      TOTAL 					-->
    <!--      TOTAL 					-->
    <tbody id="table_total">
        <!--
        <tr class="altrow2">
        <?php foreach ($precols as $key=>$precol):
            $colspan = ($key==1)? "colspan=2":"";
            ?>
                        <th <?php echo $colspan;?>><?php echo $precol;?></th>
        <?php endforeach; ?>
        </tr>
        <tr class="altrow2">
        <?php foreach ($cols as $col): ?>
                <th><?php echo $col;?></th>
        <?php endforeach; ?>
        </tr>
        -->

        <?php
        $i = 0;
        foreach ($queries as $query):
            $class = '';
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }

            $style = ($query[0]['División político-territorial']== 'Total')?' style="background-color: #fff; color: #233e87; font-weight: bolder; border-top: 1px solid silver;':'style="';
            ?>
        <tr<?php echo $class;?>>
                <?php foreach($query[0] as $head=>$line):
                    $style = $style." border-right: solid silver 1px; border-bottom: solid silver 1px;  ";
                    if($head == 'División político-territorial') {
                        $style1 = $style.'text-align:left;"';
                        ?>

            <td <?php echo $style1?>>
                            <?php echo (is_numeric($line))?number_format($line, 0, ',', '.'):$line; ?>
            </td>

                        <?php
                    } else {
                        $style1 = $style.'text-align:right;"';
                        if(substr_count($head, 'total')>0) {
                            ?>
            <td <?php echo $style1?>>
                                <?php echo (is_numeric($line))?number_format($line, 0, ',', '.'):$line; ?>
            </td>
                            <?php
                        }
                    }
                    ?>
                <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>

</table><!-- FIN TABLA DE DATOS -->



<div style="float:left;" align="justify">
    <p style="font-size: 9pt;"><u>Fuente</u>:
		INET-Ministerio de Educación. Unidad de información - 
		Área Registro Federal de Instituciones de Educación Profesional. 
		Información al <?php echo date("d-m-Y");?>
    </p>


    <p  style="font-size: 9pt;"><u>Nota</u>:
		Existen instituciones que brindan más de una oferta educativa. En estos casos se clasificaron según sus características institucionales.
        <!-- Se incluyeron de forma diferenciada a las instituciones de ETP dependientes de Universidad Nacionales. -->
    </p>

    <p style="text-align:center;display:block;margin-left:198px; float:left;">
        <a href="javascript:print();" class="btn-imprimir no-ver-para-imprimir ">Imprimir</a>
        <?php //echo $html->link("Descargar", "/queries/contruye_excel/27", array("class"=>"btn-excel no-ver-para-imprimi"));?>
    </p>
</div>