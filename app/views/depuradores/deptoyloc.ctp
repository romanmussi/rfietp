<?php

echo $javascript->link('prototype');
echo $javascript->link('scriptaculous-js-1.8.3/src/scriptaculous');


?>
<div class="instits form">
<h1>Editar Institución de <?php echo $this->data['Jurisdiccion']['name']?><br> CUE: <?= $this->data['Instit']['cue']*100+$this->data['Instit']['anexo'] ?> (id:<?php echo $this->data['Instit']['id']?>) <br>  ¡¡ vamos que faltan solo <?php echo $falta_depurar?>!!</h1>


<?php echo $form->create('Instit',array('url'=>'/depuradores/deptoyloc','id'=>'InstitDepurarForm'));?>
	<?php
		echo $form->input('id');	
		echo $form->input('depto',array('type'=>'hidden'));
		echo $form->input('localidad',array('type'=>'hidden'));
		echo $form->input('cue',array('type'=>'hidden'));
		echo $form->input('anexo',array('type'=>'hidden'));
		echo $form->input('jurisdiccion_id',array('type'=>'hidden'));
		

		

		/**
		 *   AJAX ::> JURISDICCION - Departamentop - Localidad - Tipo de Institucion 
		 */	
		echo "<p><b>".$this->data['Jurisdiccion']['name']."</b></p>";
		
		
			// DEPARTAMENTO
		$meter = '<span class="ajax_update" id="ajax_indicator_dpto" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
		echo $form->input('departamento_id', array('options'=> $departamentos, 'empty' => 'Seleccione','type'=>'select','label'=>'Departamento ('.$this->data['Instit']['depto'].')','after'=> $meter.'<br /><cite>Seleccione primero una jurisdicción.</cite>'));                                   
        
			//LOCALIDAD
		echo $form->input('localidad_id', array('options'=> $localidades,'empty' => 'Seleccione','type'=>'select','label'=>'Localidad ('.$this->data['Instit']['localidad'].')','after'=> '<br /><cite>Seleccione primero un Departamento.</cite>'));                                   
        echo $ajax->observeField('InstitDepartamentoId',
                                   array(  	'url' => '/localidades/ajax_select_localidades_form_por_departamento',
		                                   	'update'=>'InstitLocalidadId',
		                                   	'loading'=>'$("ajax_indicator_dpto").show();$("InstitLocalidadId").disable()',
		                                   	'complete'=>'$("ajax_indicator_dpto").hide();$("InstitLocalidadId").enable()',
		                                   	'onChange'=>true
                                   ));  
                                   
		echo $form->input('lugar',array('label'=>'Lugar: Barrio/Pueblo/Comuna/Paraje'));
         
		
   		// TIPO DE INSTITUCION                  
		//echo $form->input('tipoinstit_id', array('empty' => 'Todas','disabled'=>true,'type'=>'select','label'=>'Tipo De Institución','after'=> '<br /><cite>Para activar este campo, seleccione primero una jurisdicción</cite>'));
		echo $form->input('tipoinstit_id', array('empty' => array(0=>'SIN DATOS'),
												 'type'=>'select',
												 'label'=>'Tipo de Establecimiento',
												 'default'=>$this->data['Instit']['tipoinstit_id']
												 ));
		echo $ajax->observeField('jurisdiccion_id',
                                   array(  	'url' => '/tipoinstits/ajax_select_form_por_jurisdiccion',
		                                   	'update'=>'InstitTipoinstitId',
		                                   	'loading'=>'$("ajax_indicator").show();$("InstitTipoinstitId").disable()',
		                                   	'complete'=>'$("ajax_indicator").hide();$("InstitTipoinstitId").enable()',
		                                   	'onChange'=>true
                                   )); 
		                                   

        
		echo $form->button('Guardar',array('onclick'=>'$("InstitDepurarForm").submit()'));                          
     	
         
                                   
		/**
		 *    NOMBRE
		 */	
		echo $form->input('nombre');
		
		
		/**
		 *    Nro Instit
		 */	
		echo $form->input('nroinstit',array('label'=>array(	'text'=>'Nº de Institución',
															'class'=>'input_label'),
											'class'=> 'input_text_peque'
		));		
			
		echo $form->input('anio_creacion');
		
		
		/**
		 *    DIRECCION
		 */	
		echo $form->input('direccion',array('label'=>array(	'text'=> 'Domicilio',
															'class'=>'input_label'),
											'class' => 'input_text_peque'
		));
			                          
                                   
		/**
		 *    CODIGO POSTAL
		 */							
		echo $form->input('cp',array('label'=>array('text'=>'Código Postal', 'class'=>'input_label'),
									 'class' => 'input_text_peque'
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
											    'class'=>'input_text_peque'
		));
		
		/**
		 *    OBSERVACION
		 */	
		echo $form->input('observacion');
			//agrego esto para que no se puedan imprimir mas de 100 caracteres en el textarea
			?>
			

		<?
		/**
		 *    CICLOS ALTA Y MODIFICACION
		 */	
		$ciclos = $this->requestAction('/Ciclos/dame_ciclos');
		echo $form->input('ciclo_alta', array("type" => "select", 
											  "options" => $ciclos,'label'=>'Alta',
											  "selected" => $this->data['Instit']['ciclo_alta']			
		));
		
	?>
<?php echo $form->end('Guardar');?>

</div>

