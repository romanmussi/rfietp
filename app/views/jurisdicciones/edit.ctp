<div class="jurisdicciones form">
<h1>Editar Jurisdicción </h1>
<?php echo $form->create('Jurisdiccion');?>
	<fieldset>
	<?php
		echo $form->input('id');
		echo $form->input('name', array('label'=>'Nombre'));
        ?>
        
                <br />
                <b>Datos del Ministerio:</b>
        <?php
                echo $form->input('ministerio_nombre', array('label'=>'Nombre'));
                echo $form->input('ministerio_direccion', array('label'=>'Direccion'));
                echo $form->input('ministerio_codigo_postal', array('label'=>'Código postal'));
                echo $form->input('ministerio_telefono', array('label'=>'Teléfono'));
                echo $form->input('ministerio_mail', array('label'=>'Email'));
                echo $form->input('ministerio_localidad_id', 
                        array('label'=>'Localidad', 'options'=> $localidades, 'empty'=>'Seleccione una localidad'));
	?>
	</fieldset>
<?php echo $form->end('Guardar');?>
<div class="actions">
    <ul>
        <li><?php echo $html->link(__('Editar Etapas', true), array('controller'=>'etapas_jurisdicciones','action'=>'index', $this->data['Jurisdiccion']['id'])); ?> </li>
    </ul>
</div>
</div>
