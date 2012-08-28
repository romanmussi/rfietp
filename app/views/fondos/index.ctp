<div class="fondos index">
<br />
<h2><?php __('Fondos');?></h2>
<?php
$trimestres=array(''=>'Todos','1'=>'1º','2'=>'2º','3'=>'3º','4'=>'4º');

$paginator->options(array('url' => $url_conditions));
?>

<div style="margin-bottom: 20px">
    <?php
    echo $form->create('Fondo',array('url'=>array('action'=>'index')));

    echo $form->input('tipo',array(
        'label'=>'Tipo',
        'div'=> array('style'=>'float:left; clear: none'),
        'options'=>array('i'=>'Institucional','j'=>'Jurisdiccional'),
        'empty'=>'Seleccione',
        'style'=>'width: 110px;',
        'value' => (isset($this->passedArgs['Fondo.tipo'])?$this->passedArgs['Fondo.tipo']:$this->data['Fondo']['tipo'])
        )
            );

    echo $form->input('jurisdiccion_id',array(
        'label'=>'Jurisdicción',
        'div'=> array('style'=>'float:left; clear: none'),
        'style'=>'width: 150px;',
        'value' => (isset($this->passedArgs['Fondo.jurisdiccion_id'])?$this->passedArgs['Fondo.jurisdiccion_id']:$this->data['Fondo']['jurisdiccion_id'])
    ));

    echo $form->input('anio',array(
        'label'=>'Año',
        'div'=> array('style'=>'float:left; clear: none'),
        'options'=>$anios,
        'style'=>'width: 70px;',
        'value' => (isset($this->passedArgs['Fondo.anio'])?$this->passedArgs['Fondo.anio']:$this->data['Fondo']['anio'])
        ));
    
    echo $form->input('trimestre', array(
        'label'=>'Trimestre',
        'div'=> array('style'=>'float:left; clear: none'),
        'options'=>$trimestres, 'style'=>'width:100px',
        'style'=>'width: 70px;',
        'value' => (isset($this->passedArgs['Fondo.trimestre'])?$this->passedArgs['Fondo.trimestre']:$this->data['Fondo']['trimestre'])
        ));

    echo $form->input('memo', array(
        'label'=>'Memo',
        'div'=> array('style'=>'float:left; clear: none'),
        'style'=>'width: 70px;',
        'value' => (isset($this->passedArgs['Fondo.memo'])?$this->passedArgs['Fondo.memo']:$this->data['Fondo']['memo'])
    ));

    echo $form->hidden('url_conditions', array('value'=>$url_conditions));
    
    echo $form->end('Buscar',array('style'=>'float:right'));
    ?>
</div>
<div><?php echo $html->link('Agregar nuevo Fondo', array('action' => 'add')); ?></div>
<br />
<!--<p>
<?php
echo $paginator->counter(array(
'format' => __('<b>%count%</b> fondos encontrados, los cuales suman <b>$'.$total.'</b>.<br>Página %page% de %pages%, mostrando %current% fondos. ', true)
));
?></p>
-->
<p>
<?php
echo $paginator->counter(array(
'format' => __('<b>%count%</b> fondos encontrados. <br>Página %page% de %pages%, mostrando %current% fondos. ', true)
));
?></p>

<?
if (count($fondos)) {
?>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('memo');?></th>
        <th><?php echo $paginator->sort('Institución','instit_id');?></th>
	<th><?php echo $paginator->sort('jurisdiccion_id');?></th>
	<th><?php echo $paginator->sort('Año', 'anio');?></th>
	<th><?php echo $paginator->sort('trimestre');?></th>
	<th><?php echo $paginator->sort('total');?></th>
        <th class="actions"></th>
</tr>
<?php
$i = 0;
foreach ($fondos as $fondo):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
                    <strong><?php echo $fondo['Fondo']['memo']; ?></strong>
		</td>
		<td>
			<?php
                        $armar_anexo = ($fondo['Instit']['anexo']<10)?'0'.$fondo['Instit']['anexo']:$fondo['Instit']['anexo'];
                        $nombreInstit = "".($fondo['Instit']['cue']*100)+$fondo['Instit']['anexo']." - ". $fondo['Instit']['nombre'];
                        if (@$fondo['Fondo']['instit_id'] > 0) {
                            echo $nombreInstit;
                        } else {
                        ?>
                            <i>Jurisdiccional</i>
                        <?php }?>
		</td>
		<td>
			<?php echo $fondo['Jurisdiccion']['name']; ?>
		</td>
		<td>
			<?php echo $fondo['Fondo']['anio']; ?>
		</td>
		<td>
			<?php echo $fondo['Fondo']['trimestre']; ?>
		</td>
		<td>
                        $<?=number_format($fondo['Fondo']['total'],2,",",".");?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Editar', true), array('action' => 'add', $fondo['Fondo']['id'])); ?>
                        <span class="acl acl-desarrolladores"><?php echo $html->link(__('Eliminar', true), array('action' => 'delete', $fondo['Fondo']['id'])); ?></span>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
    <?
    //$paginator->options(array('url' => $this->passedArgs));

    if ($paginator->numbers()) {
    ?>
    <div class="paging">
            <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
     | 	<?php echo $paginator->numbers();?>
            <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
    </div>
<?
    }
}
?>
