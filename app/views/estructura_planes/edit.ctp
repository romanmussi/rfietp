<?php echo $javascript->link('jsonlib.js'); ?>
<?php echo $javascript->link('views/estructura_planes/etapas.js'); ?>

<div class="estructuraplanes form">
<?php echo $form->create('EstructuraPlan', array('onsubmit'=>'return EtapasASubmit();'));?>
	<fieldset>
 		<legend><?php __('Edit EstructuraPlan');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
                echo $form->input('etapa_id', array('id'=>'etapa_id'));
	?>
	        <br>
        <b>Agregar años</b>
        <br>
        <div id="etapa_1">
        <?php
            echo $form->input('edad_teorica', array('id'=>'edad_teorica', 'label'=>'Edad teórica', 'maxlength'=>2, 'size'=>2, 'style'=>'width: 18px;', 'div' => false));
            echo $form->input('anio_escolaridad', array('id'=>'anio_escolaridad', 'label'=>'Año escolaridad', 'maxlength'=>2, 'size'=>2, 'style'=>'width: 18px;', 'div' => false));
            echo $form->input('nro_anio', array('id'=>'nro_anio', 'label'=>'Año', 'maxlength'=>2, 'size'=>2, 'style'=>'width: 18px;', 'div' => false));
            echo $form->input('alias', array('id'=>'alias'));

            echo $form->input('anio_id', array('id'=>'anio_id', 'type'=>'hidden'));
            echo $form->input('estructura_plan_anio_id', array('id'=>'estructura_plan_anio_id', 'type'=>'hidden'));

            echo $form->button('Agregar año', array('id'=>'add', 'onclick'=>'Javascript: EtapaAdd();'));
	?>
        </div>
	</fieldset>
    <ul id="etapas-tree">
    </ul>
<br />
<?php
echo $form->input('etapas', array('id'=>'etapas', 'type'=>'hidden'));
echo $form->end('Guardar');
?>
<br />
<h2>Jurisdicciones con la estructura</h2>
<ul>
<?php
foreach($jurisdicciones as $jurisdiccion){
?>
    <li><?php echo $html->link(__($jurisdiccion['Jurisdiccion']['name'], true), '/jurisdicciones_estructura_planes/index/'.$jurisdiccion['Jurisdiccion']['id']); ?></li>
<?php
}
?>
</ul>
<br />
<br />
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('EstructuraPlan.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('EstructuraPlan.id'))); ?></li>
		<li><?php echo $html->link(__('List estructuras de planes', true), array('action'=>'index'));?></li>
	</ul>
</div>
<script type="text/javascript">
<?php
if (strlen($this->data['EstructuraPlan']['etapas']) > 3) {
        ?>
            var jsonStr = '<?=$this->data['EstructuraPlan']['etapas']?>';
            var json_data_object = eval("(" + jsonStr + ")");
            for (var i = 0; i < json_data_object.length; i++) {
                EtapaAddObject(json_data_object[i]);
            }
        <?php
}
?>
</script>
