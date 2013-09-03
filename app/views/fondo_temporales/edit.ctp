<div class="fondo_temporales form">
<?php echo $form->create('FondoTemporal');?>
	<fieldset>
 		<legend><?php __('Editar Fondo Temporal');?></legend>
                <div style="float:right">La diferencia es de: <?php echo $difference?></div>
	<?php
                                
		echo $form->input('id');
		echo $form->input('f01');
                echo $form->input('f02a');
                echo $form->input('f02b');
                echo $form->input('f02c');
                echo $form->input('f03a');
                echo $form->input('f03b');
                echo $form->input('f04');
                echo $form->input('f05');
                echo $form->input('f06a');
                echo $form->input('f06b');
                echo $form->input('f07a');
                echo $form->input('f07b');
                echo $form->input('f07c');
                echo $form->input('f08');
                echo $form->input('f09');
                echo $form->input('f10');
                echo $form->input('c1');
                echo $form->input('c2');
                echo $form->input('c3');
                echo $form->input('c4');
                echo $form->input('c5');
                echo $form->input('obs');
                echo $form->input('equipinf');
                echo $form->input('refaccion');
                echo $form->input('aula_movil');
                echo "<br/>-----------------------------------------------------------------------------------------------<br/>";
                echo $form->input('total');
                echo $form->hidden('totales_checked',array('value'=>0));
                echo "<br/>";
                echo "<label>Observación</label>";
                echo $form->textarea('observacion', array('label'=>'Observación','value'=>$error));
                
	?>
	</fieldset>
        <?php echo $form->end(array('label'=>'Submit', 'onClick' => "return confirm('Se aseguro de Ingresar una Observacion?');"));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar Fondos Temporales', true), array('controller'=>'fondo_temporales','action'=>'checked_instits'));?></li>
                <li><?php echo $html->link(__('Ejecutar Validacion de Totales', true), array('controller'=>'fondo_temporales','action'=>'validar_totales'));?></li>
	</ul>
</div>
