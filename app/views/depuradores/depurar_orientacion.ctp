<?php

echo $javascript->link('prototype');
echo $javascript->link('scriptaculous-js-1.8.3/src/scriptaculous');


?>
<div class="instits form">
<h1>Editar Institución de <?php echo $this->data['Jurisdiccion']['name']?> <br> Nombre: <?= $html->link($this->data['Instit']['nombre_completo'],'/instits/view/'.$this->data['Instit']['id']);?> <br> CUE: <?= $this->data['Instit']['cue']*100+$this->data['Instit']['anexo'] ?> (id:<?php echo $this->data['Instit']['id']?>) <br> ¡¡ vamos que faltan solo <?php echo $falta_depurar?>!!</h1>



<script type="text/javascript">
<!--


Event.observe(window, "keypress", function(e){ 
		var cKeyCode = e.keyCode || e.which; 
		if (cKeyCode == Event.KEY_RETURN){ 
			$('InstitDepurarForm').submit();
		} 
	});
-->
</script>


<?php 
	echo $form->create('Plan',array(	
					'url'=>'/depuradores/depurar_orientacion',
					'id'=>'FormOrientacion'));


        echo $form->input('jurisdiccion_id', array('value'=>$this->data['Instit']['jurisdiccion_id'], 'empty'=>'Todos'));
		
	echo $form->input('Form.claseinstit_id', array(
										 'empty' => 'Todos',
										 'type'=>'select',
										 'label'=>'Selecciones un Tipo Instit',
										 'id'=>'sector_id_filtro',
										 'onChange'=>'$("FormOrientacion").submit();',
										 'options'=> $tipoinstits,
										 'default' =>$tipoinstit_seleccionado,
										 'empty' => 'Todos',
										 ));
	echo $form->end('siguente');
?> 


<h2>Planes</h2>


<?php foreach ($planes as $p):?>
<?php $div_id = "plan-id-".$p['Plan']['id']; ?>
	<dl style="font-size: 12px;">
		<dt>Nombre:</dt>
                <dd style="margin-left: 10em;"><?php echo $html->link($p['Plan']['nombre'],'/Planes/view/'.$p['Plan']['id'])?>&nbsp;</dd>
		<dt>Titulo:</dt>                
                <dd><?php echo $p['Titulo']['name']?></dd>
                <?php if (empty($p['Titulo']['Subsector'])) continue; ?>
                <?php foreach ( $p['Titulo']['Subsector'] as $s) { ?>
                <dt>Sectores</dt>
                <dd style="color: OrangeRed; font-size: 12px;">
                    <?php echo $s['Sector']['name'].' :: '. $s['name']?>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( Orientación: <?php echo (!empty($s['Sector']['Orientacion']['name']))?$s['Sector']['Orientacion']['name']:"";?> )&nbsp;
                </dd>
                <?php } ?>
                
	</dl>
	<a style="font-size: 10px;" href="javascript:" onclick="$('<? echo $div_id?>').toggle(); return false;">Más info del Plan</a>
	<div style="display: none; background-color: beige;" id="<? echo $div_id?>">
		<dl>
			<dt>Sector:</dt>				<dd><?php echo $p['Plan']['sector']?>&nbsp;</dd>
			<dt>Duracion:</dt>				<dd><?php echo " - ";?>&nbsp;</dd>
			<dt>&nbsp;&nbsp;-- Horas:</dt>	<dd><?php echo $p['Plan']['duracion_hs'];?>&nbsp;</dd>
			<dt>&nbsp;&nbsp;-- Semanas:</dt><dd><?php echo $p['Plan']['duracion_semanas'];?>&nbsp;</dd>
			<dt>&nbsp;&nbsp;-- Años:</dt>	<dd><?php echo $p['Plan']['duracion_anios'];?>&nbsp;</dd>
			<dt>matricula:</dt>				<dd><?php echo $p['Plan']['matricula']?>&nbsp;</dd>
			<dt>Observación:</dt>			<dd><?php echo $p['Plan']['observacion']?>&nbsp;</dd>
			<dt>Alta:</dt>					<dd><?php echo date('d/m/Y',strtotime($p['Plan']['created']))?>&nbsp;</dd>
			<dt>Modificación:</dt>			<dd><?php echo date('d/m/Y',strtotime($p['Plan']['modified']))?>&nbsp;</dd>
			
			<?php
				foreach ($p['Anio'] as $anio):
					$ciclos[$anio['ciclo_id']] = $anio['ciclo_id'];
				endforeach;
				
				$texto = '';
				foreach ($ciclos as $c):
					$texto .= " - ".$c;
				endforeach;
			?>
			<dt>Ciclos con información</dt><dd><?php echo $texto?>&nbsp;</dd>
			
		</dl> 
	</div>
	<hr>

