<div class="jurisdicciones form">
<?php echo $form->create('Jurisdiccion');?>
	<fieldset>
 		<legend><?php __('Crear Jurisdiccion');?></legend>
	<?php
		echo $form->input('name', array('label'=>'Nombre'));
        ?>
                <br />
                <b>Datos del referente:</b>
        <?php
                echo $form->input('autoridad_cargo', array('label'=>'Cargo'));
                echo $form->input('autoridad_nombre', array('label'=>'Nombre'));
                echo $form->input('autoridad_fecha_asuncion', array('label'=>'Fecha de asuncion',
                                    'dateFormat'=>'DMY',
                                    'minYear' => date('Y') - 30,
                                    'maxYear' => date('Y')));
        ?>
                <br />
                <b>Datos del Ministerio:</b>
        <?php
                echo $form->input('ministerio_nombre', array('label'=>'Nombre'));
                echo $form->input('ministerio_direccion', array('label'=>'Direccion'));
                echo $form->input('ministerio_codigo_postal', array('label'=>'Código postal'));
                echo $form->input('ministerio_telefono', array('label'=>'Teléfono'));
                echo $form->input('ministerio_mail', array('label'=>'Email'));
                //echo $form->input('ministerio_localidad_id',
                //        array('label'=>'Localidad', 'options'=> $localidades, 'empty'=>'Seleccione una localidad'));
	?>
	</fieldset>
<?php echo $form->end('Guardar');?>
</div>
