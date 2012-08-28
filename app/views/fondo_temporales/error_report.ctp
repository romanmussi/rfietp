<div class="fondo_temporales form">
<?php echo $form->create('FondoTemporal', array('name'=>'FondoTemporal'));?>
	<fieldset>
 		<legend><?php __('Reporte de Errores en Excel');?></legend>
	<?php

		echo $form->textarea('report',array('style'=>'font-size:10px; height: 400px;width:600px','value'=>$report));
	?>
        </fieldset>
<?php echo $form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Fondos Temporales', true), array('controller'=>'fondo_temporales','action'=>'checked_instits'));?></li>
        </ul>
</div>
