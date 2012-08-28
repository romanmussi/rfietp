<?php

echo $javascript->link('prototype');
echo $javascript->link('scriptaculous-js-1.8.3/src/scriptaculous');


?>
<div class="fondo_temporales form">
<?php echo $form->create('FondoTemporal', array('name'=>'FondoTemporal'));?>
	<fieldset>
 		<legend><?php __('Reporte de Errores en Excel');?></legend>
	<?php

		echo $form->textarea('report',array('style'=>'font-size:10px; height: 400px;width:600px','value'=>$report));
	?>
        <!--<input onclick="$('FondoTemporalReport').copyToClipboard();" type="button" value="Copiar Reporte" name="cpy">-->
	</fieldset>
<?php echo $form->end();?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Fondos Temporales', true), array('controller'=>'fondo_temporales','action'=>'checked_instits'));?></li>
        </ul>
</div>
