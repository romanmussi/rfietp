<?php
/**
 *
 *  Este elemento genera una tabla toda hecha en CSS que muestra la estructura
 *  de un Ciclo, Oferta, o Plan.
 *
 *
 *  es necesario pasarle un array con la siguiente forma:
 *
 *  $trayectosData['editable'] si esta en "true" hace que los valores:
 *                             matricula, secciones y hs taller sean editables
 *
 *   $trayectosData['form_action'] es el action a donde va a submitear el form
 *
 *  string $trayectosData['nombre_etapa']
 *      Nombre del ciclo a renderizar
 *
 *  array  $trayectosData['estructura'] listado de etapas distintas
 *  string $trayectosData['estructura'][x]['title'] nombre de la Etapa *
 *  string $trayectosData['estructura'][x]['estructura_plan_id'] id la EtapaPlan
 *  array  $trayectosData['estructura'][x]['anios'] array de años. del tipo find all 'EstructuraPlanesAnio'
 *
 *  array $trayectosData['ciclos'][integer CICLO] nombre o numero de año. Ej: 2009,2010
 *
 *                                            [integer ANIO] listado de
 *                                                      ['matricula']
 *                                                      ['seccion']
 *                                                      ['hs_taller']
 *
 *
 *
 *
 *
 *
 *
 *    -----   Ejemplo de un array con informacion ------
 $trayectosData['anios'] = array(12,13,14,15,16);
 $trayectosData['etapa_header'] = array(
 array('title'=>'Ciclo Básico', 'anios'=>array(1,2,3)),
 array('title'=>'Ciclo Superior', 'anios'=>array(4,5)),
 );
 $trayectosData['ciclo_lectivo'] = array(
 array('title'=>2009,
 'ciclos_data'=> array(
 array(
 'matricula'=>12,
 'seccion'=>10,
 'hs_taller'=>1,
 ),
 array(
 'matricula'=>12,
 'seccion'=>10,
 'hs_taller'=>2,
 ),
 array(
 'matricula'=>12,
 'seccion'=>10,
 'hs_taller'=>3,
 ),
 array(
 'matricula'=>12,
 'seccion'=>10,
 'hs_taller'=>4,
 ),
 array(
 'matricula'=>12,
 'seccion'=>10,
 'hs_taller'=>5,
 ),
 ))
 );

 *
 *
 *
 *
 *
 *
 *
 */

////////////////////////////////////////////////////////////


$esEditable = false;
if (!empty($trayectosData['editable'])) {
    if ($trayectosData['editable']) {
        $esEditable = true;
    }
}

// Inicio del HTML a mostrar
echo $html->css('element_sectec_trayectos','stylesheet', array('media'=>'screen'));



/*****************************************
 *
 * CARGO LOS DEFAULTS
 */
if (empty($trayectosData)) {
    debug("la variable trayectosData es necesaria para generar la maqueta de la estructura de éste elemento.");
}

if (!empty($trayectosData['form_action'])) {
    $form_action = $trayectosData['form_action'];
} else {
    $form_action = 'add';
}

/*****************************************/




// lo inicializo con el ciclo actual pero sin años dato
$ciclosData = array(date('Y',strtotime('now'))=>array());
if (!empty($trayectosData['ciclos'])) {
    $ciclosData = $trayectosData['ciclos'];
}

$estructura_plan_id = $trayectosData['estructura'][0]['estructura_plan_id'];
$anios_estr = $trayectosData['estructura'][0]['anios'];



/**********************************************************************/
// VALIDACION DE ESTRUCTURA PARA EL CICLO
// 
// ciclos que tienen anios que no corresponden a la estructura del Plan
$ciclos_erroneos = array();
foreach($trayectosData['ciclos'] as $ciclo=>$anios) {
    foreach($anios as $anio) {
        if ($estructura_plan_id !=  $anio['EstructuraPlanesAnio']['estructura_plan_id']) {
            $ciclos_erroneos[] = $ciclo;
        }
    }
}

