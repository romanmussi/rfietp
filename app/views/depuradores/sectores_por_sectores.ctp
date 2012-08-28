<?php

echo $javascript->link('prototype');
echo $javascript->link('scriptaculous-js-1.8.3/src/scriptaculous');


?>
<div class="instits form">

<?php echo $form->create('Plan',array(	'url'=>"/depuradores/sectores_por_sectores/$sec_id/$subsec_id/$plan_nombre",
										'id'=>'FormSectorPorSector'));?>


<?php		
        $ops = array('Ambas', 'Sólo Activas');
        echo $form->input('instit_activa', array(
                    'label'=>'Buscar en instituciones activas, inactivas o en ambas',
                    'options'=>$ops,
            )
        );
        echo $form->input('sector_id_filtro', array(
                     'empty' => 'Todos',
                     'type'=>'select',
                     'label'=>'Selecciones un Sector',
                     'value'=>$sec_id,
                     'options'=>$sectores,
                     'id'=>'sector_id_filtro',
                     'onChange'=>'$("FormSectorPorSector").submit();'
                     ));

        echo $form->input('subsector_id_filtro', array('empty' => 'Todos',
                     'type'=>'select',
                     'label'=>'Selecciones un Subsector',
                     'value'=>$subsec_id,
                     'options'=>$subsectoreslist,
                     'id'=>'subsector_id_filtro',
                     'onChange'=>'$("FormSectorPorSector").submit();'
                     ));

        echo $form->input('plan_nombre', array('value'=>$plan_nombre, 'label'=>'Nombre del Plan', 'after'=> '<cite>Realiza una búsqueda por parte del nombre del plan.<br>Ej: SOLDADURA</cite>'));

        echo $form->end('Buscar');
?> 

<h1>Plan ID: <?php if(isset($this->data['Plan']['id'])) echo $this->data['Plan']['id'];	?>
<br>  ¡¡ vamos que faltan solo <?php echo $falta_depurar?>!!</h1>


<?php
if(isset($this->data['Plan']['id'])) { 
	echo $form->create('Plan',array('url'=>'/depuradores/sectores_por_sectores/'.$sec_id.'/plan_nombre:'.$plan_nombre,'id'=>'PlanDepurarForm'));
		
		echo $form->hidden('id',array('value'=>$this->data['Plan']['id']));
		
		echo $form->input('nombre', array('value'=>$this->data['Plan']['nombre'], 'label'=>'Nombre del Plan'));
				
		//echo '<span class="ajax_update" id="ajax_indicator_dpto" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
		$meter = '<span class="ajax_update" id="ajax_indicator" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
		echo $form->input('sector_id', array('type'=>'select',
											 'label'=>'Sector ('.$this->data['Sector']['name'].')',
											 'options'=>$sectores,
											 'selected'=>$sector_sug,
											 'after'=>$meter,
											 'id'=>'sector_id'
											 ));
		echo $form->input('subsector_id', array('empty' => 'Seleccione','options'=>$subsectores,'selected'=>$subsector_sug,'type'=>'select','label'=>'Subsector','after'=> $meter.'<br /><cite>Seleccione primero un sector.</cite>'));
		echo $ajax->observeField('sector_id',
                                   array(  	'url' => '/subsectores/ajax_select_subsector_form_por_sector',
		                                   	'update'=>'PlanSubsectorId',
		                                   	'loading'=>'$("ajax_indicator").show();$("PlanSubsectorId").disable()',
		                                   	'complete'=>'$("ajax_indicator").hide();$("PlanSubsectorId").enable()',
		                                   	'onChange'=>true
                                   ));
											 
		//debug($sectores);
		echo $form->end("Guardar");
}
?> 

<?php if(isset($this->data['Instit']['cue'])) {?>
	<h2>Establecimiento</h2>
	<dl>
	<dt>CUE:</dt><dd><?= $this->data['Instit']['cue']*100+$this->data['Instit']['anexo'] ?> (id:<?php echo $this->data['Instit']['id']?>)</dd>
	<dt>Nombre:</dt><dd><?= $html->link($this->data['Instit']['nombre'],'/instits/view/'.$this->data['Instit']['id']);?></dd>
	</dl>
	<br>
<?php }?>