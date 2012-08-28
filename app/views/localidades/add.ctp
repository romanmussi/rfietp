<div class="localidades form">
<?php echo $form->create('Localidad');?>
	<fieldset>
 		<legend><?php __('Agregar Localidad');?></legend>
	<?php
	
		$meter = '<span class="ajax_update" id="ajax_indicator" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
		echo $form->input('jurisdiccion_id', array('empty' => array('0'=>'Todas'),'id'=>'jurisdiccion_id','label'=>'Jurisdicción','after'=>$meter));		
		
			// DEPARTAMENTO
		$meter = '<span class="ajax_update" id="ajax_indicator_dpto" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
		echo $form->input('departamento_id', array('empty' => 'Seleccione'));                                   
        echo $ajax->observeField('jurisdiccion_id',
                                   array(  	'url' => '/departamentos/ajax_select_departamento_form_por_jurisdiccion',
		                                   	'update'=>'LocalidadDepartamentoId',
		                                   	'loading'=>'jQuery("#ajax_indicator").show();jQuery("#LocalidadDepartamentoId").attr("disabled","disabled")',
		                                   	'complete'=>'jQuery("#ajax_indicator").hide();jQuery("#LocalidadDepartamentoId").removeAttr("disabled")',
		                                   	'onChange'=>true
                                   ));	
	
		echo $form->input('name',array('value'=>""));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Localidades', true), array('action'=>'index'));?></li>
	</ul>
</div>
