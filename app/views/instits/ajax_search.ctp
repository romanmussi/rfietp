<?php


    $paginator->options(array('update' => 'consoleResult', 'url' => $this->passedArgs,'indicator'=> 'ajax_indicator'));
    ?>
<div id="resultTitle">
    <span style="width:15%">Ordenar por:</span>
    <span style="width:85%;float: right; margin-left: -30px;">
    <ul class="lista_horizontal">
            <?
            $sort = 'cue';
            if(isset($this->passedArgs['sort'])) {
                $sort = $this->passedArgs['sort'];
            }
            ?>
            <? $class = ($sort == 'cue')?'marcada':'';?>
        <li class="<?= $class?>"><?php echo $paginator->sort('cue');?></li>

            <? $class = ($sort == 'Jurisdiccion.name')?'marcada':'';?>
        <li class="<?= $class?>"><?php echo $paginator->sort('Jurisdicción','Jurisdiccion.name');?></li>

            <? $class = ($sort == 'Departamento.name')?'marcada':'';?>
        <li class="<?= $class?>"><?php echo $paginator->sort('Departamento','Departamento.name');?></li>

            <? $class = ($sort == 'Localidad.name')?'marcada':'';?>
        <li class="<?= $class?>"><?php echo $paginator->sort('Localidad','Localidad.name');?></li>
    </ul>
    </span>
</div>


<div style="clear: both; margin-top:22px;">
    <span style="width:30%;font-size: 10pt; font-family: Verdana;"><?php echo $paginator->counter(array('format' => '<b>%count%</b> Instituciones encontradas'))?></span>
    <span style="float: right; margin-top: -4px; text-decoration: none;"><?php echo $paginator->numbers() ?> </span>
</div>


<div style="margin-top: 30px">
        <?
        if (sizeof($instits) > 0) {?>
    <ul class="listado" style="margin-left:0px;margin-right:0px">
                <?php
                foreach($instits as $instit) {
                    ?>

                    <?
                    $año_actual = date("Y");
                    $fecha_hasta = "$año_actual-07-21"; //hasta julio
                    $fecha_desde = "$año_actual-01-01"; //desde enero

                    $clase = '';
                    if($instit['Instit']['activo']) {
                        $clase .= ' escuela_activa';
                    }else {
                        $clase .= ' escuela_inactiva';
                    }
                    ?>

        <li id="lista_instit_<?= $instit['Instit']['id']?>" class="lista_link <?=$clase ?>"
            onclick="window.location='<?= $html->url(array('controller'=> 'Instits', 'action'=>'view/'.$instit['Instit']['id'])) ?>'"
            onmouseover="jQuery('#lista_instit_<?= $instit['Instit']['id']?>').addClass('lista_link_hover');"
            onmouseout="jQuery('#lista_instit_<?= $instit['Instit']['id']?>').removeClass('lista_link_hover');"
            title="<?= $instit['Instit']['nombre_completo']?>"
            href="<?= $html->url('/instits/view/'.$instit['Instit']['id'])?>"
            >
            <div class="instit_link_list">
                    <?php echo $html->link('+ Info','/instits/view/'.$instit['Instit']['id']);?>
            </div>

            <div class="instit_data_bs">
                            <?
                            //el anexo viene con 1 solo digito por lo general. Pero para leerlo siempre hay que ponerlo
                            // en formato de 2 digitos
                            $armar_anexo = ($instit['Instit']['anexo']<10)?'0'.$instit['Instit']['anexo']:$instit['Instit']['anexo'];
                            ?>
                <div class="instit_name"><b><?= "".($instit['Instit']['cue']*100)+$instit['Instit']['anexo']." - ". $instit['Instit']['nombre_completo']; ?></b></div>
                <div class="instit_atributte"><b>Domicilio: </b> <?= $instit['Instit']['direccion'] ?></div>
                <br />
                <div class="instit_atributte"><b>Gestión: </b><?= $instit['Gestion']['name'] ?></div>
                <div class="instit_atributte"><b>Jurisdicción: </b> <?= $instit['Jurisdiccion']['name'] ?></div>
                <br />
                <div class="instit_atributte"><b>Departamento: </b><?= $instit['Departamento']['name'] ?></div>
                <div class="instit_atributte"><b>Localidad: </b><?= $instit['Localidad']['name'] ?></div>
            </div>

        </li>

                    <?
                }
                ?>
    </ul>

            <?
        }
        ?>
    <div style="float:right; display:block;margin-bottom: 10px">
            <?php
            echo $paginator->numbers();
            ?>
    </div>
</div>

<p style="margin-top: 20px;">
        <? echo $html->image('/css/images/puntoverde.gif',array('title'=>'Ingresados a la Base de Datos')); ?>
    - Institución ingresada al RFIETP<br />
        <? echo $html->image('/css/images/puntorojo.gif',array('title'=>'NO Ingresados a la Base de Datos')); ?>
    - Institución NO ingresada al RFIETP
</p>
