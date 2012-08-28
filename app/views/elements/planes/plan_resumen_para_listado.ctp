<?php

$class; // si es par o impar: coloca el altow
$ciclo; // si quiero ver TODOS me muestra el ciclo_lectivo de ultima actualizacion
$plan; // array del modelo Plan
$hstaller; // horas taller si hay que mostrarlas, sino ''



if (!empty($plan['Plan'])) {
    $plan += $plan['Plan'];
}
?>

<div class="plan_item <?php echo $class?>">
    <div class="plan_title">
        <span class="plan_mas_info btn-ir">
        <?php
        echo $html->link("más info",array('controller'=> 'planes', 'action'=>'view', $plan['id']), array(
            'title'=>'Ver más información del plan',
            'class'=>'',
            ));
        ?>
        </span>

        <?php
        $nombre = $plan['Plan']['nombre'];
        if($plan['PlanEstado']['id'] != PLAN_ESTADO_ACTIVO) $nombre .= ' (' . $plan['PlanEstado']['nombre'] . ')';
        if($plan['PlanTurno']['id'] != PLAN_TURNO_DIURNO) $nombre .= ' (' . $plan['PlanTurno']['nombre'] . ')';  
        echo $html->link($nombre,array(
            'action'=>'view', $plan['id']),array('class'=>'title')
                );
        ?>        
    </div>
    
    
    <div>
        <span class="plan_matricula_info">
            Matrícula: <?php echo empty($plan['matricula'])?"<span>0</span>":$plan['matricula']; ?>
        </span>
        <?php 
        if(!empty($ciclo)) { ?>
        <span class="plan_anio">
                <?php 
                echo (!empty($ciclo)? "(".$ciclo.")":"") ;
                ?>
        </span>
        <?php
        }
        ?>
        <?php if (!empty($hstaller) && $plan['Plan']['oferta_id'] == FP_ID): ?>
            <span class="plan_matricula_info">
                | <?php echo $plan['Anio'][0]['hs_taller']; ?> hs.
            </span>
        <?php endif ?>
        <span class="plan_sector_info">
            | Sector:
            <span class="plan_sector_name">
                <?php
                $sectores = array();
                $sectores_id = array();

                $sectores_s = "";
                $sectores_ids_s = "";
                
                if(isset($plan['Titulo']['SectoresTitulo'])){
                    foreach($plan['Titulo']['SectoresTitulo'] as $sector){
                        if(!in_array($sector['Sector']['id'], $sectores_id)){
                            $sectores[] = $sector['Sector']['name'];
                            $sectores_id[] = $sector['Sector']['id'];
                        }
                    }

                    $sectores_s = implode("/", $sectores);
                    $sectores_ids_s = implode(",", $sectores_id);
                }
                ?>
                <?php echo (empty($sectores_s))?" - ":$sectores_s;?>
            </span>
        </span>
    </div>
    <input class="plan_sector" type="hidden" value="<?php echo $sectores_ids_s;?>"/>
    <input class="plan_ciclo" type="hidden" value="<?php echo empty($plan['Anio'][0]['ciclo_id'])?0:$plan['Anio'][0]['ciclo_id'] ?>"/>
</div>
