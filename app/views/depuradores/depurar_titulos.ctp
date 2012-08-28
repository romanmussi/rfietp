<?php

echo $javascript->link('prototype');
echo $javascript->link('scriptaculous-js-1.8.3/src/scriptaculous');


?>
<?
$paginator->options(array('url' => $url_conditions));
?>

<h1> ¡¡ vamos que faltan solo <?php echo $paginator->counter(array(
			'format' => '%count%'));?>!!</h1>




<!-- 	BUSQUEDA POR SU OFERTA  	-->

<div id="search-planes"><?php echo $form->create('Form',array('url'=>'/depuradores/depurar_titulos','id'=>'Form'));?>

    <table align="left">
        <tr>
            <td width="308">
                <?
                echo $form->input('FPlan.limit',array(
                        'label'=>'Cantidad de planes por página',
                        'options'=>array('10'=>10,'20'=>20,'40'=>40,'60'=>60)
                     ));
                ?>
            </td>               
            <td width="308">
                 <? //  JURISDICCION
                $meter = '<span class="ajax_update" id="ajax_indicator" style="display:none;">'.$html->image('ajax-loader.gif').'</span>';
                echo $form->input('FPlan.jurisdiccion_id', array(
                                    'empty' => array('0'=>'Todas'),
                                    'id'=>'jurisdiccion_id',
                                    'label'=>'Jurisdicción',
                                    'after'=>$meter,
                                    'options'=>$jurisdicciones,

                ));
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <?
                echo $form->input('FPlan.oferta_id',array(
                                    'options'=>$ofertas,
                                    'empty'=>'Seleccione',
                                    'label'=>'Con Oferta'));
                ?>
            </td>
            <td>
                <?
                echo $form->input('FPlan.sector_id',array(
                                    'label'=>'Sector',
                                    'options'=>$sectores,
                                    'empty'=>'Seleccione'
                ));
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?
                echo $form->input('FPlan.subsector_id', array(
                                    'label'=>'Subsector',
                                    'empty'=>'Seleccione',
                        ));
                ?>
            </td>
        </tr>
    </table>

<?php echo $form->input('FPlan.plan_nombre', array('label'=>'Nombre del Plan', 'after'=> '<cite>Realiza una búsqueda por parte del nombre del plan.<br>Ej: SOLDADURA</cite>'));?>

<?php
    echo $ajax->observeField(
            'FPlanSectorId', array(
                'url' => '/subsectores/ajax_select_subsector_form_por_sector',
                'update'=>'FPlanSubsectorId',
                'loading'=>'$("FPlanSubsectorId").disable();',
                'complete'=>'$("FPlanSubsectorId").enable();',
                'onChange'=>true
    ));

   
   echo $form->end('Buscar', array(
                    'style'=>'  display: block;
                                width: 100px;
                                vertical-align: bottom;
                                margin-top: 7px;
                                margin-left: 4px;
                                border-color: #CEE3F6;
                                background-color: #DBEBF6;
                                color: #045FB4;
                                font-weight: bold;'
       ));
?>

 </div>



<hr>



<script type="text/javascript">
<!--
        Event.observe(window,'load',function(){
            checkboxes = $('formPlanes').getInputs('checkbox');
            checkboxes.each(function(e){ e.checked = 0 });

            $('formPlanes').observe('change',function(){
                //plan-linea-
                checkboxes = $('formPlanes').getInputs('checkbox');
                checkboxes.each(function(e){
                    if(e.checked == 1){
                        $('plan-linea-'+e.readAttribute('numero')).setStyle({backgroundColor:'#EFFBEF'});
                        //alert(e.numero);
                    } else {
                        $('plan-linea-'+e.readAttribute('numero')).setStyle({backgroundColor:'white'});
                    }
                });
            });

        });


	function checkAll(){
		checkboxes = $('formPlanes').getInputs('checkbox');
		checkboxes.each(function(e){
                    e.checked = 1;
                    $('plan-linea-'+e.readAttribute('numero')).setStyle({backgroundColor:'#EFFBEF'});
                });
	}


	function unCheckAll(){
		checkboxes = $('formPlanes').getInputs('checkbox');
		checkboxes.each(function(e){
                    e.checked = 0
                    $('plan-linea-'+e.readAttribute('numero')).setStyle({backgroundColor:'white'});
            });
	}


	function cambiarTitulos(e){
		e.select($F('titulo_id'));

	}


        function seleccionarTitulosEnMasa() {
            $$('.titulo').each(function(e){
                e.value = $F('titulo_id');
            });
        }

	Event.observe(window, 'load', function(){
            $('titulo_id').observe('change', seleccionarTitulosEnMasa);
            actualizarSelects();
	});



        function actualizarSelects() {
              selectedText = $('titulo_id').options[$('titulo_id').selectedIndex].text;

              $$('.titulo').each(function(e){
                  var option = new Element('option', {value: $F('titulo_id')});
                  option.update(selectedText);
                  e.appendChild(option);
                  e.value = $F('titulo_id');
            });
            
        }
-->
</script>



<?php
echo $form->create('Plan', array(
			'url'=>'/depuradores/depurar_titulos',
			//'onsubmit'=>'activarCambios(); return false;',
			'id'=>'formPlanes'
));