// cuando estoy dando de alta nuevos anios el ciclo no esta seleccionado por lo tanto hay que hacer esta verificacion
if (!empty($ciclo_seleccionado)) {
    // solo valido cuando se esta editando, quiero saber cual es el ciclo em el que estoy
    // y al mismo tiempo validar la estructura, (verificar que coincida con lo indicado en el plan)
    if (in_array($ciclo_seleccionado, $ciclos_erroneos)) {
        ?>
        <p class="msg-atencion" style="padding: 30px 20px;">
            La estructura "<?php echo $trayectosData['estructura'][0]['title']?>" para este ciclo no es válida.
        </p>
        <?php
        return;
    }
}
/**********************************************************************/




echo $form->create('Anio', array('action'=>$form_action));

echo $form->hidden('Info.estructura_plan_id', array('value'=>$estructura_plan_id));
echo $form->hidden('Info.plan_id', array('value'=>$plan_id));
?>
<span><?php echo $trayectosData['estructura'][0]['title']?></span>
<table border="2" cellpadding="2" cellspacing="0">
    <tr>
        <th>
            <?php
            if (!empty($ciclo_seleccionado)) {
                $attrs = array('disabled'=>true);
                $defaultVal = $ciclo_seleccionado;
                echo $form->hidden('Info.ciclo_id', array('value'=>$ciclo_seleccionado));
            } else {
                $attrs = array();
                //$defaultVal = date('Y',strtotime('now'));
                $defaultVal = max(array_keys($trayectosData['ciclos_disponibles']));
            }
            echo $form->select('Info.ciclo_id',$ciclos, $defaultVal, $attrs,false);
            ?>
        </th>
        <th>Matrícula</th>
        <th>Secciones</th>
        <th>Horas Taller</th>
    </tr>
    <?php
    $i = 0;
    $j = 0;

    //debug($ciclosData);
    //debug($anios_estr);

    // recorro los ciclos lectivos, por lo general va a haber 1 solo, sobre todo si estoy editando
    foreach ($ciclosData as $ciclo_seleccionado=>$cicloLectivoAnios) {
        // recorro la estruictura estructura_planes_anio para mostrar cada año
        foreach($anios_estr as $a) {
            $encontrado = false;
            // busco el año dato que tenga esta estructura
            foreach ($cicloLectivoAnios as $anioDato) {
                // muestro los datos para esa estructura que estoy recorriendo
                if ($a['id'] == $anioDato['Anio']['estructura_planes_anio_id']) {
                    $encontrado = true;
                    ?>
    <tr>
        <td><?php echo @$a["alias"]?></td>
                        <?php
                        echo $form->hidden($j.'.estructura_planes_anio_id',array(
                        'value'=>$anioDato['Anio']['estructura_planes_anio_id']));

                        // ver si es un ADD o un EDIT
                        if (!empty($anioDato['Anio']['id'])) {
                            echo $form->hidden($j.'.id',array(
                                'label'=>false,
                                'value'=> $anioDato['Anio']['id']));
                        }

                        echo '<td>'.$form->input($j.'.matricula',array(
                                'label'=>false,
                                'value'=>$anioDato['Anio']["matricula"]))
                                .'</td>';

                        echo '<td>'.$form->input($j.'.secciones',array(
                                'label'=>false,
                                'value'=>$anioDato['Anio']["secciones"]))
                                .'</td>';

                        echo '<td>'.$form->input($j.'.hs_taller',array(
                                'label'=>false,
                                'value'=>$anioDato['Anio']["hs_taller"]))
                                .'</td>';
                        ?>
    </tr>                        <?php
                    break;
                }
            }
            // si No hay datos para el año de la estrctura_anio, entonces lo agrego para que lo pueda editar
            if (!$encontrado) {
                ?>
     <tr>
        <td><?php echo $a["nro_anio"].'º'?></td>
        <?php
                echo $form->hidden($j.'.estructura_planes_anio_id',array('value'=>$a['id']));
                echo '<td>'.$form->input($j.'.matricula',array('label'=>false, 'value'=>0)).'</td>';
                echo '<td>'.$form->input($j.'.secciones',array('label'=>false, 'value'=>0)).'</td>';
                echo '<td>'.$form->input($j.'.hs_taller',array('label'=>false, 'value'=>0)).'</td>';
            }
            ?>
     </tr>
            <?php
            $i++;
            $j++;
        }
        $i = 0;


    }
    ?>
</table>
<?php
echo $form->end('Guardar');
?>







