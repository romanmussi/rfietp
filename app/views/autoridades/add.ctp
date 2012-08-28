<?
echo $javascript->link('jquery-ui-1.8.5.custom.min', false);
echo $javascript->link(array('jquery.autocomplete','jquery.megaselectlist.js'));

echo $html->css('jquery.autocomplete.css', false);
echo $html->css('smoothness/jquery-ui-1.8.6.custom',null, false);

?>
<script type="text/javascript">
    jQuery(document).ready(function(){

       jQuery("#fechaAsuncionDatePicker").datepicker({ dateFormat: 'dd/mm/yy' });
        /*
         * Bug fix: borro hidden para que permita el funcionamiento de megaselectlist
         */
       jQuery("input:hidden[name='data[Cargo][Cargo]']").remove();

       jQuery("#CargoCargo").megaselectlist({
            classmodifier: "megaselectlist",
            headers: "rel",
            animate: true,
            animateevent: "click",
            multiple: true
        });

        jQuery("#AutoridadJurDepLoc").autocomplete('<?php echo $html->url(array('controller'=>'localidades','action'=>'ajax_search_localidades_y_departamentos'))?>', {
            dataType: "json",
            delay: 200,
            max:30,
            cacheLength:1,
            extraParams: {
                jur: function() { return jQuery('#AutoridadJurisdiccionId').val(); }
            } ,
            parse: function(data) {
                return jQuery.map(data, function(loc_dep) {
                    return {
                        data: loc_dep,
                        value: loc_dep.id,
                        result: formatResult(loc_dep),
                        localidad_id:loc_dep.localidad_id,
                        departamento_id:loc_dep.departamento_id
                    }
                });
            },
            formatItem: function(item) {
                return formatResult(item);
            }
        }).result(function(e, item) {
            jQuery("#hiddenLocId").remove();
            jQuery("#hiddenDepId").remove();
            if(item.type == 'Vacio'){
                jQuery("#AutoridadJurDepLoc").val('');
            }
            else{
                jQuery("#AutoridadAddForm").append("<input id='hiddenLocId' name='data[Autoridad][localidad_id]' type='hidden' value='" + item.localidad_id + "' />");
                jQuery("#AutoridadAddForm").append("<input id='hiddenDepId' name='data[Autoridad][departamento_id]' type='hidden' value='" + item.departamento_id + "' />");
            }
        });

        jQuery("#AutoridadJurDepLoc").attr('autocomplete','off');
    });

    function formatResult(loc_dep) {
        if(loc_dep.type == 'Localidad'){
            return loc_dep.localidad + ', ' + loc_dep.departamento + ' (' + loc_dep.jurisdiccion + ')';
        }
        else if(loc_dep.type == 'Departamento'){
            return loc_dep.departamento + ' (' + loc_dep.jurisdiccion + ')';
        }
        else{
            return loc_dep.localidad;
        }
    }
</script>
<div class="autoridades form">
<?php echo $form->create('Autoridad');?>
	<fieldset>
 		<legend><?php __('Agregar Autoridad');?></legend>
	<?php
		echo $form->input('jurisdiccion_id',array('value'=>$jurisdiccion_id));
		echo $form->input('titulo',array(
                                        'label' => 'Títulos',
                                            'div'=>array('style'=>'width:20%; float: left; clear: none'),
                                            'style'=> 'float: left'));
                echo $form->input('nombre',array(
                                            'div'=>array('style'=>'width:35%; float: left; clear: none'),
                                            'style'=> 'float: left'));
		echo $form->input('apellido',array(
                                            'div'=>array('style'=>'width:36%; float: left; clear: none'),
                                            'style'=> 'float: left'));
		echo $form->input('fecha_asuncion',array(
                                            'label' => 'Fecha Asunción',
                                            'id'=>'fechaAsuncionDatePicker',
                                                         'type'=>'text',
                                                         'div' =>  array('fechaAsuncionDatePickerDiv',
                                                                         'style' => 'width:20%; clear:none; float:left;'
                                                                        ),
                                                         'style' => 'clear:none; float:left;'));
		echo $form->input('telefono_institucional',array(
                                        'label' => 'Teléfono Institucional',
                                            'div'=>array('style'=>'width:36%; float: left; clear: none'),
                                            'style'=> 'float: left'));
                echo $form->input('telefono_personal',array(
                                        'label' => 'Teléfono Personal',
                                            'div'=>array('style'=>'width:35%; float: left; clear: none'),
                                            'style'=> 'float: left'));
		echo $form->input('email_institucional',array(
                                            'div'=>array('style'=>'width:46%; float: left; clear: none'),
                                            'style'=> 'float: left'));
		echo $form->input('email_personal',array(
                                            'div'=>array('style'=>'width:47%; float: left; clear: none'),
                                            'style'=> 'float: left'));
		
		echo $form->input('direccion', array(
                                            'label' => 'Dirección',
                ));
                echo $form->input('jur_dep_loc', array('label'=>'Departamento/Localidad', 'style'=>'width:92%;','title'=>'Ingrese al menos 3 letras para que comience la busqueda de Departamentos y Localidades.'));
	?>
        <?php
                echo $form->input('Cargo',
                        array(
                            'type' => 'select',
                            'multiple' => true,
                            'options' => array(
                                    'Ministro' => $ministros,
                                    'Referentes' => $referentes
                               )
                            )
                        );
        ?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>