<?php endforeach;?>

<?php echo $form->create('Instit',array('url'=>'/depuradores/depurar_orientacion','id'=>'InstitDepurarForm'));?>
	<?php
		echo $form->input('id');
                echo $form->hidden('jurisdiccion_id');
		echo $form->input('orientacion_id',array('label'=>'Seleccione tipo de Orientación',
												 'selected'=>$orientacionSugerida,
												 'empty' => 'Seleccione',										
		));
		
        
		echo $form->button('Guardar',array('onclick'=>'$("InstitDepurarForm").submit()'));

		
			echo $form->hidden('claseinstit_id');
		
         /********************************************************************************/

		/**
		 *    Tipo Instit
		 */	
		echo $form->input('Tipoinstit.name', array('readonly'=>true,
												 'label'=>array('text'=>'Tipo de Institución','class'=>'input_label')
		));		
		
		/**
		 *    NOMBRE
		 */	
		echo $form->input('nombre', array('readonly'=>true));
		
		
		/**
		 *    Nro Instit
		 */	
		echo $form->input('nroinstit',array('label'=>array(	'text'=>'Nº de Institución',
															'class'=>'input_label'),
											'class'=> 'input_text_peque',
											'readonly'=>true
		));		
			
		echo $form->input('anio_creacion', array('readonly'=>true, 'label'=>'Año Creación'));
		
		
		/**
		 *    DIRECCION
		 */	
		echo $form->input('direccion',array('label'=>array(	'text'=> 'Domicilio',
															'class'=>'input_label'),
											'class' => 'input_text_peque',
											'readonly'=>true
		));
			                          
                                   
		/**
		 *    CODIGO POSTAL
		 */							
		echo $form->input('cp',array('label'=>array('text'=>'Código Postal', 'class'=>'input_label'),
									 'class' => 'input_text_peque',
									 'readonly'=>true
		));
		
		
		
	/****************************************************************************
	 *    
	 * 
	 * 
	 * 				DATOS ADICIONALES
	 * 
	 * 
	 */	
		?><H2>Datos Adicionales</H2><?
		/**
		 *    INGRESO/ACTUALIZACION
		 */	
		echo $form->input('actualizacion',array('label'=>array(	'text'=> 'Ingreso/Actualización',
																'class'=>'input_label'),
											    'class'=>'input_text_peque',
												'readonly'=>true
		));
		
		/**
		 *    OBSERVACION
		 */	
		echo $form->input('observacion', array('readonly'=>true, 'label'=>'Observación'));
			//agrego esto para que no se puedan imprimir mas de 100 caracteres en el textarea
			?>
			

		<?
		/**
		 *    CICLOS ALTA Y MODIFICACION
		 */	
		$ciclos = $this->requestAction('/Ciclos/dame_ciclos');
		echo $form->input('ciclo_alta', array("type" => "select", 
											  "options" => $ciclos,'label'=>'Alta',
											  "selected" => $this->data['Instit']['ciclo_alta'],
											  'disabled' => true		
		));
		
	?>
	<?php echo $form->submit('Guardar', array('style'=>' display: block;
													        width: 100px;
													        vertical-align: bottom;
													        margin-top: 7px;
													        margin-left: 4px;
													        border-color: #CEE3F6;
													        background-color: #DBEBF6;
													        color: #045FB4;
													        font-weight: bold;'
												)
								);
		?>
<?php echo $form->end();?>

</div>



