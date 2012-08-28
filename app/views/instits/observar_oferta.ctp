<?php
if (@$cerrar) {
?>
<script type="text/javascript">
    window.close();
    if (window.opener && !window.opener.closed) {
        window.opener.location.reload();
    } 
</script>
<?php
}
?>
<h1 align="center">Observación de la oferta</h1>
<div>
<?php echo $form->create('Instit', array('url' => '/instits/observar_oferta/'));?>
	<fieldset>	
	<?php
		echo $form->input('id',array('type'=>'hidden','value'=>$instit_id));
		echo $form->input('observacion_oferta', array('label'=>'Observación', 'value' => $observacion_oferta));
	?>
	</fieldset>
<?php echo $form->end('Guardar');?>
</div>