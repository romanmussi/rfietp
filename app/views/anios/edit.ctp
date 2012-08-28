<?
if(isset($script)){
echo $script;
}
?>
<? $ganchito = $this->data['Anio']['anio'] == 1?'er':'º';?>
<h1 align="center"> <?= "Editar ".$this->data['Anio']['anio']."$ganchito Año" ?></h1>
<div class="anios form">
<?php echo $form->create('Anio', array('action'=>'save'));?>
<fieldset>
<?php
echo $form->input('id');
echo $form->input('plan_id',array('type'=>'hidden'));

//debug($this->data);
if (empty($this->data['Anio']['estructura_planes_anio_id'])) {
    $anios = array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>9);
    echo $form->input('anio',array( 'options'=>$anios ,'label'=>'Año'));
    echo $form->input('etapa_id');

} else {
    echo $form->hidden('anio');
    echo $form->hidden('etapa_id');
}
 echo $form->hidden('ciclo_id');
 echo $form->hidden('estructura_planes_anio_id');

echo $form->input('matricula',array('label'=>'Matrícula'));
echo $form->input('secciones');
echo $form->input('hs_taller',array('label'=>'Horas Taller'));
?>
</fieldset>
<?php echo $form->end('Guardar');?>
</div>
