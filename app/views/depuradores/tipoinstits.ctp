<div class="instits form">
<h1>Tipo de institución y Relación con ETP</h1>  

<?php if (empty($this->data)): ?>

	<h2>Ya no quedan instituciones por depurar!</h2>

<?php else: ?>

	¡¡ vamos que faltan solo <?php echo $falta_depurar?>!!

	<br> CUE: <?= $this->data['Instit']['cue']*100+$this->data['Instit']['anexo'] ?> (id:<?php echo $this->data['Instit']['id']?>) 
	<h2><?= $this->data['Instit']['nombre']?></h2>
	<dl>
	<dt>Dependencia:</dt><dd><?php echo "&nbsp; ".$this->data['Dependencia']['name']?></dd>
	<dt>Gestión:</dt><dd><?php echo "&nbsp; ".$this->data['Gestion']['name']?></dd>
	<dt>Jurisdicción:</dt><dd><?php echo "&nbsp; ".$this->data['Jurisdiccion']['name']?></dd>
	<dt>Departamento:</dt><dd><?php echo "&nbsp; ".$this->data['Departamento']['name']?></dd>
	<dt>Localidad:</dt><dd><?php echo "&nbsp; ".$this->data['Localidad']['name']?></dd>
	</dl>
	<br>
	<?php echo $form->create('Instit',array('url'=>'/depuradores/tipoinstits','id'=>'InstitDepurarForm'));?>
		<?php		
					

			echo '<span class="ajax_update" id="ajax_indicator_dpto" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
			echo $form->input('tipoinstit_id', array('empty' => array(0=>'Todas'),
													 'type'=>'select',
													 'label'=>'Tipo de Establecimiento'
													 ));
													 ///localidades/ajax_select_localidades_form_por_departamento
			echo $form->button('actualizar Tipos de instituciones',array('id'=>'boton-actualizar'));
			 
													 
			echo $form->input('nombre');
			echo $form->input('nroinstit');

			
			echo $form->input('id');	
			echo $form->input('depto',array('type'=>'hidden'));
			echo $form->input('localidad',array('type'=>'hidden'));
			echo $form->input('cue',array('type'=>'hidden'));
			echo $form->input('anexo',array('type'=>'hidden'));
			echo $form->input('jurisdiccion_id',array('type'=>'hidden'));
			
			echo $form->input('anio_creacion',array('type'=>'hidden'));		
			echo $form->input('direccion',array('type'=>'hidden'));
			echo $form->input('cp',array('type'=>'hidden'));													 
			echo $form->input('ciclo_alta',array('type'=>'hidden'));
			echo $form->input('etp_estado_id',array('type'=>'hidden'));
			echo $form->input('gestion_id',array('type'=>'hidden'));
													 
			echo $form->end("Guardar");
			
			?> 
	<h2> Listado de Planes</h2>

	<ul>
			<?php 
			
			foreach ($this->data['Plan'] as $plan):
				echo "<li>".$plan['nombre']."(ciclo alta: ".$plan['ciclo_alta'].")</li>";
			endforeach;
			
			?>
	</ul>
			
	<script type="text/javascript">
		var url = "<?php echo $html->url('/tipoinstits/ajax_select_form_por_jurisdiccion') ?>";
		var jurisdiccion = "<?php echo $this->data['Instit']['jurisdiccion_id'] ?>";
		jQuery("#boton-actualizar").click(function() {
			jQuery("#ajax_indicator_dpto").show();
			jQuery.get(url, {'jurisdiccion_id': jurisdiccion},
			   	function(data){
			   		jQuery("#InstitTipoinstitId").html("");
			   		jQuery("#InstitTipoinstitId").append(data);
			   		jQuery("#ajax_indicator_dpto").hide();
			   	});
			return false;
		});														
	</script>
<?php endif ?>