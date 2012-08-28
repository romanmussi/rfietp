<?php

echo $javascript->link('prototype');
echo $javascript->link('scriptaculous-js-1.8.3/src/scriptaculous');


?>
<div class="instits form">
<?php echo $form->create('Plan',array(	'url'=>'/depuradores/sectores/'.$jur_id,
										'id'=>'FormSectorJurisdiccion'));?>
<?php		
		echo $form->input('Instit.jurisdiccion_id', array('empty' => 'Todos',
											 'type'=>'select',
											 'label'=>'Selecciones una Jurisdicción',
											 'value'=>$jur_id,
											 'options'=>$jurisdicciones,
											 'onChange'=>'$("FormSectorJurisdiccion").submit();'
											 ));
		echo $form->end(null);										 
?> 

<h1>Plan ID: <?= $this->data['Plan']['id']?>
<br>  ¡¡ vamos que faltan solo <?php echo $falta_depurar?>!!</h1>


<?php echo $form->create('Plan',array('url'=>'/depuradores/sectores/'.$jur_id,'id'=>'PlanDepurarForm'));?>
<?php		
		echo $form->hidden('id',array('value'=>$this->data['Plan']['id']));
		
		echo $form->input('nombre', array('value'=>$this->data['Plan']['nombre']));
				
		//echo '<span class="ajax_update" id="ajax_indicator_dpto" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
		$meter = '<span class="ajax_update" id="ajax_indicator" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
		echo $form->input('sector_id', array('type'=>'select',
											 'label'=>'Sector ('.$this->data['Plan']['sector'].')',
											 'options'=>$sectores,
											 'selected'=>$sector_sug,
											 'after'=>$meter,
											 'id'=>'sector_id'
											 ));
		echo $form->input('subsector_id', array('empty' => 'Seleccione','options'=>$subsectores,'type'=>'select','label'=>'Subsector','after'=> $meter.'<br /><cite>Seleccione primero un sector.</cite>'));
		echo $ajax->observeField('sector_id',
                                   array(  	'url' => '/subsectores/ajax_select_subsector_form_por_sector',
		                                   	'update'=>'PlanSubsectorId',
		                                   	'loading'=>'$("ajax_indicator").show();$("PlanSubsectorId").disable()',
		                                   	'complete'=>'$("ajax_indicator").hide();$("PlanSubsectorId").enable()',
		                                   	'onChange'=>true
                                   ));
											 
		//debug($sectores);
		echo $form->end("Guardar");
?> 

<script type="text/javascript">
<!--

$('sector_id').activate();

Event.observe(window, "keypress", function(e){ 
		var cKeyCode = e.keyCode || e.which; 
		if (cKeyCode == Event.KEY_RETURN){ 
			$('PlanDepurarForm').submit();
		} 
	});
-->
</script>


<h2>Establecimiento</h2>
<dl>
<dt>CUE:</dt><dd><?= $this->data['Instit']['cue']*100+$this->data['Instit']['anexo'] ?> (id:<?php echo $this->data['Instit']['id']?>)</dd>
<dt>Nombre:</dt><dd><?= $html->link($this->data['Instit']['nombre'],'/instits/view/'.$this->data['Instit']['id']);?></dd>
</dl>
<br>