echo $form->button('Seleccionar Todos', array('onclick'=>'checkAll()', 'style'=>'clear:none;float:left;width:144px;'));
echo $form->button('Deseleccionar Todos', array('onclick'=>'unCheckAll()', 'style'=>'clear:none;float:left;width:144px;'));

$i = 0;
foreach ($planes as $p) {

	$div_id = "plan-id-".$p['Plan']['id'];
	?>


	<div style="font-size: 12px;" id="plan-linea-<?= $i?>">
		<?php echo $form->input("Plan.$i.id",array('value' =>$p['Plan']['id']));?>

                <?php echo $form->checkbox("Plan.$i.selected", array(
                            'id'=>"checkbox-$i",
                            'numero'=>$i,
                    ));
                ?>

                <?php echo $form->input("Plan.$i.titulo_id", array(
                        'class'=>'titulo dep_titulo',
                        'div'=>false,
                        'label'=>false,
                        'default'=>'seleccione',
                        'empty'=>'seleccione',
                        'style'=>'clear: none;',
                        'onchange'=> '$("checkbox-'.$i.'").setValue(1);',
                    ));
                ?>
		<a style="font-size: 10px;" href="javascript:" onclick="$('<? echo $div_id?>').toggle(); return false;"><?= $p['Plan']['nombre']?></a>
	</div>
	<div style="display: none; background-color: beige;" id="<? echo $div_id?>">

		<?php echo $html->link('ir al plan','/Planes/view/'.$p['Plan']['id'],array('style'=> 'float: right;'))?>
		<dl>
			<?php $nombre = (empty($p['Instit']['nombre']))? 'SIN NOMBRE':$p['Instit']['nombre'];?>
			<dt>Institución:</dt>			<dd><?php echo $html->link($nombre,'/instits/view/'.$p['Instit']['id']);?>&nbsp;</dd>
			<dt>Oferta:</dt>				<dd><?php echo $p['Oferta']['name']?>&nbsp;</dd>
			<dt>Sector:</dt>				<dd><?php echo $p['Sector']['name']?>&nbsp;</dd>
			<dt>Subsector:</dt>				<dd><?php echo $p['Subsector']['name']?>&nbsp;</dd>
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

<?php
	$i++;
}



echo $form->input('titulo_id', array(
    'options'=>$titulos,
    'label'=>'Asignar título en masa',
    'div'=>array('id'=>'divTituloGral'),
    'id'=>'titulo_id',
    'default'=>'Seleccione',
    'empty'=>'Seleccione',
    'value'=>$titulo_id
    ));



//echo $form->button('Seleccionar Todos', array('onclick'=>'checkAll()', 'style'=>'clear:none;float:left;width:144px;'));
//echo $form->button('Deseleccionar Todos', array('onclick'=>'unCheckAll()', 'style'=>'clear:none;float:left;width:144px;'));

?>

<div>
<?php
echo $paginator->prev('<< '.__('Anterior', true), array(), null, array('class'=>'disabled'));
echo $paginator->numbers(array('modulus'=>13));
echo $paginator->next(__('Siguiente', true).' >>', array('style'=>'float:right;'), null, array('class'=>'disabled'));
?>
</div>


<?php

echo $form->button('Seleccionar Todos', array('onclick'=>'checkAll()', 'style'=>'clear:none;float:left;width:144px;'));
echo $form->button('Deseleccionar Todos', array('onclick'=>'unCheckAll()', 'style'=>'clear:none;float:left;width:144px;'));



echo $form->hidden('FPlan.limit');
echo $form->hidden('FPlan.oferta_id');
echo $form->hidden('FPlan.sector_id');
echo $form->hidden('FPlan.subsector_id');
echo $form->hidden('FPlan.jurisdiccion_id');
echo $form->hidden('FPlan.plan_nombre');

if (strlen($paginator->counter(array('format' => '%page%'))))
    echo $form->hidden('FPlan.last_page', array('value' => $paginator->counter(array('format' => '%page%'))));

echo $form->end('Guardar Cambios');


?>
<br>
<a href="javascript:" onclick="$('formularioNuevoTitulo').toggle()" style="background-color: gray; color: white; text-decoration: none">Agregar Nuevo Título de Referencia</a>
<div id="formularioNuevoTitulo" style="display: none; background-color: gray">
<?
echo $ajax->form(array('type' => 'post',
    'options' => array(
        'model'=>'Titulo',
        'url' => array(
            'controller' => 'titulos',
            'action' => 'add_and_give_me_select_options'
        ),
        'id'=> "formAltaTitulo",
        'complete'=>'$("formAltaTitulo").reset(); actualizarSelects();',
        'update'=> 'divTituloGral',
    )
));
echo $form->hidden('marco_ref', array('value'=>0));
echo $form->input(
        'oferta_id',
        array(
            'options'=>$ofertas,
            'label'=>false,
            'empty' => 'Seleccione',
            'default' => $this->data['FPlan']['oferta_id'],
        )
     );
echo $form->input('name', array('style'=>'clear:none;'));
echo $form->end('Guardar Título');
?>
</div>

<br>


