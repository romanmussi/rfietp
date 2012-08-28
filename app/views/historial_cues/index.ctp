
<?
//si el anexo tiene 1 solo digito le coloco un cero adelante
$anexo = ($instit['Instit']['anexo']<10)?'0'.$instit['Instit']['anexo']:$instit['Instit']['anexo'];
$cue_instit = $instit['Instit']['cue'].$anexo;
?>
<h2><?= $cue_instit?> - <?= $instit['Instit']['nombre_completo'] ?></h2>

<dl>

    <dt><?php __('Jurisdicción'); ?></dt>
    <dd>
        <?php echo $instit['Jurisdiccion']['name'];  ?>
        &nbsp;
    </dd>


    <dt><?php __('Departamento'); ?></dt>
    <dd>
        <?php echo $instit['Departamento']['name']; ?>
        &nbsp;
    </dd>

    <dt><?php __('Localidad'); ?></dt>
    <dd>
        <?php echo $instit['Localidad']['name']; ?>
        &nbsp;
    </dd>


    <dt><?php __('Domicilio'); ?></dt>
    <dd>
        <?php echo $instit['Instit']['direccion']; ?>
        &nbsp;
    </dd>

</dl>
<br>
<hr>

<dl>
    <?php foreach($cues as $c) {?>
    <dt><?php echo $c['HistorialCue']['cue']*100+$c['HistorialCue']['anexo']." <span style='font-size:x-small'>(".date('d/m/Y H:i:s',strtotime($c['HistorialCue']['created'])).")</span>"?></dt>
    <dd>
            <?php echo $html->link('Editar','/HistorialCues/edit/'.$c['HistorialCue']['id'])?>
            <?php echo $html->link('Eliminar','/HistorialCues/delete/'.$c['HistorialCue']['id'] , null, sprintf(__('Seguro que querés borrar el CUE # %s?', true), $c['HistorialCue']['cue']*100+$c['HistorialCue']['anexo'])); ?>
    </dd>
        <?php }?>
</dl>


<hr>
<br>
<?php echo $html->link('Agregar CUE Histórico','/HistorialCues/add/'.$instit_id);?>